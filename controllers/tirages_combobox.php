<?php
require_once '../classes/Database.php';
$r = (isset($_GET['r'])) ? htmlentities($_GET['r']) : '0';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
 
if($entrepriseId !=0) {
    $query = "SELECT a.Id,a.Nom FROM lottery.innov_tirage a
    JOIN innov_entreprise_tirage b
    ON a.Id = b.TirageId WHERE
    a.Statut <> 'SUPPRIME'
    AND b.EntrepriseId='$entrepriseId'";
} else{
    $query = "SELECT a.Id,a.Nom FROM lottery.innov_tirage a
    WHERE a.Statut <> 'SUPPRIME'"; 
}

$rs = Database::getInstance()->select($query);

$result = array();
if ($r == 1) {
    $arr = array(
        "Id" => "",
        "Nom" => "TOUS LES TIRAGES"
    );
    array_push($result, $arr);
}
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>