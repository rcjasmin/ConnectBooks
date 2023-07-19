<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? $_GET['e'] : "";
$tirageId = isset($_GET['Tirage']) ? $_GET['Tirage'] : "";

$query = "SELECT GetMontantLimiteTicket('$entrepriseId','$tirageId','BOL') AS BOL,
GetMontantLimiteTicket('$entrepriseId','$tirageId','MAR') AS MAR,
GetMontantLimiteTicket('$entrepriseId','$tirageId','LO3') AS LO3,
GetMontantLimiteTicket('$entrepriseId','$tirageId','LO4') AS LO4,
GetMontantLimiteTicket('$entrepriseId','$tirageId','LO5') AS LO5";

$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo json_encode($row);

?>
