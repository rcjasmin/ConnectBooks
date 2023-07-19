<?php
require_once '../classes/Database.php';
$Entreprises = (isset($_POST['Entreprise'])) ? $_POST['Entreprise'] : "";
$androidID = isset($_POST['AndroidID']) ? $_POST['AndroidID'] : "";
$userId = isset($_GET['u']) ? htmlentities($_GET['u']) : NULL;

//error_log($Entreprises);
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page - 1) * $rows;
$result = array();
$where = " WHERE DeviceId <> 0 ";
$q = "";

if (isset($Entreprises) && $Entreprises != NULL && $Entreprises != '') {
    foreach ($Entreprises as $entreprise) {
        if (isset($entreprise) && $entreprise != "") {
            if ($q == "")
                $q = "('" . $entreprise;
                else
                    $q = $q . "','" . $entreprise;
        }
    }
    if ($q != "") {
        $q = $q . "')";
        $where .= " AND EntrepriseId IN " . $q;
    }
}

if (isset($androidID) && $androidID != NULL && $androidID != '') {
    $where .= " AND EMEI LIKE '%$androidID%'";
}

if($userId <> 1){
    $where .= " AND EntrepriseId NOT IN ('8','9')";
}

$query = "SELECT COUNT(*) AS TOTAL FROM lottery.innov_vw_devices_pos " . $where;
$rs = Database::getInstance()->select($query);
$result["total"] = $rs->fetchObject()->TOTAL;
$rs->closeCursor();

$query = "SELECT *,GetEntrepriseNameById(EntrepriseId) AS NomEntreprise
         FROM lottery.innov_vw_devices_pos " . $where . " LIMIT $offset,$rows";

$rs = Database::getInstance()->select($query);
$items = array();
while ($row = $rs->fetchObject()) {
    array_push($items, $row);
}
$rs->closeCursor();
$result["rows"] = $items;
echo json_encode($result);

?>
