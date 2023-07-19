<?php
date_default_timezone_set('America/New_York');
$data = file_get_contents('php://input');
$obj = json_decode($data);

$numero_transaction = $obj -> NumeroTransaction;
$entrepriseId = $obj -> EntrepriseId;
$TirageId = $obj -> TirageId;
$RequestStatut ="FAILED";


$source = "../datafiles/paris/".$numero_transaction.".json";
$contenu = getFileContent($source);
    if ($contenu != null ) {
        //check if tirages  authorized
        $current_time = date("h:i:s");
        $filename = "../datafiles/tirages/".$entrepriseId."_TIRAGE_".$TirageId.".json";
        $contenu = getFileContent1($filename);
        if ($contenu != null && ($contenu->HeureOuverture <= $current_time && $current_time <= $contenu->HeureFermeture ) ) {
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
                
               // JSON_OBJECT('TransactionId',_PariId,'StatutTransaction',GetPariStatus(_PariId),'StatutRequete',_RequestStatut);
                
                $error=array('HTTP_CODE'=>'201',
                    'DATA' => $response);
                unlink($source);
                echo json_encode($error);
            } 
        
        } else { error("TIRAGE_NON_AUTORISE","Tirage non-autorise.");  } 
    
} else{ error("BET_NOT_EXIST","Jeu non retrouve.");  }
    
    

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


?>