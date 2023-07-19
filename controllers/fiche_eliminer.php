<?php
require_once '../classes/Database.php';

$pariId = (isset($_GET['pariId'])) ? htmlentities($_GET['pariId']) : '0';
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$query = "SELECT lottery.webapp_EliminerFiche('$pariId','$userId') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>