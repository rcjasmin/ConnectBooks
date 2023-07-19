<?php
require_once '../classes/Database.php';

$groupeId = (isset($_GET['groupeId'])) ? htmlentities($_GET['groupeId']) : NULL;
$query = "SELECT * FROM lottery.innov_vw_groupes_access WHERE GroupeId=" . $groupeId;

$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>