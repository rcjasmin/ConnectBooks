<?php

date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : "";
$BtnSearch = (isset($_POST['BtnSearch'])) ? htmlentities($_POST['BtnSearch']) : "";
$Banques = isset($_POST['Banque']) ? $_POST['Banque'] : "";
$DateDebut = isset($_POST['DateDebut']) ? htmlentities($_POST['DateDebut']) : "";
$DateFin = isset($_POST['DateFin']) ? htmlentities($_POST['DateFin']) : "";
$Tirages = isset($_POST['Tirage']) ? $_POST['Tirage'] : "";

if ($BtnSearch=="YES") {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $offset = ($page - 1) * $rows;
    $result = array();
    $where = " WHERE EntrepriseId='$entrepriseId' AND Statut IN ('JOUE','PAYE') ";
    $q = "";
    $t = "";
    if (isset($Banques) && $Banques != NULL && $Banques != '') {
        foreach ($Banques as $banque) {
            if (isset($banque) && $banque != "") {
                if ($q == "")
                    $q = "('" . $banque;
                    else
                        $q = $q . "','" . $banque;
            }
        }
        if ($q != "") {
            $q = $q . "')";
            $where .= " AND BanqueId IN " . $q;
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
            $where .= " AND TirageId IN " . $t;
        }
    }
    
    if (isset($DateDebut) && $DateDebut != NULL && $DateDebut != '') {
        $where .= " AND DATE(CreationDate) >= DATE('$DateDebut')";
    }
    
    if (isset($DateFin) && $DateFin != NULL && $DateFin != '') {
        $where .= " AND DATE(CreationDate) <= DATE('$DateFin')";
    }
    
    $total = 0;
    $query = "SELECT count(*) FROM lottery.innov_pari_historique";
    $query .= $where;
    $query .= "  GROUP BY BanqueId";
    
    $rs = Database::getInstance()->select($query);
    while ($row = $rs->fetchObject()) {
        $total ++;
    }
    $result["total"] = $total;
    $rs->closeCursor();
    
    $query = "SELECT BanqueId,
              CONCAT('BANQUE ',GetNumeroByBanqueId(BanqueId)) AS BANQUE,
              GetDeviseEntrepriseById(EntrepriseId)  AS DEVISE,
              GetUserFullNameById(GetSuperviseurIdByBanqueId(BanqueId))  AS SUPERVISEUR,
              GetFullAddreseBanqueById(BanqueId) AS ADRESSE,
              COUNT(*) AS TOTAL_FICHES,
              SUM(MontantTotal) AS MONTANT_VENTE,
              SUM(MontantGagne) AS MONTANT_PERTE,
              SUM(MontantCommission) AS MONTANT_COMMISSION,
              SUM(MontantTotal)-SUM(MontantGagne)-SUM(MontantCommission) AS BALANCE_TOTALE
              FROM lottery.innov_pari_historique";
    $query .= $where;
    $query .= " GROUP BY BanqueId ORDER BY BanqueId ASC LIMIT $offset,$rows";
    
    //error_log($query);
    
    $items = array();
    $rs = Database::getInstance()->select($query);
    
    
    $devise = '';
    while ($row = $rs->fetchObject()) {
        array_push($items, $row); 
        $devise = $row->DEVISE;
    }
    
    
    $query1 = "SELECT COUNT(*) AS TOTAL_FICHES,
     SUM(MontantTotal) AS MONTANT_VENTE,
     SUM(MontantGagne) AS MONTANT_PERTE,
     SUM(MontantCommission) AS MONTANT_COMMISSION,
     SUM(MontantTotal)-SUM(MontantGagne)-SUM(MontantCommission) AS BALANCE_TOTALE
     FROM lottery.innov_pari_historique";
    $query1 .= $where;
    
    //error_log($query1);
    $rs1 = Database::getInstance()->select($query1);
    $summary = $rs1->fetchObject();
    
    $footerArray = array(
        'SUPERVISEUR' => 'GRAND TOTAL',
        'TOTAL_FICHES' => $summary->TOTAL_FICHES, 
        'MONTANT_VENTE' => $summary->MONTANT_VENTE." ".$devise,
        'MONTANT_PERTE' => $summary->MONTANT_PERTE." ".$devise,
        'MONTANT_COMMISSION' => $summary->MONTANT_COMMISSION." ".$devise,
        'BALANCE_TOTALE' => $summary->BALANCE_TOTALE." ".$devise,
        'DEVISE' => $devise
    );
    $rs->closeCursor();
    $result["rows"] = $items;
    $result["footer"] = array(
        $footerArray
    );
    
    echo json_encode($result);
 }


?>
