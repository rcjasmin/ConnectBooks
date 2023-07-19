<?php
require_once 'Database.php';

class TicketLimite
{

    private $TirageId;
    private $MontantBOL;
    private $MontantMAR; 
    private $MontantLO3;
    private $MontantLO4;
    private $MontantLO5; 



    public function __construct($TirageId, $MontantBOL, $MontantMAR,$MontantLO3,$MontantLO4,$MontantLO5)
    {
        $this->TirageId = $TirageId;
        $this->MontantBOL = $MontantBOL;
        $this->MontantMAR = $MontantMAR;
        $this->MontantLO3 = $MontantLO3;
        $this->MontantLO4 = $MontantLO4;
        $this->MontantLO5 = $MontantLO5;
    }

    public function crud($entrepriseId, $userId)
    {
        $params = array(
            'TirageId' => $this->TirageId,
            'BOL' => $this->MontantBOL,
            'MAR' =>$this->MontantMAR,
            'LO3' =>$this->MontantLO3,
            'LO4' =>$this->MontantLO4,
            'LO5' =>$this->MontantLO5,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_limite_ticket('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
