<?php
require_once '../classes/Banque.php';
if ($_POST) {
    $CommuneId = (isset($_POST['CommuneId'])) ? htmlentities($_POST['CommuneId']) : NULL;
    $Addresse = (isset($_POST['Addresse'])) ? htmlentities($_POST['Addresse']) : NULL;
    $Statut = (isset($_POST['Statut'])) ? htmlentities($_POST['Statut']) : NULL;

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";

    $obj = new Banque($Id,$CommuneId,$Addresse, $Statut);
    $response = $obj -> crud($entrepriseId, $userId, $operationType);
    echo $response;
}
?>