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
    require_once '../classes/Utility.php';
    require 'easyui_inc.php';
   ?> 

</head>
<body>
	<?php  $url = "../controllers/vendeurs_pos.php?u=".$userId."&e=".$entrepriseId;?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES VENDEURS" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="false">

			<thead>
				<tr>
				    <th field="UtilisateurId" hidden="true" style="width: 23%;" sortable="true">UtilisateurId</th>
					<th field=NomComplet style="width: 23%;" sortable="true">Nom Vendeur</th>
					<th field="NomBanque" style="width: 15%;" sortable="true">Banque</th>
					<th field="AddresseBanque" style="width: 35%;" sortable="true">Addresse Banque</th>
					<th field="Statut" style="width: 8%;" sortable="true">Statut</th>
					<th field="ck" checkbox="true"></th>
					<th field="RatiosConfigures" width="15%" formatter=showButtons></th>
				</tr>
			</thead>
		</table>
		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 6px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-money-dollar1" plain="false" onclick="openFormRatio()">Ajouter Ratio Paiement Pertes</a>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 600px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;" cellspacing="8">
                <tr> 
                  <td style="width: 50%;">
                     <label style="font-weight: bold">Borlette (Format ci-dessous):</label>
                     <br/>
                     <label style="font-size: 10px; color:red; font-weight: bold ">[Montant 1e Lo:Montant 2e Lo:Montant 3e Lo]</label>
                       
                    <div class="fitem">
                        <input id="BOL" name="BOL" style="height: 30px; width: 100%;" class="easyui-textbox" data-options="validType:'borletteRatio[]'" required="true" />
                    </div>
                   </td>
                   <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 3 :</label>
                     <br/>
                     <label style="font-size: 10px; color:red; font-weight: bold ">&nbsp;</label>
                    <div class="fitem">
                        <input id="LO3" name="LO3" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Mariage:</label>
                    <div class="fitem">
                        <input id="MAR" name="MAR" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 4 [Option 1]:</label>
                    <div class="fitem">
                        <input id="LO41" name="LO41" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                </tr>
                
               <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 4 [Option 2]:</label>
                    <div class="fitem">
                        <input id="LO42" name="LO42" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 4 [Option 3]:</label>
                    <div class="fitem">
                        <input id="LO43" name="LO43" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 5 [Option 1]:</label>
                    <div class="fitem">
                        <input id="LO51" name="LO51" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                   <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 5 [Option 2]:</label>
                    <div class="fitem">
                        <input id="LO52" name="LO52" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 5 [Option 3]</label>
                    <div class="fitem">
                        <input id="LO53" name="LO53" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true"  />
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Mariage Gratuit</label>
                    <div class="fitem">
                        <input id="MAG" name="MAG" style="height: 30px; width: 100%;" class="easyui-numberbox" required="true"  />
                    </div>
                   </td>
                </tr>
               </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a id ="saveBtn" href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addRatios()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var url='';
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=RATIO_PERTES';
	
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }
       
        function openFormRatio() {
            var utilisateurs = $('#dg').datagrid('getSelections');
            if (utilisateurs.length > 0) {
              $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Ratio Paiement Pertes');
              $('#fm').form('clear');
              $('#saveBtn').show();
              $('#dlg').window('center');
            } else {
            	$.messager.alert('Message', "Selectionnez au moins un utilisateur.");
            }
        }


        function addRatios() {
        	var rows = $('#dg').datagrid('getSelections');
        	var utilisateurs ='';
        	for(var i=0;i<rows.length;i++){
            	if(utilisateurs==''){
            		utilisateurs = rows[i].UtilisateurId;
                } else {
                	utilisateurs = utilisateurs +','+ rows[i].UtilisateurId;
                }
            }
           url = '../controllers/utlisateurs_pos_ratios_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&utilisateurs=' + utilisateurs;
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
                        $.get(vurl, function(data) { });
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
   $.extend($.fn.validatebox.defaults.rules, {
	    borletteRatio: {
	        validator: function(value, param){
	        	const regex = /[0-9]+:[0-9]+:[0-9]+/g;
	            return value.match(regex)
	        },
	        message: 'Format incorrect. Exemple de format valide : 50:20:10'
	    }
	});
   </script>
   
   <script type="text/javascript">
   function showButtons(val,row,index){
			 if(val=='OUI'){
				 var s = '&nbsp;<button id="'+index+'" value="'+row.UtilisateurId+'" style="width:80px; padding:4px" onclick="viewRatio(this)">Voir</button> ';
				 s+= '<button id="'+index+'" value="'+row.UtilisateurId+'" style="width:80px; padding:4px" onclick="editRatio(this)">Modifier</button>';
			 } else{
				 var s = '<label style="font-size:10px; color:red; font-weight:bold">Ratios Non Configur&eacute;</label>';
			 }
			 return s;
	}

	function editRatio(obj){
		 $('#dg').datagrid('unselectAll');
		 var url = '../controllers/Ratios.php?vendeur='+obj.value;
		 $.get( url, function(data) {
			 var row =JSON.parse(data);
			 var title = 'Form - Modifier Ratios - Vendeur: '+row.Vendeur;
             $('#dlg').dialog('open').dialog('setTitle',title);
             $('#fm').form('load', row); 
             $('#saveBtn').show();
             $('#dlg').window('center');
		 });
	}

	function viewRatio(obj){
		 $('#dg').datagrid('unselectAll');
		 var url = '../controllers/Ratios.php?vendeur='+obj.value;
		 $.get( url, function(data) {
			 var row =JSON.parse(data);
			 var title = 'Ratio Paiement Perte - Vendeur: '+row.Vendeur;
             $('#dlg').dialog('open').dialog('setTitle',title);
             $('#fm').form('load', row); 
             $('#saveBtn').hide();
             $('#dlg').window('center');
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