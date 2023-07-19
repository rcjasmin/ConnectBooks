<?php
require_once '../classes/Database.php';
if ($_POST) {
    $Nom = (isset($_POST['Nom'])) ? htmlentities($_POST['Nom']) : NULL;
    $Logo = (isset($_FILES['Logo_entreprise'])) ? $_FILES['Logo_entreprise'] : NULL;
    $NomResponsable = (isset($_POST['NomResponsable'])) ? htmlentities($_POST['NomResponsable']) : NULL;
    $PrenomResponsable = (isset($_POST['PrenomResponsable'])) ? htmlentities($_POST['PrenomResponsable']) : NULL;
    $NomUtilisateur = (isset($_POST['NomUtilisateur'])) ? htmlentities($_POST['NomUtilisateur']) : NULL;
    
    $Commune = (isset($_POST['Commune'])) ? htmlentities($_POST['Commune']) : NULL;
    $Addresse = (isset($_POST['Addresse'])) ? htmlentities($_POST['Addresse']) : NULL;
    $Telephone1 = (isset($_POST['Telephone1'])) ? htmlentities($_POST['Telephone1']) : NULL;
    $Telephone2 = (isset($_POST['Telephone2'])) ? htmlentities($_POST['Telephone2']) : NULL;
    $Telephone3 = (isset($_POST['Telephone3'])) ? htmlentities($_POST['Telephone3']) : NULL;
    $Devise = (isset($_POST['Devise'])) ? htmlentities($_POST['Devise']) : NULL;

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['operation_type'])) ? htmlentities($_REQUEST['operation_type']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    
    $dest = "../entreprise_logos/";
    if($Logo != NULL && $_FILES['Logo_entreprise']['name'] != NULL && $_FILES['Logo_entreprise']['name'] != ""){
        $Logo ="http://beconnect-ht.com/entreprise_logos/".$_FILES['Logo_entreprise']['name'];
        $dest= $dest.$_FILES['Logo_entreprise']['name'];
        
        move_uploaded_file($_FILES['Logo_entreprise']['tmp_name'], $dest);
        
    } else {
        $Logo ="";
    }
    
    $params = array(
        'Id' => $Id,
        'Nom' => $Nom,
        'NomUtilisateur' => $NomUtilisateur,
        'Logo' =>$Logo,
        'NomResponsable' =>$NomResponsable,
        'PrenomResponsable' =>$PrenomResponsable,
        'Commune' => $Commune,
        'Addresse' => $Addresse,
        'Telephone1' => $Telephone1,
        'Telephone2' => $Telephone2,
        'Telephone3' => $Telephone3,
        'Devise' => $Devise,
        'UtilisateurId' => $userId,
        'OperationType' => $operationType
    );
    $data = json_encode($params);
    
    $query = "SELECT lottery.webapp_crud_entreprise('$data') AS RESPONSE";
    //error_log($query);
    $rs = Database::getInstance()->select($query);
    $row = $rs->fetchObject();
    $rs->closeCursor();
    echo $row->RESPONSE;

}
?>

