<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>POS - Device</title>
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
	  $url = "../controllers/devices_pos.php?u=".$userId."&e=".$entrepriseId;
	  $url_combobox_banque = "../controllers/banques_combobox.php?e=".$entrepriseId;
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES DISPOSITIFS ANDROID" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				    <th field="DeviceId" hidden="true" style="width: 1%;" sortable="true">DeviceId</th>
					<th field=EMEI style="width: 15%;" sortable="true">ANDROID ID</th>
					<th field="NomBanque" style="width: 13%;" sortable="true">Banque Assign&eacute;e</th>
					<th field="AddresseBanque" style="width: 25%;" sortable="true">Addresse Banque</th>
					<th field="Statut" style="width: 8%;" sortable="true">Statut</th>
					<!-- <th field="CreationUser" style="width: 15%;" sortable="true">Cr&eacute;&eacute; par</th>-->
					<th field="CreationDate" style="width: 15%;" sortable="true">Date Cr&eacute;ation</th> 
					<th field="" width="11%" formatter=showButtons></th>
				</tr>
			</thead>
		</table>
		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 86px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-phone-add" plain="false" onclick="openFormDispositif()">Ajouter Dispositif</a>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;" cellspacing="8">
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">ANDROID ID:</label>
                    <div class="fitem">
                        <input id="EMEI" name="EMEI" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
                    </div>
                   </td>
                </tr>
                
                
               <tr> 
                   <td style="width: 100%;">
    				<label style="font-weight: bold">Banque:</label>
					<div class="fitem">
							<input id="Banque" name="Banque" style="width: 100%;height: 30px"
							class="easyui-combobox" required="true"
							data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_banque; ?>', required:true,editable:true"
							panelHeight="200px">
					</div>
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
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=DEVICE';
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }

       
        function openFormDispositif() {
    	  crud_url = '../controllers/devices_pos_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>';
    	 // vurl = '../api/CreateDeviceFiles.php?e=<?php //echo $entrepriseId;?>//&id=0';
          $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Dispositif Android');
          $('#fm').form('clear');
          $('#dlg-buttons').show();
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

            			//Update Configuration file
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
   function showButtons(val,row,index){
		var s = '<button id="'+index+'" value="'+row.DeviceId+'"  style="width:80px; padding:4px" onclick="editDevice(this)">Modifier</button> ';
		   if(row.Statut=='ACTIF'){
			 s += '&nbsp;<button id="'+index+'" value="'+row.DeviceId+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')">Bloquer</button>&nbsp; ';
		   } else {
			  s += '&nbsp;<button id="'+index+'" value="'+row.DeviceId+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')"">Debloquer</button>&nbsp;';  
		   }
		
	    return s;
	}

	function editDevice(obj){
		 var url = '../controllers/device.php?deviceId='+obj.value;
		 $.get( url, function(data) {
			 var row =JSON.parse(data);
			 crud_url = '../controllers/devices_pos_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
			 //vurl = '../api/CreateDeviceFiles.php?e=<?php //echo $entrepriseId;?>//&id='+row.Id;
			 var title = 'Form - Modifier Dispositif';
             $('#dlg').dialog('open').dialog('setTitle',title);
             $('#fm').form('load', row); 
             $('#dlg').window('center');
		 });
	}

	function changerStatut(obj,statut){
		 var url = '../controllers/device_pos_changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&id='+obj.value;
		 $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');

			//Update Configuration file
			 //vurl = '../api/CreateDeviceFiles.php?e=<?php //echo $entrepriseId;?>//&id='+obj.value;
			 $.get(vurl, function(data) { });
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