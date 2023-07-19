<?php
require_once '../classes/Database.php';

$HeureOuverture = (isset($_POST['HeureOuverture'])) ? htmlentities($_POST['HeureOuverture']) : '';
$HeureFermeture = (isset($_POST['HeureFermeture'])) ? htmlentities($_POST['HeureFermeture']) : '';

$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
$statut = (isset($_GET['s'])) ? htmlentities($_GET['s']) : '';
$tirageId = (isset($_GET['t'])) ? htmlentities($_GET['t']) : '0';

$query = "SELECT lottery.webapp_ConfigurerEntrepriseTirage('$entrepriseId','$tirageId','$statut','$HeureOuverture','$HeureFermeture','$userId') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo $row -> RESPONSE;

?>