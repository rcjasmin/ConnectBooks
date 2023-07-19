<?php
require_once '../classes/UtilisateurPosRatio.php';
if ($_POST) {
    $BOL = (isset($_POST['BOL'])) ? htmlentities($_POST['BOL']) : NULL;
    $MAR = (isset($_POST['MAR'])) ? htmlentities($_POST['MAR']) : NULL;
    $LO3 = (isset($_POST['LO3'])) ? htmlentities($_POST['LO3']) : NULL;
    $LO41 = (isset($_POST['LO41'])) ? htmlentities($_POST['LO41']) : NULL;
    $LO42 = (isset($_POST['LO42'])) ? htmlentities($_POST['LO42']) : NULL;
    $LO43 = (isset($_POST['LO43'])) ? htmlentities($_POST['LO43']) : NULL;
    $LO51 = (isset($_POST['LO51'])) ? htmlentities($_POST['LO51']) : NULL;
    $LO52 = (isset($_POST['LO52'])) ? htmlentities($_POST['LO52']) : NULL;
    $LO53 = (isset($_POST['LO53'])) ? htmlentities($_POST['LO53']) : NULL;
    $MAG = (isset($_POST['MAG'])) ? htmlentities($_POST['MAG']) : NULL;

    $Utilisateurs = (isset($_GET['utilisateurs'])) ? htmlentities($_GET['utilisateurs']) : NULL;
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";
    

    $obj = new UtilisateurPosRatio($Utilisateurs,$BOL,$MAR,$LO3,$LO41,$LO42,$LO43,$LO51,$LO52,$LO53,$MAG);
    $response = $obj -> crud($entrepriseId, $userId, $operationType);
    echo $response;
}
?>