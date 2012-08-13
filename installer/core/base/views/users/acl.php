 
<?php
			if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
?>

    <div class="modal fade" id="group">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3>Create ACL</h3>
		</div>
    	<div class="modal-body">

			<ul style="list-style-type:none;" >
				<?php
					echo form_open('users/acl',array('id'=>'acl_forum'));
					echo("<li>");
					echo form_label('Page name or Group name ', 'name');
					echo form_input('name');
					echo("<li></li>");
					echo form_label('User Group ', 'value');
					echo form_input('value');					
					echo("</li>");
					echo form_close();
				?>
				</ul>
		</div>
		<div class="modal-footer">
			 <a href="#" onclick="document.getElementById('acl_forum').submit()" class="btn btn-primary">Submit ACL</a>
		 <a href="#" class="btn">Close</a>
		</div>
    </div>	
 
 
    <div class="modal fade" id="update">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3>Change ACL </h3>
   	</div>
    	<div class="modal-body">

	<ul id="task">
		<?php
			echo form_open('users/acl',array('id'=>'update_groups'));
			echo "<input type='hidden' name='id' id='id' />";
			echo("<li>");
			echo form_label('Page name or Group name ', 'name');
			echo form_input(array('name'=>'name','id'=>'name'));
			echo("<li></li>");
			echo form_label('User Group ', 'value');
			echo form_input(array('name'=>'value','id'=>'value'));					
			echo("</li>");
			echo form_close();
		?>
		</ul>

  	</div>
    <div class="modal-footer">
    	 <a href="#" onclick="document.getElementById('update_groups').submit()" class="btn btn-primary">Submit User</a>
   	 <a href="#" class="btn">Close</a>
    </div>
    </div>
 
 
   
		<?php
			echo  "<table class='table table-striped' width='100%' >
				<tr>
				<th>".anchor('#group', '<i class="icon-pencil"></i>', array('class' => 'btn','data-toggle'=>'modal'))."&nbsp;</th>
				<th>Page Name or Group Name</th>
				<th>users</th>
				</tr>
				";
				
			foreach ($query->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/acl/d/'.$row->id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;<a href='#update' class='btn' data-toggle='modal' onclick='document.getElementById(\"id\").value=".$row->id.";document.getElementById(\"name\").value=\"".$row->name."\";document.getElementById(\"value\").value=\"".$row->value."\"'><i class='icon-pencil' ></i></a>&nbsp;"."</td>";
				echo "<td>".$row->name."</td>";
				echo "<td>".$row->value."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?> 
