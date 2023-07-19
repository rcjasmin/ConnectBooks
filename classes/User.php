<?php
require_once 'Utility.php';

class User
{
    private $username;

    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function login()
    {
        $params = array(
            'Username' => $this->username,
            'Password' => $this->password,
            'IpAddress' => Utility::getIPaddress()
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_Login('$data') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }

    public function updatePassword()
    {
        $params = array(
            'Username' => $this->username,
            'Password' => $this->password
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_UpdatePassword('$data') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
    
    public function changerPassword($userid,$password,$newpassword)
    {
        $params = array(
            'UserId' => $userid,
            'Password' => $password,
            'NewPassword' => $newpassword
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_ChangerPassword('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
    