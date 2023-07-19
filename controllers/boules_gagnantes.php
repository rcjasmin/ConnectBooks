<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$Tirage = isset($_POST['Tirage']) ? htmlentities($_POST['Tirage']) : NULL;
$DateTirage = isset($_POST['DateTirage']) ? htmlentities($_POST['DateTirage']) : NULL;
$Boule = isset($_POST['Boule']) ? htmlentities($_POST['Boule']) : NULL;

if($DateTirage==NULL || $DateTirage==""  ){
    $DateTirage=date('Y-m-d');
}

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();

$where = " WHERE EntrepriseId='$entrepriseId' ";

if(isset($Tirage) && $Tirage != NULL && $Tirage != ''){
    $where .= " AND TirageId='$Tirage'";
}

if(isset($DateTirage)&& $DateTirage != NULL && $DateTirage != ''){
    $where .= " AND DateTirage='$DateTirage'";
}

if(isset($Boule)&& $Boule != NULL && $Boule != ''){
    $where .= " AND (LOTO3 LIKE '%$Boule%' OR LO2 LIKE '%$Boule%' OR LO3 LIKE '%$Boule%')";
}

$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_boule_tirees " . $where;

$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT Id,TirageId,GetTirageNameById(TirageId) AS Tirage,LOTO3,LO2,LO3,DateTirage,StatutGenererGagnant FROM lottery.innov_boule_tirees " . $where . " ORDER BY DateTirage DESC LIMIT $offset,$rows";
$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
