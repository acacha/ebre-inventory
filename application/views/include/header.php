<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="Inventory app">
   <meta name="keywords" content="Inventory Ebretic acacha">
   <meta name="author" content="Ebretic Enginyeria SL. Sergi Tur Badenas i Josep Llaó Angelats">

   <title><?php echo lang('inventory') . " " . $institution_name ;?> . Estat:
   <?php 
   if (isset($grocerycrudstate)) { 
    echo $grocerycrudstate_text;
   }
   ?>
   </title>

<!-- ICONS FOR APPLE: TODO -->
   <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
   <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
   <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    
<!-- FAVICON: TODO-->    
    <link rel="shortcut icon" href="assets/icon/favicon.png">
   
 
<?php if (isset($css_files)): ?>
 <!-- CSS GROCERY CRUD-->     
 <?php foreach($css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 <?php endforeach; ?>
<?php endif; ?>
       
<?php if (isset($js_files)): ?>
 <!-- JS GROCERY CRUD -->
 <?php foreach($js_files as $file): ?>
  <script src="<?php echo $file; ?>"></script>
 <?php endforeach; ?>
<?php endif; ?>

<!-- CSS PROPIS -->

<?php foreach($inventory_css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>


<!-- JS PROPIS -->
<?php foreach($inventory_js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>



<!-- PROVES ESBORRAR -->

<style type="text/css">
     body {
        padding-top: 60px;
		font-family: Arial;
                font-size: 14px;
               
		min-height:900
		
      }
      
	  
     footer {
		   
		color: #666;
		background: #222;
		padding: 17px 0 18px 0;
		border-top: 1px solid #000;
     }
     
    footer a {
		color: #999;
    }
    
    footer a:hover {
         	color: #efefef;
    }
    
.navbar-text img {
  max-height:30px;
  width:auto;
  vertical-align:middle;
}
		
</style>

</head>

<body>

<div class="navbar navbar-inverse navbar-fixed-top">
 <div class="navbar-inner">
   <div class="container">
    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="brand" href="#"> <i class="icon-home"> </i><?php echo lang('inventory');?></a>
  
    <div class="nav-collapse collapse">
            
     <ul class="nav">
      <li class="active"> <a href='<?php echo site_url('main/inventory')?>'><?php echo lang('inventory');?></a> </li>
       <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('devices');?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
         <li><a href='<?php echo site_url('main/devices')?>'><?php echo lang('computers');?></a></li>
         <li><a href='<?php echo site_url('main/todo')?>'><?php echo lang('others');?></a></li>
        </ul>
       </li>
       
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-toogle="tab"><?php echo lang('maintenances');?> <b class="caret"></b></a>
       <ul class="dropdown-menu">
		 <li><a href='<?php echo site_url('main/externalid')?>'><?php echo lang('externalid_menu');?></a></li>
         <li><a href='<?php echo site_url('main/organizationalunit')?>'><?php echo lang('organizationalunit_menu');?></a></li>
         <li><a href='<?php echo site_url('main/location')?>'><?php echo lang('location_menu');?></a></li>
         <li><a href='<?php echo site_url('main/material')?>'><?php echo lang('material_menu');?></a></li>
         <li><a href='<?php echo site_url('main/provider')?>'><?php echo lang('provider_menu');?></a></li>    
         <li><a href='<?php echo site_url('main/money_source')?>'><?php echo lang('money_source_menu');?></a></li>              
       </ul>                                                                                                                                                                                                                                                                                                                                      
      </li>
      <li class="dropdown">
       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('reports');?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href='<?php echo site_url('reports')?>'><?php echo lang('global_reports');?></a></li>
          <li><a href='<?php echo site_url('reports/todo1')?>'><?php echo lang('reports_by_organizationalunit');?></a></li>
          <li><a href='<?php echo site_url('reports/todo2')?>'>Informes per ...</a></li>                                            
        </ul>
      </li>
      
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('managment');?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href='<?php echo site_url('main/users')?>'><?php echo lang('users');?></a></li>
            <li><a href='<?php echo site_url('main/groups')?>'><?php echo lang('groups');?></a></li>
            <li><a href='<?php echo site_url('main/preferences')?>'><?php echo lang('preferences');?></a></li>                                            
          </ul>
      </li>
                                                                                              
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('language');?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?=base_url()?>index.php/main/inventory/?idioma=catalan"><?php echo lang('catalan');?></a></li>
            <li><a href="<?=base_url()?>index.php/main/inventory/?idioma=spanish"><?php echo lang('spanish');?></a></li>
            <li><a href="<?=base_url()?>index.php/main/inventory/?idioma=english"><?php echo lang('english');?></a></li>
          </ul>
      </li>
     </ul>               
   </div>
   <div class="pull-right navbar-text">
     <img src="http://placehold.it/30x30">
      <a href="<?=base_url()?>index.php/main/user_info" style="color:grey"><?php echo $this->session->userdata('username');?></a>      
      <a href="<?=base_url()?>index.php/inventory_auth/logout"><?php echo lang('CloseSession');?></a>              
   </div>
  </div>
 </div>
</div>

<?php 

if (isset($debug)) {
		print_r($session_data);
}
?>

<?php if (!isset($not_show_header2)): ?>

<script>

$(document).ready(function(){

$("#accordion").accordion();
$("#accordion").accordion( "option", "collapsible", true );
$("#accordion").accordion("option", "active", false );
$("#accordion").accordion({ heightStyle: "fill" });
$(".chosen").chosen();

/* Below Code Matches current object's (i.e. option) value with the array values */
/* Returns -1 if match not found */
var valArr = ["inventory_objectId","publicId","externalID"];

$('option').each( function() {
       if(jQuery.inArray(this.value, valArr) !=-1) {
         //alert("In array:" + this.value);
         $(this).attr('selected', true); 
         $('select').trigger('liszt:updated');
       }
});
   
//       if(jQuery.inArray(this.value, valArr) !=-1)

$('.reset').click(function(){
    $('option').prop('selected', false);
    $('select').trigger('liszt:updated');    
    var valArr = ["inventory_objectId","publicId","externalID"];
    
    $('option').each( 
     function() {
           if (jQuery.inArray(this.value, valArr) !=-1) {
             $(this).attr('selected', true);
             $('select').trigger('liszt:updated');
           }
     });
     
     $(".chosen").chosen().change();

});         


$('.select').click(function(){
    $('option').prop('selected', true);
    $('select').trigger('liszt:updated');
    $(".chosen").chosen().change();
});

$('.deselect').click(function(){
    $('option').prop('selected', false);
    $('select').trigger('liszt:updated');
    $(".chosen").chosen().change();

});

$(".chosen").chosen().change(function() {
   //alert("change!");
   //SELECTED VALUES
   //alert( $(".chosen").chosen().val() );
   //SELECTED VALUES IN JSON FORMAT
   //alert (JSON.stringify(  $(".chosen").chosen().val() ));
      
   // Ajax request sent to the CodeIgniter controller "ajax" method "username_taken"
   // post the username field's value
   
   
   $.post(
      'update_displayed_fields',
      { 'selected_columns': $(".chosen").chosen().val() } 
    ); 
    
    
});

});


</script>

<style type="text/css">
.chzn-container .chzn-results {
height: 150px;
font-size: xx-small;
}

</style>

<!-- JQUERY UI ACORDION -->

<div id="accordion">
<h3 style="font-size: x-small"><?php echo lang('fields_tho_show'); ?></h3>
<div style="font-size: xx-small; vertical-align:middle;">
<select id="table_fields" data-placeholder="<?php echo lang('choose_fields'); ?>" style="width:100%" class="chosen" multiple>
 <?php foreach($fields_in_table as $field): ?>
    <option value="<?php echo $field; ?>" ><?php echo lang($field); ?></option>
 <?php endforeach; ?>
</select>
<br/>
<button class="reset"><?php echo lang('reset'); ?></button>
<button class="select"><?php echo lang('select_all'); ?></button>
<button class="deselect"><?php echo lang('unselect_all'); ?></button>        
<button class="apply"><?php echo lang('apply'); ?></button>      

<div style='height:100px;'></div>        
</div>
                   
<!--
<h3 style="font-size: x-small">Section 2</h3>
 <div style="font-size: x-small">
  <p>
  Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
  purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
  velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
  suscipit faucibus urna.
  </p>
 </div>
-->
</div>
<?php endif; ?>

<!-- End of header-->
