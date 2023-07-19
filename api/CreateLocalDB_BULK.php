<?php
require("../classes/Database.php");
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
//$level = (isset($_GET['level'])) ? htmlentities($_GET['level']) : '0';

$q11 = "SELECT Id FROM innov_entreprise";
$rss = Database::getInstance()->select($q11);
while ($entreprise = $rss->fetchObject()){
    
    $entrepriseId = $entreprise->Id; 


$dbfile = "../datafiles/databases/entreprise_".$entrepriseId.".db";
$db = new SQLite3($dbfile);
createTables($db);


$q1 = "SELECT GetConfiguration_POST('$entrepriseId') AS RESULT";
$rs = Database::getInstance()->select($q1);
$row = $rs->fetchObject();
$rs->closeCursor();

$objData = json_decode($row->RESULT);


/*insertEntrepriseData($objData,$db);
insertBanqueData($objData,$db);
insertUtilisateurData($objData,$db);
insertTirageData($objData,$db);
insertLimigeneraleBouleData($objData,$db);
insertDeviceData($objData,$db);

insertMariageGratuitData($objData,$db);*/
insertMariageGratuitRatioData($objData,$db);

}
$rss->closeCursor();

//
/*$insertCommand = "INSERT INTO entreprise (EntrepriseId, Statut) VALUES ('$row->Id', '$row->Statut')";
 $db->exec($insertCommand);
 
 if($stmt = $db->prepare("SELECT * FROM entreprise"))
 {
 $result = $stmt->execute();
 
 while($arr=$result->fetchArray(SQLITE3_ASSOC))
 {
 //$names[$arr['id']]=$arr['student_name'];
 echo $arr['EntrepriseId'];
 }
 }
 
 */


function insertEntrepriseData($obj,$db){
    $entreprise = $obj ->ENTREPRISE;
    $data = $entreprise[0];
    $db->exec("DELETE FROM entreprise");
    $insertCommand = "INSERT INTO entreprise (EntrepriseId, Statut) VALUES ('$data->Id', '$data->Statut')";
    //echo $insertCommand;
    $db->exec($insertCommand);
}

function insertBanqueData($obj,$db){
    $banques = $obj ->BANQUE;
    $db->exec("DELETE FROM banque");
    foreach ($banques as $banque){
        $insertCommand = "INSERT INTO banque (BanqueId,Statut) VALUES ('$banque->Id', '$banque->Statut')";
        $db->exec($insertCommand);
    }
}

function insertUtilisateurData($obj,$db){
    $utilisateurs = $obj ->UTILISATEUR;
    $db->exec("DELETE FROM utilisateur");
    foreach ($utilisateurs as $utilisateur){
        $insertCommand = "INSERT INTO utilisateur (UtilisateurId,Statut) VALUES ('$utilisateur->Id', '$utilisateur->Statut')";
        $db->exec($insertCommand);
    }
}


function insertTirageData($obj,$db){
    $tirages = $obj ->TIRAGE;
    $db->exec("DELETE FROM tirage");
    foreach ($tirages as $tirage){
        $insertCommand = "INSERT INTO tirage (TirageId,Statut,HeureOuverture,HeureFermeture) VALUES ('$tirage->TirageId', '$tirage->Statut','$tirage->HeureOuverture', '$tirage->HeureFermeture')";
        $db->exec($insertCommand);
        //echo $insertCommand;
    }
}


function insertLimigeneraleBouleData($obj,$db){
    $tirages = $obj ->LIMITE_GENERALE_BOULE;
    $db->exec("DELETE FROM limite_generale_boule");
    foreach ($tirages as $tirage){
        $insertCommand = "INSERT INTO limite_generale_boule(TirageId,TypeJeu,Montant) VALUES ('$tirage->TirageId', '$tirage->Jeu','$tirage->Montant')";
        $db->exec($insertCommand);
    }
}

function insertLimiteParTicketData($obj,$db){
    $banques = $obj ->LIMITE_PAR_TICKET;
    $db->exec("DELETE FROM limite_par_fiche");
    foreach ($banques as $banque){
        $insertCommand = "INSERT INTO limite_par_fiche(TirageId,TypeJeu,Montant) VALUES ('$banque->TirageId', '$banque->Jeu','$banque->Montant')";
        $db->exec($insertCommand);
    }
}

function insertMariageGratuitData($obj,$db){
    $banques = $obj ->MARIAGE_GRATIS;
    $db->exec("DELETE FROM config_mariage_gratuit");
    foreach ($banques as $banque){
        $insertCommand = "INSERT INTO config_mariage_gratuit(BanqueId,TirageId,MontantMinimum,QuantitePari) VALUES ('$banque->BanqueId','$banque->TirageId', '$banque->MontantMinimum','$banque->QuantitePari')";
        $db->exec($insertCommand);
    }
}

function insertMariageGratuitRatioData($obj,$db){
    $banques = $obj ->MARIAGE_GRATIS_RATIO;
    $db->exec("DELETE FROM config_mariage_gratuit_ratio");
    foreach ($banques as $banque){
        $insertCommand = "INSERT INTO config_mariage_gratuit_ratio(UtilisateurId,Montant) VALUES ('$banque->UtilisateurId','$banque->Montant')";
        $db->exec($insertCommand);
    }
}

