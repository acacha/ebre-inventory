<script>
	
var ei_fnOpenEditForm = function(this_element){

	var href_url = this_element.attr("href");

	var dialog_height = $(window).height() - 80;

	//Close all
	$(".ui-dialog-content").dialog("close");

	$.ajax({
		url: href_url,
		data: {
			is_ajax: 'true'
		},
		type: 'post',
		dataType: 'json',
		beforeSend: function() {
			this_element.closest('.flexigrid').addClass('loading-opacity');
		},
		complete: function(){
			this_element.closest('.flexigrid').removeClass('loading-opacity');
		},
		success: function (data) {
			if (typeof CKEDITOR !== 'undefined' && typeof CKEDITOR.instances !== 'undefined') {
					$.each(CKEDITOR.instances,function(index){
						delete CKEDITOR.instances[index];
					});
			}

		//	LazyLoad.loadOnce(data.js_lib_files);
			//LazyLoad.load(data.js_config_files);

			//$.each(data.css_files,function(index,css_file){
			//	load_css_file(css_file);
			//});

			$("<div/>").html(data.output).dialog({
				width: 910,
				modal: true,
				height: dialog_height,
				close: function(){
					$(this).remove();
				},
				open: function(){
					var this_dialog = $(this);

					$('#cancel-button').click(function(){
						this_dialog.dialog("close");
					});

				}
			});
		}
	});
};

