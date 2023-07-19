<?php
require_once '../classes/Database.php';

$txtTirage = (isset($_POST['txtTirage'])) ? htmlentities($_POST['txtTirage']) : '';
$txtDateTirage = (isset($_POST['txtDateTirage'])) ? htmlentities($_POST['txtDateTirage']) : '';
$txtLotto3 = (isset($_POST['txtLotto3'])) ? htmlentities($_POST['txtLotto3']) : '';
$txtLo2 = (isset($_POST['txtLo2'])) ? htmlentities($_POST['txtLo2']) : '';
$txtLo3 = (isset($_POST['txtLo3'])) ? htmlentities($_POST['txtLo3']) : '';

$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : '0';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';

$Id = (isset($_GET['id'])) ? htmlentities($_GET['id']) : '0';

$query = "SELECT lottery.AjouterBoulesGagnantesTEST('$Id','$entrepriseId','$txtTirage','$txtDateTirage','$txtLotto3','$txtLo2','$txtLo3','$userId') AS RESPONSE";
//error_log($query);
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo $row -> RESPONSE;

?>