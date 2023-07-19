<?php //session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Entreprises</title>
   <?php
$userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;
if (! isset($userId)) {
    header('Location: index.php');
    exit();
}
require '../admin/easyui_inc.php';
?> 

</head>
<body>
	<?php
$url = "entreprises_data.php?u=" . $userId;
?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size: 12px"
			url=<?php echo $url; ?> title="LISTE DES ENTREPRISES" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>

					<th field="Nom" style="width: 230px;" sortable="true">Nom
						Entreprise</th>
					<th field=Commune style="width: 230px;" sortable="true">Ville</th>
					<th field=Addresse style="width: 230px;" sortable="true">Addresse</th>
					<th field="TotalPOS" style="width: 120px;" sortable="true">Nombre
						POS</th>
					<th field=FullName style="width: 230px;" sortable="true">Responsable</th>
					<th field="Telephone1" style="width: 120px;" sortable="true">Telephone
						1</th>
					<th field="Telephone2" style="width: 120px;" sortable="true">Telephone
						2</th>
					<th field="Devise" style="width: 150px;" sortable="true">Devise</th>
					<th field="" style="" formatter=showButtons>Logo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</thead>
		</table>


		<div id="tb" style="padding: 3px">
			<!-- <span>Username:</span>-->
			<input id="search"
				style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px; margin-top: 8px;">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search"
				plain="false" onclick="doSearch()">Rechercher</a> <span
				class="alignment"
				style="float: right; margin-right: 1px; margin-top: 8px;"> <a
				href="javascript:void(0)" class="easyui-linkbutton"
				iconCls="icon-add" plain="false" onclick="openForm()">Ajouter
					Entreprise</a>
			</span>
		</div>

		<div id="dlg" class="easyui-dialog"
			style="width: 600px; height: auto; padding: 20px;" closed="true"
			buttons="#dlg-buttons">
			<!--  <div class="ftitle">Information du d&eacute;partement</div>-->
			<form id="fm" enctype="multipart/form-data" method="POST" novalidate>

				<table style="width: 100%;" cellspacing="8">

					<tr>
						<td style="width: 50%;"><label style="font-weight: bold">Nom
								Entreprise:</label>
							<div class="fitem">
								<input id="Nom" name="Nom" style="height: 30px; width: 100%;"
									class="easyui-textbox" required="true" />
							</div></td>
						<td style="width: 50%;"><label style="font-weight: bold">Logo:</label>
							<div class="fitem">
								<input id="Logo_entreprise" name="Logo_entreprise"
									style="height: 30px; width: 100%;" class="easyui-filebox" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 50%;"><label style="font-weight: bold">Nom
								Utilisateur [Default User]:</label>
							<div class="fitem">
								<input id="NomUtilisateur" name="NomUtilisateur"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>

						<td style="width: 50%;"><label style="font-weight: bold">Commune:</label>
							<div class="fitem">
								<input id="Commune" name="Commune"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 50%;"><label style="font-weight: bold">Addresse:</label>
							<div class="fitem">
								<input id="Addresse" name="Addresse"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
						<td style="width: 50%;"><label style="font-weight: bold">Nom
								Responsable:</label>
							<div class="fitem">
								<input id="NomResponsable" name="NomResponsable"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 50%;"><label style="font-weight: bold">Prenom
								Responsable:</label>
							<div class="fitem">
								<input id="PrenomResponsable" name="PrenomResponsable"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
						<td style="width: 50%;"><label style="font-weight: bold">Devise:</label>
							<div class="fitem">
								<input id="Devise" name="Devise"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 50%;"><label style="font-weight: bold">Telephone
								1:</label>
							<div class="fitem">
								<input id="Telephone1" name="Telephone1"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
						<td style="width: 50%;"><label style="font-weight: bold">Telephone
								2:</label>
							<div class="fitem">
								<input id="Telephone2" name="Telephone2"
									style="height: 30px; width: 100%;" class="easyui-textbox" />
							</div></td>
					</tr>

					<tr>


						<td style="width: 50%;"><label style="font-weight: bold">Telephone
								3:</label>
							<div class="fitem">
								<input id="Telephone3" name="Telephone3"
									style="height: 30px; width: 100%;" class="easyui-textbox" />
							</div></td>
					</tr>



				</table>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6"
				iconCls="icon-ok" onclick="addEntreprise()" style="width: 140px;">Sauvegarder</a>
			<a href="javascript:void(0)" class="easyui-linkbutton"
				iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
				style="width: 140px;">Annuler</a>
		</div>
	</div>

	<script type="text/javascript">
	var url='';
	var operationType='';
	var vurl = '';
	var id =0;
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val()
            });
        }
       
        function openForm() {
        	operationType = 'create';
        	id = 0;
            $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Entreprise');
            $('#fm').form('clear');
            $('#dlg').window('center');
        }


        function addEntreprise() {
            url = 'entreprise_crud.php?operation_type='+operationType+'&u=<?php echo $userId;?>&id='+ id;
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
                    }
                    $.messager.alert('Message', result.MESSAGE);
                }
            });
        }
   
    </script>


	<script>

   $(function () {
       // Add dialog , Upload control initialization 
       $('#Logo').filebox({
           buttonText: ' Choisir ',  // Button text 
           buttonAlign: 'right',   // Button alignment 
           //multiple: true,       // Whether to use multi file mode 
           accept: 'image/*', 
           onChange: function (e) {
           	change(this);// Upload processing 
           }
       });
   });

   function change(_obj){
		//var tempFile = $("#Logo");
		//var value=tempFile.filebox('getValue');
		//alert(value);
		//  Take suffix 
		/*var ext=value.substring(value.lastIndexOf(".")+1).toLowerCase();
		if((ext!='xls') && (ext!='xlsx')){
		    $.messager.alert(" Message tip ", " The file format needs to be *.xls or *.xlsx  type ", "error");
			$('#fb').filebox('setValue','');
		    return;
		}*/
	}
   
   $(document).ready(function() {   	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }   
    });
   </script>



	<script type="text/javascript">

   function showButtons(val,row,index){
	   var s = '<img src="'+row.Logo+'" style="width:80px; height:60px;>';
	   s+= '  <button id="'+row.Id+'" value="'+row.Logo+'" style="width:80px; padding:4px" onclick="voirLogo(this)"></button>';
	   s+= '  <button id="'+row.Id+'" value="'+index+'" style="width:80px; padding:4px" onclick="editEntreprise(this)">Modifier</button>';
	   if(row.Statut=='ACTIF'){
		  s+= '&nbsp;<button id="'+row.Id+'" value="'+index+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')"">Bloquer</button>&nbsp;';
	   } else {
		 s+= '&nbsp;<button id="'+row.Id+'" value="'+index+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')"">Debloquer</button>&nbsp;';  
	   }

	   s+= '&nbsp;<button id="'+row.Id+'" value="'+index+'" style="width:160px; padding:4px" onclick="resetPassword(this)"">Reinitialiser Mot de Passe</button>&nbsp;';
	    return s;
	}

	function changerStatut(obj,statut){

        $.messager.confirm('Confirmation', 'Voulez vous vraiment effectuer cette operation?', function (r) {
        if (r) {
    		 var url = 'changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&id='+obj.id;
    		 $.get( url, function(data) {

        		 var vurl = '../api/CreateLocalDB.php?level=ENTREPRISE&e='+obj.id;
        		 $.get(vurl, function(result) { });

        		 
    			 $.messager.alert('Message',data);
    			 $('#dg').datagrid('reload'); 
    		 });


         }
        });
	}

	function resetPassword(obj,statut){
         $.messager.confirm('Confirmation', 'Voulez vous vraiment reinitialiser le mot de passe?', function (r) {
         if (r) {
    		 var url = 'reset_password.php?u=<?php echo $userId;?>+&id='+obj.id;
    		 $.get( url, function(data) {
    			 $.messager.alert('Message',data);
    			 $('#dg').datagrid('reload'); 
    		 });
         }
        });
	}

	function editEntreprise(obj){
		operationType = 'update';
	    var index =  obj.value;
	    id = obj.id;
	    var row = $('#dg').datagrid('getRows')[index];
	    $('#fm').form('clear');
	    $('#dlg').dialog('open').dialog('setTitle', 'Form - Modifier Entreprise');
	    $('#dlg').window('center');
	    $('#Devise').textbox('setValue',row.Devise);
	    //$('#NomUtilisateur').textbox('readonly'); 
	    $('#fm').form('load', row); 
	}
   </script>

	<script>
        $( window ).resize(function() {
            $('#dg').datagrid('resize');
        });        
    </script>
</body>
</html>