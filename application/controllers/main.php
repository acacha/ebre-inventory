<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    public $current_table = "inventory_object";
    public $login_page = "inventory_auth/login";
 
    function __construct()
    {
        parent::__construct();
        
        //LOAD GLOBAL INVENTORY CONFIG
        $this->config->load('inventory');
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
		session_start();
        /* ------------------ */ 
        $this->load->library('grocery_CRUD');
		$this->load->library('image_CRUD');  
		$this->load->library('session');  
		$this->load->library('ion_auth');
		
		/* Idioma per defecte */
		if(isset($_SESSION['idioma'])){
			$this->grocery_crud->set_language($_SESSION['idioma']);
			$this->config->set_item('language', $_SESSION['idioma']);
		}else{
			$_SESSION['idioma'] = 'catalan';
			$this->grocery_crud->set_language($_SESSION['idioma']);
			$this->config->set_item('language', $_SESSION['idioma']);
		}
		
		/* Tamany pantalla */
		if(!isset($_SESSION['tamany'])){
		$_SESSION['tamany'] = 'petit';
		}
		
        //Localization:
        
        //TODO: Session variable with selected language
        $this->lang->load('inventory', 'catalan');	       
        $this->load->helper('language');
 
    }
	
	public function signin(){
		$this->load->view('signin');
	}
	
	
    public function load_header($output = array(),$not_show_header = true){

             //GET GROCERY CRUD STATE & PASS INFO TO VIEW
             //TODO            
             $state = $this->grocery_crud->getState();
             $state_info = $this->grocery_crud->getStateInfo();
             $data['grocerycrudstate']=$state;
             
             $data['not_show_header2']=$not_show_header;
             
           switch ($state) {
			default:
			 $data['grocerycrudstate_text']="Desconegut";
             break;
			case "unknown":			 
             $data['grocerycrudstate_text']="Desconegut";
             break;
			case "list":			 
             $data['grocerycrudstate_text']="Llistant";
             if ($not_show_header) {
			    unset($data['not_show_header2']);
			 } else {
				$data['not_show_header2']= true;
			 }
			 
			 break;
            case "add":			 
             $data['grocerycrudstate_text']="Afegint";
             break; 
            case "edit":			 
             $data['grocerycrudstate_text']="Editant";
             break;
            case "delete":			 
             $data['grocerycrudstate_text']="Esborrant";
             break;
            case "insert":			 
             $data['grocerycrudstate_text']="Inserint";
             break;
            case "update":			 
             $data['grocerycrudstate_text']="Actualitzant";
             break;
            case "ajax_list":			 
             $data['grocerycrudstate_text']="Llista ajax";
             break;
            case "ajax_list_info":			 
             $data['grocerycrudstate_text']="Llista d'informació Ajax";
             break;
            case "insert_validation":			 
             $data['grocerycrudstate_text']="Validant inserció";
             break;
            case "update_validation":			 
             $data['grocerycrudstate_text']="Validant pujada de fitxer";
             break;
            case "upload_file":			 
             $data['grocerycrudstate_text']="Pujant fitxer";
             break;
			case "delete_file":			 
             $data['grocerycrudstate_text']="Esborrant fitxer";
             break;
            case "ajax_relation":			 
             $data['grocerycrudstate_text']="Relació Ajax";
             break;
            case "ajax_relation_n_n":			 
             $data['grocerycrudstate_text']="Relació Ajax n_n";
             break; 
            case "success":			 
             $data['grocerycrudstate_text']="Èxit";
             break; 
            case "export":			 
             $data['grocerycrudstate_text']="Exportant";
             break; 
            case "print":			 
             $data['grocerycrudstate_text']="Imprimint";
             break;    
		   }
    
        $data['inventory_js_files'] = array(
            '//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.2.1/lodash.min.js',
            base_url('assets/js/bootstrap.min.js'),
            base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'),
            base_url('assets/js/jquery-ui.min.js')                        
            );
        $data['inventory_css_files'] = array(
            base_url('assets/css/bootstrap.min.css'),
            base_url('assets/css/bootstrap-responsive.min.css'),
            base_url('assets/css/font-awesome.css'),
            base_url('assets/css/custom.css'),
            base_url('assets/css/jquery.multiselect.css'),
            base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'),
            'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css'
            );                 
            
        $data['fields_in_table'] = $this->db->list_fields($this->current_table);
        $data['institution_name'] = $this->config->item('institution_name');
        //TODO: use real user name		
        
        //DEBUGGING PURPOSES
        if ($this->config->item('debug')) {
		 $data['debug']=true;	
		}
        
        $data['session_data']=$this->session->all_userdata(); 
                                                
        $this->load->view('include/header',array_merge((array) $output,$data));
                    
    }
    
    public function update_displayed_fields()
    {
		$selected_columns = $_POST['selected_columns'];
		$this->grocery_crud->columns($selected_columns);
		
    }
    
 
    public function index()
    {
       if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
       $this->inventory();
    }
	
	public function images(){
	    if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
					
		$image_crud = new image_CRUD();
	
		$image_crud->set_table('images');
	
		$image_crud->set_primary_key_field('imageId');
		$image_crud->set_url_field('url');
		$image_crud->set_title_field('title');
		$image_crud->set_ordering_field('priority');
		$image_crud->set_image_path('assets/uploads/files');
		$image_crud->set_relation_field('inventory_objectId');
	
		$output = $image_crud->render();
	
	    $this->load_header($output,false);	
		$this->load->view('images', $output);
	}
	
	
	
 /***************************************************************************************************************************************/
 /*                                         Classe inventari on forma tota la taula                                                     */               
 /***************************************************************************************************************************************/
  
   
    public function inventory()
    {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		
        $this->grocery_crud->add_action(lang('Images'),base_url('assets/img/images.png'), '/main/images');
        $this->grocery_crud->add_action(lang('QRCode'),base_url('assets/img/qr_code.png'), '/qr/generate');
                
        
        //<i class="icon-large icon-qrcode"></i>
	

		if(isset($_GET['idioma'])){
			$idioma=$_GET['idioma'];
			$_SESSION['idioma'] = $idioma;
			$this->grocery_crud->set_language($_SESSION['idioma']);
		}
		
		if(isset($_GET['tamany_get'])){
			$_SESSION['tamany']= $_GET['tamany_get'];
		}
		
		
        $this->grocery_crud->set_table('inventory_object');
        
        //Exemples de com canviar l'idioma
        //$this->grocery_crud->set_language("catalan"); 
        
        //Establish subject:
        $this->grocery_crud->set_subject(lang('object_subject'));
                        
        //FIELD NAMES        

        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //ESPECIFIC COLUMNS                                            
        $this->grocery_crud->display_as('publicId',lang('publicId'));
        $this->grocery_crud->display_as('externalID',lang('externalId')); 
        $this->grocery_crud->display_as('externalIDType',lang('externalIDType')); 
        $this->grocery_crud->display_as('location',lang('location'));
        $this->grocery_crud->display_as('quantityInStock',lang('quantityInStock'));
        $this->grocery_crud->display_as('price',lang('price'));
        $this->grocery_crud->display_as('moneySourceId',lang('moneySourceId'));
        $this->grocery_crud->display_as('providerId',lang('providerId'));
        $this->grocery_crud->display_as('preservationState',lang('preservationState'));                
        $this->grocery_crud->display_as('file_url',lang('file_url'));
        $this->grocery_crud->display_as('OwnerOrganizationalUnit',lang('OwnerOrganizationalUnit'));
	
        //Limitar les columnes a mostrar a la llista
        //$this->grocery_crud->columns('name','shortName','description');        
        
        //Limitar els camps a mostrar a add/edit
        //http://www.grocerycrud.com/documentation/options_functions/fields
        //$crud->fields('customerName','contactLastName','phone','city','country','creditLimit');
        
        //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','location','markedForDeletion');
        //$this->grocery_crud->required_fields('externalCode','name','shortName','location','markedForDeletion');

        $this->grocery_crud->unset_add_fields('last_update','manualLast_update');
        
        //ExternID types
        $this->grocery_crud->set_relation('externalIDType','externalIDType','{externalIDTypeID} - {name}',array('markedForDeletion' => 'n'));
        
        //ORGANIZATIONAL UNIT
        $this->grocery_crud->set_relation_n_n('OwnerOrganizationalUnit', 'inventory_object_organizational_unit', 'organizational_unit', 'organitzational_unitId', 'inventory_objectId', 'name','priority');
        
        //LOCATION
        $this->grocery_crud->set_relation('location','location','{locationId} - {name}',array('markedForDeletion' => 'n'));
        
        //PROVIDERS
        $this->grocery_crud->set_relation('providerId','provider','{providerId} - {name}',array('markedForDeletion' => 'n'));
        
        //MONEYSOURCEID
        $this->grocery_crud->set_relation('moneySourceId','money_source ','{moneySourceId} - {name}',array('markedForDeletion' => 'n'));
                
                
	   
        //Example de validació. Natural no zero
        $this->grocery_crud->set_rules('quantityInStock','Quantitat','is_natural_no_zero');
		
		$this->grocery_crud->callback_add_field('quantityInStock',array($this,'add_field_callback_quantityInStock'));
		
		//CREATION USER ID
    	//DEFAULT VALUE= LOGGED USER. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
        //$this->grocery_crud->callback_add_field('creationUserId',array($this,'add_field_callback_creationUserId'));
        $this->grocery_crud->callback_edit_field('creationUserId',array($this,'edit_field_callback_creationUserId'));
		
		
		//ENTRY DATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
		$this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
		
		//LAST UPDATE
		//DEFAULT VALUE=NOW. ONLY WHEN ADDING
		//EDITING: SHOW CURRENT VALUE READONLY
		$this->grocery_crud->callback_add_field('last_update',array($this,'add_callback_last_update'));
		$this->grocery_crud->callback_edit_field('last_update',array($this,'edit_callback_last_update'));
		
		//$this->grocery_crud->callback_add_field('markedForDeletion',array($this,'add_field_callback_markedForDeletionDate'));
		$this->grocery_crud->callback_column('price',array($this,'valueToEuro'));
		$this->grocery_crud->callback_field('Link Imatges',array($this,'field_callback_Link'));
		
		//UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		
	
        $this->grocery_crud->set_field_upload('file_url','assets/uploads/files');
        
        //USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        
        $output = $this->grocery_crud->render();
        
        $this->load_header($output);
        
        // VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
        $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
        
        //GROCERYCRUD VIEW
        $this->load->view('inventory_object_view.php',$output);        
        $this->load->view('include/footer');          
    }
    
    function user_info() {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		 $data['inventory_js_files'] = array(
            base_url('assets/grocery_crud/js/jquery-1.8.2.min.js'),
            '//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.2.1/lodash.min.js', 
            base_url('assets/js/bootstrap.min.js'), 
            base_url('assets/js/custom.js'),
            );
        $data['inventory_css_files'] = array(
            base_url('assets/css/bootstrap.min.css'),
            base_url('assets/css/bootstrap-responsive.min.css'),
            base_url('assets/css/font-awesome.css'),
            base_url('assets/css/custom.css'),
            );           
        $data['not_show_header2']=true;
		$this->load->view('include/header',$data);
		$this->load->view('user_info_view'); 
		$this->load->view('include/footer'); 
	}
    
    
    //
    function get_default_values() {
		
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		
		//print_r($this->session->all_userdata());
		//echo "user_id: " . $this->session->userdata('user_id');
		$defaultvalues['defaultcreationUserId']= $this->session->userdata('user_id');
		
		$defaultvalues['defaultfieldexternalIDType']= $this->config->item('default_externalID_type');
		$defaultvalues['defaultfieldlocation']= $this->config->item('default_location');
     	$defaultvalues['defaultfieldmoneysourceid']= $this->config->item('default_moneysourceid');
     	$defaultvalues['defaultfieldpreservationstate']= $this->config->item('default_preservationState');
     	$defaultvalues['defaultfieldprovider']= $this->config->item('default_provider');
     	$defaultvalues['defaultfieldmarkedfordeletion']= $this->config->item('default_markedfordeletionvalue');
     	$defaultvalues['defaultfieldparentMaterialId']= $this->config->item('default_materialid');

     	//TRANSLATIONS:
     	$defaultvalues['good_translated']= lang('Good');
     	$defaultvalues['bad_translated']= lang('Bad');
     	$defaultvalues['regular_translated']= lang('Regular');
     	$defaultvalues['yes_translated']= lang('Yes');
     	$defaultvalues['no_translated']= lang('No');
     	
		return $defaultvalues;
		
	}
		 
	function valueToEuro($value, $row)
    {
        return $value.' &euro;';
    }
    
	
    /********************************************************************************************************************/
    /*                             Funcions callback per modificar text dels inputs                                     */
    /********************************************************************************************************************/
    function field_callback_Link($value = '', $primary_key = null)
    {
        return '<input type="text" maxlength="50" value="'.$value.'" name="phone" style="width:462px">';
    }
   
    function add_field_callback_quantityInStock(){
    return '<input id="field-quantityInStock" type="text" maxlength="6" value="1" name="quantityInStock">';
    }
    
    function edit_field_callback_creationUserId($value, $primary_key){
     return '<input type="text" maxlength="11" class="numeric" value="' . $value  . '" name="creationUserId" id="field-creationUserId" readonly> ';
    }
    
	function add_field_callback_entryDate(){  
	  $data= date('d/m/Y H:i:s', time());
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'.$data.'" name="entryDate" id="field-entryDate" readonly>';    
    }
    
    function edit_field_callback_entryDate($value, $primary_key){  
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-entryDate" readonly>';    
    }
    
    function edit_field_callback_lastupdate($value, $primary_key){
	  return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'" name="entryDate" id="field-last_update" readonly>';    	
	}
    
    function add_callback_last_update(){  
	 return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" name="last_update" id="field-last_update" readonly>';
    }
    
    function edit_callback_last_update($value, $primary_key){  
	 return '<input type="text" class="datetime-input hasDatepicker" maxlength="19" value="'. date('d/m/Y H:i:s', strtotime($value)) .'"  name="last_update" id="field-last_update" readonly>';
    }
    
    //UPDATE AUTOMATIC FIELDS BEFORE INSERT
    function before_insert_object_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['last_update'] = $data;
		
		$post_array['creationUserId'] = $this->session->userdata('user_id');
		$post_array['lastupdateUserId'] = $this->session->userdata('user_id');
		return $post_array;
    }
    
    //UPDATE AUTOMATIC FIELDS BEFORE UPDATE
    function before_update_object_callback($post_array, $primary_key) {
		//UPDATE LAST UPDATE FIELD
		$data= date('d/m/Y H:i:s', time());
		$post_array['last_update'] = $data;
		
		$post_array['lastupdateUserId'] = $this->session->userdata('session_id');
        return $post_array;
    }
	


    public function externalid()
    {
        if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
        $this->current_table="externalIDType";
        $this->grocery_crud->set_table($this->current_table);
        
        //Establish subject:
        $this->grocery_crud->set_subject(lang('externalID_subject'));
                  
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
        
        //SPECIFIC COLUMNS
        //$this->grocery_crud->display_as('externalCode',lang('code'));
        //$this->grocery_crud->display_as('location',lang('location'));
                                                         
        //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
 
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
		
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		
		$this->grocery_crud->unset_add_fields('last_update');
		
        $output = $this->grocery_crud->render();
           
        $this->load_header($output);        

		// VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
        $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
        $this->load->view('externalid_view.php',$output);
        
	    $this->load->view('include/footer');                        
    
    }
	
    public function organizationalunit()
    {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
        $this->current_table="organizational_unit";
        $this->grocery_crud->set_table($this->current_table);
        
        //Establish subject:
        $this->grocery_crud->set_subject(lang('organizationalunit_subject'));
                  
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
        
        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('externalCode',lang('code'));
        $this->grocery_crud->display_as('location',lang('location'));
                                                         
        //Camps obligatoris
        $this->grocery_crud->required_fields('externalCode','name','shortName','location','markedForDeletion');

        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_add_field('last_update',array($this,'add_field_callback_last_update'));
        
        //Relacions entre taules
        $this->grocery_crud->set_relation('location','location','{locationId} - {name}',array('markedForDeletion' => 'n'));
        
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('last_update');
   		
   		//USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));

        
        $output = $this->grocery_crud->render();
           
        $this->load_header($output);        

		// VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
        $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
        $this->load->view('organizational_unit_view.php',$output);
        
	    $this->load->view('include/footer');                        
    
    }
    

    public function location()
    {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
		$this->current_table="location";
        $this->grocery_crud->set_table($this->current_table);
       
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('location_subject'));                
        
        //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
        
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();
               
        //SPECIFIC COLUMNS
        $this->grocery_crud->display_as('parentLocation',lang('parentLocation'));
        
        //Relacions entre taules
        $this->grocery_crud->set_relation('parentLocation','location','{locationId} - {name}',array('markedForDeletion' => 'n'));
        
         //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
        $this->grocery_crud->unset_add_fields('last_update');
        
   		
   		//USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
                   
        $output = $this->grocery_crud->render();
        
        $this->load_header($output);
        // VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
        $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
        $this->load->view('grocerycrud_view.php',$output);
                
        $this->load->view('include/footer');                            
    } 
	
