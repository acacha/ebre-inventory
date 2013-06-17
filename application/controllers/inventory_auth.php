<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of Auth_Ldap.

    Auth_Ldap is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Auth_Ldap is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Auth_Ldap.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Sergi Tur <sergitur@ebretic.com>
 * @license     GNU Lesser General Public License
 */
 
include 'auth.php';
 
class Inventory_auth extends Auth {
	
    public $realms = "mysql,ldap";

	
    function __construct() {
		
		parent::__construct();
		
		session_start();

		$this->config->load('inventory');	
		
		$this->lang->load('inventory', 'catalan');	       
        $this->load->helper('language');
        
        //Owerwrite values
        $this->login_page="inventory_auth/login";
        $this->after_succesful_login_page="main";
        
        if ($this->config->item('realms')!="") {
			$this->realms = explode(",",$this->config->item('realms'));
		}
        
	}


function login()  {
    
    @session_start();
    
    $this->session->set_userdata('realms', $this->realms);
    $this->session->set_userdata('default_realm', $this->config->item('default_realm'));
    $this->session->set_userdata('institution_name', $this->config->item('institution_name'));
    
    if ($this->input->post('realm')) {
		
		switch ($this->input->post('realm')) {
		case "mysql":
			parent::login();
			break;
		case "ldap":
			parent::login();
			break;
		}
    } else {
			parent::login();
	}
}

function logout()  {
    $this->data['title'] = "Logout";

	//log the user out
	$logout = $this->ion_auth->logout();

	@session_start();

	//redirect them to the login page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect($this->login_page, 'refresh');
}
}
