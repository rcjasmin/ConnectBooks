<?php
date_default_timezone_set('America/New_York');
$data = file_get_contents('php://input');
$obj = json_decode($data);
//$current_time = date("H:i:s");
$PariId = $obj -> PariId;
$numero_transaction = $obj -> NumeroTransaction;
$entrepriseId = $obj -> EntrepriseId;
$TirageId = $obj -> TirageId;
$RequestStatut ="FAILED";

$dbfile = "../datafiles/databases/entreprise_".$entrepriseId.".db";
$db = new SQLite3($dbfile);

$source = "../datafiles/paris/".$numero_transaction.".json";
$contenu = getFileContent($source);
    if ($contenu != null ) {

        $query = "SELECT COUNT(*) AS RESULT FROM tirage WHERE TirageId = '$TirageId' AND Statut='ACTIF' AND (TIME('now','localtime') BETWEEN HeureOuverture AND HeureFermeture)";
        $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);
        
            if( $count>0){
                
                $destination = "../datafiles/paris/JOUE/".$numero_transaction.".json";
                if( !copy($source, $destination) ) {
                    error("ERROR","Une erreur est survenu lors de la validation d''impression.");
                }
                else {
                    $RequestStatut ="SUCCESS";
                    chmod($destination,0777);
                    
                    $response= array('TransactionId' => 0,
                        'StatutTransaction'=> 'JOUE',
                        'StatutRequete'=>$RequestStatut
                    );
                    
                    $error=array('HTTP_CODE'=>'201',
                        'DATA' => $response);
                    $query = "UPDATE pari SET Statut='JOUE' WHERE PariId ='$PariId'";
                    executeQuery($dbfile,$query);
                    //$db->query($query);
                    echo json_encode($error);
                }
            } else { error("TIRAGE_NON_AUTORISE","Tirage sa pa otorize.");} //end if tirage is authorized logic
        
} else{ error("BET_NOT_EXIST","Jeu non retrouve.");  }
$db->close();
    
    

function getFileContent($fichier){
    
    if (file_exists($fichier)) {
        $contenu = json_decode(file_get_contents($fichier));
            return $contenu;
        } else return null;  
}

function error($errCode,$errMessage){
    $reponse = array('CODE_MESSAGE'=>$errCode,
        'MESSAGE'=>$errMessage);
    
    $error=array('HTTP_CODE'=>'401',
        'DATA' => $reponse);
    echo json_encode($error);
}

function getFileContent1($fichier){
    
    if (file_exists($fichier)) {
        $contenu = json_decode(file_get_contents($fichier));
        if ($contenu->Statut=="ACTIF") {
            return $contenu;
        } else return null;
    }else return null;
    
}

function getQueryResultObject($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $stmt = $db->query($query);
    $obj = $stmt->fetchObject();
    $db->commit();
    return $obj;
}

function executeQuery($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $db->query($query);
    $db->commit();
    return null;
}


?>