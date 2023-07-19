<?php
require_once '../classes/Database.php';

$txtTirage = (isset($_GET['txtTirage'])) ? htmlentities($_GET['txtTirage']) : '';
$txtDateTirage = (isset($_GET['txtDateTirage'])) ? htmlentities($_GET['txtDateTirage']) : '';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';

$query = "SELECT StatutGenererGagnant FROM lottery.innov_boule_tirees WHERE EntrepriseId='$entrepriseId' AND TirageId='$txtTirage' AND DateTirage='$txtDateTirage' LIMIT 1";
//error_log($query);
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo $row -> StatutGenererGagnant;

?>