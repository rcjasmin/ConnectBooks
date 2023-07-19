<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title></title>


<!-- Invoice styling -->
<style>
body {
	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	text-align: center;
	color: #777;
}

body h1 {
	font-weight: 300;
	margin-bottom: 0px;
	padding-bottom: 0px;
	color: #000;
}

body h3 {
	font-weight: bold;
	margin-top: 10px;
	margin-bottom: 20px;
	font-style: italic;
	color: #555;
	font-
}

body a {
	color: #06f;
}

.invoice-box {
	max-width: 800px;
	margin: auto;
	padding: 30px;
	border: 1px solid #eee;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
	font-size: 16px;
	line-height: 24px;
	font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	color: #555;
}

.invoice-box table {
	width: 100%;
	line-height: inherit;
	text-align: left;
	border-collapse: collapse;
}

.invoice-box table td {
	padding: 5px;
	vertical-align: top;
}

.invoice-box table tr td:nth-child(2) {
	text-align: right;
}

.invoice-box table tr.top table td {
	padding-bottom: 20px;
}

.invoice-box table tr.top table td.title {
	font-size: 45px;
	line-height: 45px;
	color: #333;
}

.invoice-box table tr.information table td {
	padding-bottom: 40px;
}

.invoice-box table tr.heading td {
	background: #eee;
	border-bottom: 1px solid #ddd;
	font-weight: bold;
}

.invoice-box table tr.details td {
	padding-bottom: 20px;
}

.invoice-box table tr.item td {
	border-bottom: 1px solid #eee;
}

.invoice-box table tr.item.last td {
	border-bottom: none;
}

.invoice-box table tr.total td:nth-child(2) {
	border-top: 2px solid #eee;
	font-weight: bold;
}

@media only screen and (max-width: 600px) {
	.invoice-box table tr.top table td {
		width: 100%;
		display: block;
		text-align: center;
	}
	.invoice-box table tr.information table td {
		width: 100%;
		display: block;
		text-align: center;
	}
}

#table thead, #table tfoot {
	background-color: #3f87a6;
	color: #fff;
}

#table tbody {
	background-color: #e4f0f5;
}

#table {
	border-collapse: collapse;
	border: 2px solid rgb(200, 200, 200);
	letter-spacing: 1px;
	font-family: sans-serif;
	font-size: .8rem;
}

#table td, #table th {
	border: 1px solid rgb(190, 190, 190);
	padding: 5px 10px;
}

#table td {
	text-align: center;
}
</style>
</head>

<?php
date_default_timezone_set('America/New_York');
require_once '../classes/Database.php';
$entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : '';
$Banques = (isset($_GET['b'])) ? htmlentities($_GET['b']) : '';
$Tirages = (isset($_GET['t'])) ? htmlentities($_GET['t']) : '';
$DateDebut = (isset($_GET['from'])) ? htmlentities($_GET['from']) : date('Y-m-d');
$DateFin = (isset($_GET['to'])) ? htmlentities($_GET['to']) : date('Y-m-d');

if($DateDebut=="" && $DateFin==""){
    $DateDebut=$DateFin=date('Y-m-d');
}

$query = "SELECT lottery.webapp_GetReportHeaderInfos('$entrepriseId','$Banques','$Tirages','$DateDebut','$DateFin') AS RESPONSE";
//echo $query;
$rs = Database::getInstance()->select($query);
$row = $rs->fetchObject();

$headerInfos = json_decode($row->RESPONSE);
$rs->closeCursor();

$where = " WHERE Statut IN ('JOUE','PAYE') AND EntrepriseId='$entrepriseId' ";
$q = "";
$t = "";
$Banques = explode(",", $Banques);

if (isset($Banques) && $Banques != NULL && $Banques != '') {
    foreach ($Banques as $banque) {
        if (isset($banque) && $banque != "") {
            if ($q == "")
                $q = "('" . $banque;
            else
                $q = $q . "','" . $banque;
        }
    }
    if ($q != "") {
        $q = $q . "')";
        $where .= " AND BanqueId IN " . $q;
    }
}
$Tirages = explode(",", $Tirages);
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

if (isset($DateDebut) && $DateDebut != NULL && $DateDebut != '') {
    $where .= " AND DATE(CreationDate) >= DATE('$DateDebut')";
}

if (isset($DateFin) && $DateFin != NULL && $DateFin != '') {
    $where .= " AND DATE(CreationDate) <= DATE('$DateFin')";
}

$query = "SELECT BanqueId,
          CONCAT('BANQUE ',GetNumeroByBanqueId(BanqueId)) AS BANQUE,
          GetDeviseEntrepriseById(GetEntrepriseIdByBanqueId_1(BanqueId))  AS DEVISE,
          GetUserFullNameById(GetSuperviseurIdByBanqueId(BanqueId))  AS SUPERVISEUR,
          GetFullAddreseBanqueById(BanqueId) AS ADRESSE,
          COUNT(*) AS TOTAL_FICHES,
          SUM(MontantTotal) AS MONTANT_VENTE,
          SUM(MontantGagne) AS MONTANT_PERTE,
          SUM(MontantCommission) AS MONTANT_COMMISSION,
          SUM(MontantTotal)-SUM(MontantGagne)-SUM(MontantCommission) AS BALANCE_TOTALE
          FROM lottery.innov_pari";
