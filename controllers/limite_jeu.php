<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? $_GET['e'] : "";
$tirageId = isset($_GET['Tirage']) ? $_GET['Tirage'] : "";

$query = "SELECT * FROM lottery.innov_pari_limite_generale_jeu WHERE EntrepriseId ='$entrepriseId' AND TirageId ='$tirageId' ";

$items = array();
$rs = Database::getInstance()->select($query);

while ($row = $rs->fetchObject()) {
    array_push($items, $row); 
}

$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
