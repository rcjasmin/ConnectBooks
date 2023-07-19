<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? $_GET['e'] : "";
$tirageId = isset($_GET['Tirage']) ? $_GET['Tirage'] : "";

$query = "SELECT GetMontantLimiteJeu('$entrepriseId','$tirageId','BOL') AS BOL,
GetMontantLimiteJeu('$entrepriseId','$tirageId','MAR') AS MAR,
GetMontantLimiteJeu('$entrepriseId','$tirageId','LO3') AS LO3,
GetMontantLimiteJeu('$entrepriseId','$tirageId','LO4') AS LO4,
GetMontantLimiteJeu('$entrepriseId','$tirageId','LO5') AS LO5";

$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo json_encode($row);

?>
