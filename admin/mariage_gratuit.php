<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Mariage Gratuits</title>

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
			url=<?php echo $url_combobox_tirages1; ?> title="CONFIGURATION BONUS - MARIAGE GRATUIT" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="Nom" style="width: 200px;" sortable="true">TIRAGE</th>
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
						<td style="width: 100%;"><label style="font-weight: bold">MONTANT MINIMUM:</label>
							<div class="fitem">
								<input id="MontantMinimum" name="MontantMinimum"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">QUANTITE MARIAGE GRATUIT:</label>
							<div class="fitem">
								<input id="QuantitePari" name="QuantitePari"
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
	var vurl = '../api/CreateLocalDB.php?e=<?php echo $entrepriseId;?>&level=MARIAGE_GRATUIT';
    function openForm() {
            $('#dlg').dialog('open').dialog('setTitle', 'Limite Ticket Tirage : '+row.Nom);
            $('#fm').form('clear');
            $('#dlg').window('center');
     }

    function Save() {	 
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
			var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:230px; padding:4px" onclick="ConfigurerTouteBanque(this)">CONFIGURER TOUTES BANQUES</button>&nbsp;';
		    s += '&nbsp;<button id="'+row.Id+'" value="'+row.Nom+'" style="width:310px; padding:4px" onclick="EliminerTouteBanque(this)">ANNULER CONFIGURATION TOUTES BANQUES</button>&nbsp;';
			return s;
		}

        function ConfigurerTouteBanque(obj){
        	url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&Tirage=' + obj.id+'&OperationType=CNF_ALL_BANK&u='+<?php echo $userId;?>;
      		$('#dlg').dialog('open').dialog('setTitle', 'Toutes les Banques - Tirage : '+obj.value);
      		$('#dlg').window('center');

        }

        function Modifier(obj){

           	var url_data = '../controllers/mariage_gratis_data.php?id=' + obj.id;
   		    $.get( url_data, function(data) {
               if(data == 'false') {
            	   $.messager.alert('Message','Banque pas encore configuree');
               } else {
            	   url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&id=' + obj.id+'&OperationType=CNF_CONF_1_BANK&u='+<?php echo $userId;?>; 
           		var dataObj = JSON.parse(data);
       			$('#fm').form('load',dataObj);
       			$('#dlg').dialog('open').dialog('setTitle', 'Configuration | '+dataObj.Banque+ ' - '+dataObj.Tirage);
       			$('#dlg').window('center');

               }

        });
       }

        function Annuler(obj){    
            $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment annuler cette configuration?', function (r) {
                if (r) {
                	url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&id=' + obj.id+'&OperationType=DEL_CONF_1_BANK&u='+<?php echo $userId;?>; 
            		 $.get( url, function(data) {
                         var result = eval('(' + data + ')');
                         if (result.CODE_MESSAGE =='SUCCESS') {
                        	 $('#dg').datagrid('reload');
                        	 $.messager.alert('Message',result.MESSAGE);
                        	 $.get(vurl, function(data) { });	 
                         }
            		 }); }
               });
         }

        function EliminerTouteBanque(obj){    
            $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment annuler toutes les configurations?', function (r) {
                if (r) {
                	url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&Tirage=' + obj.id+'&OperationType=DEL_CONF_ALL_BANK&u='+<?php echo $userId;?>; 
            		 $.get( url, function(data) {
                         var result = eval('(' + data + ')');
                         if (result.CODE_MESSAGE =='SUCCESS') {
                        	 $('#dg').datagrid('reload');
                        	 $.messager.alert('Message',result.MESSAGE);
                        	 $.get(vurl, function(data) { });	 
                         }
            		 }); }
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
                    url: '../controllers/banques_mariage_gratis.php?e=<?php  echo $entrepriseId;?>&t=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des configurations en cours ...',
                    height: 'auto',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [   
                            {field: 'Nom', title: 'BANQUE', width: 6},
                            {field: 'MontantMinimum', title: 'MONTANT MINIMUM', width: 8},
                            {field: 'QuantitePari', title: 'QUANTITE MARIAGE', width: 8 },
                            {field: 'Id', title: '', width: 4,
                            	formatter(value){
                                if (value != null){
                                  return '<button id="'+value+'" value="'+value+'" style="width100px; padding:4px" onclick="Modifier(this)">MODIFIER</button>'
                                } else {
                                  return value;
                                }
                              }
                            },
                            {field: 'Cid', title: '', width: 4,
                            	formatter(value){
                                if (value != null){
                                  return '<button id="'+value+'" value="'+value+'" style="width100px; padding:4px" onclick="Annuler(this)">ANNULER</button>'
                                } else {
                                  return value;
                                }
                              }
                            }  
                        ]
                    ],
                    onResize: function () {
                        $('#dg').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function () {
                        setTimeout(function () {
                            $('#dg').datagrid('fixDetailRowHeight', index);
                        }, 0);
                    },
                    toolbar:[{
                        iconCls:'icon-deposit',
                        text:'Configurer',
                        handler:function(){
                          
                            var rows =  $('#ddv-' + index).datagrid('getSelections');
                            var banques ='';
                            if(rows.length>0) {
                            for(var i=0; i<rows.length; i++){
                                if(banques==''){
                                	banques = rows[i].BanqueId;
                                } else {
                                	banques +=','+ rows[i].BanqueId;
                                }
                            }

                            var row = $('#dg').datagrid('getSelected');
                        	url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&Tirage=' + row.Id+'&OperationType=CNF_BLK_BANK&u='+<?php echo $userId;?>+'&b='+banques;
                      		$('#dlg').dialog('open').dialog('setTitle', 'Banques Selectionnees - Tirage : '+row.Nom);
                      		$('#dlg').window('center');
                      		//alert(url);
                            
                          } else {
                        	  $.messager.alert('Message','Selectionner au moins une banque');	
                          }

                        }
                    },{
                        iconCls:'icon-cancel',
                        text:'Annuler',
                        handler:function(){
                            var rows =  $('#ddv-' + index).datagrid('getSelections');
                            var banques ='';
                            if(rows.length>0) {
                            for(var i=0; i<rows.length; i++){
                                if(banques==''){
                                	banques = rows[i].BanqueId;
                                } else {
                                	banques +=','+ rows[i].BanqueId;
                                }
                            }

                            var row = $('#dg').datagrid('getSelected');
                        	url = '../controllers/MariageGratis_crud.php?e=<?php  echo $entrepriseId;?>&Tirage=' + row.Id+'&OperationType=DEL_BLK_BANK&u='+<?php echo $userId;?>+'&b='+banques;

                            $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment annuler toutes ces configurations?', function (r) {
                                if (r) {

                            		 $.get( url, function(data) {
                                         var result = eval('(' + data + ')');
                                         if (result.CODE_MESSAGE =='SUCCESS') {
                                        	 $('#dg').datagrid('reload');
                                        	 $.messager.alert('Message',result.MESSAGE);
                                        	 $.get(vurl, function(data) { });	 
                                         }
                            		 }); }
                               });
                            
                          } else {
                        	  $.messager.alert('Message','Selectionner au moins une banque');	
                          }
                        }
                    }]
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