<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Qr extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('ciqrcode');        
 
    }
	
    public function index()
    {
		$this->generate();
    }
    
    public function generate()
    {          
       $params['data'] = 'Hola!';
       $params['level'] = 'H';
       $params['size'] = 10;
       $params['savename'] = FCPATH."/assets/uploads/qrcodes/test.png";
       $this->ciqrcode->generate($params);
       
       if ( $this->_is_ajax()) {
		   $output= '<img src="'.base_url().'/assets/uploads/qrcodes/test.png" />';
		   echo json_encode(array ( "output" => $output));
	   } else {
			echo '<img src="'.base_url().'/assets/uploads/qrcodes/test.png" />';       
	   }
    }
    
    protected function _is_ajax()
	{
		return array_key_exists('is_ajax', $_POST) && $_POST['is_ajax'] == 'true' ? true: false;
	}
        
}
 
/* End of file qr.php */
/* Location: ./application/controllers/qr.php */

