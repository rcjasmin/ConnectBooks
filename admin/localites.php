<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Localites</title>
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
	<?php $url = "../controllers/localites.php?u=".$userId."&e=".$entrepriseId; ?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES REGIONS" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="Nom" style="width: 250px;" sortable="true">Nom R&eacute;gions</th>
					<th field="Statut" style="width: 250px;" sortable="true">Statut</th>
					<th field="CreationUser" style="width: 250px;" sortable="true">Cr&eacute;&eacute; par</th>
					<th field="CreationDate" style="width: 250px;" sortable="true">Date Cr&eacute;ation</th>
				</tr>
			</thead>
		</table>
		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 135px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="false" onclick="openFormDepartement()">Ajouter R&eacute;gion</a>
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-deposit" plain="false" onclick="openFormCommune()">Ajouter Ville</a>
        	    </span>
        </div>
        
    
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            	<label style="font-weight: bold">Nom:</label>
                <div class="fitem">
                    
                    <input id="Nom" name="Nom" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
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
            <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addDepartment()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var url='';
        function doSearch() {
            $('#dg').datagrid('load', {
                search: $('#search').val(),
                e:<?php echo $entrepriseId;?>
            });
        }

       
        function openFormDepartement() {
            $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Region');
            $('#fm').form('clear');
            url = '../controllers/localites_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>';
            $('#Statut').combobox('select', 'ACTIF');
            $('#Statut').combobox('readonly', true);
            $('#dlg').window('center');
        }


        function addDepartment() {
            $('#fm').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    if (result.CODE_MESSAGE =='SUCCESS') {
                        $('#dlg').dialog('close');
                        $('#dg').datagrid('reload');
                    }
                    $.messager.alert('Message', result.MESSAGE);
                }
            });
        }

        function openFormCommune() {
         var departement = $('#dg').datagrid('getSelected');
         if(departement != null) {
             $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Ville');
             $('#fm').form('clear');
             url = '../controllers/communes_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&d='+departement.Id;
             $('#Statut').combobox('select', 'ACTIF');
             $('#Statut').combobox('readonly', true);
             $('#dlg').window('center');
         } else {
        	 $.messager.alert('Message', 'SVP, selectionnez la region.');
         }
        }
        
    </script>
    
    
   <script>
   $(document).ready(function() {
   /*var dg = $('#dg').datagrid('enableFilter', [{
			field:'Statut',
			type:'combobox',
			options:{
				panelHeight:'auto',
				data:[{value:'',text:'TOUS'},{value:'ACTIF',text:'ACTIF'},{value:'INACTIF',text:'INACTIF'}],
				onChange:function(value){
					if (value == ''){
						dg.datagrid('removeFilterRule', 'status');
					} else {
						dg.datagrid('addFilterRule', {
							field: 'Statut',
							op: 'equal',
							value: value
						});
					}
					dg.datagrid('doFilter');
				}
			}
		},{
			field:'CreationDate',
			type:'datebox',
			options:{ onChange:function(value){
					if (value == ''){
						dg.datagrid('removeFilterRule', 'status');
					} else {
						dg.datagrid('addFilterRule', {
							field: 'CreationDate',
							op: 'contains',
							value: value
						});
					}
					dg.datagrid('doFilter');
				}
			}
		}]);
		*/
    	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>
   
   <script type="text/javascript">
	$('#dg').datagrid({
        onDblClickRow:function(index,row){
          url = '../controllers/localites_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
          $('#dlg').dialog('open').dialog('setTitle', 'Form - Modifier Region');
          $('#fm').form('clear');
          $('#fm').form('load',row);
          $('#Statut').combobox('readonly', false);
          $('#dlg').window('center');
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
                    url: '../controllers/communes.php?departement=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des communes en cours ...',
                    height: 'auto',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [
                            {field: 'Nom', title: 'Nom', width: 40},
                            {field: 'Statut', title: 'Statut', width: 40},
                            {field: 'CreationUser', title: 'Cree Par', width: 40},
                            {field: 'CreationDate', title: 'Date Creation', width: 40}
                        ]
                    ],
                    onResize: function () {
                        $('#dg').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function () {
                        setTimeout(function () {
                            $('#dg').datagrid('fixDetailRowHeight', index);
                        }, 0);
                    },onDblClickRow: function (index, row){
                        if (row) {
                            url = '../controllers/communes_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
                            $('#dlg').dialog('open').dialog('setTitle', 'Form - Modifier Ville');
                            $('#fm').form('clear');
                            $('#fm').form('load',row);
                            $('#Statut').combobox('readonly', false);
                            $('#dlg').window('center');
       			        }
            	     }
                });
                $('#dg').datagrid('fixDetailRowHeight', index);
            }
        });
     });
   </script>
   
    <script>
        $( window ).resize(function() {
            $('#dg').datagrid('resize');
        });        
    </script>
    </body>
</html>