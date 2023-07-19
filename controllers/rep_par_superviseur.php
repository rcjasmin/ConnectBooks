<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : "";
$Superviseurs = isset($_POST['Superviseur']) ? $_POST['Superviseur'] : "";
$DateDebut = isset($_POST['DateDebut']) ? htmlentities($_POST['DateDebut']) : NULL;
$DateFin = isset($_POST['DateFin']) ? htmlentities($_POST['DateFin']) : "";
$Tirages = isset($_POST['Tirage']) ? $_POST['Tirage'] : "";

if($DateDebut=="" && $DateFin==""){
    $DateDebut=$DateFin=date('Y-m-d');
}

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();
$where = " WHERE a.EntrepriseId='$entrepriseId' AND a.Statut IN ('JOUE','PAYE') ";


$q = "";
$t = "";
if (isset($Superviseurs) && $Superviseurs != NULL && $Superviseurs != '') {
    foreach ($Superviseurs as $superviseur) {
        if (isset($superviseur) && $superviseur != "") {
            if ($q == "")
                $q = "('" . $superviseur;
                else
                    $q = $q . "','" . $superviseur;
        }
    }
    if ($q != "") {
        $q = $q . "')";
        $where .= " AND a.SuperviseurId IN " . $q;
    }
}

if (isset($Tirages) && $Tirages != NULL && $Tirages != '') {
    foreach ($Tirages as $tirage) {
        if (isset($tirage) && $tirage != "") {
            if ($t == "")
                $t = "('" . $tirage;
                else
                    $t = $t . "','" . $tirage;
        }
    }
    if ($t != "") {
        $t = $t . "')";
        $where .= " AND a.TirageId IN " . $t;
    }
}


if (isset($DateDebut) && $DateDebut != NULL && $DateDebut != '') {
    $where .= " AND DATE(a.CreationDate) >= DATE('$DateDebut')";
}

if (isset($DateFin) && $DateFin != NULL && $DateFin != '') {
    $where .= " AND DATE(a.CreationDate) <= DATE('$DateFin')";
}


$query = "SELECT count(*) AS TOTAL FROM lottery.innov_pos_utilisateur WHERE EntrepriseId='$entrepriseId' AND Role='SUPERVISEUR' AND Statut='ACTIF' ";
$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT GetUserFullNameById(a.SuperviseurId) AS SUPERVISEUR,
          GetDeviseEntrepriseById(EntrepriseId) AS DEVISE,
	      COUNT(*) AS TOTAL_FICHES,
          SUM(a.MontantTotal) AS MONTANT_VENTE,
          SUM(a.MontantGagne) AS MONTANT_PERTE,
          SUM(a.MontantCommission) AS MONTANT_COMMISSION,
          SUM(a.MontantTotal)-SUM(a.MontantGagne)-SUM(a.MontantCommission) AS BALANCE_TOTALE
          FROM ( SELECT *,GetSuperviseurIdByBanqueId(BanqueId) AS SuperviseurId 
          FROM innov_pari) a";
$query .= $where;
$query .= " GROUP BY a.SuperviseurId LIMIT $offset,$rows";

//error_log($query);

$items = array();
$rs = Database::getInstance()->select($query);

$devise = "";

while ($row = $rs->fetchObject()) {    
    $devise = $row->DEVISE;
    array_push($items, $row);
}

$query1 = "SELECT SUM(a.MontantTotal) AS MONTANT_VENTE,
          SUM(a.MontantGagne) AS MONTANT_PERTE,
          SUM(a.MontantCommission) AS MONTANT_COMMISSION,
          SUM(a.MontantTotal)-SUM(a.MontantGagne)-SUM(a.MontantCommission) AS BALANCE_TOTALE
          FROM ( SELECT *,GetSuperviseurIdByBanqueId(BanqueId) AS SuperviseurId 
          FROM innov_pari) a";
$query1 .= $where;


//error_log($query1);
$rs1 = Database::getInstance()->select($query1);
$summary = $rs1->fetchObject();

$footerArray = array(
    'SUPERVISEUR' => 'GRAND TOTAL',
    'MONTANT_VENTE' => $summary->MONTANT_VENTE." ".$devise, //round($gtVentes,2),
    'MONTANT_PERTE' => $summary->MONTANT_PERTE." ".$devise, //round($gtPertes,2),
    'MONTANT_COMMISSION' => $summary->MONTANT_COMMISSION." ".$devise, //round($gtCommissions,2),
    'BALANCE_TOTALE' => $summary->BALANCE_TOTALE." ".$devise, //round($gtBalance,2),
    'DEVISE' => $devise
);
$rs->closeCursor();
$result["rows"] = $items;
$result["footer"] = array(
    $footerArray
);
echo json_encode($result);

?>
