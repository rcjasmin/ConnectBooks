<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Vendeurs</title>
   <?php
    $userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;
    $entrepriseId = (isset($_GET['e'])) ? htmlentities($_GET['e']) : NULL;
    if(!isset($userId) || !isset($entrepriseId)){
        header('Location: 404.php');
        exit();
    }
    //require_once '../classes/Utility.php';
    require 'easyui_inc.php';
   ?> 

</head>
<body>
	<?php 
	  $url = "../controllers/utilisateurs_pos.php?u=".$userId."&e=".$entrepriseId;
	  $url_combobox_banque = "../controllers/banques_combobox.php?e=".$entrepriseId;
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES VENDEURS ET SUPERVISEURS" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field=FullName style="width: 230px;" sortable="true">Nom Complet</th>
					<th field="Role" style="width: 120px;" sortable="true">Role</th>
					<th field="Telephone1" style="width: 120px;" sortable="true">Telephone 1</th>
					<th field="Telephone2" style="width: 120px;" sortable="true">Telephone 2</th>
					<!-- <th field="Telephone3" style="width: 120px;" sortable="true">Telephone 3</th>-->
					<th field="NomUtilisateur" style="width: 150px;" sortable="true">Nom Utilisateur</th>
					<th field="Commission" style="width: 100px;" sortable="true">Commission</th>
					<th field="Statut" style="width: 80px;" sortable="true">Statut</th>
					<!-- <th field="CreationUser" style="width: 15%;" sortable="true">Cr&eacute;&eacute; par</th>
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
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-adduser" plain="false" onclick="openFormUtilisateur()">Ajouter Vendeur ou Superviseur</a>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 600px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
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
            								 }], required:true,editable:false,onSelect:function(role){
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
                   </td>
                </tr>
               </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addUtilisateur()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var url='';
	var operationType='';
	var id =0;
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=USER';
	
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }
       
        function openFormUtilisateur() {
        	operationType = 'create';
        	id = 0;
        	//vurl = '../api/CreateUtilisateurFiles.php?e=<?php //echo $entrepriseId;?>//&id=0';
            $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Utilisateur POS');
            $('#fm').form('clear');
            $('#Statut').combobox('select', 'ACTIF');
            $('#Statut').combobox('readonly', true);
            $('#NomUtilisateur').textbox('readonly', false);
            $('#PourcentageCommission').textbox('readonly', false);
            $('#dlg').window('center');
        }


        function addUtilisateur() {
            var banques = $('#Banques').combobox('getValues');
            url = '../controllers/utlisateurs_pos_crud.php?operation_type='+operationType+'&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+ id +'&b=' + banques;
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
                        //Update conf file
                        $.get(vurl, function(result) { });
                    }
                    $.messager.alert('Message', result.MESSAGE);
                }
            });
        }
        
    </script>
    

   <script>
   $(document).ready(function() {   	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }

        $('#dg').datagrid({
            onDblClickRow:function(index,row){
              operationType = 'update';
              id = row.Id;
              //vurl = '../api/CreateUtilisateurFiles.php?e=<?php //echo $entrepriseId;?>//&id='+id;
              $('#dlg').dialog('open').dialog('setTitle', 'Form - Modifier Utilisateur');
              $('#fm').form('clear');
              $('#fm').form('load',row);
              $('#Statut').combobox('readonly', false);
              $('#NomUtilisateur').textbox('readonly', true);
              if(row.Role =='SUPERVISEUR'){
            	 $('#PourcentageCommission').textbox('readonly', true);
              }
              $('#dlg').window('center');
            }
        });
        
    });
   </script>
   <script type="text/javascript">
   
	$('#Banques11').combobox({
		  formatter:function(row){
		    var opts = $(this).combobox('options');
		    return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField]
		  },
		  onLoadSuccess:function(){
		    var opts = $(this).combobox('options');
		    var target = this;
		    var values = $(target).combobox('getValues');
		    $.map(values, function(value){
		      var el = opts.finder.getEl(target, value);
		      el.find('input.combobox-checkbox')._propAttr('checked', true);
		    })
		  },
		  onSelect:function(row){
		    var opts = $(this).combobox('options');
		    var el = opts.finder.getEl(this, row[opts.valueField]);
		    el.find('input.combobox-checkbox')._propAttr('checked', true);
		  },
		  onUnselect:function(row){
		    var opts = $(this).combobox('options');
		    var el = opts.finder.getEl(this, row[opts.valueField]);
		    el.find('input.combobox-checkbox')._propAttr('checked', false);
		  }
		});
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
                    url: '../controllers/utilisateurs_pos_banque.php?utilisateur=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des banques en cours ...',
                    height: '150px',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [
                            {field: 'NomBanque', title: 'Banque', width: 40},
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
                       
                    }
                });
                $('#dg').datagrid('fixDetailRowHeight', index);
            }
        });
     });

   </script>
   
  
   <script type="text/javascript">
   
   function showButtons(val,row,index){
	   var s = '<button id="'+row.index+'" value="'+row.Id+'" style="width:120px; padding:4px" onclick="resetPassword(this)">Reset Password</button>';
	   if(row.Statut=='ACTIF'){
		  s+= '&nbsp;<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')"">Bloquer</button>&nbsp;';
	   } else {
		 s+= '&nbsp;<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')"">Debloquer</button>&nbsp;';  
	   }
	    return s;
	}

	function changerStatut(obj,statut){
		 var url = '../controllers/utilisateur_pos_changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&id='+obj.value;
		 //vurl = '../api/CreateUtilisateurFiles.php?e=<?php //echo $entrepriseId;?>//&id='+obj.value;
		 $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload'); 

 			//Update Configuration file
			 $.get(vurl, function(result) { });
		 });
	}

	function resetPassword(obj){
		var url = '../controllers/utilisateur_pos_reset_password.php?u=<?php echo $userId;?>&id='+obj.value;
        $.messager.confirm('Confirmation Reinitialisation', 'Voulez vous vraiment r&eacute;initialiser le mot de passe?', function (r) {
        if (r) {
		     $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');
		  });
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