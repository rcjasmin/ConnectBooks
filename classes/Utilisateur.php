<?php
require_once 'Database.php';

class Utilisateur
{

    private $id;

    private $nom;

    private $prenom;

    private $nomUtilisateur;

    private $groupe;

    private $statut;

    public function __construct($id, $nom, $prenom, $nomUtilisateur, $groupe, $statut)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->groupe = $groupe;
        $this->statut = $statut;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'Nom' => $this->nom,
            'Prenom' =>$this->prenom,
            'NomUtilisateur' =>$this->nomUtilisateur,
            'Groupe' =>$this->groupe,
            'Statut' => $this->statut,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_utilisateur('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
