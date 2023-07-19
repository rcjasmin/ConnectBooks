<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Utilisateurs</title>
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
	  $url = "../controllers/utilisateurs.php?u=".$userId."&e=".$entrepriseId;
	  $url_combobox_groupes = "../controllers/groupes_combobox.php?e=".$entrepriseId;
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES UTILISATEURS" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				    <th field="Id" hidden="true" style="width: 1%;" sortable="true">Id</th>
				    <th field=Nom style="width: 200px;" sortable="true">Nom</th>
				    <th field=Prenom style="width: 200px;" sortable="true">Pr&eacute;nom</th>
					<th field=NomUtilisateur style="width: 200px;" sortable="true">Nom Utilisateur</th>
					<th field=Groupe style="width: 150px;" sortable="true">Groupe</th>
					<th field="Statut" style="width: 100px;" sortable="true">Statut</th>
					<!--<th field="CreationUser" style="width: 200px;" sortable="true">Cr&eacute;&eacute; par</th>
					<th field="CreationDate" style="width: 200px;" sortable="true">Date Cr&eacute;ation</th> -->
					<th field=""  formatter=showButtons></th>
				</tr>
			</thead>
		</table>		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 13px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-adduser" plain="false" onclick="openFormUser()">Ajouter Utilisateur</a>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;" cellspacing="8">
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Nom:</label>
                    <div class="fitem">
                        <input id="Nom" name="Nom" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Pr&eacute;nom:</label>
                    <div class="fitem">
                        <input id="Prenom" name="Prenom" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Nom Utilisateur:</label>
                    <div class="fitem">
                        <input id="NomUtilisateur" name="NomUtilisateur" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
                    </div>
                   </td>
                </tr>

                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Groupe:</label>
                        <div class="fitem">
                            <input id="GroupeId" name="GroupeId" style="height: 30px; width: 100%;" class="easyui-combobox"
        					data-options="valueField:'Id',textField:'GroupName',url:'<?php echo $url_combobox_groupes; ?>', required:true,editable:true"
        					panelHeight="200px" />
                        </div>
                   </td>
                </tr>

               <tr> 
                   <td style="width: 100%;">
    				<label style="font-weight: bold">Statut:</label>
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
                   </td>
                </tr>
               </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="Save()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var crud_url='';
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }
  
        function openFormUser() {
    	  crud_url = '../controllers/utilisateurs_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>';
          $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Utilisateur');
          $('#fm').form('clear');
          $('#Statut').combobox('select', 'ACTIF');
          $('#Statut').combobox('readonly', true);
          $('#dlg').window('center');
        }

        function Save() {
            $('#fm').form('submit', {
                url: crud_url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.CODE_MESSAGE =='SUCCESS') {
                        $('#fm').form('clear');
                        $('#dlg').dialog('close');
                        $('#dg').datagrid('reload');
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
    });
   </script>
   
   <script type="text/javascript">
   function showButtons(val,row,index){
		var s = '<button id="'+index+'" value="'+row.Id+'"  style="width:80px; padding:4px" onclick="editUser(this)">Modifier</button> ';
		    s += '<button id="'+index+'" value="'+row.Id+'" style="width:120px; padding:4px" onclick="resetPassword(this)">Reset Password</button> ';
		   if(row.Statut=='ACTIF'){
			 s += '<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')">Bloquer</button>';
		   } else {
			  s += '<button id="'+index+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')"">Debloquer</button>';  
		   }
	    return s;
	}

	function editUser(obj){
	     var index =  obj.id;
	     var row = $('#dg').datagrid('getRows')[index];
		 crud_url = '../controllers/utilisateurs_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
		 var title = 'Form - Modifier Utilisateur';
         $('#dlg').dialog('open').dialog('setTitle',title);
         $('#fm').form('load', row); 
         $('#NomUtilisateur').textbox('readonly', true);
         $('#dlg').window('center');
	}

	function changerStatut(obj,statut){
		 var url = '../controllers/utilisateur_changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&id='+obj.value;
		 $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');
		 });
	}

	function resetPassword(obj){
		var url = '../controllers/utilisateur_reset_password.php?u=<?php echo $userId;?>&id='+obj.value;
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