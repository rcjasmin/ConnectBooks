<?php
require_once '../classes/Database.php';

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$limiteId = (isset($_GET['l'])) ? htmlentities($_GET['l']) : '0';
$banqueId = (isset($_GET['b'])) ? htmlentities($_GET['b']) : '0';
$operation = (isset($_GET['o'])) ? htmlentities($_GET['o']) : '';
$action = (isset($_GET['a'])) ? htmlentities($_GET['a']) : '';
$query = "SELECT lottery.webapp_updateLimiteBouleAccess('$entrepriseId','$limiteId','$banqueId','$userId','$operation','$action') AS RESPONSE";
//error_log($query);
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo $row->RESPONSE;
?>