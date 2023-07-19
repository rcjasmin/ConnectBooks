<?php
require_once '../classes/Database.php';

$UserId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : "0";
$CurrentPassword = (isset($_POST['CurrentPassword'])) ? htmlentities($_POST['CurrentPassword']) : "";
$NewPassword = (isset($_POST['NewPassword'])) ? htmlentities($_POST['NewPassword']) : "";

$query = "SELECT lottery.webapp_UpdatePasswordMasterUser('$UserId','$CurrentPassword','$NewPassword') AS RESPONSE";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo json_encode(array($row -> RESPONSE));

?>