<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| INSTITUTION NAME
|--------------------------------------------------------------------------
|
| Institution name
| 
| Example: Institut de l'Ebre
*/
$config['institution_name']	= "Institut de l'Ebre";

/*
|--------------------------------------------------------------------------
| Default external Id type
|--------------------------------------------------------------------------
|
| Database Id of the default external ID
| 
| Example: 1
*/
$config['default_externalID_type']	= 1;

/*
|--------------------------------------------------------------------------
| Default location
|--------------------------------------------------------------------------
|
| Database Id of the default location ID
| 
| Example: 1
*/
$config['default_location']	= 1;


/*
|--------------------------------------------------------------------------
| Default money source id
|--------------------------------------------------------------------------
|
| Database Id of the default money source ID
| 
| Example: 1
*/
$config['default_moneysourceid']	= 1;

/*
|--------------------------------------------------------------------------
| Default provider id
|--------------------------------------------------------------------------
|
| Database Id of the default provider ID
| 
| Example: 1
*/
$config['default_provider']	= 1;

/*
|--------------------------------------------------------------------------
| Default material id
|--------------------------------------------------------------------------
|
| Database Id of the default material ID
| 
| Example: 1
*/

$config['default_materialid']   = 1;

/*
|--------------------------------------------------------------------------
| Default brand id
|--------------------------------------------------------------------------
|
| Database Id of the default brand ID
| 
| Example: 1
*/

$config['default_brandid']   = 1;

/*
|--------------------------------------------------------------------------
| Default model id
|--------------------------------------------------------------------------
|
| Database Id of the default model ID
| 
| Example: 1
*/

$config['default_modelid']   = 1;


/*
|--------------------------------------------------------------------------
| Default preservation state
|--------------------------------------------------------------------------
|
| Value of default select option for preservation state field
| 
| Example: Good
*/
$config['default_preservationState'] = "Good";

/*
|--------------------------------------------------------------------------
| Default marked for deletion value
|--------------------------------------------------------------------------
|
| Value of default marked for deletion field
| 
| Example: Good
*/
$config['default_markedfordeletionvalue'] = "n";

/*
|--------------------------------------------------------------------------
| ENABLE DEBUG?
|--------------------------------------------------------------------------
|
| Enables debug showing more info to developers. Disable this on production site
| 
| Example: false
*/
$config['debug'] = false;

/*
|--------------------------------------------------------------------------
| DISABLE USERS?
|--------------------------------------------------------------------------
|
| Disable users in app. All actions are permited and the user is admin. 
| Useful for debugging puposes
| 
| Example: false
*/
$config['disable_users'] = true;

/*
|--------------------------------------------------------------------------
| SUPPORTED REALMS
|--------------------------------------------------------------------------
|
| Supported Authentication Realms
| 
| Example: ldap,mysql
*/
$config['realms'] = "mysql,ldap";

/*
|--------------------------------------------------------------------------
| DEFAULT REALM
|--------------------------------------------------------------------------
|
| Default realm at login box
| 
| Example: ldap
*/
$config['default_realm'] = "ldap";

/*
|--------------------------------------------------------------------------
| GROUP WITH READONLY ROLE
|--------------------------------------------------------------------------
|
| Groups with readonly acces to app
| 
| Example: inventory_readonly
*/
$config['readonly_group'] = "inventory_readonly";


/*
|--------------------------------------------------------------------------
| GROUP WITH ADMIN ROLE
|--------------------------------------------------------------------------
|
| Groups with admin role
| 
| Example: inventory_readonly
*/
$config['admin_group'] = "inventory_admin";


// DEFAULT FIELDS
  
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  inventory_object
|--------------------------------------------------------------------------
* 'inventory_objectId',
    'publicId',  
    'externalID',
    'externalIDType',
    'name',
    'shortName',  
    'description',
    'materialId', 
    'brandId',  
    'modelId',  
    'entryDate',
    'manualEntryDate',
    'last_update',
    'manualLast_update',
    'creationUserId',  
    'lastupdateUserId',
    'location',
    'quantityInStock',
    'price',
    'moneySourceId',
    'providerId',
    'preservationState',
    'markedForDeletion',
    'markedForDeletionDate',
    'file_url'
* 
*/
$config['default_fields_table_inventory_object'] = array (
    'quantityInStock',
    'shortName', 
    'publicId',  
    'externalID', 
    'materialId',
    'brandId',
    'modelId',
    'OwnerOrganizationalUnit',
    'entryDate',  
    'last_update',
    'lastupdateUserId',
    'location',
    'file_url'
    );
  
/*


/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  model
|--------------------------------------------------------------------------
*   'modelId',
    'name',
    'shortName',  
    'description',      
    'entryDate',       
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_model'] = array (
    'name',
    'shortName',  
    'description',         
    'entryDate',       
    'last_update',      
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );
    
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  material
|--------------------------------------------------------------------------
*   'materialId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_material'] = array (
    'name',
    'shortName',           
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );
    
  
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  externalIDType
|--------------------------------------------------------------------------
*   'externalIDTypeID',
    'name',
    'shortName',       
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_externalIDType'] = array (
    'name',
    'shortName',       
    'description',      
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );
  
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  organizational_unit
|--------------------------------------------------------------------------
*   'organizational_unitId',
    'externalCode',
    'name', 
    'shortName',       
    'description',     
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'parentLocation',   
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_organizational_unit'] = array (
    'externalCode',
    'name',
    'shortName',       
    'description',      
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );
    
    
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  location
|--------------------------------------------------------------------------
*   'locationId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'parentLocation',   
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_location'] = array (
    'name',
    'shortName',           
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'parentLocation',      
    'markedForDeletion',   
    'markedForDeletionDate'
    );
    
  
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  material
|--------------------------------------------------------------------------
*   'materialId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_material'] = array (
    'name',
    'shortName',           
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );
    

/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  brand
|--------------------------------------------------------------------------
*   'brandId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_brand'] = array (
    'name',
    'shortName',           
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );


/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  provider
|--------------------------------------------------------------------------
*   'providerId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_provider'] = array (
    'name',
    'shortName',           
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );


/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  money_source
|--------------------------------------------------------------------------
*   'moneySourceId',
    'name',
    'shortName',        
    'description',      
    'entryDate',        
    'last_update',      
    'creationUserId',   
    'lastupdateUserId', 
    'markedForDeletion',
    'markedForDeletionDate',
* 
*/
$config['default_fields_table_money_source'] = array (
    'name',
    'shortName',        
    'description',         
    'entryDate',           
    'last_update',         
    'creationUserId',      
    'lastupdateUserId',    
    'markedForDeletion',   
    'markedForDeletionDate'
    );


/*       
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  users
|--------------------------------------------------------------------------
*   'id',
    'ip_address',
    'username',  
    'password',  
    'salt',
    'email',
    'activation_code',
    'forgotten_password_code',
    'forgotten_password_time',
    'remember_code',
    'created_on',   
    'last_login',   
    'active',
    'first_name',
    'last_name', 
    'company',   
    'phone',     
* 
*/

$config['default_fields_table_users'] = array (
    'username',   
    'email',
    'created_on',   
    'last_login',
    'active',
    'first_name',
    'last_name',
    'company',
    'phone',
    );
    
/*
|--------------------------------------------------------------------------
| DEFAULT FIELDS TABLE  groups
|--------------------------------------------------------------------------
*   'id',
    'name',
    'description'
* 
*/
$config['default_fields_table_groups'] = array (
    'name',
    'description'   
    ); 

/* End of file inventory.php */
/* Location: ./application/config/inventory.php */
