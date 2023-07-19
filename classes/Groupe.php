<?php
require_once 'Database.php';

class Groupe
{

    private $id;

    private $nom;

    private $statut;

    public function __construct($id, $nom, $statut)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->statut = $statut;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'Nom' => $this->nom,
            'Statut' => $this->statut,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_groupe('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
