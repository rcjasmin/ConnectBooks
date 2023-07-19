<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Limite Toutes Boules</title>

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
$url_combobox_tirages1 = "../controllers/tirages_combobox.php?r=0&e=" . $entrepriseId;
?>		
	  <div id="Main" align="center">

		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 600px; font-size: 12px"
			url=<?php echo $url_combobox_tirages1; ?> title="CONFIGURATION DE LIMITES POUR TOUTES LES BOULES" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="Nom" style="width: 300px;" sortable="true">TIRAGE</th>
					<th field=Id formatter=showButtons></th>
				</tr>
			</thead>
		</table>

		<div id="dlg" class="easyui-dialog"
			style="width: 400px; height: auto; padding: 20px;" closed="true"
			buttons="#dlg-buttons">
			<!--  <div class="ftitle">Information du d&eacute;partement</div>-->
			<form id="fm" method="POST" novalidate>

				<table style="width: 100%;" cellspacing="8">
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">BORLETTE:</label>
							<div class="fitem">
								<input id="BOL" name="BOL"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">MARIAGE:</label>
							<div class="fitem">
								<input id="MAR" name="MAR"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">LOTO 3:</label>
							<div class="fitem">
								<input id="LO3" name="LO3"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">LOTO 4:</label>
							<div class="fitem">
								<input id="LO4" name="LO4"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">LOTO 5:</label>
							<div class="fitem">
								<input id="LO5" name="LO5"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>

				</table>
			</form>
		</div>
		<div id="dlg-buttons">
			<a href="javascript:void(0)" class="easyui-linkbutton c6"
				iconCls="icon-ok" onclick="Save()" style="width: 140px;">Sauvegarder</a>
			<a href="javascript:void(0)" class="easyui-linkbutton"
				iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')"
				style="width: 140px;">Annuler</a>
		</div>
		

	</div>

	<script type="text/javascript">
	var url='';
	var operation_type= '';
	var id =0;
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=LIMITE_FICHE_BOULE';
    function openForm() {
            $('#dlg').dialog('open').dialog('setTitle', 'Limite Ticket Tirage : '+row.Nom);
            $('#fm').form('clear');
            $('#dlg').window('center');

     }


    function Save() {	 
        var selectedTirage = $('#dg').datagrid('getSelected');
  
       if (selectedTirage){
        
    	url = '../controllers/limite_toute_boule_crud.php?u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&t='+selectedTirage.Id;
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
                    
                    $.get(vurl, function(result) { });
                }
                $.messager.alert('Message', result.MESSAGE);
            }
        });
       } else {
    	   $.messager.alert('Message', 'SVP, selectionnez le tirage.');
       } 
    }


</script>

	<script type="text/javascript">
    	$('#dg').datagrid({
            onDblClickRow:function(index,row){

            	var url_data = '../controllers/limite_toute_boule_data.php?e=<?php  echo $entrepriseId;?>&Tirage=' + row.Id;
           		 $.get( url_data, function(data) {
               		 var obj = JSON.parse(data);
           			 $('#fm').form('load',obj);
           			$('#dlg').dialog('open').dialog('setTitle', 'Limite Toutes Boules Tirage : '+row.Nom);
           			$('#dlg').window('center');
           		 });
            }
        });

        function showButtons(val,row,index){
        	//var row = $('#dg').datagrid('getRows')[index];
			var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:120px; padding:4px" onclick="Configurer(this)">CONFIGURER</button>&nbsp;';
			return s;
		}

        function Configurer(obj){
        	var url_data = '../controllers/limite_toute_boule_data.php?e=<?php  echo $entrepriseId;?>&Tirage=' + obj.id;
      		 $.get( url_data, function(data) {
          		 var obj1 = JSON.parse(data);
      			 $('#fm').form('load',obj1);
      			$('#dlg').dialog('open').dialog('setTitle', 'Limite Toutes Boules Tirage : '+obj.value);
      			$('#dlg').window('center');
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
                    url: '../controllers/limite_toute_boule.php?e=<?php  echo $entrepriseId;?>&Tirage=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des configurations en cours ...',
                    height: 'auto',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [
                            {field: 'Jeu', title: 'TYPE JEU', width: 40},
                            {field: 'Montant', title: 'MONTANT', width: 40}
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


	<script>
   $(document).ready(function() {   
	   //$('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});	

        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>

</body>
</html>