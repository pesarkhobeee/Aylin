<?php echo form_open('menu/index'); ?>
<ul style="list-style-type:none;direction:rtl;">
<li>نام منو</li>
<li><input type="text" name="menu_name" /></li>
<li>آدرس منو</li>
<li><input type="text" name="menu_url" /></li>
<li>بخش</li>
<li>
<select name="menu_section">
	<?php
	foreach ($query_groups->result() as $row)
	{
		echo "<option value='".$row->g_name."'>".$row->g_name."</option>";
	}
	?>
</select>
</li>
<li>والد منو</li>
<li>
<select name="parent">
	<option value="NULL" >بدون والد</option>
<?php
	foreach ($query->result() as $row)
	{
		echo "<option value='".$row->menu_id."'>".$row->menu_name."</option>";
	}
?>
</select>
</li>
<li><input type="submit" value="ثبت منو" /></li>
</ul>
<?php echo form_close(); ?>
