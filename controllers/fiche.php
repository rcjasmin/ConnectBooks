<?php
require_once '../classes/Database.php';

$pariId = (isset($_GET['pariId'])) ? htmlentities($_GET['pariId']) : '0';
$query = "SELECT Fiche_GET('$pariId') AS RESPONSE";
//error_log($query);
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>