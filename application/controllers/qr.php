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
       
       echo '<img src="'.base_url().'/assets/uploads/qrcodes/test.png" />';       
    }
        
}
 
/* End of file qr.php */
/* Location: ./application/controllers/qr.php */

