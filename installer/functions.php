<?php
# recursively remove a directory
function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

function extractor($source,$destination){
		$zip = new ZipArchive;
	$open = $zip->open($source, ZIPARCHIVE::CHECKCONS);
//	 If the archive is broken(or just another file renamed to *.zip) the function will return error on httpd under windows, so it's good to check if the archive is ok with ZIPARCHIVE::CHECKCONS
	 if ($open === TRUE) {
	 if(!$zip->extractTo($destination)) {
	 die ("Error during extracting");
	 }
	 $zip->close();
}
 }
 
//extract last code igniter frame work zip file to install directory


    /**
     * Copy file or folder from source to destination, it can do
     * recursive copy as well and is very smart
     * It recursively creates the dest file or directory path if there weren't exists
     * Situtaions :
     * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination
     * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it
     * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest     
     * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest
     * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name
     * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name
     * @todo
     *     - Should have rollback technique so it can undo the copy when it wasn't successful
     *  - Auto destination technique should be possible to turn off
     *  - Supporting callback function
     *  - May prevent some issues on shared enviroments : http://us3.php.net/umask
     * @param $source //file or folder
     * @param $dest ///file or folder
     * @param $options //folderPermission,filePermission
     * @return boolean
     */
    function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755))
    {
        $result=false;
       
        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=copy($source, $__dest);
            chmod($__dest,$options['filePermission']);
           
        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }

            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!="..")
                {
                     if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);
           
        } else {
            $result=false;
        }
        return $result;
    }


function import_db_file($sql_file_adress){
	$pdo_driver=$_POST["db_driver"];
	$dbhost=$_POST["db_host"];
	$dbname=$_POST["db_name"];
	$dsn="$pdo_driver:host=$dbhost;dbname=$dbname";
	$user=$_POST["db_username"];
	$password=$_POST["db_password"];
	$db = new PDO($dsn, $user, $password);
	$db->exec("SET NAMES 'utf8';");
	$sql = file_get_contents($sql_file_adress);
	$qr = $db->exec($sql);
}

 
function auto_generate_insert($table_name,$source,$eskape=null)
{
 
    $pdo_driver=$_POST["db_driver"];
	$dbhost=$_POST["db_host"];
	$dbname=$_POST["db_name"];
	$dsn="$pdo_driver:host=$dbhost;dbname=$dbname";
	$user=$_POST["db_username"];
	$password=$_POST["db_password"];
	$db = new PDO($dsn, $user, $password);
	$db->exec("SET NAMES 'utf8';");
            
            $column="";
            $columnvalue="";
 
            foreach($source as $item=>$value){
                                if(isset($eskape))
                                        if(in_array($item,$eskape))
                                                continue;
                                if(!is_array($value)){
                                        $column.="`".$item."`,";
                                        $columnvalue.="'".$value."',";
                                        }else{
                                                foreach($value as $tmp){
                                                        $value2.=$tmp.",";
                                                }
                                        $column.="`".$item."`,";
                                        $columnvalue.="'".$value2."',";
                                        $value2="";
                                                }
                                }
                        $column=substr($column,0,strlen($column)-1);
 
            $columnvalue = substr($columnvalue,0,strlen($columnvalue)-1);
            $sql = "INSERT INTO $table_name ($column) VALUES ($columnvalue) ";
           
            if($db->query($sql))
                                return true;
                        else
                                return false;
}
                                







function replace_in_file($search_str,$replace_str,$file_address){
	// read the file
	$file = file_get_contents($file_address);
	// replace the data
	$file = str_replace($search_str, $replace_str, $file);
	// write the file
	file_put_contents($file_address, $file);
}



 function  GenerateKey($random_string_length = 16) {
	
	$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	 $string = '';
	 for ($i = 0; $i < $random_string_length; $i++) {
		  $string .= $characters[rand(0, strlen($characters) - 1)];
	 }

	return $string;
}

?> 
