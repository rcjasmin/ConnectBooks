<?php
require_once 'Database.php';

class UtilisateurPos
{

    private $id;

    private $nom;

    private $prenom;

    private $nomUtilisateur;

    private $role;

    private $banques;

    private $telephone1;

    private $telephone2;

    private $telephone3;

    private $commission;

    private $statut;

    public function __construct($id, $nom, $prenom, $nomUtilisateur, $role, $banques, $telephone1, $telephone2, $telephone3, $commission, $statut)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->role = $role;
        $this->banques = $banques;
        $this->telephone1 = $telephone1;
        $this->telephone2 = $telephone2;
        $this->telephone3 = $telephone3;
        $this->commission = $commission;
        $this->statut = $statut;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'Id' => $this->id,
            'Nom' => $this->nom,
            'Prenom' =>$this->prenom,
            'NomUtilisateur' =>$this->nomUtilisateur,
            'Role' =>$this->role,
            'Banques' =>$this->banques,
            'Telephone1' =>$this->telephone1,
            'Telephone2' =>$this->telephone2,
            'Telephone3' =>$this->telephone3,
            'Commission' =>$this->commission,
            'Statut' => $this->statut,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_utilisateurPOS('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
