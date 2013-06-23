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
		return TRUE;
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
