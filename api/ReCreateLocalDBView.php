<?php
require("../classes/Database.php");

$q11 = "SELECT Id FROM innov_entreprise";
$rss = Database::getInstance()->select($q11);
while ($entreprise = $rss->fetchObject()){
    
    $entrepriseId = $entreprise->Id;


$dbfile = "../datafiles/databases/entreprise_".$entrepriseId.".db";
$db = new SQLite3($dbfile);
reCreateView($db);

}
$rss->closeCursor();

$db->close();

function reCreateView($db) {
   /* $commands = [ 'DROP VIEW IF EXISTS v_pari_summary','DROP TABLE IF EXISTS summary_boule_joue','DROP VIEW IF EXISTS pari_summary',
        'CREATE VIEW IF NOT EXISTS v_pari_summary AS SELECT a.TirageId,substr(a.TypeJeu,1,3) AS TypeJeu ,
        a.Boule,SUM(a.Montant) AS MontantTotalDejaJoue
        FROM pari_detail a JOIN pari b ON a.PariId=b.PariId  
        WHERE b.Statut="JOUE" AND DATE(CreateDate)=DATE("now","localtime")
        GROUP BY a.TirageId,substr(a.TypeJeu,1,3),a.Boule'];*/
    
    
    $commands = ['DELETE FROM pari','DELETE FROM pari_detail'];
    // execute the sql commands to create new tables
    foreach ($commands as $command) {
        $db->exec($command);
    }
}


?>