public function material()
{
	   if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}	
	   $this->current_table="material";
       $this->grocery_crud->set_table($this->current_table);
        
       //ESTABLISH SUBJECT
       $this->grocery_crud->set_subject(lang('material_subject'));
       
       //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
               
       //COMMON_COLUMNS                 
       $this->set_common_columns_name();

       //SPECIFIC COLUMNS
       $this->grocery_crud->display_as('parentMaterialId',lang('parentMaterialId'));
       
       //Parent Material
       $this->grocery_crud->set_relation('parentMaterialId','material','{name}',array('markedForDeletion' => 'n'));
                                        
       //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('last_update');
   		
   		
   		//USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        
       $output = $this->grocery_crud->render();


        $this->load_header($output);          
        // VIEW WITH DINAMIC JAVASCRIPT. Purpose: set default values
        $this->load->view('defaultvalues_view.php',$this->get_default_values());            
        $this->load->view('material_view.php',$output); 
        $this->load->view('include/footer');                            
} 
	
public function provider()
{
	   if (!$this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
	   }	
       $this->current_table="provider";
       $this->grocery_crud->set_table($this->current_table);                          
       //ESTABLISH SUBJECT
       $this->grocery_crud->set_subject(lang('provider_subject'));
       
       //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
                              
       //COMMON_COLUMNS                 
       $this->set_common_columns_name();
                                            
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
        
   		$this->grocery_crud->unset_add_fields('last_update');
   		
   		
   		//USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
        
                                                          
       $output = $this->grocery_crud->render(); 
                                                   
       $this->load_header($output);
       $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
       $this->load->view('provider_view.php',$output);
       $this->load->view('include/footer');
}

