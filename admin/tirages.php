<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Tirages</title>
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
	<?php  $url = "../controllers/tirages.php?u=".$userId."&e=".$entrepriseId;?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES TIRAGES" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				    <th field="Id" hidden="true"  sortable="true">Id</th>
					<th field="Nom" style="width: 250px" sortable="true">Tirage</th>
					<th field="HEURE_OUVERTURE" style="width: 200px;" sortable="true">Heure d'ouverture</th>
					<th field="HEURE_FERMETURE" style="width: 200px;" sortable="true">Heure de Fermeture</th>
					<th field="Statut" style="width: 100px;" sortable="true">Statut</th>
					<th field="IsExist" formatter=showButtons></th>
				</tr>
			</thead>
		</table>
		
       
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;">
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Heure d'ouverture:</label>
                    <div class="fitem">
                        <input id="HeureOuverture" name="HeureOuverture" style="height: 30px; width: 100%;" class="easyui-timespinner" data-options="showSeconds:true" required="true" />
                    </div>
                   </td>
                   </tr>
                   
                   <tr>
                   <td style="width: 100%;">
                    <label style="font-weight: bold">Heure de fermeture:</label>
                     <br/>
                     <label style="font-size: 10px; color:red; font-weight: bold ">&nbsp;</label>
                    <div class="fitem">
                        <input id="HeureFermeture" name="HeureFermeture" style="height: 30px; width: 100%;" class="easyui-timespinner" data-options="showSeconds:true" required="true" />
                    </div>
                   </td>
                </tr>
                
              
               </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a id ="saveBtn" href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="Save()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
   <script>
   var url='';
   $(document).ready(function() {   	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=TIRAGE';
   </script>

   
   <script type="text/javascript">
   function showButtons(val,row,index){
			   if(row.Statut=='ACTIF'){
				     
					var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\',\'OUI\')">Desactiver</button>&nbsp; ';
					 s+= '<button id="'+row.Id+'" value="'+row.Nom+'" style="width:185px; padding:4px" onclick="editConfiguration(this)">Modifier Configuration Heures</button>';
			   } else {
				  if (val =='OUI'){
				   var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\',\'OUI\')">Activer</button>&nbsp;'; 
				  } else{
					var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\',\'NON\')">Activer</button>&nbsp;';
				  } 
			   }
			 return s;
	}

	function editConfiguration(obj){
		 var getConfUrl = '../controllers/tirage.php?e=<?php echo $entrepriseId;?>&t='+obj.id;
		 $.get( getConfUrl, function(data) {
			 var row =JSON.parse(data);
			 url = '../controllers/tirage_configuration.php?u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&t='+obj.id+'&s='+row.Statut;
			 var title = 'Form - Configuration Tirage: '+ obj.value;
	         $('#dlg').dialog('open').dialog('setTitle', title);
	         $('#fm').form('load', row); 
	         $('#dlg').window('center');
		 });
	}

	function changerStatut(obj,statut,isExist){
		 url = '../controllers/tirage_configuration.php?u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&s='+statut+'&t='+obj.id;
		 if(isExist=='OUI') {
		  $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');

			  //Update Configuration file
			   //url = '../api/CreateTirageFiles.php?u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&s='+statut+'&t='+obj.id;
			   $.get(vurl, function(data) { });
		  });
		 }else{
			 var title = 'Form - Configuration Tirage: '+ obj.value;
             $('#dlg').dialog('open').dialog('setTitle', title);
             $('#fm').form('clear');
             $('#dlg').window('center');
		 }
	}

    function Save() {
        $('#fm').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (result) {
               if (result != 'HEURE_RANGE_NOK') {
            	$('#dg').datagrid('reload');
                $('#fm').form('clear');
                $('#dlg').dialog('close');
                $('#dg').datagrid('reload');

                //Update Configuration file
                //var qs = url.substring(url.indexOf('?') + 1);
                //var vurl = '../api/CreateTirageFiles.php?'+qs;
                $.get(vurl, function(data) { });
                
                $.messager.alert('Message', result);
               }else{
                   var msg = "L'heure d'ouverture doit etre inferieure a celle de fermeture";
            	   $.messager.alert('Message', msg);
               }
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