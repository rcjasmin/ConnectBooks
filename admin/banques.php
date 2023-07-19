<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Banques</title>
   <?php

    $userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;
    $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
    if(!isset($userId) || !isset($entrepriseId)){
        header('Location: 404.php');
        exit();
    }
    require_once '../classes/Utility.php';
    require 'easyui_inc.php';
   ?> 

</head>
<body>
	<?php 
	  $url = "../controllers/banques.php?u=".$userId."&e=".$entrepriseId;
	  $url_combobox_departement = "../controllers/departements_combobox.php?e=".$entrepriseId;
	  $url_combobox_commune = "../controllers/communes_combobox.php?d=";
	  $url_combobox_banque = "../controllers/banques_combobox.php?e=".$entrepriseId;
	
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES BANQUES" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				   <th field="Id" hidden="true" style="" sortable="true">Id</th>
					<th field="Nom" style="width: 150px;" sortable="true">Nom Banque</th>
					<th field="Superviseur" style="width: 250px;" sortable="true">Superviseur</th>
					<th field="Departement" style="width: 150px;" sortable="true">R&eacute;gion</th>
					<th field="Commune" style="width: 150px;" sortable="true">Ville</th>
					<th field="Addresse" style="width: 250px;" sortable="true">Addresse</th>
					<th field="Statut" style="width: 80px;" sortable="true">Statut</th>
					<!--<th field="CreationUser" style="width: 15%;" sortable="true">Cr&eacute;&eacute; par</th>
					 <th field="CreationDate" style="width: 15%;" sortable="true">Date Cr&eacute;ation</th>-->
					<th field="" style="" formatter=showButtons></th>
				</tr>
			</thead>
		</table>
		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 1px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-house" plain="false" onclick="openFormBanque()">Ajouter Banque</a>
        			<?php if(Utility::isAuthorizedSubmenu($userId, "utilisateurs_pos.php")){ ?>
        			  <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-adduser" plain="false" onclick="openFormUtilisateur()">Ajouter Vendeur ou Superviseur</a>
        		    <?php } ?>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
                <label style="font-weight: bold">R&eacute;gion:</label>
                <div class="fitem">
                    <input id="DepartementId" name="DepartementId" style="height: 30px; width: 100%;" class="easyui-combobox"
					data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_departement; ?>', required:true,editable:true,
					 onSelect:function(departement){
					  var url = '<?php echo $url_combobox_commune; ?>'+departement.Id;
					  $('#CommuneId').combobox('setValue','');
					  $('#CommuneId').combobox('reload',url);}"
					panelHeight="200px" />
                </div>
                <br/>
            	<label style="font-weight: bold">Ville:</label>
                <div class="fitem">
                    <input id="CommuneId" name="CommuneId" style="height: 30px; width: 100%;" class="easyui-combobox"
					data-options="valueField:'Id',textField:'Nom', required:true,editable:true"
					panelHeight="180px" />
                </div>
                <br/>
               <label style="font-weight: bold">Addresse:</label>
                <div class="fitem">
                    <input id="Addresse" name="Addresse" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
                </div>
                <br/>
				<label style="font-weight: bold">Statut:</label>
                <div class="fitem">
                    
                    <input
                        style="height: 30px; width: 100%;"
                        id="Statut"
                        class="easyui-combobox"
                        name="Statut"
                        required="true"
                        data-options="valueField:'value',textField:'label',data:
        								 [{
        									label: 'ACTIF',
        									value: 'ACTIF'
        								  },{
        									label: 'INACTIF',
        									value: 'INACTIF'
        								 },{
        									label: 'SUPPRIME',
        									value: 'SUPPRIME'
        								 }], required:true,editable:false,"
                        panelHeight="auto"
                    />
                </div>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addBanque()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
        
        
        <div id="dlg1" class="easyui-dialog" style="width: 600px; height: auto; padding:20px;" closed="true" buttons="#dlg1-buttons">
        	<form id="fm1" method="POST" novalidate>
        	
        	   <table style="width: 100%;" cellspacing="8">
        		<tr> 
        		  <td style="width: 50%;">
        			 <label style="font-weight: bold">Nom:</label>
        			<div class="fitem">
        				<input id="Nom" name="Nom" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
        			</div>
        		   </td>
        		   <td style="width: 50%;">
        			<label style="font-weight: bold">Pr&eacute;nom:</label>
        			<div class="fitem">
        				<input id="Prenom" name="Prenom" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
        			</div>
        		   </td>
        		</tr>
        		
        		<tr> 
        		  <td style="width: 50%;">
        			<label style="font-weight: bold">Nom Utilisateur:</label>
        			<div class="fitem">
        				<input id="NomUtilisateur" name="NomUtilisateur" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
        			</div>
        		   </td>
        		   <td style="width: 50%;">
        			<label style="font-weight: bold">Role:</label>
        			<div class="fitem">
        				
        				<input
        					style="height: 30px; width: 100%;"
        					id="Role"
        					class="easyui-combobox"
        					name="Role"
        					required="true"
        					data-options="valueField:'value',textField:'label',data:
        									 [{
        										label: 'VENDEUR',
        										value: 'VENDEUR'
        									  },{
        										label: 'SUPERVISEUR',
        										value: 'SUPERVISEUR'
        									 }], required:true,editable:false,
        									 onSelect:function(role){
        									  if(role.value =='SUPERVISEUR'){
        									    $('#PourcentageCommission').textbox('setValue','0.00');
        									    $('#PourcentageCommission').textbox('readonly', true);
        									  }else{
        									  	$('#PourcentageCommission').textbox('setValue','');
					   							$('#PourcentageCommission').textbox('readonly', false);
        									  }
        									}"
        					panelHeight="auto"
        				/>
        			</div>
        		   </td>
        		</tr>
        		
        	   <tr> 
        		  <td style="width: 50%;">
        			<label style="font-weight: bold">Commission[%]:</label>
        			<div class="fitem">
        				<input id="PourcentageCommission" name="PourcentageCommission" style="height: 30px; width: 100%;" class="easyui-numberbox" data-options="min:0,precision:2" required="true" />
        			</div>
        		   </td>
        		   <td style="width: 50%;">
        			<label style="font-weight: bold">Banque(s):</label>
        			<div class="fitem">
        					<input id="Banques" name="Banques" style="width: 100%;height: 30px"
        					class="easyui-combobox" required="true"
        					data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_banque; ?>', required:true,editable:true,multiple:true"
        					panelHeight="200px">
        			</div>
        		   </td>
        		</tr>
        		
        		<tr> 
        		  <td style="width: 50%;">
        			<label style="font-weight: bold">Telephone 1:</label>
        			<div class="fitem">
        				<input id="Telephone1" name="Telephone1" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
        			</div>
        		   </td>
        		   <td style="width: 50%;">
        			<label style="font-weight: bold">Telephone 2:</label>
        			<div class="fitem">
        				<input id="Telephone2" name="Telephone2" style="height: 30px; width: 100%;" class="easyui-textbox" />
        			</div>
        		   </td>
        		</tr>
        		
        		<tr> 
        		  <td style="width: 50%;">
        			<label style="font-weight: bold">Telephone 3:</label>
        			<div class="fitem">
        				<input id="Telephone3" name="Telephone3" style="height: 30px; width: 100%;" class="easyui-textbox" />
        			</div>
        		   </td>
        		   <td style="width: 50%;">
        			<label style="font-weight: bold">Statut:</label>
        			<div class="fitem">
        				
        				<input
        					style="height: 30px; width: 100%;"
        					id="Statut1"
        					class="easyui-combobox"
        					name="Statut"
        					required="true"
        					data-options="valueField:'value',textField:'label',data:
        									 [{
        										label: 'ACTIF',
        										value: 'ACTIF'
        									  },{
        										label: 'INACTIF',
        										value: 'INACTIF'
        									 },{
        										label: 'SUPPRIME',
        										value: 'SUPPRIME'
        									 }], required:true,editable:false,"
        					panelHeight="auto"
        				/>
        			</div>
        		   </td>
        		</tr>
        	   </table>
        	</form>
        </div>
        <div id="dlg1-buttons">
        	<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addUtilisateur()" style="width: 140px;">Sauvegarder</a>
        	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg1').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var url='';
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=BANK';
	var vurl1 = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=USER';
	
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }

       
        function openFormBanque() {
            $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Banque');
            $('#fm').form('clear');
            url = '../controllers/banques_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>';
            vurl = '../api/CreateBanqueFiles.php?e=<?php echo $entrepriseId;?>&id=0';
            $('#Statut').combobox('select', 'ACTIF');
            $('#Statut').combobox('readonly', true);
            $('#dlg').window('center');
        }


        function addBanque() {
            $('#fm').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.CODE_MESSAGE =='SUCCESS') {
                        $('#fm').form('clear');
                        $('#dlg').dialog('close');
                        $('#dg').datagrid('reload');

          			  //Update Configuration file
         			   $.get( vurl, function(data) { });
                    }
                    $.messager.alert('Message', result.MESSAGE);
                }
            });
        }
        
    </script>
    

   <script type="text/javascript">
	$(function () {
        $('#dg').datagrid({
            view: detailview,
            detailFormatter: function (index, row) {
            	subgrid= "#ddv-" + index;
                return "<div style=\"padding:2px\"><table id=\"ddv-" + index + "\"></table></div>";
            },
            onExpandRow: function (index, row) {
                $("#dg").datagrid("selectRow", index);
                $('#ddv-' + index).datagrid({
                    url: '../controllers/utilisateurs_pos_banque.php?banque=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des utilisateurs en cours ...',
                    height: 'auto',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [
                            {field: 'NomComplet', title: 'Utilisateur', width: 40},
                            {field: 'Role', title: 'Role', width: 40},
                            {field: 'Commission', title: 'Commission', width: 40},
                            {field: 'Telephone', title: 'Telephone', width: 40},
                            {field: 'Statut', title: 'Statut', width: 40}
                        ]
                    ],
                    onResize: function () {
                        $('#dg').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function () {
                        setTimeout(function () {
                            $('#dg').datagrid('fixDetailRowHeight', index);
                        }, 0);
                       
                          /*var rows = $(this).datagrid('getRows');
                            for (i = 0; i < rows.length; ++i) {
                                if (rows[i].Status == 'ENABLED') {
                                    $(this).datagrid('checkRow', i);
                                    //$.messager.alert('Error Message',$(this).attr('id'));
                                }
                          }*/

                    }
                });
                $('#dg').datagrid('fixDetailRowHeight', index);
            }
        });
     });
   </script>
   
   <script>
   $(document).ready(function() {   	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>
   <script type="text/javascript">
   function showButtons(val,row,index){
	   if(row.Statut=='ACTIF'){
		 var s = '&nbsp;<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')">Bloquer</button>&nbsp;';
	   } else {
		 var s = '&nbsp;<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')">Debloquer</button>&nbsp;';  
	   }
	    return s;
	}

	function changerStatut(obj,statut){
		 var url = '../controllers/banque_changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&b='+obj.value;
		 //vurl = '../api/CreateBanqueFiles.php?e=<?php echo $entrepriseId;?>&id='+obj.value;
		 
		 $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');

			  //Update Configuration file
			  //$.messager.alert('Message', vurl);
			   $.get( vurl, function(result) { });
		 });
	}
   </script>
   
   <script type="text/javascript">
	$('#dg').datagrid({
        onDblClickRow:function(index,row){
            url = '../controllers/banques_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
            vurl = '../api/CreateBanqueFiles.php?e=<?php echo $entrepriseId;?>&id='+row.Id;
            $('#dlg').dialog('open').dialog('setTitle', 'Form - Modifier Banque');
            $('#fm').form('clear');
            $('#fm').form('load',row);
			var vurl = '<?php echo $url_combobox_commune; ?>'+$('#DepartementId').combobox('getValue');
			$('#CommuneId').combobox('reload',vurl);
			$('#Statut').combobox('readonly', false);
            $('#dlg').window('center');
        }
    });

    function openFormUtilisateur() {
        var row = $('#dg').datagrid('getSelected');
        if(row) {
            $('#dlg1').dialog('open').dialog('setTitle', 'Form - Ajouter Utilisateur POS');
            $('#fm1').form('clear');
            $('#Banques').combobox('setValue', row.Id);
            $('#Statut1').combobox('select', 'ACTIF');
            $('#Banques').combobox('readonly', true);
            $('#Statut1').combobox('readonly', true);
            $('#dlg1').window('center');
            //vurl = '../api/CreateUtilisateurFiles.php?e=<?php echo $entrepriseId;?>&id=0';
        }else{
        	$.messager.alert('Message','SVP, Selectionnez la banque.');
        }
    }


    function addUtilisateur() {
        var banques = $('#Banques').combobox('getValues');
        url = '../controllers/utlisateurs_pos_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&b=' + banques;
        $('#fm1').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (result) {
                var result = eval('(' + result + ')');
                if (result.CODE_MESSAGE =='SUCCESS') {
                    $('#fm1').form('clear');
                    $('#dlg1').dialog('close');
                    $('#dg').datagrid('reload');

      			  //Update Configuration file
      			   //$.messager.alert('Message',  vurl);
     			   $.get( vurl, function(data) { });
     			  $.get( vurl1, function(data) { });
                }
                $.messager.alert('Message', result.MESSAGE);
            }
        });
    }
   </script>
   
    <script>
        $( window ).resize(function() {
            $('#dg').datagrid('resize');
        });        
    </script>
    </body>
</html>