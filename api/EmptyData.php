<?php
require("../classes/Database.php");

$q11 = "SELECT Id FROM innov_entreprise";
$rss = Database::getInstance()->select($q11);
while ($entreprise = $rss->fetchObject()){
    
    $entrepriseId = $entreprise->Id;


$dbfile = "../datafiles/databases/entreprise_".$entrepriseId.".db";
$db = new SQLite3($dbfile);
deleteData($db);

}
$rss->closeCursor();

$db->close();

function deleteData($db) {
    $commands = ['DELETE FROM pari','DELETE FROM pari_detail'];
    foreach ($commands as $command) {
        $db->exec($command);
    }
}


?>