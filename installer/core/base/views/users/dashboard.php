<div style="margin:auto 0px;">
<ul class="red_fonts logos" >
	<?php
	if( $this->session->userdata('user_group') == "root")
	{
		$this->db->join('links_group', 'links_logo.lg_id = links_group.lg_id', 'left');
		$this->db->where("lg_name","dashboard");
			
		$this->db->where("lg_name !=","slide");
		$query = $this->db->get("links_logo");
		$links="";
		foreach ($query->result() as $row)
		{
			$links.="<li>".anchor($row->ll_url, "<img  src='".base_url("assets/uploads/files")."/".$row->ll_img_url."'/>",array('class'=>'btn','data-original-title'=>$row->ll_title,'rel'=>'tooltip'))."</li>";
		}
		echo $links;
	}
 ?>
	
</ul>
</div>
