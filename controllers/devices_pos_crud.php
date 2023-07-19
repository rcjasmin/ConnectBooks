<?php
require_once '../classes/DevicePOS.php';
if ($_POST) {
    $androidId = (isset($_POST['EMEI'])) ? htmlentities($_POST['EMEI']) : NULL;
    $BanqueId = (isset($_POST['Banque'])) ? htmlentities($_POST['Banque']) : NULL;
    $Statut = (isset($_POST['Statut'])) ? htmlentities($_POST['Statut']) : NULL;

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";


    $obj = new DevicePOS($Id,$androidId,$BanqueId, $Statut);
    $response = $obj -> crud($userId, $operationType);
    echo $response;
}
?>