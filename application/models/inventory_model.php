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
    
    function get_primary_key($table_name) {
		$fields = $this->db->field_data($table_name);
		
		foreach ($fields as $field)	{
			if ($field->primary_key) {
					return $field->name;
			}
		} 	
		return false;
	}
    
    function get_dropdown_values($table_name,$field_name,$primary_key=null,$order_by="asc") {
		
		$primary_key_field_name;
		if ($primary_key==null)
			$primary_key_field_name=$this->get_primary_key($table_name);
		else
			$primary_key_field_name=$primary_key;
		
		$this->db->select("$primary_key_field_name,$field_name");
		$this->db->order_by($field_name, $order_by); 
		$query = $this->db->get($table_name);
		if ($query->num_rows() != 0)
			return $query->result();
		return false;
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

	function get_externalIdInfoByInventoryObjectId($inventory_objectid)	{
		$this->db->select('externalID,externalIDType');
		$this->db->where('inventory_objectId',$inventory_objectid);
		$query = $this->db->get('inventory_object');
		if ($query->num_rows() > 0)
			return array ("externalID" => $query->row()->externalID,
						  "externalIDType" => $query->row()->externalIDType);
		else
			return false;
	}
	
	function get_barcodetype_byExternalIDTypeID($externalIDTypeID)	{
		//Shortname is barcodetype (php-barcode format)
		$this->db->select('barcode.shortname');
		$this->db->from('externalIDType');
		$this->db->join('barcode', 'barcode.barcodeId = externalIDType.barcodeId','inner');
		$this->db->where('externalIDTypeID',$externalIDTypeID);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->row()->shortname;
		else
			return false;
	}
	
}
