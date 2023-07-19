<?php
require_once '../classes/Database.php';

$departementId = (isset($_GET['d'])) ? htmlentities($_GET['d']) : NULL;
$query = "SELECT Id,Nom FROM lottery.innov_commune WHERE Statut<>'SUPPRIME' AND DepartementId=" . $departementId;
$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>