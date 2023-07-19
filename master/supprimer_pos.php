<?php
require_once '../classes/Database.php';

$DeviceId = (isset($_GET['DeviceId'])) ? htmlentities($_GET['DeviceId']) : '0';
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$query = "SELECT lottery.webapp_SupprimerPOS('$DeviceId','$userId') AS RESPONSE";
//error_log($query);
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>