<?php
require_once '../classes/Database.php';

$vendeurId = (isset($_GET['vendeur'])) ? htmlentities($_GET['vendeur']) : '0';
$query = "SELECT GetUserFullNameById('$vendeurId') AS Vendeur, GetMontantByAliasCode('BOL','$vendeurId') AS BOL,GetMontantByAliasCode('MAR','$vendeurId') AS MAR,GetMontantByAliasCode('LO3','$vendeurId') AS LO3,
GetMontantByAliasCode('LO41','$vendeurId') AS LO41,GetMontantByAliasCode('LO42','$vendeurId') AS LO42,GetMontantByAliasCode('LO43','$vendeurId') AS LO43,
GetMontantByAliasCode('LO51','$vendeurId') AS LO51,GetMontantByAliasCode('LO52','$vendeurId') AS LO52,GetMontantByAliasCode('LO53','$vendeurId') AS LO53,GetMontantByAliasCode('MAG','$vendeurId') AS MAG";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();

echo json_encode($row);

?>