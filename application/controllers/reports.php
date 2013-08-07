<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reports extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        
        $this->load->helper('url');

        //DATABLES LIBRARY
        $this->load->library('Datatables');
   		$this->load->library('session');  

        
        //Table library: helps creting html tables
        
        $this->load->library('table');
               	
        //Localization:       
        //TODO: Session variable with selected language
        $this->lang->load('inventory', 'catalan');	       
        $this->load->helper('language');
 
    }
	
	public function load_header(){
    
        $data['inventory_js_files'] = array(
            base_url('assets/grocery_crud/js/jquery-1.10.2.min.js'),
            '//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.2.1/lodash.min.js', 
            base_url('assets/js/bootstrap.min.js'), 
            base_url('assets/js/custom.js'),
            base_url('assets/js/jquery-ui.min.js'),
            base_url('assets/js/jquery.multiselect.min.js'),
            "/javascript/jquery/datatables/jquery.dataTables.js",
            base_url('assets/js/paging.js'),
            );
        $data['inventory_css_files'] = array(
            base_url('assets/css/bootstrap.min.css'),
            base_url('assets/css/bootstrap-responsive.min.css'),
            base_url('assets/css/font-awesome.css'),
            base_url('assets/css/custom.css'),
            base_url('assets/css/jquery.multiselect.css'),
            base_url('assets/css/jquery-ui.css')
            );                 
		
        $data['usuari']=$this->session->userdata('session_id');
        
        $data['not_show_header2']=true;
            
        $this->load->view('include/header',$data);
                    
    }
    
    public function index()
    {
		$this->global_reports();
    }
    
    public function global_reports()
    {
		$this->load_header();
		
		//set table id in table open tag
		
               $tmpl = array ( 'table_open'  => '<table id="inventory" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
		        
               $this->table->set_template($tmpl); 
               $this->table->set_heading('publicId','name','shortName','description');
        
                //$this->load->view('ajax', $data);
		$this->load->view('global_reports_view'); 
		$this->load->view('include/footer');
    }
    
    public function list_all()
    {
	$this->datatables
        ->select('publicId, name, shortName, description')
        ->from('inventory_object');
        echo $data['result'] = $this->datatables->generate();
    }
}
 
/* End of file reports.php */
/* Location: ./application/controllers/reports.php */

