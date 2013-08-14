<?php
/**
 * Ebre-inventory Model
 *
 *
 * @package    	Ebre-inventory CRUD
 * @author     	Sergi Tur <sergitur@ebretic.com>
 * @version    	1.0
 * @link		http://www.acacha.com/index.php/ebre-inventory
 */
class inventory_Model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function user_have_preferences ($userid) {
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() != 0)
			return true;
		return false;
	}
	
	function get_user_preferencesId ($userid) {
		$this->db->select('user_preferencesId');
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() > 0)
			return $query->row()->user_preferencesId;
		else
			return false;
	}
	
	function get_user_theme($userid){
		$this->db->select('theme');
		$this->db->where('userId',$userid);
		$query = $this->db->get('user_preferences');
		if ($query->num_rows() > 0)
			return $query->row()->theme;
		else
			return false;
	}
	
	function get_user_theme_by_username($username){
		$userid="TODO";
		return $this->get_user_theme($userid);
	}
	
	function get_organizational_units(){
		
		$this->db->select('organizational_unitId, name');
		$query = $this->db->get('organizational_unit');
		return $query->result_array();
	}
	
	function get_main_organizational_unit_from_userid($userid){
		
		$this->db->select('mainOrganizationaUnitId');
		$this->db->where('id',$userid);
		$query = $this->db->get('users');
		return $query->row()->mainOrganizationaUnitId;
	}
	
	function get_main_organizational_unit_name_from_userid($userid){
		
		$unitid=$this->get_main_organizational_unit_from_userid($userid);
		$this->db->select('name');
		$this->db->where('organizational_unitId',$unitid);
		$query = $this->db->get('organizational_unit');
		if ($query->num_rows() > 0)
			return $query->row()->name;
		else
			return "";

	}
	
	
	
	
	
}