$(document).ready(function(){
	
$('.qr_button').unbind('click');
$('.qr_button').click(function(){
	ei_fnOpenEditForm($(this));
	return false;
});
 
//CHECK IF WE SET READ ONLY URL HASH (#readonly)
 if(window.location.hash.indexOf('readonly') != -1){
   //disable all input html elements:
   $('#main-table-box').find('input, textarea, button, select').attr('disabled','disabled');
   //HIDE BUTTONS
   $('.pDiv').hide();
 }
 
//SELECT DEFAULT VALUES
/*
<?php if ( isset($defaultuserId)) {?>
    //userId
	if (document.getElementById('field-userId') != null) {
		var userId = document.getElementById('field-userId');
		if (userId.value == "") {
			userId.value = <?php echo $defaultuserId ?>;	 
		}
		$('#field-userId').trigger('liszt:updated');
	}		
<?php }?>
*/
 
 //creationUserId
 if (document.getElementById('field-creationUserId') != null) {
  var creationUserId = document.getElementById('field-creationUserId');
  document.getElementById('field-creationUserId').disabled = true;
  if (creationUserId.value == "") {
   creationUserId.value = <?php echo $defaultcreationUserId ?>;	 
  }
  $('#field-creationUserId').trigger('liszt:updated');
 }
 
 //lastupdateUserId
 if (document.getElementById('field-lastupdateUserId') != null) {
  var lastupdateUserId = document.getElementById('field-lastupdateUserId');
  document.getElementById('field-lastupdateUserId').disabled = true;
  if (lastupdateUserId.value == "") {
   lastupdateUserId.value = <?php echo $defaultcreationUserId ?>;	 
  }
  $('#field-lastupdateUserId').trigger('liszt:updated');
 }
 
 //EXTERNAL ID TYPE
 if (document.getElementById('field-externalIDType') != null) {
  var eit = document.getElementById('field-externalIDType');
   if (eit.value == "") {
    eit.value = <?php echo $defaultfieldexternalIDType ?>; 
    $('#field-externalIDType').trigger('liszt:updated');
   }
 } 
 
 //Add URL to express add External Id Type
 //externalIDType_input_box
 $("#externalIDType_input_box").after("&nbsp; <a href=\"<?php echo base_url('index.php/main/externalIDType/add');?>\">Afegir</a>");

 
 
 //field-mainOrganizationaUnitId
 if (document.getElementById('field-mainOrganizationaUnitId') != null) {
  var mainOrganizationaUnitId = document.getElementById('field-mainOrganizationaUnitId');
  if (mainOrganizationaUnitId.value == "") {
   document.getElementById('field-mainOrganizationaUnitId').value = '<?php echo $defaultmainOrganizationaUnitId ?>';
   $('#field-mainOrganizationaUnitId').trigger('liszt:updated');
  }
 }
 
 //USER FORM
 
 //field-active
 if (document.getElementById('field-active') != null) {
  var fa=document.getElementById("field-active");
  if (fa.value == "") {
   fa.value = '<?php echo $user_form_default_active ?>';
  }
  $('#field-active').trigger('liszt:updated');
 }
 
 //field-mainOrganizationaUnitId
 if (document.getElementById('field-mainOrganizationaUnitId') != null) {
  var moui=document.getElementById("field-mainOrganizationaUnitId");
  if (moui.value == "") {
   moui.value = '<?php echo $user_form_default_MainOrganizationaUnitId ?>';
  }
  $('#field-mainOrganizationaUnitId').trigger('liszt:updated');
 }
 
 //field-groups
 if (document.getElementById('field-groups') != null) {
  var fg=document.getElementById("field-groups");
  if (fg.value == "") {
   fg.value = '<?php echo $user_form_default_group ?>';
  }
  $('#field-groups').trigger('liszt:updated');
 }
 
 //LOCATION
 if (document.getElementById('field-location') != null) {
  var location = document.getElementById('field-location');
  if (location.value == "") {
   location.value = <?php echo $defaultfieldlocation ?>;	 
   $('#field-location').trigger('liszt:updated');
  }
 }
 
 //MONEY SOURCE ID 
 if (document.getElementById('field-moneySourceId') != null) {
  var msi = document.getElementById('field-moneySourceId');
  if (msi.value == "") {
   document.getElementById('field-moneySourceId').value = <?php echo $defaultfieldmoneysourceid ?>;
   $('#field-moneySourceId').trigger('liszt:updated');
  }
 }
 
 //PROVIDER
 if (document.getElementById('field-providerId') != null) {
  var provider = document.getElementById('field-providerId');
  if (provider.value == "") {
   document.getElementById('field-providerId').value = <?php echo $defaultfieldprovider ?>;
   $('#field-providerId').trigger('liszt:updated');
  }
 }
 
 //PARENT MATERIAL
 if (document.getElementById('field-parentMaterialId') != null) {
  var parentMaterialId = document.getElementById('field-parentMaterialId');
  if (parentMaterialId.value == "") {
   document.getElementById('field-parentMaterialId').value = <?php echo $defaultfieldparentMaterialId ?>;
   $('#field-parentMaterialId').trigger('liszt:updated');
  }
 }
 
 //MATERIAL
 if (document.getElementById('field-materialId') != null) {
  var parentMaterialId = document.getElementById('field-materialId');
  if (parentMaterialId.value == "") {
   document.getElementById('field-materialId').value = <?php echo $defaultfieldMaterialId ?>;
   $('#field-materialId').trigger('liszt:updated');
  }
 }
 
 //BRAND
 if (document.getElementById('field-brandId') != null) {
  var parentMaterialId = document.getElementById('field-brandId');
  if (parentMaterialId.value == "") {
   document.getElementById('field-brandId').value = <?php echo $defaultfieldBrandId ?>;
   $('#field-brandId').trigger('liszt:updated');
  }
 }
 
 //MODEL
 if (document.getElementById('field-modelId') != null) {
  var parentMaterialId = document.getElementById('field-modelId');
  if (parentMaterialId.value == "") {
   document.getElementById('field-modelId').value = <?php echo $defaultfieldModelId ?>;
   $('#field-modelId').trigger('liszt:updated');
  }
 }
 
 //theme
 if (document.getElementById('field-theme') != null) {
  var theme = document.getElementById('field-theme');
  if (theme.value == "") {
   theme.value = '<?php echo $defaultfieldTheme ?>';	 
  }
  $('#field-theme').trigger('liszt:updated');
 }
 
 //PRESERVATION STATE
 if (document.getElementById('field-preservationState') != null) {
  var ps = document.getElementById('field-preservationState');
  if (ps.value == "") {
   ps.value = '<?php echo $defaultfieldpreservationstate ?>';
  }
  //TRANSLATE PRESERVATION STATE:
  ps.options[1].text='<?php echo $good_translated ?>';
  ps.options[2].text='<?php echo $regular_translated ?>';
  ps.options[3].text='<?php echo $bad_translated ?>';
  $('#field-preservationState').trigger('liszt:updated');
 }
 
 //LANGUAGE
 if (document.getElementById('field-language') != null) {
  var language = document.getElementById('field-language');
  if (language.value == "") {
   language.value = '<?php echo $defaultfieldLanguage ?>';
  }
  //TRANSLATE PRESERVATION STATE:
  language.options[1].text='<?php echo $catalan_translated ?>';
  language.options[2].text='<?php echo $spanish_translated ?>';
  language.options[3].text='<?php echo $english_translated ?>';
  $('#field-language').trigger('liszt:updated');
 }
 
 //MARKED FOR DELETION
 if (document.getElementById('field-markedForDeletion') != null) {
  var mfd=document.getElementById("field-markedForDeletion");
  if (mfd.value == "") {
   mfd.value = '<?php echo $defaultfieldmarkedfordeletion ?>';
  }
  //TRANSLATE MARKED FOR DELETION:
  mfd.options[1].text='<?php echo $no_translated ?>';
  mfd.options[2].text='<?php echo $yes_translated ?>';
  $('#field-markedForDeletion').trigger('liszt:updated');
 }
 
 //DISABLE markedForDeletionDate
 var $markedForDeletion = $('#field-markedForDeletion');
 var $markedForDeletionDate = $('#field-markedForDeletionDate');
 $markedForDeletion.change(function () {
    if ($markedForDeletion.val() == 'y') {
	    $markedForDeletionDate.removeAttr('disabled'); 
    } else {
		$markedForDeletionDate.attr('disabled', 'disabled').val('');
	}
 }).trigger('change'); // added trigger to calculate initial state
 

  //$('#field-manualEntryDate').datetimepicker('setTime','16:55');
});


