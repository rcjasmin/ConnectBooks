<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : "";
$Tirages = isset($_POST['Tirage']) ? $_POST['Tirage'] : "";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();
$where = " WHERE EntrepriseId='$entrepriseId' ";

$t = "";


if (isset($Tirages) && $Tirages != NULL && $Tirages != '') {
    foreach ($Tirages as $tirage) {
        if (isset($tirage) && $tirage != "") {
            if ($t == "")
                $t = "('" . $tirage;
                else
                    $t = $t . "','" . $tirage;
        }
    }
    if ($t != "") {
        $t = $t . "')";
        $where .= " AND TirageId IN " . $t;
    }
}



$query = "SELECT count(*) AS TOTAL FROM lottery.innov_pari_limite ".$where;
$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();


$query = "SELECT *,
          TirageId,GetTirageNameById(TirageId) AS TIRAGE,
          Jeu AS JEU
          FROM lottery.innov_pari_limite ";
$query .= $where;
$query .= " ORDER BY Id DESC LIMIT $offset,$rows";


$items = array();
$rs = Database::getInstance()->select($query);


while ($row = $rs->fetchObject()) {
    array_push($items, $row); 
}

$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
