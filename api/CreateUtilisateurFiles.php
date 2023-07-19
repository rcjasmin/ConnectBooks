<?php
 require("../classes/Database.php");
 
 $vendeurId = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';
 $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
 $fileNotExist = false;
 
 if ($vendeurId != 0) {
 $query ="SELECT JSON_OBJECT('Id',a.Id,
 'EntrepriseId',EntrepriseId,
 'Nom',a.Nom,
 'Prenom',a.Prenom,
 'Role',a.Role,
 'NomUtilisateur',NomUtilisateur,
 'Telephone',GetPhonesByUserId(a.Id),
 'Statut',Statut) AS UTILISATEUR
 FROM lottery.innov_pos_utilisateur a 
 WHERE Id = '$vendeurId' AND  a.Statut <> 'SUPPRIME'";
 

 } else {
     $query ="SELECT a.Id,JSON_OBJECT('Id',a.Id,
 'EntrepriseId',EntrepriseId,
 'Nom',a.Nom,
 'Prenom',a.Prenom,
 'Role',a.Role,
 'NomUtilisateur',NomUtilisateur,
 'Telephone',GetPhonesByUserId(a.Id),
 'Statut',Statut) AS UTILISATEUR
 FROM lottery.innov_pos_utilisateur a 
 WHERE a.EntrepriseId= '$entrepriseId' AND a.Statut <> 'SUPPRIME' ORDER BY a.Id DESC LIMIT 1";
 }
 
 echo $query;
 $rs = Database::getInstance()->select($query);
 
 $filename = $entrepriseId."_UTILISATEUR_".$vendeurId;
 $filename = "../datafiles/utilisateurs/".$filename.".json";
 
 if (file_exists($filename)) {
     unlink($filename);
 } else {
     
     $fileNotExist = true;
 }
 
 $row = $rs->fetchObject();
 
 if($fileNotExist){
     $vendeurId = $vendeurId!=0?$vendeurId:$row-> Id;
     $filename = $entrepriseId."_UTILISATEUR_".$vendeurId;
     $filename = "../datafiles/utilisateurs/".$filename.".json";
 }
 
 file_put_contents($filename,$row-> UTILISATEUR);
 echo ("File  ".$filename." Created.<br/>");
 
 $rs->closeCursor();
 

?>