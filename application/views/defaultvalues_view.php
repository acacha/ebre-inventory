<script type="text/javascript" id="defaultvalues_view_script">
	
var load_css_file = function(css_file) {
	if ($('head').find('link[href="'+css_file+'"]').length == 0) {
		$('head').append($('<link/>').attr("type","text/css")
				.attr("rel","stylesheet").attr("href",css_file));
	}
};

var ei_noLoadfnOpenEditForm = function(this_element){

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

var set_form_default_values = function(){
	
	//MARKED FOR DELETION
	if (document.getElementById('field-<?php echo $table_name?>-markedForDeletion') != null) {
		var mfd=document.getElementById("field-<?php echo $table_name?>-markedForDeletion");
		if (mfd.value == "") {
			mfd.value = '<?php echo $defaultfieldmarkedfordeletion ?>';
		}
		//TRANSLATE MARKED FOR DELETION:
		mfd.options[1].text='<?php echo $no_translated ?>';
		mfd.options[2].text='<?php echo $yes_translated ?>';
		$('#field-<?php echo $table_name?>-markedForDeletion').trigger('liszt:updated');
	}
	
	//PRESERVATION STATE
	if (document.getElementById('field-<?php echo $table_name?>-preservationState') != null) {
		var ps = document.getElementById('field-<?php echo $table_name?>-preservationState');
		if (ps.value == "") {
			ps.value = '<?php echo $defaultfieldpreservationstate ?>';
		}
		//TRANSLATE PRESERVATION STATE:
		ps.options[1].text='<?php echo $good_translated ?>';
		ps.options[2].text='<?php echo $regular_translated ?>';
		ps.options[3].text='<?php echo $bad_translated ?>';
		$('#field-<?php echo $table_name?>-preservationState').trigger('liszt:updated');
	}
	

	/************************
	* USER PREFERENCES FORM *
	*************************/
	//THEME
	if (document.getElementById('field-<?php echo $table_name?>-theme') != null) {
		var theme = document.getElementById('field-<?php echo $table_name?>-theme');
		if (theme.value == "") {
			theme.value = '<?php echo $defaultfieldTheme ?>';	 
		}
		$('#field-<?php echo $table_name?>-theme').trigger('liszt:updated');
	}
	
	//LANGUAGE
	if (document.getElementById('field-<?php echo $table_name?>-language') != null) {
		var language = document.getElementById('field-<?php echo $table_name?>-language');
		if (language.value == "") {
			language.value = '<?php echo $defaultfieldLanguage ?>';
		}
		//TRANSLATE LANGUAGE:
		language.options[1].text='<?php echo $catalan_translated ?>';
		language.options[2].text='<?php echo $spanish_translated ?>';
		language.options[3].text='<?php echo $english_translated ?>';
		$('#field-<?php echo $table_name?>-language').trigger('liszt:updated');
	}
	
	/****************************
	* END USER PREFERENCES FORM *
	*****************************/

/*******************************************
* END SET DEFAULT VALUES FOR CHOSEN FIELDS *
********************************************/	 

}

//MAIN JAVASCRIPT CODE
var pageInitialized = false;


$(document).ready(function(){

 //ONLY IN LIST VIEW:	
 $('.qr_button').unbind('click');
 $('.qr_button').click(function(){
	ei_noLoadfnOpenEditForm($(this));
	return false;
 });
	
 //END OF ONLY LIST VIEW
 
 	
 //AVOID DOCUMENT READY TO EXECUTE TWO TIMES
 if (pageInitialized) return;
 pageInitialized = true;
 
 /***************************************
 * OUTSIDE FORM INITIALIZATION
 ****************************************/
 
 /** READONLY IMPLEMENTATION *********/
 //CHECK IF WE SET READ ONLY URL HASH (#readonly)
 if(window.location.hash.indexOf('readonly') != -1){
   //disable all input html elements:
   $('#main-table-box').find('input, textarea, button, select').attr('disabled','disabled');
   //HIDE BUTTONS
   $('.pDiv').hide();
 }
 /** END READONLY IMPLEMENTATION *********/
 
 /***************************************
 * END OUTSIDE FORM INITIALIZATION
 ****************************************/
 
 set_form_default_values();
 
});

</script>
