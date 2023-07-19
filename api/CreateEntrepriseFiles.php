<?php
 require("../classes/Database.php");
 $query ="SELECT JSON_OBJECT('Id',a.Id,
	 'Nom',a.Nom,
	 'PrenomResponsable',a.PrenomResponsable,
	 'NomResponsable',a.NomResponsable,
	 'Statut',a.Statut,
	 'Commune',Commune,
	 'Addresse',a.Addresse,
	 'LogoURL',Logo,
	 'MontantMaxTicketaSupprimer',MontantMaxTicketaSupprimer,
	 'Devise',Devise,
	 'Telephone',GetPhonesCombined(a.Telephone1,a.Telephone2,a.Telephone3),
	 'Message',IFNULL(ReceiptMessage,'')) AS ENTREPRISE
      FROM lottery.innov_entreprise a 
      WHERE a.Statut <> 'SUPPRIME'";
 $rs = Database::getInstance()->select($query);
 
 while($row = $rs->fetchObject()){

     $object = json_decode($row-> ENTREPRISE);
     $filename = "ENTREPRISE_".$object ->Id;
     file_put_contents("../datafiles/entreprises/".$filename.".json",$row-> ENTREPRISE);
     echo ("File ".$filename." Created.<br/>");
     
 }
 $rs->closeCursor();

?>