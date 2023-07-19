<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Groupes</title>
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
	  $url = "../controllers/groupes.php?u=".$userId."&e=".$entrepriseId;
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES GROUPES ET DROITS D'ACCES" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				    <th field="Id" hidden="true" style="width: 1%;" sortable="true">Id</th>
					<th field=GroupName style="width: 300px;" sortable="true">Nom du Groupe</th>
					<th field="Statut" style="width: 100px;" sortable="true">Statut</th>
					<th field="CreationUser" style="width: 200px;" sortable="true">Cr&eacute;&eacute; par</th>
					<th field="CreationDate" style="width: 200px;" sortable="true">Date Cr&eacute;ation</th> 
					<th field=""  formatter=showButtons></th>
				</tr>
			</thead>
		</table>		
		
        <div id="tb" style="padding: 3px">
        	<!-- <span>Username:</span>-->
        	<input id="search" style="line-height: 26px; border: 1px solid #ccc; margin-left: 28px;margin-top: 8px;">
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 155px;margin-top: 8px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-addgroup" plain="false" onclick="openFormGroup()">Ajouter Groupe & Droits d'acces</a>
        	    </span>
        </div>
        
        <div id="dlg" class="easyui-dialog" style="width: 400px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
           <!--  <div class="ftitle">Information du d&eacute;partement</div>-->
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;" cellspacing="8">
                <tr> 
                  <td style="width: 100%;">
                     <label style="font-weight: bold">Nom Groupe:</label>
                    <div class="fitem">
                        <input id="GroupName" name="GroupName" style="height: 30px; width: 100%;" class="easyui-textbox" required="true" />
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

       
        function openFormGroup() {
    	  crud_url = '../controllers/groupe_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>';
          $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Groupe');
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
   <script type="text/javascript">
    var loaded = false;
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
                    url: '../controllers/groupes_access.php?groupeId=' + row.Id,
                    fitColumns: true,
                    singleSelect: false,
                    rownumbers: true,
                    loadMsg: 'Chargement des droits d\'acces en cours ...',
                    height: '150px',
                    checkOnSelect: true,
                    selectOnCheck: true,
                    columns: [
                        [
                            {field: 'Description', title: 'Description Droit d\'Acces', width: 40},
                            {field: 'ck', checkbox: "true", width: 40, align: "center"}
                        ]
                    ],
                    onResize: function () {
                        $('#dg').datagrid('fixDetailRowHeight', index);
                    },
                    onLoadSuccess: function () {
                        setTimeout(function () {
                            $('#dg').datagrid('fixDetailRowHeight', index);
                        }, 0);
                        
                        var rows = $(this).datagrid('getRows');
                        for (i = 0; i < rows.length; ++i) {
                            if (rows[i].Statut == 'ACTIF') {
                                $(this).datagrid('checkRow', i);
                            }
                        }
                        loaded = true;
                    },
                    /*onClickRow: function (index, row){
                    	updateDroitsAccess(this,row.Id);
                	},*/
                	onCheck: function (index, row){
                    	if(loaded) 
                		 updateDroitsAccess(this,row.Id,'ACTIF','record');
               	    },
               	     onUncheck: function (index, row){
             			  updateDroitsAccess(this,row.Id,'INACTIF','record');
            	    },
            	    onSelectAll: function() {
                	    var groupe =  $('#dg').datagrid('getSelected');
            	    	updateDroitsAccess(this,groupe.Id,'ACTIF','batch');
            	    },
            	    onUnselectAll: function() {
                	    var groupe =  $('#dg').datagrid('getSelected');
            	    	updateDroitsAccess(this,groupe.Id,'INACTIF','batch');
            	    }
                });
                $('#dg').datagrid('fixDetailRowHeight', index);
            }
        });
     });

    function updateDroitsAccess(dg,id,statut,operation){
      	 var url = '../controllers/groupes_access_update.php?id='+id+'&u=<?php echo $userId; ?>&s='+statut+'&o='+operation;
       	 $.get(url, function(data, status){
       	   if(data == "OK") {
       		//$(dg).datagrid('reload')
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
		var s = '<button id="'+index+'" value="'+row.DeviceId+'"  style="width:80px; padding:4px" onclick="editGroup(this)">Modifier</button> ';
		   if(row.Statut=='ACTIF'){
			 s += '&nbsp;<button id="'+index+'" value="'+row.DeviceId+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'INACTIF\')">Bloquer</button>&nbsp; ';
		   } else {
			  s += '&nbsp;<button id="'+index+'" value="'+row.DeviceId+'" style="width:80px; padding:4px" onclick="changerStatut(this,\'ACTIF\')"">Debloquer</button>&nbsp;';  
		   }
		
	    return s;
	}

	function editGroup(obj){
	     var index =  obj.id;
	     var row = $('#dg').datagrid('getRows')[index];
		 crud_url = '../controllers/groupe_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id='+row.Id;
		 var title = 'Form - Modifier Groupe';
         $('#dlg').dialog('open').dialog('setTitle',title);
         $('#fm').form('load', row); 
         $('#dlg').window('center');

	}

	function changerStatut(obj,statut){
		 var url = '../controllers/device_pos_changer_statut.php?u=<?php echo $userId;?>&s='+statut+'&id='+obj.value;
		 $.get( url, function(data) {
			 $.messager.alert('Message',data);
			 $('#dg').datagrid('reload');
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