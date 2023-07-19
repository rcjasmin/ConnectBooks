<?php
require_once '../classes/Database.php';

$Id = (isset($_GET['Id'])) ? htmlentities($_GET['Id']) : '0';
$query = "SELECT lottery.webapp_SupprimerLimite('$Id') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>