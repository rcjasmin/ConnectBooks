<?php
require_once 'Database.php';

class BouleLimite
{

    private $id;

    private $Tirage;
    
    private $Banque;

    private $Jeu;

    private $Boule;

    private $Montant;
    
    private $DateDebut;
    
    private $DateFin;


    public function __construct($id, $Tirage, $Banque, $Jeu, $Boule, $Montant,$DateDebut,$DateFin)
    {
        $this->id = $id;
        $this->Tirage = $Tirage;
        $this->Banque = $Banque;
        $this->Jeu = $Jeu;
        $this->Boule = $Boule;
        $this->Montant = $Montant;
        $this->DateDebut= $DateDebut;
        $this->DateFin = $DateFin;

    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'Tirage' => $this->Tirage,
            'Banque' => $this->Banque,
            'Jeu' =>$this->Jeu,
            'Boule' =>$this->Boule,
            'Montant' =>$this->Montant,
            'DateDebut' => $this->DateDebut,
            'DateFin' => $this->DateFin,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_limite_boule('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
