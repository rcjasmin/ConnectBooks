<?php
require_once '../classes/Database.php';

$r = (isset($_GET['r'])) ? htmlentities($_GET['r']) : '0';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$query = "SELECT Id,CONCAT(Nom,' ',Prenom) AS Nom FROM lottery.innov_pos_utilisateur WHERE ROLE='SUPERVISEUR' AND Statut <> 'SUPPRIME' AND EntrepriseId=" . $entrepriseId;
$rs = Database::getInstance()->select($query);
$result = array();

if ($r == 1) {
    
    $arr = array(
        "Id" => "",
        "Nom" => "TOUS LES SUPERVISEURS"
    );
    array_push($result, $arr);
}
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>
