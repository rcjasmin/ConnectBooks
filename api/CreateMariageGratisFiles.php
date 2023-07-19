<?php
 require("../classes/Database.php");

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';

$query ="SELECT a.BanqueId,a.TirageId,JSON_OBJECT('Id',a.Id,
 'EntrepriseId',a.EntrepriseId,
 'BanqueId',a.BanqueId,
 'TirageId',a.TirageId,
 'MontantMinimum',a.MontantMinimum,
 'QuantitePari',QuantitePari) AS MARIAGE_GRATIS
 FROM lottery.innov_config_mariage_gratuit a
 WHERE a.EntrepriseId = '$entrepriseId'";

/*$query ="SELECT a.BanqueId,a.TirageId,JSON_OBJECT('Id',a.Id,
 'EntrepriseId',a.EntrepriseId,
 'BanqueId',a.BanqueId,
 'TirageId',a.TirageId,
 'MontantMinimum',a.MontantMinimum,
 'QuantitePari',QuantitePari) AS MARIAGE_GRATIS
 FROM lottery.innov_config_mariage_gratuit a";
 */

$rs = Database::getInstance()->select($query);
 
 while($row = $rs->fetchObject()){     
     $banqueId =  $row -> BanqueId;
     $tirageId =  $row -> TirageId;
     
     $filename = $banqueId."_MARIAGE_".$tirageId;
     $filename = "../datafiles/mariages/".$filename.".json";
     file_put_contents($filename,$row-> MARIAGE_GRATIS);
     echo ("File : ".$filename." Created.<br/>");   
 }
 $rs->closeCursor();

?>