<?php
require_once 'Database.php';
class Utility
{

    public static function getDomainName()
    {
        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
        $host = $_SERVER['HTTP_HOST'];
        $currentUrl = $protocol . '://' . $host;
        return $currentUrl;
    }

    public static function getIPaddress()
    {
        return ($_SERVER['REMOTE_ADDR']);
    }

    public static function getCurrentPageName()
    {
        return substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
    }

    public static function getCurrentURI()
    {
        return ($_SERVER['REQUEST_URI']);
    }
    
    public static function redirectTologin($username){
        if(!isset($_SESSION[$username]) || $_SESSION[$username]==NULL || $_SESSION[$username] ==""){
            echo '<script type="text/javascript">window.parent.location.href = "/beconnect"</script>'; 
            //header('Location: /beconnect');
        }
        return;
    }
    
    public static function isAuthorizedSubmenu($userId,$page){
        $query = "SELECT lottery.webapp_IsAccessiblePage('$userId','$page') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }

}
?>