$query .= $where;
$query .= " GROUP BY BanqueId";
$rs = Database::getInstance()->select($query);

$query1 = "SELECT COUNT(*) AS TOTAL_FICHES,
 SUM(MontantTotal) AS MONTANT_VENTE,
 SUM(MontantGagne) AS MONTANT_PERTE,
 SUM(MontantCommission) AS MONTANT_COMMISSION,
 SUM(MontantTotal)-SUM(MontantGagne)-SUM(MontantCommission) AS BALANCE_TOTALE
 FROM lottery.innov_pari";
 $query1 .= $where;

 $rs1 = Database::getInstance()->select($query1);
 $summary = $rs1->fetchObject();
 



?>

<body>
	<div id=content>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title"><img src="<?php echo $headerInfos->LOGO; ?>"
									alt="Company logo" style="width: 100px; height: 70px;" /></td>

								<td><b><?php echo $headerInfos->ENTREPRISE; ?></b><br /><?php echo $headerInfos->ADDRESSE; ?><br /> Imprim&eacute; le:
								<?php echo date('d-m-Y h:i:s');?>
							</td>
							</tr>
						</table>
					</td>

				</tr>
			</table>
		</div>
		<div style="text-align: center;">
			<br />
			<table style="text-align: left">
				<tr>
					<td><b>BANQUE(S) : </b></td>
					<td><?php echo $headerInfos->BANQUES; ?> </td>
				</tr>
				<tr>
					<td><b>TIRAGE(S) : </b></td>
					<td><?php echo $headerInfos->TIRAGES; ?> </td>
				</tr>
				
				<tr>
					<td><b>DATE DEBUT : </b></td>
					<td><?php echo $headerInfos->DATE_DEBUT; ?> </td>
				</tr>
				<tr>
					<td><b>DATE FIN : </b></td>
					<td><?php echo $headerInfos->DATE_FIN; ?> </td>
				</tr>
				<tr>
					<td><b>FICHES : </b></td>
					<td><?php echo $summary->TOTAL_FICHES; ?> </td>
				</tr>
				<tr>
					<td><b>VENTES : </b></td>
					<td><?php echo $summary->MONTANT_VENTE." ".$headerInfos->DEVISE; ?> </td>
				</tr>
				
				<tr>
					<td><b>A PAYER : </b></td>
					<td><?php echo $summary->MONTANT_PERTE." ".$headerInfos->DEVISE; ?> </td>
				</tr>
				<tr>
					<td><b>COMMISSIONS : </b></td>
					<td><?php echo $summary->MONTANT_COMMISSION." ".$headerInfos->DEVISE; ?> </td>
				</tr>
				
				<tr>
					<td><b>BALANCE TOTALE : </b></td>
					<td><?php echo $summary->BALANCE_TOTALE." ".$headerInfos->DEVISE; ?> </td>
				</tr>
				

			</table>

			<u><h3>RAPPORT PAR BANQUE</h3></u>
			<table id="table" align="center">
				<thead>
					<tr>
						<th scope="col">BANQUE</th>
						<th scope="col">ADRESSE</th>
						<th scope="col">SUPERVISEUR</th>
						<th scope="col">VENTES</th>
						<th scope="col">A PAYER</th>
						<th scope="col">COMMISSIONS</th>
						<th scope="col">BALANCE TOTALE</th>
					</tr>
				</thead>
				<tbody>
				<?php while ($row = $rs->fetchObject()) { ?>
					<tr>
						<td><?php echo $row->BANQUE; ?></td>
						<td><?php echo $row->ADRESSE; ?></td>
						<td><?php echo $row->SUPERVISEUR; ?></td>
						<td><?php echo $row->MONTANT_VENTE." ".$row->DEVISE; ?></td>
						<td><?php echo $row->MONTANT_PERTE." ".$row->DEVISE; ?></td>
						<td><?php echo $row->MONTANT_COMMISSION." ".$row->DEVISE; ?></td>
						<td><?php echo $row->BALANCE_TOTALE." ".$row->DEVISE; ?></td>
					</tr>
                <?php  }  $rs->closeCursor(); ?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript"
		src="../lib_easyui/js/jquery/jquery-1.9.1.min.js"></script>
	<script type="text/javascript">
    $(document).ready(function () {
       
        var page = window.opener.location;
        //alert(page);
        /*if(page.includes("rep_par_banque.php")){
        	window.location.href ='404.php';
        }*/
        window.print();
        setTimeout(function () { window.close(); }, 500);
    });
    </script>

	<script
		src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
	<script type="text/javascript">
	function generatePDF() {
	 var doc = new jsPDF();  //create jsPDF object
	  doc.fromHTML(document.getElementById("content"), // page element which you want to print as PDF
	  15,
	  15, 
	  {
	    'width': 1000  //set width
	  },
	  function(a) 
	   {
	    doc.save("Rapport_par_Banque.pdf"); // save file name as HTML2PDF.pdf
	  });
	}
</script>
</body>
</html>