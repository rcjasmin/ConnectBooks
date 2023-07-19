<?php
require_once '../classes/Database.php';

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$query = "SELECT Id,Nom FROM lottery.innov_departement WHERE Statut<>'SUPPRIME' AND EntrepriseId=" . $entrepriseId;
$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>