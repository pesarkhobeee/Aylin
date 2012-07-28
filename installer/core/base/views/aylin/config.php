<?php
if(isset($massege))
	echo $massege;

$conter=1;
echo '
<form action="" method="post" />
<div id="accordion2" class="accordion">';
			foreach ($groups->result() as $row)
			{
				echo '
	            <div class="accordion-group">
				<div class="accordion-heading">
                <a href="#collapse'.$conter.'" data-parent="#accordion2"  data-toggle="collapse" class="accordion-toggle">
                ';
				echo substr($row->group,7);
				echo '
				</a>
				</div>
				<div class="accordion-body collapse" id="collapse'.$conter.'" style="height: 0px;">
                <div class="accordion-inner">
				<div >
				<ul style="list-style-type : none;">
				';
				$this->db->where('group', $row->group); 
				foreach ($this->db->get("meta_data")->result() as $filds)
				{
					echo "<li>".$filds->name."</li>";
					echo "<input type='hidden' name='name[]' value='".$filds->name."'/>";
					echo "<li><input type='text' name='value[]' value='".$filds->value."' /></li>";
					echo "<input type='hidden' name='group[]' value='".$filds->group."'/>";
				}
				echo '
				</ul>
				</div>
				</div>
				</div>
				</div>
				';
			$conter++;
			}
echo '
</div>
<input type="submit" value="update" class="btn btn-success" />
</form>
';
