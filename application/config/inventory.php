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
$config['institution_name']	= "Institut Montsià";

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
$config['default_materialid']	= 1;

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


/* End of file inventory.php */
/* Location: ./application/config/inventory.php */
