<?php
require_once '../classes/Database.php';

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
$tirageId = (isset($_GET['t'])) ? htmlentities($_GET['t']) : '0';

$query = "SELECT Id,GetTirageNameById(Id) AS Nom,HeureOuverture,HeureFermeture,Statut FROM lottery.innov_entreprise_tirage WHERE EntrepriseId='$entrepriseId' AND TirageId ='$tirageId'";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo json_encode($row);
?>