<?php

class Database
{

    private static $obj;

    private $connection;

    private final function __construct()
    {
        $this->connection = new PDO('mysql:host=159.223.116.31;dbname=lottery', 'root', 'c0nneXus@');
    }

    public static function getInstance()
    {
        if (! isset(self::$obj)) {
            self::$obj = new Database();
        }

        return self::$obj;
    }

    public function select($query)
    {
        try {
            $res = $this->connection->query($query);
            return ($res);
        } catch (Exception $e) {
            return (false);
        }
    }

    public function insert($query, $params)
    {
        try {
            $req = $this->connexion->prepare($query);
            $req->execute($params);
            $req->closeCursor();
            return ("SUCCESS");
        } catch (Exception $e) {
            return ($e->getMessage());
        }
    }
}
?>
