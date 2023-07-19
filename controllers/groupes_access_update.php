<?php
require_once '../classes/Database.php';

$id = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$statut = (isset($_GET['s'])) ? htmlentities($_GET['s']) : '';
$operation = (isset($_GET['o'])) ? htmlentities($_GET['o']) : '';
$query = "SELECT lottery.webapp_updateDroitAccess('$id','$statut','$userId','$operation') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>