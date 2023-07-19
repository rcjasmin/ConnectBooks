<?php
date_default_timezone_set('America/New_York');
$data = file_get_contents('php://input');
$obj = json_decode($data);
$date_trx_db = date('Y-m-d H:i:s');
$date_trx = date('d-m-Y h:i:s A');

$obj->HEADER->dt = $date_trx_db;
$data = json_encode($obj);

$entrepriseId = $obj->HEADER->e;
$banqueId = $obj->HEADER->b;
$utilisateurId = $obj->HEADER->u;
$tirageId  = $obj->HEADER->t;
$androidId = $obj->HEADER->a;

$dbfile = "../datafiles/databases/entreprise_" . $entrepriseId . ".db";
$db = new SQLite3($dbfile);

$BOL = $obj->PARI->BOL;
$MAR = $obj->PARI->MAR;
$LO3 = $obj->PARI->LO3;
$LO41 = $obj->PARI->LO41;
$LO42 = $obj->PARI->LO42;
$LO43 = $obj->PARI->LO43;
$LO51 = $obj->PARI->LO51;
$LO52 = $obj->PARI->LO52;
$LO53 = $obj->PARI->LO53;

$b = $obj->HEADER->b;
$t = $obj->HEADER->t;
$u = $obj->HEADER->u;
$a = $obj->HEADER->a;
$m = $obj->HEADER->m;
$dt = $obj->HEADER->dt;
$d = $obj->HEADER->d;

// if entreprise is authorized logic
$query = "SELECT COUNT(*) AS RESULT FROM entreprise WHERE EntrepriseId = '$entrepriseId' AND Statut='ACTIF'";
$count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);

