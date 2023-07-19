<?php
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$search = isset($_POST['search']) ? htmlentities($_POST['search']) : NULL;

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();

$where = "WHERE GroupName LIKE '%$search%' AND EntrepriseId='$entrepriseId'";
$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_vw_groupes " . $where;
$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT *  FROM lottery.innov_vw_groupes " . $where . " LIMIT $offset,$rows";

$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
