<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Inventory Lang - Catalan
*
* Author: Sergi Tur Badenas
* 		  sergitur@ebretic.com
*         @sergitur
*
* Author: ...
*         @....
*
*
* Created:  31.05.2013
*
* Description:  Català per a l'aplicació d'inventari
*
*/

//GENERAL
$lang['inventory']       		= 'Inventari';
$lang['remember']       		= 'Recordar';

//LOGIN FORM
$lang['login-form-greetings']   = 'Si us plau, entreu';
$lang['User']   = 'Usuari';
$lang['Password']   = 'Paraula de pas';
$lang['Register']   = 'Registrar';
$lang['Login']   = 'Entrar';


// Camps
$lang['name']       		= 'Nom';
$lang['shortName']        	= 'Nom curt';           
$lang['description']            = 'Descripció';
$lang['entryDate']              = "Data d'entrada (automàtica)";
$lang['manualEntryDate']        = "Data d'entrada (manual)";
$lang['last_update']            = 'Última actualització (automàtica)';
$lang['manual_last_update']     = 'Última actualització (manual)';
$lang['creationUserId']         = 'Usuari de creació';
$lang['lastupdateUserId']       = 'Usuari darrera actualització';
$lang['materialId']             = 'Tipus de material';
$lang['brandId']             = 'Marca';
$lang['brand']             = 'Marca';
$lang['modelId']             = 'Model';
$lang['location']               = 'Ubicació';
$lang['quantityInStock']        = 'Quantitat'; 
$lang['price']                  = 'Preu'; 
$lang['moneySourceIdcolumn']    = 'Font dels diners'; 
$lang['providerId']             = 'Proveïdor'; 
$lang['preservationState']      = 'Estat de conservació'; 
$lang['markedForDeletion']      = 'Baixa lògica?'; 
$lang['markedForDeletionDate']  = 'Data de baixa'; 
$lang['file_url']               = 'Fitxer principal'; 
$lang['OwnerOrganizationalUnit']  = 'Unitat organitzativa'; 
$lang['publicId'] = 'Id públic';
$lang['externalId'] = 'Id extern';
$lang['externalID'] = 'Id extern';
$lang['externalIDType'] = 'Tipus Id extern';
$lang['Id'] = 'Id';
$lang['id'] = 'Id';

$lang['code'] = 'Codi';
$lang['parentLocation'] = 'Espai pare';
$lang['parentMaterialId'] = 'Material pare'; 

//SUBJECTS
$lang['object_subject'] = 'objecte';
$lang['externalID_subject']       		= 'identificador extern';
$lang['organizationalunit_subject']     = 'unitat organitzativa';
$lang['location_subject']     = 'ubicació';
$lang['material_subject']     = 'tipus material';
$lang['brand_subject']     = 'marca';
$lang['model_subject']     = 'model';
$lang['provider_subject']     = 'proveïdor';
$lang['money_source_id_subject'] = 'origen dels diners';
$lang['users_subject'] = 'usuari';
$lang['groups_subject'] = 'grup';

//BUTTONS
$lang['reset'] = 'Reset';
$lang['select_all'] = 'Seleccionar tot';
$lang['unselect_all'] = 'Deseleccionar tot';
$lang['apply'] = 'Aplicar';

//PLACEHOLDERS
$lang['choose_fields'] = 'Escull els camps a mostrar';
$lang['fields_tho_show'] = 'Camps a mostrar';


//ACTIONS
$lang['Images'] = 'Imatges';
$lang['QRCode'] = 'Codi QR';
$lang['View'] = 'Veure';

//LOGIN & AUTH
$lang['CloseSession'] = 'Tancar Sessió';

//MENUS
$lang['devices'] = 'Dispositius';
 $lang['computers'] = 'Ordinadors';
 $lang['others'] = 'Altres';

