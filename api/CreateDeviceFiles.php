<?php
 require("../classes/Database.php");
 
 $deviceId = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';
 $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
 $fileNotExist = false;
 
 if ($deviceId != 0) {
 $query ="  SELECT JSON_OBJECT('BanqueId',a.BanqueId,
 'AndroidID',EMEI,
 'Statut',Statut) AS DEVICE
 FROM lottery.innov_pos_device a 
 WHERE Id = '$deviceId' AND  a.Statut <> 'SUPPRIME'";
 $rs = Database::getInstance()->select($query);
 } else {
     $query ="SELECT a.Id,JSON_OBJECT('BanqueId',a.BanqueId,
     'AndroidID',EMEI,
     'Statut',Statut) AS DEVICE
     FROM lottery.innov_pos_device a
     WHERE GetEntrepriseIdByBanqueId(BanqueId)='$entrepriseId' AND a.Statut <> 'SUPPRIME' ORDER BY a.Id DESC LIMIT 1";
 }
 
 
 $rs = Database::getInstance()->select($query);
 
 $filename = $entrepriseId."_DEVICE_".$deviceId;
 $filename = "../datafiles/devices/".$filename.".json";
 
 if (file_exists($filename)) {
     unlink($filename);
 } else {
     
     $fileNotExist = true;
 }
 
 $row = $rs->fetchObject();
 
 if($fileNotExist){
     $banqueId = $deviceId!=0?$deviceId:$row-> Id;
     $filename = $entrepriseId."_DEVICE_".$banqueId;
     $filename = "../datafiles/devices/".$filename.".json";
 }
 
 file_put_contents($filename,$row-> DEVICE);
 echo ("File  ".$filename." Created.<br/>");
 
 $rs->closeCursor();
 

?>