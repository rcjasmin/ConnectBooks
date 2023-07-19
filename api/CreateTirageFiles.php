<?php
 require("../classes/Database.php");
 
 $tirageId = (isset($_GET['t'])) ? htmlentities($_GET['t']) : '0';
 $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
 
$query ="SELECT JSON_OBJECT('TirageId',TirageId,
'Tirage',GetTirageNameById(TirageId),
'EntrepriseId',EntrepriseId,
'Entreprise', GetEntrepriseNameById(EntrepriseId),
'TirageKey',GetTirageKeyById(TirageId),
'Statut','ACTIF',
'HeureOuverture',RIGHT(HeureOuverture,10),
'HeureFermeture',RIGHT(HeureFermeture,10)) AS TIRAGE
FROM innov_entreprise_tirage
WHERE EntrepriseId='$entrepriseId' AND TirageId='$tirageId'  LIMIT 1";


 $rs = Database::getInstance()->select($query);
 
 $filename = $entrepriseId."_TIRAGE_".$tirageId;
 $filename = "../datafiles/tirages/".$filename.".json";
 
 if (file_exists($filename)) {
     unlink($filename);
 }
 
 while($row = $rs->fetchObject()){
     file_put_contents($filename,$row-> TIRAGE);
     echo ("File : ".$filename." Created.<br/>");   
 }
 $rs->closeCursor();

?>