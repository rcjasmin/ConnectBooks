<?php
require_once '../classes/Database.php';

$r = (isset($_GET['r'])) ? htmlentities($_GET['r']) : '0';
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';


$query = "SELECT Id,Nom FROM lottery.innov_entreprise WHERE Statut <> 'SUPPRIME'";

if ($userId <> 1 ){
    $query .= " AND Id NOT IN ('8','9')";
}
    
$rs = Database::getInstance()->select($query);
$result = array();

if ($r == 1) {
    
    $arr = array(
        "Id" => "",
        "Nom" => "TOUTES ENTREPRISES"
    );
    array_push($result, $arr);
}
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>
