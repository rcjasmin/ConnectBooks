<?php
require("../classes/Database.php");
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
$ticket = (isset($_GET['ticket'])) ? htmlentities($_GET['ticket']) : NULL;

$db = "../datafiles/databases/entreprise_".$entrepriseId.".db";

$query1 ="DELETE FROM pari_detail WHERE PariId IN (SELECT PariId FROM pari WHERE NumeroTicket='$ticket')";
$query2 ="DELETE  FROM pari WHERE NumeroTicket='$ticket')";
executeQuery($db,$query1);
executeQuery($db,$query2);


function executeQuery($dbfile,$query) {
    $db = new PDO('sqlite:'.$dbfile);
    $db->beginTransaction();
    $db->query($query);
    $db->commit();
    return null;
}

?>