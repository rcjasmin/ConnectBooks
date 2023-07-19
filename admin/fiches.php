<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Tickets</title>

<?php
    $userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;
    $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
    if (! isset($userId) || ! isset($entrepriseId)) {
        header('Location: 404.php');
        exit();
    }
    require_once '../classes/Utility.php';
    require 'easyui_inc.php';
?> 
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css"
	href="https://cdn.datatables.net/r/dt/dt-1.10.22/datatables.min.css" />
<script type="text/javascript"
	src="https://cdn.datatables.net/r/dt/dt-1.10.22/datatables.min.js"></script>

</head>
<body>
<?php
    $url = "../controllers/fiches.php?u=" . $userId . "&e=" . $entrepriseId;
    $url_combobox_tirages = "../controllers/tirages_combobox.php?r=1&e=" . $entrepriseId;
    $url_combobox_banques = "../controllers/banques_combobox.php?r=1&e=" . $entrepriseId;
?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 600px; font-size: 12px"
			url=<?php echo $url; ?> title="LISTE DES TICKETS" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="" width="100px" formatter=showButtons>|...........Options...........|</th>
					<th field="Id" hidden="true" sortable="true">Id</th>
					<th field=NumeroTransaction style="width: 100px;" sortable="true">No
						Ticket</th>
					<th field=Vendeur style="width: 180px;" sortable="true">Vendeur</th>
					<th field=NomBanque style="width: 140px;" sortable="true">Banque</th>
					<th field=Tirage style="width: 150px;" sortable="true">Tirage</th>
					<th field=NombrePari style="width: 100px;" sortable="true">Nombre
						Pari</th>
					<th field="MontantTotalComplet" style="width: 150px;"
						sortable="true">Montant Vente</th>
					<th field="MontantCommissionComplet" style="width: 155px;"
						sortable="true">Montant Commission</th>
					<th field="Statut" style="width: 100px;" sortable="true">Statut</th>
					<th field="CreationDate" style="width: 160px;" sortable="true">Date
						du Jeu</th>
					<th field="EstGagne" style="width: 120px;" sortable="true">Fiche
						Gagnante</th>
					<th field="MontantGagneComplet" style="width: 150px;"
						sortable="true">Montant Gagn&eacute;</th>
					<th field="EstPayePar" style="width: 120px;" sortable="true">Perte
						pay&eacute; par</th>
					<th field="DatePaiement" style="width: 160px;" sortable="true">Date
						Paiement Perte</th>
				</tr>
			</thead>
		</table>


		<div id="tb" style="padding: 5px; height: auto">
			<fieldset style="width: 200px">
				<legend
					style="background-color: #000; color: #fff; padding: 3px 6px;">
					Param&egrave;tres de Filtrage</legend>
				<div style="margin-bottom: 5px">

					<table>
						<tr>
							<td><span>Num&eacute;ro Ticket:</span></td>
							<td><span>Tirage:</span></td>
							<td><span>Date D&eacute;but:</span></td>
						</tr>

						<tr>
							<td><input id="NumeroReference" name="NumeroReference"
								style="line-height: 26px; height: 28px; width: 200px; border: 1px solid #ccc;">
							</td>
							<td><input id="Tirage" name="Tirage"
								style="height: 28px; width: 200px;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>', required:false,editable:true"
								panelHeight="200px" /></td>
								
							<td><input class="easyui-datebox" id="DateDebut" name="DateDebut"
								data-options="formatter:myformatter,parser:myparser"
								style="width: 200px; height: 28px; line-height: 20px"></td>
						</tr>
					</table>
					<table>
						<tr>
							<td><span>Fiche Gagnante:</span></td>
							<td><span>Statut:</span></td>
							<td><span>Date Fin:</span></td>
						</tr>
						<tr>
							<td><input id="EstGagne" class="easyui-combobox" name="EstGagne"
								style="width: 200px; height: 28px; line-height: 20px"
								data-options="valueField:'value',textField:'label',data:
														 [{
															label: 'TOUTES',
															value: ''
														  },{
															label: 'OUI',
															value: 'OUI'
														  },{
															label: 'NON',
															value: 'NON'
														 }],editable:false,"
								panelHeight="auto"></td>
							<td><input id="Statut" class="easyui-combobox" name="Statut"
								style="width: 200px; height: 28px; line-height: 20px"
								data-options="valueField:'value',textField:'label',data:
														 [{
															label: 'TOUS',
															value: ''
														  },{
															label: 'JOUE',
															value: 'JOUE'
														  },{
															label: 'PAYE',
															value: 'PAYE'
														 },{
															label: 'ELIMINE',
															value: 'ELIMINE'
														 }],editable:false,"
								panelHeight="auto"></td>
								
							<td><input class="easyui-datebox" id="DateFin" name="DateFin"
								data-options="formatter:myformatter,parser:myparser"
								style="width: 200px; height: 28px; line-height: 20px"></td>
						</tr>
						<tr>
							<td><span>Banque:</span></td>
						</tr>
						<tr>
							<td><input id="Banque" name="Banque"
								style="height: 28px; width: 200px;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_banques; ?>', required:false,editable:true,multiple:false"
								panelHeight="200px" />
							</td>

						</tr>
					</table>


				</div>
				<a href="#" class="easyui-linkbutton" iconCls="icon-search"
					plain="false" onclick="doSearch()">Rechercher</a>
			</fieldset>
		</div>

		<div id="dlg" class="easyui-dialog"
			style="width: 680px; height: 420px; padding: 10px;" closed="true">
			<table
				style="width: 100%; border-collapse: collapse; border: 1px solid black;">
				<tr>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">DATE JEU:</label></td>
								<td><label id="dateJeu" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">TIRAGE:</label></td>
								<td><label id="tirage" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">BANQUE:</label></td>
								<td><label id="banque" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">No TICKET:</label></td>
								<td><label id="reference" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">NOMBRE PARI:</label></td>
								<td><label id="pari" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">MONTANT JOUE:</label></td>
								<td><label id="montant" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">FICHE GAGNANTE:</label></td>
								<td><label id="estGagne" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">STATUT:</label></td>
								<td><label id="statut" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td><label style="font-weight: bold">MONTANT GAGNE:</label></td>
								<td><label id="montantGagne" style="font-size: 12px"></label></td>
							</tr>
						</table>
					</td>
				
				</tr>
			</table>
			<br />
			<div  style="height: 220px; overflow-y: scroll;">
				<table id="ficheDetails" class="display cell-border "
					style="width: 100%">
					<thead>
						<tr>
							<th>JEU&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
							<th>BOULE</th>
							<th>MONTANT JOUE</th>
							<th>BOULE GAGNANTE</th>
							<th>MONTANT GAGNE</th>
						</tr>
					</thead>

				</table>
			</div>
		</div>


	</div>

	<script type="text/javascript">
	var url='';
	
	
        function doSearch() {
            $('#dg').datagrid('load', {
            	EstGagne: $('#EstGagne').combobox('getValue'),
            	Statut: $('#Statut').combobox('getValue'),
            	Tirage: $('#Tirage').combobox('getValue'),
            	Banque: $('#Banque').combobox('getValue'),
                NumeroReference: $('#NumeroReference').val(),
            	DateDebut: $('#DateDebut').datebox('getValue'),
            	DateFin: $('#DateFin').datebox('getValue'),
                e:<?php echo $entrepriseId;?>       
            });
        }
       
    </script>

	<script>
   $(document).ready(function() {   
	   $('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});	


        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>

	<script type="text/javascript">
   function showButtons(val,row,index){
	   var s = '&nbsp;<button id="'+row.Id+'" style="width:80px; padding:4px" onclick="voirFiche(this)">Voir Fiche</button>&nbsp; ';
	   if(row.Statut=='JOUE' && row.EstGagne=='NON'){ 
	      s+= '<button id="'+row.Id+'" value="'+row.NumeroTransaction+'" style="width:80px; padding:4px" onclick="eliminerFiche(this)">Eliminer</button>&nbsp; ';
	   }
	   if(row.EstGagne=='OUI' && row.Statut!='PAYE' ){ 
	      s+= '<button id="'+row.Id+'" value="'+row.NumeroTransaction+'" style="width:80px; padding:4px" onclick="payerFiche(this)">Payer</button>&nbsp; ';
	   }
	  return s;
	}


	function voirFiche(obj){
		 var url = '../controllers/fiche.php?pariId='+obj.id;
		 $.get( url, function(data) {
			 var row =JSON.parse(data);
			 
			 $('#dateJeu').html(row.PARI.DATE_JEU);
			 $('#tirage').html(row.PARI.TIRAGE);
			 $('#banque').html(row.PARI.BANQUE);
			 $('#reference').html(row.PARI.NUMERO_REFERENCE);
			 $('#pari').html(row.PARI.NOMBRE_PARI);
			 $('#montant').html(row.PARI.MONTANT_TOTAL);
			 $('#estGagne').html(row.PARI.EST_GAGNE);
			 $('#statut').html(row.PARI.STATUT);
			 $('#montantGagne').html(row.PARI.MONTANT_GAGNE);
			 setDataToTable(row.PARI_DETAILS);
             $('#dlg').dialog('open').dialog('setTitle','Details du Ticket');
             $('#dlg').window('center');
		 });
	}

	function eliminerFiche(obj){
		 var url = '../controllers/fiche_eliminer.php?u=<?php echo $userId;?>&pariId='+obj.id;
         $.messager.confirm('Confirmation Elimination', 'Voulez vous vraiment &eacute;liminer ce ticket?', function (r) {
             if (r) {
        		 $.get( url, function(data) {
        			 if(data=='OK'){
        			   $('#dg').datagrid('reload');
        			   var vurl = '../api/EliminerTicket.php?e='+<?php echo $entrepriseId;?>+'&ticket='+obj.value;
        			   $.get(vurl,function(result) {});
        			   $.messager.alert('Message', 'Le ticket '+obj.value+' a &eacute;t&eacute; &eacute;limin&eacute;e.');
        			 }else{
        				 $.messager.alert('Message',data);
        			 }
        		 });
             }
         });
	}

	function payerFiche(obj){
		 var url = '../controllers/fiche_payer.php?u=<?php echo $userId;?>&pariId='+obj.id;
        $.messager.confirm('Confirmation Paiement', 'Voulez vous vraiment payer ce ticket?', function (r) {
            if (r) {
       		 $.get( url, function(data) {
       			 if(data=='OK'){
       			   $('#dg').datagrid('reload');
       			   $.messager.alert('Message', 'La Fiche '+obj.value+' a &eacute;t&eacute; pay&eacute;e.');
       			 }else{
       				 $.messager.alert('Message',data);
       			 }
       		 });
            }
        });
	}
	</script>

	<script>
        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
        }
        function myparser(s) {
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }
        $( window ).resize(function() {
            $('#dg').datagrid('resize');
        });        
    </script>



	<script>


function setDataToTable(jsonData){
	var dataTable = $('#ficheDetails').DataTable( {
        	        "paging":         false,
                    filter:true,
                    data: jsonData,
                    destroy: true,
                    "columns":[  
                        {     "data"     :     "JEU"     },  
                        {     "data"     :     "BOULE"},  
                        {     "data"     :     "MONTANT"},
                        {     "data"     :     "EST_GAGNANT"},
                        {     "data"     :     "MONTANT_GAGNE"}  
                   ]
          } );
    return dataTable;
}
</script>
</body>
</html>