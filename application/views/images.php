
<body>

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

 <div style='height:20px;'></div>  

<a href="<?php echo base_url('index.php/main/inventory_object');?>"><?php echo lang('come_back');?></a>
 
<?php echo $output;?>

</body>

