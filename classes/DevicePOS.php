<?php
require_once 'Database.php';

class DevicePOS
{

    private $id;

    private $androidId;

    private $banque;

    private $statut;

    public function __construct($id, $androidId, $banque, $statut)
    {
        $this->id = $id;
        $this->androidId = $androidId;
        $this->banque = $banque;
        $this->statut = $statut;
    }

    public function crud($userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'AndroidId' => $this->androidId,
            'BanqueId' => $this->banque,
            'Statut' => $this->statut,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_device_pos('$data') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
