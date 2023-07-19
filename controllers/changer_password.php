<?php
session_start();
include_once '../classes/User.php';

if ($_POST) {
    $UserId = (isset($_POST['userid'])) ? htmlentities($_POST['userid']) : "";
    $Password = (isset($_POST['oldpassword'])) ? htmlentities($_POST['oldpassword']) : "";
    $NewPassword = (isset($_POST['newpassword'])) ? htmlentities($_POST['newpassword']) : "";
    $user = new User(null, null);
    $response = $user->changerPassword($UserId,$Password,$NewPassword);
    echo $response;

    
}

?>