if($count > 0){
  $query = "SELECT COUNT(*) AS RESULT FROM banque WHERE BanqueId = '$banqueId' AND Statut='ACTIF'";
  $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);
  if($count > 0){
    $query = "SELECT COUNT(*) AS RESULT FROM utilisateur WHERE UtilisateurId = '$utilisateurId' AND Statut='ACTIF'";
    $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);
    if($count > 0){
      $query = "SELECT COUNT(*) AS RESULT FROM device WHERE LOWER(AndroidId) = LOWER('$androidId') AND Statut='ACTIF'";
      $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);
      if($count > 0){
        $query = "SELECT COUNT(*) AS RESULT FROM tirage WHERE TirageId = '$tirageId' AND Statut='ACTIF' AND (TIME('now','localtime') BETWEEN HeureOuverture AND HeureFermeture)";
        $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);
        if($count > 0){
            
            $QuantiteMariageGratis = 0;
            $RatioMariageGratis =0;
            $MariageGratis = array();
            
            $numero_trx = generateNumeroTransaction($dbfile);
            $filename = $numero_trx;
            $filename = "../datafiles/paris/" . $filename . ".json";
            file_put_contents($filename, $data);
            chmod($filename, 07777);
            
            $PariId =0;
            $response = array(
                'TransactionId' => $PariId,
                'NumeroTransaction' => $numero_trx,
                'DateTransaction' => $date_trx,
                'StatutTransaction' => 'AJOUTE',
                'UtilisateurId' => $obj->HEADER->u,
                'EntrepriseId' => $obj->HEADER->e,
                'TirageId' => $obj->HEADER->t,
                'QuantiteMariageGratis' => $QuantiteMariageGratis,
                'RatioMariageGratis' => $RatioMariageGratis,
                'MariageGratis' => $MariageGratis
            );
            
            $error = array(
                'HTTP_CODE' => '201',
                'DATA' => $response
            );

            $q = "INSERT INTO pari(NumeroTicket,BanqueId,TirageId,UtilisateurId,Device,Montant,Devise,Statut,CreateDate) VALUES ('$numero_trx','$b','$t','$u','$a','$m','$d','AJOUTE','$dt')";
            executeQuery($dbfile,$q);
            
            $q = "SELECT PariId AS RESULT  FROM pari WHERE NumeroTicket = '$numero_trx' LIMIT 1";
            $PariId = getQueryResultObject($dbfile,$q)->RESULT;// $db->querySingle($q);
            
            insertGame($PariId, $t, 'BOL', $BOL, $dbfile, $d);
            insertGame($PariId, $t, 'MAR', $MAR, $dbfile, $d);
            insertGame($PariId, $t, 'LO3', $LO3, $dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO41,$dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO42,$dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO43,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO51,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO52,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO53,$dbfile, $d);
            
            error_log($PariId);


            echo json_encode($error);
          


  /*$q = "INSERT INTO pari(NumeroTicket,BanqueId,TirageId,UtilisateurId,Device,Montant,Devise,Statut,CreateDate) VALUES ('$numero_trx','$b','$t','$u','$a','$m','$d','AJOUTE','$dt')";
            executeQuery($dbfile,$q);
            
            $q = "SELECT PariId AS RESULT  FROM pari WHERE NumeroTicket = '$numero_trx' LIMIT 1";
            $PariId = getQueryResultObject($dbfile,$q)->RESULT;// $db->querySingle($q);
            
            insertGame($PariId, $t, 'BOL', $BOL, $dbfile, $d);
            insertGame($PariId, $t, 'MAR', $MAR, $dbfile, $d);
            insertGame($PariId, $t, 'LO3', $LO3, $dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO41,$dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO42,$dbfile, $d);
            insertGame($PariId, $t, 'LO4', $LO43,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO51,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO52,$dbfile, $d);
            insertGame($PariId, $t, 'LO5', $LO53,$dbfile, $d);

            
            //Check limite generale toute boule
            // check no existing ticket
             $q = "SELECT COUNT(*) AS Count, a.PariId, a.TirageId,a.TypeJeu,a.Boule,a.Montant AS MontantJoue,
             b.Montant AS MontantLimite,a.Devise FROM pari_detail a
             JOIN  limite_generale_boule b
             ON (a.TirageId = b.TirageId AND a.TypeJeu=b.TypeJeu )
             WHERE a.PariId = '$PariId' AND a.Montant > b.Montant LIMIT 1";

             $result = getQueryResultObject($dbfile,$q);
             //error_log($q);
             //error_log( $result->Count);
             
             if($result->Count == 0) {
                 
               $q = "SELECT COUNT(*) AS Count,x.*,y.Montant AS MontantLimite FROM
                    (SELECT b.PariId,b.TirageId,a.TypeJeu,a.Boule,a.MontantTotalDejaJoue,b.Montant AS MontantJoue,
                    (a.MontantTotalDejaJoue+b.Montant) AS MontantTotalApresJeu,b.Devise
                    FROM v_pari_summary a JOIN pari_detail b
                    ON (a.TirageId=b.TirageId AND a.TirageId=b.TirageId AND a.Boule=b.Boule)
                    WHERE b.PariId='$PariId') x JOIN limite_generale_boule y
                    ON (x.TirageId =y.TirageId AND x.TypeJeu = y.TypeJeu)
                    WHERE x.MontantTotalDejaJoue >= y.Montant OR x.MontantTotalApresJeu > y.Montant LIMIT 1";
               $result = getQueryResultObject($dbfile,$q);
               
               if($result->Count == 0) { 
                   // Check limit per ticket
                 $q = "SELECT COUNT(*) AS Count,x1.TypeJeu,x1.Boule, x1.Montant AS TOTAL_JOUE, x2.Montant AS TOTAL_LIMITE FROM pari_detail x1 
                    JOIN limite_par_fiche x2 
                    ON (x1.TirageId=x2.TirageId AND x1.TypeJeu=x2.TypeJeu)
                    WHERE x1.PariId='$PariId' AND x1.Montant > x2.Montant LIMIT 1";
           
                 $result = getQueryResultObject($dbfile,$q);   
                 if($result->Count == 0) { 
                     
                    $q = "SELECT COUNT(*) AS Count,QuantitePari,MontantMinimum FROM config_mariage_gratuit WHERE BanqueId='$b' AND TirageId='$t' AND MontantMinimum<='$m' LIMIT 1";
                    $result = getQueryResultObject($dbfile,$q); 
                    
                    $QuantiteMariageGratis = 0;
                    $RatioMariageGratis =0;
                    $MariageGratis = array();
                    
                    //Mariage gratis
                    if ($result->Count > 0) {
                        
                        $QuantiteMariageGratis = $result->QuantitePari;
                        
                        $q1 = "SELECT COUNT(*) AS Count, UtilisateurId,Montant FROM config_mariage_gratuit_ratio WHERE UtilisateurId = '$u' LIMIT 1";
                        $result1 = getQueryResultObject($dbfile,$q1);
                        
                        if ($result1->Count > 0){
                            $RatioMariageGratis = $result1->Montant;
                        }
                        
                        
                        $arr = array();
                        for($i=0;$i<$QuantiteMariageGratis;$i++){
                            $boule =  generateNDigitRandomNumber(4);
                            $mag = array($boule,"0");
                            array_push($arr,$mag);
                            array_push($MariageGratis,$boule);
                        }
                        
                        $obj = json_decode($data);
                        $obj->PARI->MAG = $arr;
                        $data = json_encode($obj);
                        //error_log($data);
                    }
                    
                    $filename = $numero_trx;
                    $filename = "../datafiles/paris/" . $filename . ".json";
                    file_put_contents($filename, $data);
                    chmod($filename, 07777);
                    

                    $response = array(
                        'TransactionId' => $PariId,
                        'NumeroTransaction' => $numero_trx,
                        'DateTransaction' => $date_trx,
                        'StatutTransaction' => 'AJOUTE',
                        'UtilisateurId' => $obj->HEADER->u,
                        'EntrepriseId' => $obj->HEADER->e,
                        'TirageId' => $obj->HEADER->t,
                        'QuantiteMariageGratis' => $QuantiteMariageGratis,
                        'RatioMariageGratis' => $RatioMariageGratis,
                        'MariageGratis' => $MariageGratis
                    );
                    
                    $error = array(
                        'HTTP_CODE' => '201',
                        'DATA' => $response
                    );
                    echo json_encode($error);
                 }else{
                     $gameName = getGameName($result->TypeJeu);
                     $message = "Nou paka vann ".$result->Boule." nan " . $gameName . " pou plis pase " . $result->TOTAL_LIMITE . " nan ticket sa.";
                     error("LIMITE_PAR_TICKET", $message);
                 }
               }else {
                   $gameName = getGameName($result->TypeJeu);
                   if ($result->MontantTotalJoue >= $result->MontantLimite) {
                       $message = "Nou paka vann " . $result->Boule. " nan " . $gameName . " anko";
                   } else {
                       if ($result->MontantTotalDejaJoue >= $result->MontantLimite) {
                           $message = "Nou paka vann " . $result->Boule . " nan " . $gameName . " anko.";
                       } else if ($result->MontantTotalApresJeu > $result->MontantLimite) {
                           $message = "Nou paka vann ". $result->Boule. " nan ". $gameName. " pou plis pase ".($result->MontantLimite - $result->MontantTotalDejaJoue). " ". $result->Devise;
                       }
                   }
                   error("LIMITE_GENERALE_TOUTE_BOULE", $message);
               } // end Check limite generale toute boule
                
             }else{
               $gameName = getGameName($result->TypeJeu);
               $message = "Nou paka vann " . $result->Boule . " nan " . $gameName . " pou plis pase " . $result->MontantLimite. " " . $result->Devise;
               error("LIMITE_GENERALE_TOUTE_BOULE", $message);   
             } */  
        }else{error("TIRAGE_NON_AUTORISE", "Tirage sa femen.");}
      }else{error("DEVICE_NON_AUTORISE", "Machin sa pa otorize sou sistem nan. SVP Kontakte biwo santral.");}   
    }else{error("UTILISATEUR_NON_AUTORISE", "Itilizate sa bloke. SVP Kontakte sipevize a.");}
  }else{error("BANQUE_NON_AUTORISE", "Bank sa bloke. SVP Kontakte sipevize a.");}    
} else{ error("FOURNISSEUR_NON_AUTORISE", "Access non-autorise. SVP Contactez le fournisseur."); }


