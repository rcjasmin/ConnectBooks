<?php
require_once '../classes/Utilisateur.php';
if ($_POST) {
    $Nom = (isset($_POST['Nom'])) ? htmlentities($_POST['Nom']) : NULL;
    $Prenom = (isset($_POST['Prenom'])) ? htmlentities($_POST['Prenom']) : NULL;
    $NomUtilisateur = (isset($_POST['NomUtilisateur'])) ? htmlentities($_POST['NomUtilisateur']) : NULL;
    $Groupe = (isset($_POST['GroupeId'])) ? htmlentities($_POST['GroupeId']) : NULL;
    $Statut = (isset($_POST['Statut'])) ? htmlentities($_POST['Statut']) : NULL;

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";

    $obj = new Utilisateur($Id,$Nom,$Prenom,$NomUtilisateur,$Groupe,$Statut);
    $response = $obj -> crud($entrepriseId, $userId, $operationType);
    echo $response;
}
?>