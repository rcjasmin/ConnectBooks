<?php
require_once '../classes/TouteBouleLimite.php';
if ($_POST) {

    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";
    $tirageId = (isset($_REQUEST['t'])) ? htmlentities($_REQUEST['t']) : "0";
    
    $MontantBOL = (isset($_POST['BOL'])) ? htmlentities($_POST['BOL']) : "0";
    $MontantMAR = (isset($_POST['MAR'])) ? htmlentities($_POST['MAR']) : "0";
    $MontantLO3 = (isset($_POST['LO3'])) ? htmlentities($_POST['LO3']) : "0";
    $MontantLO4 = (isset($_POST['LO4'])) ? htmlentities($_POST['LO4']) : "0";
    $MontantLO5 = (isset($_POST['LO5'])) ? htmlentities($_POST['LO5']) : "0";
    
    $obj = new TouteBouleLimite($tirageId, $MontantBOL, $MontantMAR,$MontantLO3,$MontantLO4,$MontantLO5);
    $response = $obj->crud($entrepriseId, $userId);
    
    echo $response;
}
?>




