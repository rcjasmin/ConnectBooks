<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$id = (isset($_GET['id'])) ? $_GET['id'] : "";

$query = "SELECT Id,TirageId,GetTirageNameById(TirageId) AS Tirage,CONCAT('BANQUE ',GetNumeroByBanqueId(BanqueId)) AS Banque, MontantMinimum,QuantitePari FROM innov_config_mariage_gratuit WHERE Id='$id'";
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();
$rs->closeCursor();
echo json_encode($row);

?>
