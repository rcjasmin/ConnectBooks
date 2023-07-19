<?php
 require("../classes/Database.php");
 
 $banqueId = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';
 $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
 $fileNotExist = false;
 
 if ($banqueId != 0) {
 $query ="SELECT JSON_OBJECT('Id',a.Id,
    'EntrepriseId',EntrepriseId,
    'Numero',Numero,
    'Nom',CONCAT('BANQUE ',Numero),
    'Responsable',GetUserFullNameById(GetSuperviseurIdByBanqueId(a.Id)),
    'Departement',GetDepartementNameById(GetDepartementIdByCommuneId(CommuneId)),
    'Commune',GetCommuneNameById(CommuneId),
    'Addresse',a.Addresse,
    'Statut',a.Statut,
    'Telephone',GetPhonesByUserId(GetSuperviseurIdByBanqueId(a.Id))) AS BANQUE
    FROM lottery.innov_banque a  
    WHERE a.Statut <> 'SUPPRIME' AND Id = '$banqueId' LIMIT 1";
 }else{
     $query ="SELECT a.Id, JSON_OBJECT('Id',a.Id,
    'EntrepriseId',EntrepriseId,
    'Numero',Numero,
    'Nom',CONCAT('BANQUE ',Numero),
    'Responsable',GetUserFullNameById(GetSuperviseurIdByBanqueId(a.Id)),
    'Departement',GetDepartementNameById(GetDepartementIdByCommuneId(CommuneId)),
    'Commune',GetCommuneNameById(CommuneId),
    'Addresse',a.Addresse,
    'Statut',a.Statut,
    'Telephone',GetPhonesByUserId(GetSuperviseurIdByBanqueId(a.Id))) AS BANQUE
    FROM lottery.innov_banque a
    WHERE a.EntrepriseId='$entrepriseId' AND a.Statut <> 'SUPPRIME' ORDER BY a.Id DESC LIMIT 1";
     
 }
 
     $rs = Database::getInstance()->select($query);
     
     $filename = $entrepriseId."_BANQUE_".$banqueId;
     $filename = "../datafiles/banques/".$filename.".json";
     
     if (file_exists($filename)) {
         unlink($filename);
     } else {
         
         $fileNotExist = true;
     }
     
     $row = $rs->fetchObject();

     if($fileNotExist){
         $banqueId = $banqueId!=0?$banqueId:$row-> Id;
         $filename = $entrepriseId."_BANQUE_".$banqueId;
         $filename = "../datafiles/banques/".$filename.".json";
     }
     
      file_put_contents($filename,$row-> BANQUE);
      echo ("File  ".$filename." Created.<br/>");

     $rs->closeCursor();

?>