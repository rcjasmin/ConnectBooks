<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
$EstGagne = isset($_POST['EstGagne']) ? htmlentities($_POST['EstGagne']) : NULL;
$Statut = isset($_POST['Statut']) ? htmlentities($_POST['Statut']) : NULL;
$NumeroReference = isset($_POST['NumeroReference']) ? htmlentities($_POST['NumeroReference']) : NULL;
$Tirage = isset($_POST['Tirage']) ? htmlentities($_POST['Tirage']) : NULL;
$Banque = isset($_POST['Banque']) ? htmlentities($_POST['Banque']) : NULL;
$DateDebut = isset($_POST['DateDebut']) ? htmlentities($_POST['DateDebut']) : "";
$DateFin = isset($_POST['DateFin']) ? htmlentities($_POST['DateFin']) : "";


if($DateDebut=="" && $DateFin==""){
    $DateDebut=$DateFin=date('Y-m-d');
}

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();

$where = " WHERE EntrepriseId='$entrepriseId' AND Statut <> 'AJOUTE' ";

if(isset($EstGagne) && $EstGagne != NULL && $EstGagne != ''){
    $where .= " AND EstGagne='$EstGagne'";
}

if(isset($Tirage) && $Tirage != NULL && $Tirage != ''){
    $where .= " AND TirageId='$Tirage'";
}

if(isset($Banque) && $Banque != NULL && $Banque != ''){
    $where .= " AND BanqueId='$Banque'";
}

if(isset($Statut)&& $Statut != NULL && $Statut != ''){
    $where .= " AND Statut='$Statut'";
}

if(isset($NumeroReference)&& $NumeroReference != NULL && $NumeroReference != ''){
    $where .= " AND NumeroTransaction LIKE '%$NumeroReference%'";
}

if (isset($DateDebut) && $DateDebut != NULL && $DateDebut != '') {
    $where .= " AND DATE(CreationDate) >= DATE('$DateDebut')";
}

if (isset($DateFin) && $DateFin != NULL && $DateFin != '') {
    $where .= " AND DATE(CreationDate) <= DATE('$DateFin')";
}

$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_pari " . $where;

$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT Id,EntrepriseId,BanqueId,CONCAT('BANQUE ',GetNumeroByBanqueId(BanqueId)) AS NomBanque,
GetUserFullNameById(UtilisateurId)  AS Vendeur,
TirageId,GetTirageNameById(TirageId)  AS Tirage,NumeroTransaction,Statut,
CONCAT(MontantTotal,' ',Devise) AS MontantTotalComplet,NombrePari,EstGagne,
CONCAT(MontantGagne,' ',Devise) AS MontantGagneComplet,
CONCAT(MontantCommission,' ',Devise) AS MontantCommissionComplet,
CreationDate,EstPayePar,DatePaiement
FROM innov_pari " . $where . " ORDER BY CreationDate DESC  LIMIT $offset,$rows";

//error_log("$query");
$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
