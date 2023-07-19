<?php
require_once '../classes/Database.php';
//if ($_POST) {

    $Id = (isset($_REQUEST['id'])) ? htmlentities($_REQUEST['id']) : "0";
    $operationType = (isset($_REQUEST['OperationType'])) ? htmlentities($_REQUEST['OperationType']) : NULL;
    $userId = (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : "0";
    $entrepriseId = (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : "0";
    $TirageId = (isset($_REQUEST['Tirage'])) ? htmlentities($_REQUEST['Tirage']) : "0";
    $banques = (isset($_REQUEST['b'])) ? htmlentities($_REQUEST['b']) : "0";
    
    $MontantMinimum = (isset($_REQUEST['MontantMinimum'])) ? htmlentities($_REQUEST['MontantMinimum']) : 0;
    $QuantitePari = (isset($_REQUEST['QuantitePari'])) ? htmlentities($_REQUEST['QuantitePari']) : 0;
    
    $Banques = array();
    
    if($banques != "0") {
      $Banques = explode(",", $banques);
    }
    
    $param = array(           
        'Id' => $Id,
        'TirageId' => $TirageId,
        'MontantMinimum' =>$MontantMinimum,
        'QuantitePari' =>$QuantitePari,
        'Banques' =>$Banques,
        'OperationType' =>$operationType,
        'EntrepriseId' => $entrepriseId,
        'UtilisateurId' => $userId);
    
    $param = json_encode($param);
    $query = "SELECT webapp_crud_mariage_gratis('$param') AS RESULT";
    //echo $query;
    //error_log($query);
    $rs = Database::getInstance()->select($query);
    $row = $rs->fetchObject();
    $rs->closeCursor();

    echo ($row -> RESULT);
//}
    
 ?>




