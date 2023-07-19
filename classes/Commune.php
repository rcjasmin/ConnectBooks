<?php
require_once 'Database.php';

class Commune
{
    private $id;

    private $departementid;

    private $nom;

    private $statut;

    public function __construct($id, $departementid, $nom, $statut)
    {
        $this->id = $id;
        $this->departementid = $departementid;
        $this->nom = $nom;
        $this->statut = $statut;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'DepartementId' => $this->departementid,
            'Nom' => $this->nom,
            'Statut' => $this->statut,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_commune('$data') AS RESPONSE";
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
