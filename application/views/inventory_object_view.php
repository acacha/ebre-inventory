<!-- EXEMPLE ACORDIO 
<div id="accordion">
<h3 style="font-size: x-small">Camps a mostrar</h3>
<div style="font-size: x-small">
Camps:
<select id="table_fields2" data-placeholder="Escull els camps a mostrar" class="chosen" style="width:90%" multiple>
 <?php foreach($fields_in_table as $field): ?>
  <option value="<?php echo $field; ?>" ><?php echo $field; ?></option>
 <?php endforeach; ?>
</select>
    
</div>

<h3 style="font-size: x-small">Section 2</h3>
<div style="font-size: x-small">
<p>
Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
suscipit faucibus urna.
</p>
</div>
</div>
!-->

<!-- End of header-->
    <div style='height:30px;'></div>  
    <div style="margin:10px;">
        <?php echo $output; ?>
    </div>

</body>

