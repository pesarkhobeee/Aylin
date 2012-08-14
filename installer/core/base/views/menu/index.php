<?php
	if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
?>
<?php
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				<th>".anchor('/menu/add', '<i class="icon-user"></i>', array('class' => 'btn'))."&nbsp;</th>
				<th>نام منو</th>
				<th>آدرس منو</th>
				<th>بخش</th>
				<th>والد منو</th>
				</tr>
				";
				
			foreach ($query->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('/menu/index/'.$row->menu_id ,'<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;".anchor('menu/edit/'.$row->menu_id, '<i class="icon-pencil"></i>', array('class' => 'btn','tooltip'=>'Update'))."&nbsp;"."</td>";
				echo "<td>".$row->menu_name."</td>";
				echo "<td>".$row->menu_url."</td>";
				echo "<td>".$row->menu_section."</td>";
				echo "<td>".$row->parent."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?>
