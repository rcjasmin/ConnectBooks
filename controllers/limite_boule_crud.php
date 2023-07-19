<?php
require_once '../classes/BouleLimite.php';
if ($_POST) {

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";
    $Tirages = (isset($_REQUEST['t'])) ? htmlentities($_REQUEST['t']) : NULL;
    $Jeux = (isset($_REQUEST['j'])) ? htmlentities($_REQUEST['j']) : NULL;
    
    if($Id == 0) {
    
    $Banques = (isset($_REQUEST['b'])) ? htmlentities($_REQUEST['b']) : NULL;
    $Boule = (isset($_POST['Boule'])) ? htmlentities($_POST['Boule']) : NULL;
    $Montant = (isset($_POST['Montant'])) ? htmlentities($_POST['Montant']) : NULL;
    $DateDebut = (isset($_POST['StartDate'])) ? htmlentities($_POST['StartDate']) : NULL;
    $DateFin = (isset($_POST['EndDate'])) ? htmlentities($_POST['EndDate']) : NULL;

    } else {
        $Banques = '0';
        $Boule = (isset($_POST['Boule1'])) ? htmlentities($_POST['Boule1']) : NULL;
        $Montant = (isset($_POST['Montant1'])) ? htmlentities($_POST['Montant1']) : NULL;      
        $DateDebut = (isset($_POST['StartDate1'])) ? htmlentities($_POST['StartDate1']) : NULL;
        $DateFin = (isset($_POST['EndDate1'])) ? htmlentities($_POST['EndDate1']) : NULL;
         
    }
    
    $Banques = explode(",", $Banques);
    $Tirages = explode(",", $Tirages);
    
    $obj = new BouleLimite($Id, $Tirages, $Banques, $Jeux, $Boule, $Montant, $DateDebut, $DateFin);
    $response = $obj->crud($entrepriseId, $userId, $operationType);
    
    echo $response;
}
?>




