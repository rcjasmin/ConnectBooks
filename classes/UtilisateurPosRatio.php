<?php
require_once 'Database.php';

class UtilisateurPosRatio
{

    private $posUtilisateurIds;

    private $borlette;

    private $mariage;

    private $loto3;

    private $loto41;

    private $loto42;

    private $loto43;

    private $loto51;

    private $loto52;

    private $loto53;
    private $mag;

    public function __construct($posUtilisateurIds, $borlette, $mariage, $loto3, $loto41, $loto42, $loto43, $loto51, $loto52, $loto53,$mag)
    {
        $this->posUtilisateurIds = $posUtilisateurIds;
        $this->borlette = $borlette;
        $this->mariage = $mariage;
        $this->loto3 = $loto3;
        $this->loto41 = $loto41;
        $this->loto42 = $loto42;
        $this->loto43 = $loto43;
        $this->loto51 = $loto51;
        $this->loto52 = $loto52;
        $this->loto53 = $loto53;
        $this->mag = $mag;
    }

    public function crud($entrepriseId, $userId, $operationType)
    {
        $params = array(
            'UtilisateurPOSIds' => $this->posUtilisateurIds,
            'BOL' => $this->borlette,
            'MAR' => $this->mariage,
            'LO3' => $this->loto3,
            'LO41' => $this->loto41,
            'LO42' => $this->loto42,
            'LO43' => $this->loto43,
            'LO51' => $this->loto51,
            'LO52' => $this->loto52,
            'LO53' => $this->loto53,
            'MAG' => $this->mag,
            'EntrepriseId' => $entrepriseId,
            'UtilisateurId' => $userId,
            'OperationType' => $operationType
        );
        $data = json_encode($params);
        $query = "SELECT lottery.webapp_crud_utilisateurPOSRatios('$data') AS RESPONSE";
        //error_log($query);
        $resultSet = Database::getInstance()->select($query);
        $response = $resultSet->fetchObject()->RESPONSE;
        $resultSet->closeCursor();
        return $response;
    }
}
