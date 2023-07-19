<?php
require_once '../classes/Database.php';
if ($_POST) {
    $entreprises= (isset($_REQUEST['e'])) ? htmlentities($_REQUEST['e']) : NULL;
    $userId= (isset($_REQUEST['u'])) ? htmlentities($_REQUEST['u']) : '0';
    
    $txtTirage = (isset($_POST['txtTirage'])) ? htmlentities($_POST['txtTirage']) : '';
    $txtDateTirage = (isset($_POST['txtDateTirage'])) ? htmlentities($_POST['txtDateTirage']) : '';
    $txtLotto3 = (isset($_POST['txtLotto3'])) ? htmlentities($_POST['txtLotto3']) : '';
    $txtLo2 = (isset($_POST['txtLo2'])) ? htmlentities($_POST['txtLo2']) : '';
    $txtLo3 = (isset($_POST['txtLo3'])) ? htmlentities($_POST['txtLo3']) : '';
    
    $query = "SELECT lottery.AjouterBoulesGagnantesBULK('$entreprises','$txtTirage','$txtDateTirage','$txtLotto3','$txtLo2','$txtLo3','$userId') AS RESPONSE";
    //error_log($query);
    $rs = Database::getInstance()->select($query);
    $row = $rs->fetchObject();
    $rs->closeCursor();
    
    echo $row -> RESPONSE;

}
?>