public function money_source()
{
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
        $this->current_table="money_source";
        $this->grocery_crud->set_table($this->current_table);  
        //ESTABLISH SUBJECT
        $this->grocery_crud->set_subject(lang('money_source_id_subject'));
        
        //Camps obligatoris
        $this->grocery_crud->required_fields('name','shortName','markedForDeletion');
                                     
        //COMMON_COLUMNS                 
        $this->set_common_columns_name();
        
        //CALLBACKS        
        $this->grocery_crud->callback_add_field('entryDate',array($this,'add_field_callback_entryDate'));
        $this->grocery_crud->callback_edit_field('entryDate',array($this,'edit_field_callback_entryDate'));
        
        //Camps last update no editable i automàtic        
        $this->grocery_crud->callback_edit_field('last_update',array($this,'edit_field_callback_lastupdate'));
        
        //UPDATE AUTOMATIC FIELDS
		$this->grocery_crud->callback_before_insert(array($this,'before_insert_object_callback'));
		$this->grocery_crud->callback_before_update(array($this,'before_update_object_callback'));
		
		//USER ID
        $this->grocery_crud->set_relation('creationUserId','users','{username}',array('active' => '1'));
        
        //LAST UPDATE USER ID
        $this->grocery_crud->set_relation('lastupdateUserId','users','{username}',array('active' => '1'));
		        
   		$this->grocery_crud->unset_add_fields('last_update');
                                                           
        $output = $this->grocery_crud->render();
                
        $this->load_header($output);
        $this->load->view('defaultvalues_view.php',$this->get_default_values()); 
        $this->load->view('money_source_view.php',$output);
        $this->load->view('include/footer');
}
                                        


