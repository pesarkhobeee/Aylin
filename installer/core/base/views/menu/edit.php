
<?php echo form_open('menu/index'); ?>
<input type="hidden" name="menu_id" value="<?php echo $query->row("menu_id"); ?>" />
<ul style="list-style-type:none;direction:rtl;">
<li>نام منو</li>
<li><input type="text" name="menu_name" value="<?php echo $query->row("menu_name"); ?>" /></li>
<li>آدرس منو</li>
<li><input type="text" name="menu_url" value="<?php echo $query->row("menu_url"); ?>"  /></li>
<li>بخش</li>
<li>
<select name="menu_section">
	<?php
	foreach ($query_groups->result() as $row)
	{
		$tmp="";
		if($query->row("menu_section")==$row->g_name) $tmp="selected='selected'"; 
		echo "<option $tmp  value='".$row->g_name."'>".$row->g_name."</option>";
	}
	?>
	
</select>
</li>
<li>والد منو</li>
<li>
<select name="parent">
	<option value="NULL" >بدون والد</option>
<?php
	foreach ($parents->result() as $row2)
	{
		if($query->row("parent")!=$row2->menu_id)
			echo "<option value='".$row2->menu_id."'>".$row2->menu_name."</option>";
		else
			echo "<option selected='selected' value='".$row2->menu_id."'>".$row2->menu_name."</option>";
	}
?>
</select>
</li>
<li><input type="submit" value="بروز رسانی" /></li>
</ul>
<?php echo form_close(); ?>
