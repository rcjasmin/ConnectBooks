<?php
include_once '../classes/Database.php';

if ($_POST) {
    $username = (isset($_POST['username'])) ? htmlentities($_POST['username']) : "";
    $password = (isset($_POST['password'])) ? htmlentities($_POST['password']) : "";
    
    $params = array(
        'Username' => $username,
        'Password' => $password
    );
    $data = json_encode($params);
    $query = "SELECT lottery.webapp_master_Login('$data') AS RESPONSE";
    //error_log($query);
    $rs = Database::getInstance()->select($query);
    $row = $rs->fetchObject();
    $rs->closeCursor();
    echo $row->RESPONSE;
}

?>
