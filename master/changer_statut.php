<?php
require_once '../classes/Database.php';

$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$Id = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';
$statut = (isset($_GET['s'])) ? htmlentities($_GET['s']) : '';

$query = "SELECT lottery.webapp_ChangerStatutEntreprise('$Id','$statut','$userId') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo $row -> RESPONSE;

?>