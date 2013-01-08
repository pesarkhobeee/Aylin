<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aylin_base extends CI_Controller {

	public function __construct()
	{
	            parent::__construct();
	            // Your own constructor code
	            $this->load->helper(array('form', 'url'));
	     
	}

	public function config(){

		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		$key=true;
		if(isset($_POST["group"])){
			for($i=0;$i<count($_POST["group"]);$i++)
			{
		
				$tmp_array = array("value"=>$_POST["value"][$i]);
				
				$this->db->where('group', $_POST["group"][$i]);
				$this->db->where('name', $_POST["name"][$i]);
				
				if(!$this->db->update('meta_data', $tmp_array)){
					$data["massege"]=" <div class='fade in alert alert-error'>
						               <a data-dismiss='alert' class='close'><i class='icon-remove'></i></a>
						                 <strong>Sorry!</strong> Operation Failed.
					                      </div>";
					$key=false;
				}
			}

			if($key==true)
			{
					$data["massege"]="<div class='fade in alert alert-success'>
					<a data-dismiss='alert' class='close'><i class='icon-remove'></i></a>
					<strong>Well done!</strong> Field Successfully Updated</div>";
			}

		}
		
		
		$this->db->like('group', 'config', 'after'); 
		$this->db->select('group');
		$this->db->distinct();
		$data["groups"]= $this->db->get('meta_data');
		
		
		$this->load->view('admin_them/header');
		$this->load->view('aylin/config',$data);
		$this->load->view('admin_them/footer');
	}
	
	
	function upload()
	{
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		$this->load->view('admin_them/header');
		$this->load->view('aylin/upload_form', array('error' => ' ' ));
		$this->load->view('admin_them/footer');
	}
	
	
	function do_upload()
	{

		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|zip';
		//$config['max_size']	= '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin_them/header');
			$this->load->view('aylin/upload_form', $error);
			$this->load->view('admin_them/footer');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('admin_them/header');
			$this->load->view('aylin/upload_success', $data);
			$this->load->view('admin_them/footer');
		}
	}

	
/* backup the db OR just a table */
function _backup_tables($tables = '*')
{
	$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');

  $link = mysql_connect($this->db->hostname,$this->db->username,$this->db->password);
  mysql_select_db($this->db->database,$link);
   //mysql_set_charset("charset=utf8");  
    mysql_query("SET NAMES 'utf8'");
    mysql_query("SET CHARACTER SET utf8");
    mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  $return="";
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
    
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = preg_replace("#\n#", "\\n", $row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  
  
  
  return $return;

		
}

	public function backup_dl(){
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		
		header("Content-type: application/octet-stream");
		header('Content-Disposition: attachment; filename='.'db-backup-'.date("Y-m-d_H:i:s").'.sql');
		echo $this->_backup_tables();
	}
	
	public function backup_mail()
	{
		$this->load->helper('file');
		
		$filename = "./assets/backup/".'db-backup-'.date("Y-m-d_H:i:s").'.sql';
		$attechment = $this->_backup_tables();
		
		write_file($filename,$attechment);
		
		
		$content ="<p style='direction:rtl'>";
		$content .= "Backup UP :" . $filename;
		$content .="</p>";
		

		$to = $this->aylin->config("backup_mail","config_mail");
		
		$this->aylin->send_mail("پشتیبان گیری خودکار",$content,$to,"normal",$filename);
		
		delete_files("./assets/backup/");
		
	}

	
}

