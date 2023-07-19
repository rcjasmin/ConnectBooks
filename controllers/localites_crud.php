<?php
require_once '../classes/Departement.php';
if ($_POST) {
    $Nom = (isset($_POST['Nom'])) ? htmlentities($_POST['Nom']) : NULL;
    $Statut = (isset($_POST['Statut'])) ? htmlentities($_POST['Statut']) : NULL;

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";

    $obj = new Departement($Id, $Nom, $Statut);
    $response = $obj -> crud($entrepriseId, $userId, $operationType);
    echo $response;
    
    // echo json_encode ( array ('success' => true ) );
    // echo json_encode(array(  'errorMsg' => $response  ));
}
?>