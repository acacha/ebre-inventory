<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * IonAuth Ldap Model
 *
 * A rewrite of IonAuth model to use Ldap as database backend. 
 * It requires TODO.... 
 *
 * This model class will be loaded in case that it's set to use Ldap as
 * database backend instead of the original model class, see controller and library
 * files for more info on its internal usage.
 *
 * @package		CodeIgniter
 * @author		Sergi Tur <sergitur@ebretic.com>
 * @copyright	Copyright (c) 2013 Sergi Tur.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		https://github.com/acacha
 * @version 	Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * IonAuth LDap Model
 *
 * A rewrite of IonAuth model class to use Ldap as database backend.
 *
 * @package 	CodeIgniter
 * @subpackage	Models
 * @category	Authentication
 * @author		Sergi Tur <sergitur@ebretic.com>
 * @link		https://github.com/acacha
 * @todo		Document!
 */

include "ion_auth_model.php";
 
class Ion_auth_ldap_model extends Ion_auth_model {

	
	/**
	 * IonAuth Ldap Model Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		//LOAD LDAP LIBRARY
		$this->load->library('Auth_Ldap');		
		$this->load->library('ion_auth');
		
		//DATABASE MODEL
		$this->load->model('inventory_Model');
	}

	/**
	 * Checks credentials and logs the passed user in if possible.
	 *
	 * @return bool
	 */
	public function login($identity, $password, $remember = FALSE)
	{
		$this->trigger_events('pre_login');
		
		if (empty($identity) || empty($password))
		{
			$this->set_error('login_unsuccessful');
			return FALSE;
		}
		$return_value=$this->auth_ldap->login($identity, $password);
		
		switch ($return_value) {
			case 1:
				break;
			case -1:
				$this->increase_login_attempts($identity);
				$this->trigger_events('post_login_unsuccessful');
				$this->set_error('login_unsuccessful');
				return FALSE;
				break;
			case -2:
				$this->increase_login_attempts($identity);
				$this->trigger_events('post_login_unsuccessful');
				$this->set_error('login_unsuccessful_not_allowed_role');	
				return FALSE;
				break;
		}
		
		//AT THIS POINT USER HAS LOGGED CORRECTLY AT LDAP
		
		//CHECK IF ACCOUNT HAS TO BE LOCKED BY TOO MANY AUTH ATTEMPTS
		if($this->is_time_locked_out($identity))
		{
			//Hash something anyway, just to take up time
			$this->hash_password($password);

			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_timeout');

			return FALSE;
		}
		
		//CORRECT LOGIN. SET DATA:
		
		$email;
		$id;
		$last_login;
		$username=$identity;
		$last_login;
		$user = new stdClass;
		
		// ADD USER TO users table if not exists
		if (!$this->username_check($identity)) {
			//NOT EXISTS -> ADD/REGISTER
			$additional_data = $this->auth_ldap->get_additional_data($identity);
			$email=$this->auth_ldap->get_email($identity);
			$id=$this->register($identity, $password, $email, $additional_data);
		}

		$database_user=$this->get_user_by_username($identity);
		$email=$database_user->email;
		$id=$database_user->id;
		$last_login=$database_user->last_login;
		
		//IS USER ACTIVE?
		if (!$this->is_user_active($identity)) {
			$this->trigger_events('post_login_unsuccessful');
			$this->set_error('login_unsuccessful_not_active');
			return FALSE;
		}

		//SET SESSION DATA
		$user->identity=$identity;
		$user->username=$username;
		$user->email=$email;
		$user->id=$id;
		$user->last_login=$last_login;
		
		$this->set_session($user);

		$this->update_last_login($user->id);
	
		$this->clear_login_attempts($identity);

		if ($remember && $this->config->item('remember_users', 'ion_auth')) {
			$this->remember_user($user->id);
		}
		
		//SET DEFAULT LANGUAGE
		if (!$this->session->userdata("current_language")) {
			$this->session->set_userdata("current_language",
										  $this->config->item('default_language'));
		}
		
		//GET DURRENT ROLE INFO
		$current_rol_id = $this->session->userdata('role');
		$current_role_name=$this->_get_rolename_byId($current_rol_id);
		
		
		//SET DEFAULT CURRENT ORGANIZATIONAL UNIT
		$current_organizational_unit="all";
		
		//CHECK USER ROLE: IF 
		//$config['organizationalunit_group'] = "inventory_organizationalunit";
		$organizationalunit_group=$this->config->item('organizationalunit_group');
		
		if ( $current_role_name == $organizationalunit_group) {
			//OBTAIN current_organizational_unit from database
			$current_organizational_unit=$this->inventory_Model->get_main_organizational_unit_from_userid($user->id);
		}
		
		if (!$this->session->userdata("current_organizational_unit")) {
			$this->session->set_userdata("current_organizational_unit",
										  $current_organizational_unit);
		}
		
		//SET CORRECT LDAP GRUPS IN DATABASE		
		
		//CHECK IF ROL EXISTS AS GROUP IN DATABASE
		if (! $this->_check_if_group_exists($current_role_name)) {
			//ADD ROLE AS GROUP AT DATABASE
			$group = $this->ion_auth->create_group($current_role_name, "Automatic group added as ldap inventory role");
			if(!$group) {
				show_error($this->ion_auth->messages());
			}
		}
		
		//SET (IF NOT YET) LDAP ROLES AS DATABASE USER GROUPS
		$group_id = $this->_get_group_id_by_group_name($current_role_name);
		if (! $this->_check_if_user_group_exists($current_role_name) ) {
			$this->add_to_group($group_id,$user->id);
		}
		
		//USERS HAVE ONLY ON LDAP ROLE! -> DELETE OLD LDAP USERS GROUPS
		$ldap_roles = (array) $this->config->item('roles');
		$ldap_roles_without_current_role=array_diff($ldap_roles,(array) $current_role_name);
		
		$ldap_roles_database_keys=array();
		foreach ($ldap_roles_without_current_role as $ldaprole){
			$ldap_roles_database_keys[]=$this->_get_group_id_by_group_name($ldaprole);
		}
		
		//REMOVE USER FROM OTHER LDAP GROUPS:
		$this->remove_from_group($ldap_roles_database_keys, $user->id);
		
		
		$this->_initialize_fields();
		return TRUE;
	}
	