$db->close();

function error($errCode, $errMessage)
{
    $reponse = array(
        'CODE_MESSAGE' => $errCode,
        'MESSAGE' => $errMessage
    );

    $error = array(
        'HTTP_CODE' => '401',
        'DATA' => $reponse
    );
    echo json_encode($error);
}

function generateNDigitRandomNumber($length)
{
    return mt_rand(pow(10, ($length - 1)), pow(10, $length) - 1);
}

function generateNumeroTransaction($dbfile)
{
    $joue = "../datafiles/paris/JOUE/";
    $loaded = "../datafiles/paris/LOADED/";
    $added = "../datafiles/paris/";
    do {
        $numeroTrx = generateNDigitRandomNumber(9);
        $filename = $numeroTrx . ".json";
    } while (file_exists($joue . $filename) || file_exists($loaded . $filename) || file_exists($added . $filename) );
    //| isExistTicket($numeroTrx, $dbfile)
    return $numeroTrx;
}

function isExistTicket($numTicket, $dbfile)
{
    $query = "SELECT COUNT(*) AS RESULT FROM pari WHERE NumeroTicket = '$numTicket'";
    $count = getQueryResultObject($dbfile,$query)->RESULT;// $db->querySingle($query);

    if ($count > 0)
        return true;
    else
        return false;
}

function insertGame($pariId, $tirageId, $typeJeu, $games, $dbfile, $devise)
{
    
    $dbh = new PDO('sqlite:'.$dbfile);
    $dbh->beginTransaction();
    foreach ($games as $game) {
        $boule = $game[0];
        $montant = $game[1];
        $q = "INSERT INTO pari_detail(PariId ,TirageId,TypeJeu,Boule,Montant,Devise) VALUES ('$pariId','$tirageId','$typeJeu','$boule','$montant','$devise')";
        $dbh->query($q);
    }
    $dbh->commit();
}

function getQueryResultObject($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $stmt = $db->query($query);
    $obj = $stmt->fetchObject();
    //$db->commit();
    return $obj;
}

function executeQuery($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $db->query($query);
    $db->commit();
    return null;
}

function getQueryResultStatement($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $stmt = $db->query($query);
    $db->commit();
    return $stmt;
}


function getGameName($typeJeu)
{
    if ($typeJeu == 'BOL')
        return "BOLET";
    else if ($typeJeu == 'MAR')
        return "MARYAJ";
    else if ($typeJeu == 'LO3')
        return "LOTO 3 CHIF";
    else if ($typeJeu == 'LO4')
        return "LOTO 4 CHIF";
    else if ($typeJeu == 'LO5')
        return "LOTO 5 CHIF";
}

?>
