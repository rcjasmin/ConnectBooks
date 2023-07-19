<?php
require_once '../classes/Database.php';

$tirageId = (isset($_GET['t'])) ? htmlentities($_GET['t']) : '0';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$query = "SELECT Id AS BanqueId,GetIdMariageGratis(Id,'$tirageId') AS Id,GetIdMariageGratis(Id,'$tirageId') AS Cid,Nom,GetMontantMinimumMariageGratis(Id,'$tirageId') AS MontantMinimum, GetQuantiteMariageGratis(Id,'$tirageId') AS QuantitePari FROM lottery.innov_vw_banques WHERE Statut <> 'SUPPRIME' AND EntrepriseId=" . $entrepriseId;
$rs = Database::getInstance()->select($query);
$result = array();


while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>
