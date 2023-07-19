<?php
require_once '../classes/Database.php';

$depatementId = (isset($_GET['departement'])) ? htmlentities($_GET['departement']) : NULL;
$query = "SELECT Id,Nom,Statut,webapp_GetUtilisateurFullNameById(CreationUser) AS CreationUser,CreationDate FROM lottery.innov_commune WHERE Statut<>'SUPPRIME' AND DepartementId=" . $depatementId;
$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>