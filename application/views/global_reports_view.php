<style type="text/css">
div.dataTables_length label {
    width: 460px;
    float: left;
    text-align: left;
}
 
div.dataTables_length select {
    width: 75px;
}
 
div.dataTables_filter label {
    float: right;
    width: 460px;
}
 
div.dataTables_info {
    padding-top: 8px;
}
 
div.dataTables_paginate {
    float: right;
    margin: 0;
}
 
table {
    margin: 1em 0;
    clear: both;
}
</style>

<script type="text/javascript">
	
$.extend( $.fn.dataTableExt.oStdClasses, {
    "sSortAsc": "header headerSortDown",
    "sSortDesc": "header headerSortUp",
    "sSortable": "header"
} );
	

$(document).ready(function() {

	var oTable = $('#inventory').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>",
		"sPaginationType": "bootstrap",
		"sAjaxSource": '<?php echo base_url(); ?>index.php/reports/list_all',
        "bJQueryUI": true,
        "iDisplayStart ":100,
        "oLanguage": {
         "sProcessing": "<img src='<?php echo base_url(); ?>assets/img/ajax-loader-dark.gif'>"
        },  
        "fnInitComplete": function() {

                //oTable.fnAdjustColumnSizing();

         },

                'fnServerData': function(sSource, aoData, fnCallback)

            {

              $.ajax

              ({

                'dataType': 'json',

                'type'    : 'POST',

                'url'     : sSource,

                'data'    : aoData,

                'success' : fnCallback

              });

            }

	} );
});

</script>
<?php echo $this->table->generate(); ?>

