<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>POS-Devices</title>
   <?php
    $userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;
    if(!isset($userId)){
        header('Location: index.php');
        exit();
    }
    require '../admin/easyui_inc.php';
   ?> 

</head>
<body>
<?php
$url = "pos_devices_data.php?u=" . $userId;
$url_combobox = "entreprises_combobox.php?r=1&u=".$userId;

?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 560px; font-size: 12px"
			url=<?php echo $url; ?> title="LISTE DES MATERIELS POS" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="DeviceId" hidden="true" sortable="true">Id</th>
					<th field=NomEntreprise style="width: 250px;" sortable="true">Nom Entreprise</th>
					<th field=EMEI style="width: 250px;" sortable="true">Android ID</th>
					<th field="" width="250px" formatter=showButtons></th>
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
							<td><span>Android ID:</span></td>
							<td><span>Entreprise(s):</span></td>
						</tr>

						<tr>
							<td><input id="AndroidID" name="AndroidID"
								style="line-height: 26px; height: 28px; width: 200px; border: 1px solid #ccc;">
							</td>
							<td><input id="Entreprise" name="Entreprise"
								style="height: 28px; width: 200px;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox; ?>',required:false,editable:true,multiple:true"
								panelHeight="200px" /></td>
						</tr>
					</table>
					
				</div>
				<a href="#" class="easyui-linkbutton" iconCls="icon-search"
					plain="false" onclick="doSearch()">Rechercher</a>
			</fieldset>
		</div>

	</div>

	<script type="text/javascript">
	var url='';
	
	
        function doSearch() {
            $('#dg').datagrid('load', {
            	Entreprise: $('#Entreprise').combobox('getValues'),
            	AndroidID: $('#AndroidID').val()      
            });
        }
       
    </script>

	<script>
   $(document).ready(function() {   
	  // $('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});	

        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
        $('#Entreprise').combobox('setValues','');
    });
   </script>

	<script type="text/javascript">
   function showButtons(val,row,index){
	   var s = '&nbsp;<button id="'+row.DeviceId+'" style="width:80px; padding:4px" onclick="supprimer(this)">Supprimer</button>&nbsp; ';
	  return s;
	}




	function supprimer(obj){
		 var url = 'supprimer_pos.php?u=<?php echo $userId;?>&DeviceId='+obj.id;
         $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment supprimer cet appareil POS?', function (r) {
             if (r) {
        		 $.get( url, function(data) {
        			 if(data=='OK'){
        			   $('#dg').datagrid('reload');
        			   $.messager.alert('Message', 'POS '+obj.value+' supprim&eacute;.');
        			 }else{
        				 $.messager.alert('Message',data);
        			 }
        		 });
             }
         });
	}


	</script>

</body>
</html>