public function users() {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
	    
	    $this->current_table="users";
        $this->grocery_crud->set_table($this->current_table);  
        
        $this->grocery_crud->required_fields('username','password','email','active','groups');

        
        //COMMON_COLUMNS               
        $this->set_common_columns_name();

        //ESPECIFIC COLUMNS                                            
        $this->grocery_crud->display_as('ip_address',lang('ip_address'));
        $this->grocery_crud->display_as('username',lang('username')); 
        $this->grocery_crud->display_as('password',lang('Password')); 
        $this->grocery_crud->display_as('email',lang('email'));
        $this->grocery_crud->display_as('activation_code',lang('activation_code'));
        $this->grocery_crud->display_as('forgotten_password_code',lang('forgotten_password_code'));
        $this->grocery_crud->display_as('forgotten_password_time',lang('forgotten_password_time'));
        $this->grocery_crud->display_as('remember_code',lang('remember_code'));
        $this->grocery_crud->display_as('created_on',lang('created_on'));                
        $this->grocery_crud->display_as('active',lang('active'));
        $this->grocery_crud->display_as('first_name',lang('first_name'));
        $this->grocery_crud->display_as('last_name',lang('last_name'));
        $this->grocery_crud->display_as('company',lang('company'));
        $this->grocery_crud->display_as('phone',lang('phone'));
        
        $this->grocery_crud->field_type('password', 'password');
        
        $this->grocery_crud->unset_add_fields('ip_address','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code','last_login','created_on');
        $this->grocery_crud->unset_edit_fields('ip_address','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code','last_login','created_on');

	    //GROUPS
        $this->grocery_crud->set_relation_n_n('groups', 'users_groups','groups', 'group_id', 'id', 'name');

        $output = $this->grocery_crud->render();
        
        $this->load_header($output);
               
        $this->load->view('users_view.php',$output);
        $this->load->view('include/footer');
}