	function _get_rolename_byId($id) {		
		$roles = (array) $this->config->item('roles');
		return $roles[(int) $id];
	}
	
	protected function _get_group_id_by_group_name ($groupname) {
		$groups = $this->ion_auth->groups()->result();
		foreach ($groups as $group) {
			if ( $group->name == $groupname )
				return $group->id;
		}
		return false;
	}
	
	protected function _check_if_group_exists($groupname) {
		$groups = $this->ion_auth->groups()->result();
		foreach ($groups as $group) {
			if ( $group->name == $groupname )
				return true;
		}
		return false;
	}
	
	protected function _check_if_user_group_exists($groupname) {
		$usergroups=$this->ion_auth->get_users_groups()->result();
		foreach ($usergroups as $usergroup) {
			if ( $usergroup->name == $groupname ) {
				return true;
			}
		}
		return false;
	}
	
	protected function _initialize_fields() {
		
		if (!$this->session->userdata("inventory_object_current_fields_to_show")) {
			$this->session->set_userdata("inventory_object_current_fields_to_show",
									 $this->config->item('default_fields_table_inventory_object'));
		}
		
		if (!$this->session->userdata("externalIDType_current_fields_to_show")) {
			$this->session->set_userdata("externalIDType_current_fields_to_show",
									 $this->config->item('default_fields_table_externalIDType'));							 
		}
		
		if (!$this->session->userdata("organizational_unit_current_fields_to_show")) {
			$this->session->set_userdata("organizational_unit_current_fields_to_show",
									 $this->config->item('default_fields_table_organizational_unit'));
		}
		
		if (!$this->session->userdata("location_current_fields_to_show")) {
			$this->session->set_userdata("location_current_fields_to_show",
									 $this->config->item('default_fields_table_location'));
		}
		if (!$this->session->userdata("material_current_fields_to_show")) {
			$this->session->set_userdata("material_current_fields_to_show",
									 $this->config->item('default_fields_table_material'));
		}
		if (!$this->session->userdata("brand_current_fields_to_show")) {
			$this->session->set_userdata("brand_current_fields_to_show",
									 $this->config->item('default_fields_table_brand'));
		}
		if (!$this->session->userdata("model_current_fields_to_show")) {
			$this->session->set_userdata("model_current_fields_to_show",
									 $this->config->item('default_fields_table_model'));			
		}
		if (!$this->session->userdata("provider_current_fields_to_show")) {
			$this->session->set_userdata("provider_current_fields_to_show",
									 $this->config->item('default_fields_table_provider'));
		}
		if (!$this->session->userdata("money_source_current_fields_to_show")) {
			$this->session->set_userdata("money_source_current_fields_to_show",
									 $this->config->item('default_fields_table_money_source'));			
		}
		if (!$this->session->userdata("users_current_fields_to_show")) {
			$this->session->set_userdata("users_current_fields_to_show",
									 $this->config->item('default_fields_table_users'));
		}
		if (!$this->session->userdata("groups_current_fields_to_show")) {
			$this->session->set_userdata("groups_current_fields_to_show",
									 $this->config->item('default_fields_table_groups'));
		}
		if (!$this->session->userdata("user_preferences_current_fields_to_show")) {
			$this->session->set_userdata("user_preferences_current_fields_to_show",
									 $this->config->item('default_fields_table_user_preferences'));
		}																																
									 
	}
	
	/**
	 * Get user data by username
	 *
	 * @return user object
	 * @author Sergi Tur
	 **/
	public function get_user_by_username($username)
	{
		if (empty($username))
		{
			return FALSE;
		}

		$query = $this->db->where('username', $username)
						->limit(1)
		                ->get($this->tables['users']);
		return $query->row();
	}


	/**
	 * Check if user is active
	 */
	public function is_user_active($username) {
		
		$query = $this->db->select($this->identity_column . ', username, active')
		                  ->where($this->identity_column, $this->db->escape_str($username))
		                  ->limit(1)
		                  ->get($this->tables['users']);
		
		if ($query->num_rows() === 1) {
			$user = $query->row();
			if ($user->active == 1)	{
				return TRUE;
			}
		}
		return FALSE;
	}

}
// END Ion_auth_ldap_model Class

/* End of file ion_auth_ldap_model.php */
/* Location: ./application/modules/auth/models/ion_auth_ldap_model.php */
