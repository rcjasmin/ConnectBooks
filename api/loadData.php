<?php 
require("../classes/Database.php");
$dir="../datafiles/paris/JOUE/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if($file != "." && $file != ".." ){
                $data = file_get_contents($dir.$file);
                $num_trans = substr($file,0,10);
                
                $query = "SELECT Pari_POST_FROM_FILE('$data','$num_trans','','')";
                $rs = Database::getInstance()->select($query);
                echo $query;
                
             //echo $data. "<br />";
            }
        }
        closedir($dh);
    }
}

?>