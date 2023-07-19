<?php
require_once '../classes/Database.php';

$deviceId = (isset($_GET['deviceId'])) ? htmlentities($_GET['deviceId']) : '0';
$query = "SELECT Id,BanqueId AS Banque,CONCAT('BANQUE ',BanqueId) AS NomBanque,EMEI FROM lottery.innov_pos_device WHERE Id = '$deviceId'";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo json_encode($row);
?>