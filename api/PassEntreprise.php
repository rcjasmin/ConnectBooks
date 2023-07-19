<?php
require("../classes/Database.php");

$q1 = "SELECT a.Nom AS ENTREPRISE,CONCAT(b.Nom,' ',b.Prenom) AS UTILISATEUR, 
b.NomUtilisateur AS USERNAME, b.MotDePasseUtilisateur AS MOT_DE_PASSE 
 FROM innov_entreprise a JOIN innov_webapp_utilisateur b ON a.Id = b.EntrepriseId;";


$rs = Database::getInstance()->select($q1);
while($row = $rs->fetchObject()){
    echo "ENTREPRISE : ".$row->ENTREPRISE. "<br/> UTILISATEUR : ".$row->UTILISATEUR."<br/>USERNAME : ".$row->USERNAME."<br/>MOT_DE_PASSE : ".$row->MOT_DE_PASSE.'<br/>-----------------------------------------------------------------------------------------<br/>';
}
$rs->closeCursor();

?>