<?php
require_once '../classes/Database.php';

$limiteId = (isset($_GET['l'])) ? htmlentities($_GET['l']) : NULL;
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$query = "SELECT Id,  CONCAT('BANQUE ',Numero) AS Nom,IsBanqueLimited(Id,'".$limiteId."') AS EST_LIMITE FROM lottery.innov_banque WHERE EntrepriseId = ".$entrepriseId. " AND Statut <> 'SUPPRIME'";

$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>