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
    
	
	function get_organizational_units(){
		
		$this->db->select('organizational_unitId, name');
		$query = $this->db->get('organizational_unit');
		return $query->result_array();
	}
}
