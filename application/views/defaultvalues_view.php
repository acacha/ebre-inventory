<script>

$(document).ready(function(){
 
 //SELECT DEFAULT VALUES
 
 //EXTERNAL ID TYPE
 if (document.getElementById('field-externalIDType') != null) {
  var eit = document.getElementById('field-externalIDType');
   if (eit.value == "") {
    eit.value = <?php echo $defaultfieldexternalIDType ?>; 
    $('#field-externalIDType').trigger('liszt:updated');
   }
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
