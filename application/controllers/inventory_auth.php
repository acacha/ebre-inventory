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
		
		$this->config->load('inventory');	
		
		$this->lang->load('inventory', 'catalan');	       
		$this->ion_auth->lang->load('ion_auth', 'catalan');
		$this->lang->load('auth', 'catalan');
		$this->lang->load('form_validation', 'catalan');

        $this->load->helper('language');
        
        //Owerwrite values
        $this->login_page="inventory_auth/login";
        $this->after_succesful_login_page="main";
        
        if ($this->config->item('realms')!="") {
			$this->realms = explode(",",$this->config->item('realms'));
		}
        
	}


function login()  {
    
    $this->session->set_userdata('realms', $this->realms);
    $this->session->set_userdata('default_realm', $this->config->item('default_realm'));
    $this->session->set_userdata('institution_name', $this->config->item('institution_name'));
    
    if ($this->config->item('maintenance_mode')) {
		$this->session->set_userdata('maintenance_mode', true);
	}	else {
		$this->session->unset_userdata('maintenance_mode', true);
	}
    
    if ($this->input->post('realm')) {
		
		switch ($this->input->post('realm')) {
	    case "maintenance_mode":
			$maintenance_user= $this->config->item('maintenance_mode_user');
			$maintenance_password= $this->config->item('maintenance_mode_password');
			
			//validate form input
			$this->form_validation->set_rules('identity', 'Identity', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == true)	{
				
				//check maintenance LOGIN
				if (( $this->input->post('identity') == $maintenance_user ) && ( $this->input->post('password') == $maintenance_password)) 			{
					//if the login is successful redirect them back to the home page
					$session_data = array(
						'identity'             => $maintenance_user,
						'username'             => $maintenance_user,
						'email'                => $this->config->item('maintenance_mode_user_email'),
						'user_id'              => $this->config->item('maintenance_mode_user_id'), //everyone likes to overwrite id so we'll use user_id
						'old_last_login'       => "nothing"
					);
					$this->session->set_userdata($session_data);
					redirect($this->after_succesful_login_page, 'refresh');
				}
				else {
					//if the login was un-successful redirect them back to the login page
					$this->session->set_flashdata('message', lang('maintenance_mode_login_error_message'));
					redirect($this->login_page, 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
				}
			}
			else {
				//the user is not logging in so display the login page
				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	
				$this->data['identity'] = array('name' => 'identity',
					'id' => 'identity',
					'type' => 'text',
					'value' => $this->form_validation->set_value('identity'),
				);
				$this->data['password'] = array('name' => 'password',
					'id' => 'password',
					'type' => 'password',
				);
				$this->_render_page($this->login_view, $this->data);
			}
			
			break;
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

	//redirect them to the login page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect($this->login_page, 'refresh');
}
}
