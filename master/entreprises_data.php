<?php
require_once '../classes/Database.php';
$search = isset($_POST['search']) ? htmlentities($_POST['search']) : NULL;

$userId = isset($_GET['u']) ? htmlentities($_GET['u']) : NULL;


$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();

if($userId <> 1){
$where = "WHERE (Nom LIKE '%$search%' OR Commune LIKE '%$search%' OR Addresse LIKE '%$search%' OR PrenomResponsable LIKE '%$search%' OR NomResponsable LIKE '%$search%') AND Id NOT IN('8','9')";
} else {
    $where = "WHERE (Nom LIKE '%$search%' OR Commune LIKE '%$search%' OR Addresse LIKE '%$search%' OR PrenomResponsable LIKE '%$search%' OR NomResponsable LIKE '%$search%')";
}
$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_entreprise " . $where;
$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT *,CONCAT(PrenomResponsable,' ',NomResponsable) AS FullName, GetTotalPOSDeviceByEntrepriseId(Id) AS TotalPOS,
         webapp_GetMasterUtilisateur(Id) AS NomUtilisateur
         FROM lottery.innov_entreprise " . $where . " LIMIT $offset,$rows";

$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
