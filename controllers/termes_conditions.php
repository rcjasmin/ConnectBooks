<?php
require_once '../classes/Database.php';

$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '0';
$message = (isset($_REQUEST['message'])) ? htmlentities($_REQUEST['message']) : '';
$montantTicket = (isset($_REQUEST['montantTicket'])) ? htmlentities($_REQUEST['montantTicket']) : 0;
$action = (isset($_GET['action'])) ? htmlentities($_GET['action']) : '';

if($action=="get") {
    $query = "SELECT ReceiptMessage,MontantMaxTicketaSupprimer FROM lottery.innov_entreprise WHERE Id ='$entrepriseId'";
    $rs = Database::getInstance()->select($query);
    $row = $rs->fetchObject();
    $rs->closeCursor();
    //echo $row->ReceiptMessage;
    echo json_encode($row);
} else {
    if($action=="post"){
        $query = "UPDATE lottery.innov_entreprise SET ReceiptMessage='$message', MontantMaxTicketaSupprimer='$montantTicket' WHERE Id ='$entrepriseId'";
        $rs = Database::getInstance()->select($query);
        $row = $rs->fetchObject();
        $rs->closeCursor();
        echo "Parametres generaux mis a jour avec success.";
    }
}
?>