<?php
require_once 'Database.php';

class Banque
{
    private $id;

    private $communeid;

    private $addresse;

    private $statut;

    public function __construct($id, $communeid, $addresse, $statut)
    {
        $this->id = $id;
        $this->communeid = $communeid;
        $this->addresse = $addresse;
        $this->statut = $statut;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'CommuneId' => $this->communeid,
            'Addresse' => $this->addresse,
            'Statut' => $this->statut,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_banque('$data') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
