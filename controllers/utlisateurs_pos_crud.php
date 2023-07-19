<?php
require_once '../classes/UtilisateurPos.php';
if ($_POST) {
    $Nom = (isset($_POST['Nom'])) ? htmlentities($_POST['Nom']) : NULL;
    $Prenom = (isset($_POST['Prenom'])) ? htmlentities($_POST['Prenom']) : NULL;
    $NomUtilisateur = (isset($_POST['NomUtilisateur'])) ? htmlentities($_POST['NomUtilisateur']) : NULL;
    $Role = (isset($_POST['Role'])) ? htmlentities($_POST['Role']) : NULL;
    $PourcentageCommission = (isset($_POST['PourcentageCommission'])) ? htmlentities($_POST['PourcentageCommission']) : NULL;
    $Telephone1 = (isset($_POST['Telephone1'])) ? htmlentities($_POST['Telephone1']) : NULL;
    $Telephone2 = (isset($_POST['Telephone2'])) ? htmlentities($_POST['Telephone2']) : NULL;
    $Telephone3 = (isset($_POST['Telephone3'])) ? htmlentities($_POST['Telephone3']) : NULL;
    $Statut = (isset($_POST['Statut'])) ? htmlentities($_POST['Statut']) : NULL;

    $Banques = (isset($_GET['b'])) ? htmlentities($_GET['b']) : NULL;
    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";
    
    $Banques = explode(",",$Banques);

    $obj = new UtilisateurPos($Id,$Nom,$Prenom,$NomUtilisateur,$Role,$Banques,$Telephone1,$Telephone2,$Telephone3,$PourcentageCommission,$Statut);
    $response = $obj -> crud($entrepriseId, $userId, $operationType);
    echo $response;
}
?>