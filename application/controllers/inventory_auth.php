<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of Ebre-inventory.

    Ebre-inventory is free software: you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Ebre-inventory is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Ebre-inventory.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

/**
 * @author      Sergi Tur <sergitur@ebretic.com>
 * @license     GNU Lesser General Public License
 */
 
include 'auth.php';
 
class Inventory_auth extends Auth {
	
	//Default accepted realms
    public $realms = "mysql,ldap";
    
    function __construct() {
		$model="inventory_ion_auth_model";
		parent::__construct($model);
		
		$this->config->load('inventory');	
		
		$this->lang->load('inventory', 'catalan');	       
		$this->ion_auth->lang->load('ion_auth', 'catalan');
		$this->lang->load('auth', 'catalan');
		$this->lang->load('form_validation', 'catalan');

        $this->load->helper('language');
        
        //Owerwrite values
        $this->login_page="inventory_auth/login";
        $this->after_succesful_login_page="main";
        $this->forgot_password_page ="inventory_auth/forgot_password";
        $this->reset_password_page ="inventory_auth/reset_password";
        $this->users_list_page = "main/users";
        $this->user_edit_page = "main/users/edit";
        $this->user_add_page = "main/users/add";
        $this->user_delete_page = "main/users/delete";
		$this->groups_list_page = "main/groups";
        $this->group_edit_page = "main/groups/edit";
        $this->group_add_page = "main/groups/add";
        $this->group_delete_page = "main/groups/delete";
        
        //GET REALMS FROM CONFIG
        if ($this->config->item('realms')!="") {
			$this->realms = explode(",",$this->config->item('realms'));
		}
        
	}
	

	
public function reset_password($code = NULL) {
	$this->session->set_userdata('institution_name', $this->config->item('institution_name'));
	parent::reset_password($code);
}

function forgot_password()	{
	$this->session->set_userdata('institution_name', $this->config->item('institution_name'));
	parent::forgot_password();
}

function forgot_password_username()	{
	$this->session->set_userdata('institution_name', $this->config->item('institution_name'));
	parent::forgot_password_username();
}

function forgot_password_email()	{
	$this->session->set_userdata('institution_name', $this->config->item('institution_name'));
	parent::forgot_password_email();
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
			$this->ion_auth->ion_auth_model->setRealm("mysql");
			parent::login();
			break;
		case "ldap":
			$this->ion_auth->ion_auth_model->setRealm("ldap");
			parent::login();
			break;
		}
    } else {
			parent::login();
	}
}

//redirect if needed, otherwise display the user list
/*function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			//redirect them to the home page because they must be an administrator to view this
			redirect($this->after_succesful_login_page, 'refresh');
		}
		else
		{
			redirect($this->users_list_page, 'refresh');
		}
	}
	*/

public function change_password() {
	parent::change_password();
}	
	
public function create_user()	{
	redirect($this->user_add_page, 'refresh');
}	

public function create_group() {
	redirect($this->group_add_page, 'refresh');
}

public function edit_user($id)	{
	redirect($this->group_add_page."/".$id, 'refresh');
}

public function edit_group($id)	{	
	redirect($this->group_edit_page."/".$id, 'refresh');
}

public function logout()  {
    $this->data['title'] = "Logout";

	//log the user out
	$logout = $this->ion_auth->logout();

	//redirect them to the login page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect($this->login_page, 'refresh');
}

}