public function groups(){
	   if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
	   $this->current_table="groups";
       $this->grocery_crud->set_table($this->current_table);  
       
       $this->grocery_crud->required_fields('name');

       
       //COMMON_COLUMNS               
       $this->set_common_columns_name();

       //ESPECIFIC COLUMNS                                            
       $this->grocery_crud->display_as('name',lang('name'));
       $this->grocery_crud->display_as('description',lang('description')); 
       
       $this->grocery_crud->set_relation_n_n('users', 'users_groups','users', 'user_id', 'id', 'username');
            
       $output = $this->grocery_crud->render();
       
       $this->load_header($output);
       $this->load->view('groups_view.php',$output);
       $this->load->view('include/footer');                          
}      

protected function set_common_columns_name()
{
       //COMMON_COLUMNS                      
       $this->grocery_crud->display_as('name',lang('name'));       
       $this->grocery_crud->display_as('shortName',lang('shortName'));       
       $this->grocery_crud->display_as('description',lang('description'));       
       $this->grocery_crud->display_as('entryDate',lang('entryDate'));       
       $this->grocery_crud->display_as('manualEntryDate',lang('manualEntryDate'));       
       $this->grocery_crud->display_as('last_update',lang('last_update')); 
       $this->grocery_crud->display_as('manualLast update',lang('manual_last_update')); 
       $this->grocery_crud->display_as('creationUserId',lang('creationUserId'));
       $this->grocery_crud->display_as('lastupdateUserId',lang('lastupdateUserId'));  
       $this->grocery_crud->display_as('markedForDeletion',lang('markedForDeletion'));
       $this->grocery_crud->display_as('markedForDeletionDate',lang('markedForDeletionDate'));
}

public function devices() {
	   if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect($this->login_page, 'refresh');
		}
       $this->current_table="inventory_object";
       $this->grocery_crud->set_table($this->current_table);       
       
       $this->set_common_columns_name();

       $output = $this->grocery_crud->render();
       
       $this->load_header($output);
       $this->load->view('devices_view.php',$output);
       $this->load->view('include/footer');         
} 	
	
	
	
	
	
	  

}
 
/* End of file main.php */
/* Location: ./application/controllers/main.php */