/*
//CHOOSEN

$(".chosen").chosen();
$("#accordion").accordion();
$("#accordion").accordion({ icons: { "header": "ui-icon-triangle-1-e", "activeHeader": "ui-icon-triangle-1-s" } });
$("#accordion").accordion({ collapsible: true });
$("#accordion").accordion({ heightStyle: "content" });

/*

//*** Hiding jQuery Chosen's search box for 10 or less results.
$("select").chosen().each(function () {
$(this).on("liszt:showing_dropdown", function () {
 var $chzn   = $(this).next()
 , $results  = $(this).next().find(".chzn-results li");
                    
if ($results.length <= 10) {
$chzn.find(".chzn-search").hide();
}
});
});

*/

/*    var city = "Thanjavur";
    var value = $("#field-markedForDeletion option:contains("+city+")").attr('selected', 'selected');
    $(".chosen-select").val(city);
    $(".chosen-select").trigger("liszt:updated");

$("#table_fields").multiselect({  
   selectedText: "# de # seleccionats",
   noneSelectedText: "camps",
   checkAllText: "Marcar tots",
   uncheckAllText: "Desmarcar tots",
   minWidth: "250"
   });

var valArr = ["inventory_objectId","publicId","externalID"];
*/
 
/* Below Code Matches current object's (i.e. option) value with the array values */
/* Returns -1 if match not found */

/*$("#table_fields").multiselect("widget").find(":checkbox").each(function(){
       if(jQuery.inArray(this.value, valArr) !=-1)
       this.click();              
});   

$('#table_fields').change(function(){
    alert($(this).val());
    });
*/


/*
EXEMPLE DE MULTISELECT
 OCO! GROCERYCRUD NOMES CARREGA ELS JS I CSS EN CAS DE NECESSITAR-LOS, és a dir no els carrega a la vista de camps si no al afegir/editar camps!
 
$(function(){
// choose either the full version
$("#table_fields").multiselect();
// or disable some features
$("#table_fields").multiselect({sortable: false, searchable: false});
});


});
*/
</script>
