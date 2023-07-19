<?php
require_once '../classes/Database.php';

$banqueId = (isset($_GET['banque'])) ? htmlentities($_GET['banque']) : NULL;
$utilisateurId = (isset($_GET['utilisateur'])) ? htmlentities($_GET['utilisateur']) : NULL;

if(isset($banqueId)) {
  $query = "SELECT * FROM lottery.innov_vw_utilisateurs_pos_banques WHERE Role='VENDEUR' AND BanqueId=" . $banqueId;
} else {
    if(isset($utilisateurId)){
        $query = "SELECT * FROM lottery.innov_vw_utilisateurs_pos_banques WHERE UtilisateurId=" . $utilisateurId;
    } 
}
$rs = Database::getInstance()->select($query);
$result = array();
while ($row = $rs->fetchObject()) {
    array_push($result, $row);
}
$rs->closeCursor();

echo json_encode($result);

?>