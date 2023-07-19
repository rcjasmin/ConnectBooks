<?php
date_default_timezone_set('America/New_York');
$data = file_get_contents('php://input');
$obj = json_decode($data);
$userId =0;
$date_trx_db =  date('Y-m-d H:i:s');
$date_trx =  date('d-m-Y h:i:s A');

$obj->HEADER ->dt = $date_trx_db;
$data = json_encode($obj);

//check if if enterprise if authorized
$filename = "../datafiles/entreprises/ENTREPRISE_".$obj->HEADER ->e.".json";
$contenu = getFileContent($filename);
if ($contenu != null ) {
    //check if if enterprise if authorized
    //$filename = "../datafiles/banques/".$obj->HEADER ->e."_BANQUE_".$obj->HEADER ->b.".json";
    // echo $filename;
    //$contenu = getFileContent($filename);
    
    //if ($contenu != null ) {
    //check if if device if authorized
    //$filename = "../datafiles/devices/".$obj->HEADER ->b."_DEVICE_".$obj->HEADER ->a.".json";
    //$contenu = getFileContent($filename);
    
    // if ($contenu != null ) {
    //check if if user  authorized
    //  $filename = "../datafiles/utilisateurs/".$obj->HEADER ->e."_UTILISATEUR_".$obj->HEADER ->u.".json";
    // $contenu = getFileContent($filename);
    
    // if ($contenu != null ) {
    //check if tirages  authorized
    $filename = "../datafiles/tirages/".$obj->HEADER ->e."_TIRAGE_".$obj->HEADER ->t.".json";
    $contenu = getFileContent($filename);
    $current_time = date("H:i:s");
    if ($contenu != null && ($contenu->HeureOuverture <= $current_time && $current_time <= $contenu->HeureFermeture ) ) {
        $numero_trx = generateNumeroTransaction();
        
        $filename = $numero_trx;
        $filename = "../datafiles/paris/".$filename.".json";
        file_put_contents($filename,$data);
        chmod($filename,07777);
        
        $response= array('TransactionId' => 0,
            'NumeroTransaction'=> $numero_trx,
            'DateTransaction'=>$date_trx,
            'StatutTransaction'=>'AJOUTE',
            'UtilisateurId'=> $obj->HEADER ->u,
            'EntrepriseId'=> $obj->HEADER ->e,
            'TirageId'=> $obj->HEADER ->t,
            'QuantiteMariageGratis' => 0,
            'RatioMariageGratis' => 0,
            'MariageGratis' => array()
        );
        
        $error=array('HTTP_CODE'=>'201',
            'DATA' => $response);
        echo json_encode($error);
        
        //echo date("Y-m-d h:iA", $date->format('U'));
        
    } else { error("TIRAGE_NON_AUTORISE","Tirage non-autorise.");  }
    //} else { error("VENDEUR_NON_AUTORISE","Vous n'etes pas autorise! Contactez le superviseur.");  }
    //} else { error("DEVICE_NON_AUTORISEE","Appareil POS non-autorise! Contactez le superviseur.");  }
    
    //} else{ error("BANQUE_NON_AUTORISEE","Banque non-autorisee! Contactez le superviseur ou le bureau centrale."); }
    
} else{  error("FOURNISSEUR_NON_AUTORISE","Access non-autorise. SVP Contacter le fournisseur."); }


function getFileContent($fichier){
    
    if (file_exists($fichier)) {
        $contenu = json_decode(file_get_contents($fichier));
        if ($contenu->Statut=="ACTIF") {
            return $contenu;
        } else return null;
    }else return null;
    
}

function error($errCode,$errMessage){
    $reponse = array('CODE_MESSAGE'=>$errCode,
        'MESSAGE'=>$errMessage);
    
    $error=array('HTTP_CODE'=>'401',
        'DATA' => $reponse);
    echo json_encode($error);
}

/*     function generateNumeroTransaction(){
 do{
 $numeroTrx = substr(mt_rand(),0,6).date("dm");
 } while(file_exists($numeroTrx.".json"));
 return $numeroTrx;
 }*/

function generateNDigitRandomNumber($length){
    return mt_rand(pow(10,($length-1)),pow(10,$length)-1);
}

function generateNumeroTransaction(){
    $joue = "../datafiles/paris/JOUE/";
    $loaded = "../datafiles/paris/LOADED/";
    $added = "../datafiles/paris/";
    do{
        //$numeroTrx = substr(mt_rand(),0,5).date("dm");
        $numeroTrx = generateNDigitRandomNumber(9); //mt_rand(100000000,999999999);
        $filename = $numeroTrx.".json";
    } while(file_exists($joue.$filename) || file_exists($loaded.$filename) || file_exists($added.$filename));
    return $numeroTrx;
}
?>
