<?php
require_once '../classes/Database.php';

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$query = "SELECT Id,GroupName FROM lottery.innov_webapp_usergroup WHERE Statut<>'SUPPRIME' AND GroupName<>'MASTER' AND EntrepriseId=" . $entrepriseId;
$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>