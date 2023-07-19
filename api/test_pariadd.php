<?php
date_default_timezone_set('America/New_York');
$data = file_get_contents('php://input');
$obj = json_decode($data);
$date_trx_db =  date('Y-m-d H:i:s');
$date_trx =  date('d-m-Y h:i:s A');

$obj->HEADER ->dt = $date_trx_db;
$data = json_encode($obj);

$entrepriseId = $obj->HEADER ->e;
$banqueId = $obj->HEADER ->b;
$utilisateurId = $obj->HEADER ->u;
$tirageId = $obj->HEADER ->t;
$androidId = $obj->HEADER ->a;

$dbfile = "../datafiles/databases/entreprise_".$entrepriseId.".db";
$db = new SQLite3($dbfile);

//if entreprise is authorized logic
$query = "SELECT COUNT(*) AS RESULT FROM entreprise WHERE EntrepriseId = '$entrepriseId' AND Statut='ACTIF'";
if($stmt = $db->prepare($query))
{
    $result = $stmt->execute();
    $arr=$result->fetchArray(SQLITE3_ASSOC);
    if( $arr['RESULT']>0){
        
        //if bank is authorized logic
        $query = "SELECT COUNT(*) AS RESULT FROM banque WHERE BanqueId = '$banqueId' AND Statut='ACTIF'";
        if($stmt = $db->prepare($query))
        {
            $result = $stmt->execute();
            $arr=$result->fetchArray(SQLITE3_ASSOC);
            if( $arr['RESULT']>0){
                
                //if utilisateur is authorized logic
                $query = "SELECT COUNT(*) AS RESULT FROM utilisateur WHERE UtilisateurId = '$utilisateurId' AND Statut='ACTIF'";
                if($stmt = $db->prepare($query))
                {
                    $result = $stmt->execute();
                    $arr=$result->fetchArray(SQLITE3_ASSOC);
                    if( $arr['RESULT']>0){
                        
                        //if device is authorized logic
                        $query = "SELECT COUNT(*) AS RESULT FROM device WHERE AndroidId = '$androidId' AND Statut='ACTIF'";
                        if($stmt = $db->prepare($query))
                        {
                            $result = $stmt->execute();
                            $arr=$result->fetchArray(SQLITE3_ASSOC);
                            if($arr['RESULT'] > 0){
                                //$current_time = date("H:i:s");
                                //if tirage is authorized logic
                                $query = "SELECT COUNT(*) AS RESULT FROM tirage WHERE TirageId = '$tirageId' AND Statut='ACTIF' AND (TIME('now','localtime') BETWEEN HeureOuverture AND HeureFermeture)";
                                if($stmt = $db->prepare($query)) {
                                    $result = $stmt->execute();
                                    $arr=$result->fetchArray(SQLITE3_ASSOC);
                                    if( $arr['RESULT']>0){
                                        $numero_trx = generateNumeroTransaction($db);
                                        
                                        $BOL = $obj->PARI ->BOL;
                                        $MAR = $obj->PARI ->MAR;
                                        $LO3 = $obj->PARI ->LO3;
                                        $LO41 = $obj->PARI ->LO41;
                                        $LO42 = $obj->PARI ->LO42;
                                        $LO43 = $obj->PARI ->LO43;
                                        $LO51 = $obj->PARI ->LO51;
                                        $LO52 = $obj->PARI ->LO52;
                                        $LO53 = $obj->PARI ->LO53;
                                        
                                        $b = $obj->HEADER ->b;
                                        $t =$obj->HEADER ->t;
                                        $u = $obj->HEADER ->u;
                                        $a = $obj->HEADER ->a;
                                        $m = $obj->HEADER ->m;
                                        $dt = $obj->HEADER ->dt;
                                        $d = $obj->HEADER ->d;
                                        
                                        
                                        $q = "INSERT INTO pari(NumeroTicket,BanqueId,TirageId,UtilisateurId,Device,Montant,Devise,Statut,CreateDate) VALUES ('$numero_trx','$b','$t','$u','$a','$m','$d','AJOUTE','$dt')";
                                        $db->exec($q);
                                        
                                        $q = "SELECT PariId  FROM pari WHERE NumeroTicket = '$numero_trx'";
                                        $PariId = $db->querySingle($q);
                                        
                                        insertGame($PariId,$t,'BOL',$BOL,$db,$d);
                                        insertGame($PariId,$t,'MAR',$MAR,$db,$d);
                                        insertGame($PariId,$t,'LO3',$LO3,$db,$d);
                                        insertGame($PariId,$t,'LO41',$LO41,$db,$d);
                                        insertGame($PariId,$t,'LO42',$LO42,$db,$d);
                                        insertGame($PariId,$t,'LO43',$LO43,$db,$d);
                                        insertGame($PariId,$t,'LO51',$LO51,$db,$d);
                                        insertGame($PariId,$t,'LO52',$LO52,$db,$d);
                                        insertGame($PariId,$t,'LO53',$LO53,$db,$d);
                                        
                                        // Check limite generale toute boule 
                                        
                                        // check no existing ticket
                                        $q = "SELECT COUNT(*) AS Count, a.PariId, a.TirageId,a.TypeJeu,a.Boule,a.Montant AS MontantJoue,
                                              b.Montant AS MontantLimite,a.Devise FROM pari_detail a
                                              JOIN  limite_generale_boule b 
                                              ON (a.TirageId = b.TirageId AND a.TypeJeu=b.TypeJeu ) 
                                              WHERE a.PariId = '$PariId' AND a.Montant > b.Montant LIMIT 1";
                                        
                                       // error_log($q);
                                        
                                      $stmt = $db->prepare($q);
                                      $result = $stmt->execute();
                                      $row=$result->fetchArray(SQLITE3_ASSOC);
                                        
                                      if($row['Count']==0){
                                        
                                        $q = "SELECT COUNT(*) AS Count,x.*,y.Montant AS MontantLimite FROM 
                                            (SELECT b.PariId,b.TirageId,a.TypeJeu,a.Boule,a.MontantTotalDejaJoue,b.Montant AS MontantJoue,
                                            (a.MontantTotalDejaJoue+b.Montant) AS MontantTotalApresJeu,b.Devise 
                                            FROM v_pari_summary a JOIN pari_detail b
                                            ON (a.TirageId=b.TirageId AND a.TirageId=b.TirageId AND a.Boule=b.Boule)
                                            WHERE b.PariId='$PariId') x JOIN limite_generale_boule y
                                            ON (x.TirageId =y.TirageId AND x.TypeJeu = y.TypeJeu)
                                            WHERE x.MontantTotalDejaJoue >= y.Montant OR x.MontantTotalApresJeu > y.Montant LIMIT 1";
                                        
                                        //error_log($q);
                                        
                                       // echo $q;
                                        $stmt = $db->prepare($q);
                                        $result = $stmt->execute();
                                        $row=$result->fetchArray(SQLITE3_ASSOC);

        
                                        if($row['Count']==0){
                                            $filename = $numero_trx;
                                            $filename = "../datafiles/paris/".$filename.".json";
                                            file_put_contents($filename,$data);
                                            chmod($filename,07777);
                                            
                                            $response= array('TransactionId' => $PariId,
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
                                        } else {
                                            $gameName = getGameName($row['TypeJeu']);
                                            if ($row['MontantTotalJoue']>=$row['MontantLimite'] ) {
                                                $message = "Nou paka vann ".$row['Boule']." nan ".$gameName." anko";   
                                            } else {
                                                if($row['MontantTotalDejaJoue'] >= $row['MontantLimite'] ) {
                                                    $message = "Nou paka vann ".$row['Boule']." nan ".$gameName." anko.";
                                                } else if ($row['MontantTotalApresJeu'] > $row['MontantLimite']){
                                                    $message = "Nou paka vann ".$row['Boule']." nan ".$gameName." pou plis pase ".($row['MontantLimite']-$row['MontantTotalDejaJoue'])." ".$row['Devise'];
                                                }
                                            }
                                            error("LIMITE_GENERALE_TOUTE_BOULE",$message);
                                        } //end Check limite generale toute boule
                                      } else {
                                          $gameName = getGameName($row['TypeJeu']);
                                          $message = "Nou paka vann ".$row['Boule']." nan ".$gameName." pou plis pase ".$row['MontantLimite']." ".$row['Devise'];   
                                          error("LIMITE_GENERALE_TOUTE_BOULE",$message);
                                      }
                                        
                                        
                                    } else { error("TIRAGE_NON_AUTORISE","Tirage sa pa otorize.");}
                                    
                                } else{  error("TIRAGE_NOT_FOUND","Tirage not found."); } //end if tirage is authorized logic
                                
                            } else { error("DEVICE_NON_AUTORISE","Machin sa pa otorize sou sistem nan. SVP Kontakte biwo santral.");}
                            
                        } else{  error("DEVICE_NOT_FOUND","Device not found."); } //end if pos device is authorized logic
                        
                    } else { error("UTILISATEUR_NON_AUTORISE","Itilizate sa pa otorize. SVP Kontakte biwo santral.");}
                    
                } else{  error("USER_NOT_FOUND","User not found."); } //end if utilisateur is authorized logic
                
            } else { error("BANQUE_NON_AUTORISE","Bank sa pa otorize. SVP Kontakte sipevize a oubyen biwo santral.");} $current_time = date("H:i:s");
            
        } else{  error("BANQUE_NOT_FOUND","Bank not found."); } //end if bank is authorized logic
        
    } else { error("FOURNISSEUR_NON_AUTORISE","Access non-autorise. SVP Contactez le fournisseur.");}
    
} else{  error("ENTREPRISE_NOT_FOUND","Entreprise not found."); } //end if entreprise is authorized logic
$db->close();


function error($errCode,$errMessage){
    $reponse = array('CODE_MESSAGE'=>$errCode,
        'MESSAGE'=>$errMessage);
    
    $error=array('HTTP_CODE'=>'401',
        'DATA' => $reponse);
    echo json_encode($error);
}
function generateNDigitRandomNumber($length){
    return mt_rand(pow(10,($length-1)),pow(10,$length)-1);
}
function generateNumeroTransaction($db){
    $joue = "../datafiles/paris/JOUE/";
    $loaded = "../datafiles/paris/LOADED/";
    $added = "../datafiles/paris/";
    do{
        $numeroTrx = generateNDigitRandomNumber(9);
        $filename = $numeroTrx.".json";
    } while(file_exists($joue.$filename) || file_exists($loaded.$filename) || file_exists($added.$filename) || isExistTicket($numeroTrx,$db));
    return $numeroTrx;
}

function isExistTicket($numTicket,$db){
    $query = "SELECT COUNT(*) AS RESULT FROM pari WHERE NumeroTicket = '$numTicket'";
    $count = $db->querySingle($query);
    
    if($count>0) return true;
    else return false;
}

function insertGame($pariId,$tirageId,$typeJeu,$games,$db,$devise){
    foreach ($games as $game) {
        $boule = $game[0];
        $montant = $game[1];
        $q = "INSERT INTO pari_detail(PariId ,TirageId,TypeJeu,Boule,Montant,Devise) VALUES ('$pariId','$tirageId','$typeJeu','$boule','$montant','$devise')";
        //echo $q;
        $db->exec($q);
    }
}

function getGameName($typeJeu){
    if($typeJeu=='BOL') return "BOLET";
    else if($typeJeu=='MAR') return "MARYAJ";
    else if($typeJeu=='LO3') return "LOTO 3 CHIF";
    else if($typeJeu=='LO4') return "LOTO 4 CHIF";
    else if($typeJeu=='LO5') return "LOTO 5 CHIF";

}

?>
