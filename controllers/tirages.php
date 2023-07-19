<?php
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();

$where = " WHERE Statut ='ACTIF'";
$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_tirage" . $where;

$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT Id,Nom,GetHeureTirage('$entrepriseId',Id,'HEURE_OUVERTURE') AS HEURE_OUVERTURE, GetHeureTirage('$entrepriseId',Id,'HEURE_FERMETURE') AS HEURE_FERMETURE, GetHeureTirage('$entrepriseId',Id,'STATUT') AS Statut,IsConfigurationTirageExist('$entrepriseId',Id) AS IsExist FROM lottery.innov_tirage" . $where . " LIMIT $offset,$rows";
$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
