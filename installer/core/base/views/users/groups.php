<?php
			if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
?>

    <div class="modal fade" id="group">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3>Create Group</h3>
		</div>
    	<div class="modal-body">

			<ul id="task">
				<?php
					echo form_open('users/groups',array('id'=>'group_forum'));
					echo("<li>");
					echo form_label('Group name  ', 'g_name');
					echo form_input('g_name');
					echo("</li>");
					echo form_close();
				?>
				</ul>
		</div>
		<div class="modal-footer">
			 <a href="#" onclick="document.getElementById('group_forum').submit()" class="btn btn-primary">Submit Group</a>
		 <a href="#" class="btn">Close</a>
		</div>
    </div>	
 
 
    <div class="modal fade" id="update">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3>Change Group name</h3>
   	</div>
    	<div class="modal-body">

	<ul id="task">
		<?php
			echo form_open('users/groups',array('id'=>'update_groups'));
			echo "<input type='hidden' name='g_id' id='g_id' />";
			echo("<li>");
			echo form_label('Group name  ', 'g_name');
			echo form_input(array('name'=>'g_name','id'=>'g_name'));
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
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				<th>".anchor('#group', '<i class="icon-pencil"></i>', array('class' => 'btn','data-toggle'=>'modal'))."&nbsp;</th>
				<th>Group</th>
				</tr>
				";
				
			foreach ($query_users->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/groups/d/'.$row->g_id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;<a href='#update' class='btn' data-toggle='modal' onclick='document.getElementById(\"g_id\").value=".$row->g_id.";document.getElementById(\"g_name\").value=\"".$row->g_name."\"'><i class='icon-pencil' ></i></a>&nbsp;"."</td>";
				echo "<td>".$row->g_name."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?> 
