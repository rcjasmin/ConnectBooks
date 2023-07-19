<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Fiches Ventes</title>

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
</head>
<body>
<?php
    $url = "../controllers/rep_par_superviseur.php?u=" . $userId . "&e=" . $entrepriseId;
    $url_combobox_tirages = "../controllers/tirages_combobox.php?r=1&e=" . $entrepriseId;
    $url_combobox_superviseurs = "../controllers/superviseurs_combobox.php?r=1&e=" . $entrepriseId;
?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 600px; font-size: 12px"
			url=<?php echo $url; ?> title="RAPPORT PAR SUPERVISEUR" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true" showFooter="true">

			<thead>
				<tr>
					<th field=SUPERVISEUR style="width: 200px;" sortable="true">SUPERVISEUR</th>
					<th field="BALANCE_TOTALE" styler="cellStyler" style="width: 160px;" sortable="true">BALANCE TOTALE</th>
					<th field=MONTANT_VENTE style="width: 150px;" sortable="true">VENTES</th>
					<th field="MONTANT_PERTE" style="width: 150px;" sortable="true">A PAYER</th>
					<th field="MONTANT_COMMISSION" style="width: 155px;"sortable="true">COMMISSION</th>
					
		
				</tr>
			</thead>
		</table>

		<div id="tb" style="padding: 5px; height: auto">
			<fieldset style="width: 200px">
				<legend
					style="background-color: #000; color: #fff; padding: 3px 6px;">
					Param&egrave;tres du Rapport</legend>
				<div style="margin-bottom: 5px">

					<table>
						<tr>
							<td><span>Superviseur:</span></td>
							<td><span>Tirage:</span></td>
						</tr>

						<tr>
							<td><input id="Superviseur" name="Superviseur"
								style="height: 28px; width: 250px;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_superviseurs; ?>', required:false,editable:true,multiple:true,
								onSelect: function(rec){
                                 if(rec.Id =='') {
                                    var list = $('#Superviseur').combobox('getData');
                                    for (let i = 1; i < list.length; i++) {
                                     $('#Superviseur').combobox('unselect', list[i].Id);
                                    }
                                 } else {
                                   $('#Superviseur').combobox('unselect', '');
                                 }
                                 }"
								panelHeight="200px" /></td>
							</td>
							<td><input id="Tirage" name="Tirage"
								style="height: 28px; width: 250px;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>', required:false,editable:true,multiple:true,
								
								onSelect: function(rec){
                                 if(rec.Id =='') {
                                    var list = $('#Tirage').combobox('getData');
                                    for (let i = 1; i < list.length; i++) {
                                     $('#Tirage').combobox('unselect', list[i].Id);
                                    }
                                 } else {
                                   $('#Tirage').combobox('unselect', '');
                                 }
                                 }"
								panelHeight="200px" /></td>
						</tr>
					</table>
					<table>
						<tr>
							<td><span>Date D&eacute;but:</span></td>
							<td><span>Date Fin:</span></td>
						</tr>
						<tr>
							<td><input class="easyui-datebox" id="DateDebut" name="DateDebut"
									data-options="formatter:myformatter,parser:myparser"
									style="width: 250px; height: 28px; line-height: 20px"></td>
									
							<td><input class="easyui-datebox" id="DateFin" name="DateFin"
									data-options="formatter:myformatter,parser:myparser"
									style="width: 250px; height: 28px; line-height: 20px"></td>
						</tr>
					</table>


				</div>
				<a href="#" class="easyui-linkbutton" iconCls="icon-database_gear"
					plain="false" onclick="doSearch()">Executer</a> <a href="#"
					class="easyui-linkbutton" iconCls="page_white_delete" plain="false"
					onclick="clearFilter()">Effacer</a> <a href="#"
					class="easyui-linkbutton" iconCls="icon-print" plain="false"
					onclick="openNewPrintWindow()">Imprimer</a>
			</fieldset>
		</div>

	</div>

	<script type="text/javascript">
	var url='';
        function doSearch() {
            $('#dg').datagrid('load', {
            	Superviseur: $('#Superviseur').combobox('getValues'),
            	Tirage: $('#Tirage').combobox('getValues'),
            	DateDebut: $('#DateDebut').datebox('getValue'),
            	DateFin: $('#DateFin').datebox('getValue'),
                e:<?php echo $entrepriseId;?>       
            });
        }

        function clearFilter(){
        	$('#Superviseur').combobox('setValue','');
        	$('#Tirage').combobox('setValue','');
        	$('#DateDebut').datebox('setValue','');
        	$('#DateFin').datebox('setValue','');
        }

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
    </script>
    
    <script type="text/javascript">
        function cellStyler(value,row,index){
            if (value < 0 || value.substring(0, 1)=='-'){
                return 'background-color:red;color:#fff;';
            } else {
            	return 'background-color:green;color:#fff;';
            }
        }
    </script>
    
    	<script type="text/javascript">
    var popupWindow = null;
        function centeredPopup(url,winName,w,h,scroll){
        LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
        TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
        settings =
        'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
        popupWindow = window.open(url,winName,settings);
        //popupWindow.close();
    }
    </script>

	<script>
        function openNewPrintWindow(){
            var url = 'rep_par_superviseur_print.php?e=<?php echo $entrepriseId;?>&b='+
            $('#Superviseur').combobox('getValues')+'&t='+
            $('#Tirage').combobox('getValues')+
            '&from='+$('#DateDebut').datebox('getValue')+
            '&to='+$('#DateFin').datebox('getValue');
        	centeredPopup(url,'','1000','300','yes');
        	return false
          //var newWindow=window.open('test.php','popUpWindow','height=500,width=400,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
          //newWindow.close();
        }
    </script>

	<script>
   $(document).ready(function() {   
	   //$('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});	
	   $('#Superviseur').combobox('setValues','');
	   $('#Tirage').combobox('setValues','');       
	    var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>

</body>
</html>