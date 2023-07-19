<?php
session_start();
include_once '../classes/User.php';

if ($_POST) {
    $username = (isset($_POST['username'])) ? htmlentities($_POST['username']) : "";
    $password = (isset($_POST['password'])) ? htmlentities($_POST['password']) : "";
    $user = new User($username, $password);
    $response = $user->login();
    //error_log($response);
    echo $response;
}

?>