$lang['maintenances'] = 'Manteniments';
 $lang['externalid_menu'] = 'Típus Identificadors externs';
 $lang['organizationalunit_menu'] = 'Unitats Organitzatives';
 $lang['location_menu'] = 'Espais';
 $lang['brand_menu'] = 'Marques';
 $lang['model_menu'] = 'Models';
 $lang['material_menu'] = 'Tipus Material';
 $lang['provider_menu'] = 'Proveïdors';
 $lang['money_source_menu'] = 'Origen Diners';

$lang['reports'] = 'Informes';
 $lang['global_reports'] = 'Informes globals';
 $lang['reports_by_organizationalunit'] = 'Informes per unitat organitzativa';

$lang['managment'] = 'Gestió';
 $lang['users'] = 'Usuaris';
 $lang['groups'] = 'Grups';
 $lang['preferences'] = 'Preferències';

//ERRORS
$lang['404_page_not_found'] = '404 Pàgina no trobada';
$lang['404_page_not_found_message'] = "La pàgina que heu demanat no s'ha pogut trobar";
$lang['table_not_found'] = 'Taula no trobada';
$lang['table_not_found_message'] = "La taula no s'ha pogut trobar";

 
//OPTIONS
$lang['Good'] = 'Bo';
$lang['Regular'] = 'Regular';
$lang['Bad'] = 'Dolent';
$lang['Yes'] = 'Si';
$lang['No'] = 'No';

//SUPPORTED LANGUAGES
$lang['language'] = 'Idioma';
$lang['catalan'] = 'Català';
$lang['spanish'] = 'Castellà';
$lang['english'] = 'Anglès';

$lang['ip_address'] = 'Adreça IP';
$lang['username'] = "Nom d'usuari";
$lang['email'] = 'Correu electrònic';
$lang['activation_code'] = "Codi d'activació";
$lang['forgotten_password_code'] = 'Codi paraula de pas oblidada';
$lang['forgotten_password_time'] = 'Temps de la paraula de pas oblidada' ;
$lang['remember_code'] = 'Codi de recuperació';
$lang['created_on'] = 'Creat el';
$lang['active'] = 'Actiu';
$lang['first_name'] = 'Nom';
$lang['last_name'] = 'Cognoms';
$lang['company'] = 'Companyia';
$lang['phone'] = 'Telèfon';


$lang['Filter by organizational units'] = 'Filtrar per unitats organitzatives';
$lang['choose_organization_unit'] = 'Escolliu una unitat organitzativa';

$lang['maintenance_mode_message'] = "El sistema es troba actualment en manteniment. No podeu entrar a l'aplicació en aquests moments, proveu més tard o poseu-vos en contacte amb l'administrador. Disculpeu les molèsties.";
$lang['maintenance_mode']="Mode manteniment";
$lang['maintenance_mode_login_error_message']="El login no és correcte";

$lang['grocerycrud_state_unknown']="Desconegut";
$lang['grocerycrud_state_listing']="Llistant";
$lang['grocerycrud_state_adding']="Afegint";
$lang['grocerycrud_state_editing']="Editant";
$lang['grocerycrud_state_deleting']="Esborrant";
$lang['grocerycrud_state_inserting']="inserting";
$lang['grocerycrud_state_updating']="Actualitzant";
$lang['grocerycrud_state_listing_ajax']="Llista ajax";
$lang['grocerycrud_state_listing_ajax_info']="Llista d'informació Ajax";
$lang['grocerycrud_state_inserting_validation']="Validant inserció";
$lang['grocerycrud_state_uploading_validation']="Validant pujada de fitxer";
$lang['grocerycrud_state_uploading_file']="Pujant fitxer";
$lang['grocerycrud_state_deleting_file']="Esborrant fitxer";
$lang['grocerycrud_state_ajax_relation']="Relació Ajax";
$lang['grocerycrud_state_ajax_relation_n_n']="Relació Ajax n_n";
$lang['grocerycrud_state_exit']="Èxit";
$lang['grocerycrud_state_exporting']="Exportant";
$lang['grocerycrud_state_printing']="Imprimint";

$lang['login_unsuccessful_not_allowed_role'] = "El login és correcte però l'usuari no té un rol adequat per accedir a l'aplicació";