function insertDeviceData($obj,$db){
    $tirages = $obj ->DEVICE;
    $db->exec("DELETE FROM device");
    foreach ($tirages as $tirage){
        $insertCommand = "INSERT INTO device (DeviceId,AndroidId,Statut) VALUES ('$tirage->DeviceId', '$tirage->AndroidId','$tirage->Statut')";
        $db->exec($insertCommand);
        //echo $insertCommand;
    }
}

function createTables($db) {
    $commands = ['CREATE TABLE IF NOT EXISTS entreprise (
                        EntrepriseId INTEGER PRIMARY KEY,
                        Statut VACHAR(10) NOT NULL
                      )',
        'CREATE TABLE IF NOT EXISTS banque (
                        BanqueId   INTEGER PRIMARY KEY,
                        Statut VACHAR(10) NOT NULL
                      )',
        'CREATE TABLE IF NOT EXISTS utilisateur (
                        UtilisateurId INTEGER PRIMARY KEY,
                        Statut VACHAR(10) NOT NULL
                      )',
        
        'CREATE TABLE IF NOT EXISTS tirage (
                        TirageId INTEGER PRIMARY KEY,
                        Statut VACHAR(10) NOT NULL,
                        HeureOuverture TIME NOT NULL,
                        HeureFermeture TIME NOT NULL
                      )',
        'CREATE TABLE IF NOT EXISTS pari (
                        PariId INTEGER PRIMARY KEY autoincrement,
                        NumeroTicket   VARCHAR(20) NOT NULL,
                        BanqueId INTEGER NOT NULL,
                        TirageId INTEGER NOT NULL,
                        UtilisateurId INTEGER NOT NULL,
                        Device VARCHAR(30) NOT NULL,
                        Montant DECIMAL(50,2) NOT NULL,
                        Devise VARCHAR(10) NOT NULL,
                        CreateDate DATETIME NOT NULL DEFAULT current_timestamp,
                        Statut VARCHAR(10) NOT NULL,
                        UNIQUE(NumeroTicket)
                      )',
        'CREATE TABLE IF NOT EXISTS pari_detail (
                        PariDetailId INTEGER PRIMARY KEY autoincrement,
                        PariId  INTEGER NOT NULL,
                        TirageId  INTEGER NOT NULL,
                        TypeJeu VARCHAR(5) NOT NULL,
                        Boule VARCHAR(5) NOT NULL,
                        Montant DECIMAL(50,2),
                        Devise VARCHAR(10) NOT NULL,
                        FOREIGN KEY (PariId) REFERENCES pari(PariId)
                        ON UPDATE CASCADE ON DELETE CASCADE
                      )',
        'CREATE TABLE IF NOT EXISTS limite_generale_boule (
                        TirageId INTEGER,
                        TypeJeu VARCHAR(20) NOT NULL,
                        Montant DECIMAL(50,2) NOT NULL,
                        UNIQUE(TirageId,TypeJeu)
                      )',
        'CREATE TABLE IF NOT EXISTS summary_boule_joue (
                        TirageId INTEGER PRIMARY KEY,
                        TypeJeu VARCHAR(20) NOT NULL,
			            Boule VARCHAR(20) NOT NULL,
                        MontantTotal DECIMAL(50,2) NOT NULL,
                        UNIQUE(TirageId,TypeJeu,Boule)
                      )',
        'CREATE TABLE IF NOT EXISTS device (
                        DeviceId INTEGER PRIMARY KEY,
                        AndroidId VARCHAR(60) NOT NULL,
			            Statut VARCHAR(20) NOT NULL,
                        UNIQUE(AndroidId)
                      )',
        'CREATE TABLE IF NOT EXISTS limite_par_fiche (
                        TirageId INTEGER,
                        TypeJeu VARCHAR(20) NOT NULL,
                        Montant DECIMAL(50,2) NOT NULL,
                        UNIQUE(TirageId,TypeJeu)
                      )',
        'CREATE TABLE IF NOT EXISTS config_mariage_gratuit (
                        BanqueId INTEGER,
                        TirageId INTEGER,
                        QuantitePari INTEGER NOT NULL,
                        MontantMinimum DECIMAL(50,2) NOT NULL,
                        UNIQUE(BanqueId,TirageId)
                      )',
        'CREATE TABLE IF NOT EXISTS config_mariage_gratuit_ratio (
                        UtilisateurId INTEGER,
                        Montant DECIMAL(50,2) NOT NULL,
                        UNIQUE(UtilisateurId)
                      )',
        'CREATE VIEW IF NOT EXISTS v_pari_summary AS SELECT a.TirageId,substr(a.TypeJeu,1,3) AS TypeJeu ,
        a.Boule,SUM(a.Montant) AS MontantTotalDejaJoue
        FROM pari_detail a JOIN pari b ON a.PariId=b.PariId  
        WHERE b.Statut="JOUE"
        GROUP BY a.TirageId,substr(a.TypeJeu,1,3),a.Boule'];
    // execute the sql commands to create new tables
    foreach ($commands as $command) {
        $db->exec($command);
    }
}

?>