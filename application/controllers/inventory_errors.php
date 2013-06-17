<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Inventory_errors extends CI_Controller {
	
	function __construct()
    {
        parent::__construct();
        
        //LOAD GLOBAL INVENTORY CONFIG
        $this->config->load('inventory');
 
        $this->load->helper('url');
   		$this->load->library('session');  

		
        //Localization:
        $this->lang->load('inventory', 'catalan');	       
        $this->load->helper('language');
 
    }
	
	public function load_header($not_show_header = true){

             
        $data['not_show_header2']=$not_show_header;

    
        $data['inventory_js_files'] = array(
            '/javascript/jquery/jquery.min.js',
            base_url('assets/js/bootstrap.min.js')
            );
        $data['inventory_css_files'] = array(
            base_url('assets/css/bootstrap.min.css'),
            base_url('assets/css/bootstrap-responsive.min.css'),
            base_url('assets/css/font-awesome.css')
            );                 
            
        
        $data['institution_name'] = $this->config->item('institution_name');
        //TODO: use real user name		
        
        $data['usuari']=$this->session->userdata('session_id');
        
        $this->load->view('include/header',array_merge($data));
                    
    }
    
	
	
	function error404()	{
		$this->load_header();
        $this->load->view('404.php');        
        $this->load->view('include/footer');   	
	}
	
	


}
