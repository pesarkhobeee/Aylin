		<?php
			if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
		?>

    <div class="modal fade" id="user">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3>Change Password</h3>
   	</div>
    	<div class="modal-body">

	<ul id="task">
		<?php
			echo form_open('users/show_users',array('id'=>'user_form'));
			echo("<li>");
			echo form_label('Username  ', 'username');
			echo form_input('username');
			echo("</li><li>");
			echo form_label('Password  ', 'password');
			echo form_input('password');
			echo form_hidden('user_group', 'user');
			echo("</li>");
			echo form_close();
		?>
		</ul>

  	</div>
    <div class="modal-footer">
    	 <a href="#" onclick="document.getElementById('user_form').submit()" class="btn btn-primary">Submit User</a>
   	 <a href="#" class="btn">Close</a>
    </div>
    </div>

		
		
		
		
		<?php
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				<th>".anchor('#user', '<i class="icon-pencil"></i>', array('class' => 'btn','data-toggle'=>'modal'))."&nbsp;".anchor('users/customer_detail', '<i class="icon-user"></i>', array('class' => 'btn'))."</th>
				<th>Username</th>
				<th>Group</th>
				</tr>
				";
				
			foreach ($query_users->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/show_users/duser/'.$row->id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete'))."&nbsp;".anchor('users/show_users/uuser/'.$row->id, '<i class="icon-pencil"></i>', array('class' => 'btn','tooltip'=>'Update'))."&nbsp;"."</td>";
				echo "<td>".$row->username."</td>";
				echo "<td>".$row->user_group."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?>
