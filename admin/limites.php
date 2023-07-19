<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Fiches Ventes</title>

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
    $url = "../controllers/limites.php?u=" . $userId . "&e=" . $entrepriseId;
    $url_combobox_tirages = "../controllers/tirages_combobox.php?r=1&e=" . $entrepriseId;
    $url_combobox_banques = "../controllers/banques_combobox.php?r=1&e=" . $entrepriseId;
?>		
	  <div id="Main" align="center">

		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height: 600px; font-size: 12px"
			url=<?php echo $url; ?> title="CONFIGURATION DE LIMITES" iconCls=""
			toolbar="#tb" rownumbers="true" pagination="true" singleSelect="true">

			<thead>
				<tr>
					<th field="TIRAGE" style="width: 150px;" sortable="true">TIRAGE</th>
					<th field=JEU style="width: 150px;" sortable="true">TYPE JEU</th>
					<th field=Boule style="width: 150px;" sortable="true">BOULE</th>
					<th field=Montant style="width: 150px;" sortable="true">MONTANT</th>
					<th field=DateDebut style="width: 150px;" sortable="true">DATE DEBUT</th>
					<th field=DateFin style="width: 150px;" sortable="true">DATE FIN</th>
					<th field=Id formatter=showButtons></th>
				</tr>
			</thead>
		</table>

		<div id="tb" style="padding: 5px; height: auto">

			<!-- <fieldset style="width: 200px">
				<legend
					style="background-color: #000; color: #fff; padding: 3px 6px;">
					Param&egrave;tres Filtrage</legend> -->
			<div style="margin-bottom: 5px">

				<table>
					<tr>
						<td><span>Tirage:</span></td>
					</tr>

					<tr>
						<td><input id="Tirage" name="Tirage"
							style="height: 28px; width: 200px;" class="easyui-combobox"
							data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>', required:false,editable:true,multiple:true,
							 onSelect: function(rec){
                             if(rec.Id =='') {
                                var list = $('#Tirage').combobox('getData');
                                for (let i = 0; i < list.length; i++) {
                                 $('#Tirage').combobox('select', list[i].Id);
                                }
                             }
                             $('#Tirage').combobox('unselect', '');}
							"
							panelHeight="200px" />
							
							 <a href="#" class="easyui-linkbutton" iconCls="icon-database_gear" plain="false" onclick="doSearch()">Rechercher</a>
							
							</td>
					</tr>
					
					<tr>
					 <td> 
					 
            			<span class="alignment"
            				style="float: left; margin-right: 0px; margin-top: 8px;"> <a
            				href="javascript:void(0)" class="easyui-linkbutton"
            				iconCls="icon-money-dollar1" plain="false" onclick="openForm()">Ajouter
            					Limite Boule</a>
            			</span><br /> <br />
					 </td>
					</tr>
				</table>
				<!--  <table>
					<tr>
						<td><span>Date D&eacute;but:</span></td>
						<td><span>Date Fin:</span></td>
					</tr>
					<tr>
						<td><input class="easyui-datebox" id="DateDebut" name="DateDebut"
							data-options="formatter:myformatter,parser:myparser"
							style="width: 200px; height: 28px; line-height: 20px"></td>

						<td><input class="easyui-datebox" id="DateFin" name="DateFin"
							data-options="formatter:myformatter,parser:myparser"
							style="width: 200px; height: 28px; line-height: 20px"></td>
					</tr>
				</table>
				-->
			</div>




			<!-- </fieldset> -->


		</div>


		<div id="dlg" class="easyui-dialog"
			style="width: 400px; height: auto; padding: 20px;" closed="true"
			buttons="#dlg-buttons">
			<!--  <div class="ftitle">Information du d&eacute;partement</div>-->
			<form id="fm" method="POST" novalidate>

				<table style="width: 100%;" cellspacing="8">
				<tr>
					<td style="width: 100%;"><label style="font-weight: bold">Banque(s):</label>
						<div class="fitem">
							<input id="Banques" name="Banques"
								style="height: 30px; width: 100%;" class="easyui-combobox"
								data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_banques; ?>',
							 required:true,editable:true,multiple:true,
							 
                            onSelect: function(rec){
                             if(rec.Id =='') {
                                var list = $('#Banques').combobox('getData');
                                for (let i = 0; i < list.length; i++) {
                                 $('#Banques').combobox('select', list[i].Id);
                                }
                             }
                             $('#Banques').combobox('unselect', '');}"
								panelHeight="200px" />
						</div></td>
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Tirage(s):</label>
							<div class="fitem">
								<input id="Tirages" name="Tirages"
									style="height: 30px; width: 100%;" class="easyui-combobox"
									data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>',
							 required:true,editable:true,multiple:true,
							 
                            onSelect: function(rec){
                             if(rec.Id =='') {
                                var list = $('#Tirages').combobox('getData');
                                for (let i = 0; i < list.length; i++) {
                                 $('#Tirages').combobox('select', list[i].Id);
                                }
                             }
                             $('#Tirages').combobox('unselect', '');}"
									panelHeight="200px" />
							</div></td>
					</tr>

					<tr>
						
					<tr>
					
						<td style="width: 100%;"><label style="font-weight: bold">Jeu</label>
							<div class="fitem">
								<input style="height: 30px; width: 100%;" id="Jeux"
									class="easyui-combobox" name="Jeux"
									data-options="valueField:'value',textField:'label',data:
        								 [{
        									label: '',
        									value: ''
        								  },{
        									label: 'BOL',
        									value: 'BOL'
        								  },{
        									label: 'MAR',
        									value: 'MAR'
        								  },{
        									label: 'LO3',
        									value: 'LO3'
        								 },{
        									label: 'LO41',
        									value: 'LO41'
        								 },{
        									label: 'LO42',
        									value: 'LO42'
        								 },{
        									label: 'LO43',
        									value: 'LO43'
        								 },{
        									label: 'LO51',
        									value: 'LO51'
        								 },{
        									label: 'LO52',
        									value: 'LO52'
        								 },{
        									label: 'LO53',
        									value: 'LO53'
        								 }], required:true,editable:true"
									panelHeight="200px" />
							</div></td>
					    <!-- 
						<td style="width: 100%;"><label style="font-weight: bold">Jeu</label>
							<div class="fitem">
								<input style="height: 30px; width: 100%;" id="Jeux"
									class="easyui-combobox" name="Jeux"
									data-options="valueField:'value',textField:'label',data:
        								 [{
        									label: 'TOUS LES JEUX',
        									value: 'TOUS'
        								  },{
        									label: 'BORLETTE',
        									value: 'BOL'
        								  },{
        									label: 'MARIAGE',
        									value: 'MAR'
        								  },{
        									label: 'LOTTO 3',
        									value: 'LO3'
        								 },{
        									label: 'LOTTO 4',
        									value: 'LO4'
        								 },{
        									label: 'LOTTO 5',
        									value: 'LO5'
        								 }], required:true,editable:true,multiple:false,
        								 
                        onSelect: function(rec){
                         if(rec.value =='TOUS') {
                            $('#Jeux').combobox('select', 'BOL');
                            $('#Jeux').combobox('select', 'MAR');
                            $('#Jeux').combobox('select', 'LO3');
                            $('#Jeux').combobox('select', 'LO4');
                            $('#Jeux').combobox('select', 'LO5'); 
                         } 
                         $('#Jeux').combobox('unselect', 'TOUS'); }"
									panelHeight="200px" />
							</div></td>
							-->
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Toutes les boules:</label>
							<div class="fitem">
                                <input  id="ttBoule" type="checkbox"  class="easyui-checkbox" name="ttBoule"  />
                                
							</div></td>
					</tr>
					
					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Boule:</label>
							<div class="fitem">
								<input id="Boule" name="Boule"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Montant:</label>
							<div class="fitem">
								<input id="Montant" name="Montant"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>


					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Date
								Debut:</label>
							<div class="fitem">
								<input class="easyui-datebox" id="StartDate" name="StartDate"
									data-options="formatter:myformatter,parser:myparser,required:true"
									style="width: 100%; height: 30px; line-height: 20px">
							</div></td>
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Date
								Fin:</label>
							<div class="fitem">
								<input class="easyui-datebox" id="EndDate" name="EndDate"
									data-options="formatter:myformatter,parser:myparser,required:true"
									style="width: 100%; height: 30px; line-height: 20px">
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
		
		
		
		
		<div id="dlg1" class="easyui-dialog"
			style="width: 400px; height: auto; padding: 20px;" closed="true"
			buttons="#dlg-buttons1">
			<!--  <div class="ftitle">Information du d&eacute;partement</div>-->
			<form id="fm1" method="POST" novalidate>

				<table style="width: 100%;" cellspacing="8">

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Tirage(s):</label>
							<div class="fitem">
								<input id="Tirages1" name="Tirages1"
									style="height: 30px; width: 100%;" class="easyui-combobox"
									data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>',
							 required:true,editable:true,multiple:false"
									panelHeight="200px" />
							</div></td>
					</tr>

		
					<tr>
					
						<td style="width: 100%;"><label style="font-weight: bold">Jeu</label>
							<div class="fitem">
								<input style="height: 30px; width: 100%;" id="Jeux1"
									class="easyui-combobox" name="Jeux1"
									data-options="valueField:'value',textField:'label',data:
        								 [{
        									label: '',
        									value: ''
        								  },{
        									label: 'BOL',
        									value: 'BOL'
        								  },{
        									label: 'MAR',
        									value: 'MAR'
        								  },{
        									label: 'LO3',
        									value: 'LO3'
        								 },{
        									label: 'LO41',
        									value: 'LO41'
        								 },{
        									label: 'LO42',
        									value: 'LO42'
        								 },{
        									label: 'LO43',
        									value: 'LO43'
        								 },{
        									label: 'LO51',
        									value: 'LO51'
        								 },{
        									label: 'LO52',
        									value: 'LO52'
        								 },{
        									label: 'LO53',
        									value: 'LO53'
        								 }], required:true,editable:true"
									panelHeight="200px" />
							</div></td>
					   
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Boule:</label>
							<div class="fitem">
								<input id="Boule1" name="Boule1"
									style="height: 30px; width: 100%;" class="easyui-textbox"
									required="true" />
							</div></td>
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Montant:</label>
							<div class="fitem">
								<input id="Montant1" name="Montant1"
									style="height: 30px; width: 100%;" class="easyui-numberbox"
									required="true" />
							</div></td>
					</tr>


					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Date
								Debut:</label>
							<div class="fitem">
								<input class="easyui-datebox" id="StartDate1" name="StartDate1"
									data-options="formatter:myformatter,parser:myparser,required:true"
									style="width: 100%; height: 30px; line-height: 20px">
							</div></td>
					</tr>

					<tr>
						<td style="width: 100%;"><label style="font-weight: bold">Date
								Fin:</label>
							<div class="fitem">
								<input class="easyui-datebox" id="EndDate1" name="EndDate1"
									data-options="formatter:myformatter,parser:myparser,required:true"
									style="width: 100%; height: 30px; line-height: 20px">
							</div></td>
					</tr>

				</table>
			</form>
		</div>
		<div id="dlg-buttons1">
			<a href="javascript:void(0)" class="easyui-linkbutton c6"
				iconCls="icon-ok" onclick="Update()" style="width: 140px;">Sauvegarder</a>
			<a href="javascript:void(0)" class="easyui-linkbutton"
				iconCls="icon-cancel" onclick="javascript:$('#dlg1').dialog('close')"
				style="width: 140px;">Annuler</a>
		</div>
	</div>

	<script type="text/javascript">
	var url='';
	var operation_type= '';
	var id =0;
    function openForm() {
        operation_type = 'create';
        $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Limite Boule');
        $('#fm').form('clear');
        $('#dlg').window('center');
      }


    function Save() {

        var b=  $('#Banques').combobox('getValues');
        var t=  $('#Tirages').combobox('getValues');
        var j=  $('#Jeux').combobox('getValue');

        url = '../controllers/limite_boule_crud.php?operation_type=create&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&b='+b+'&t='+t+'&j='+j;
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

    function Update() {

        var b=  '0';
        var t=  $('#Tirages1').combobox('getValue');
        var j=  $('#Jeux1').combobox('getValue');

        url = '../controllers/limite_boule_crud.php?operation_type=update&u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&b='+b+'&t='+t+'&j='+j+ '&id='+id;

        $('#fm1').form('submit', {
            url: url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (result) {
                var result = eval('(' + result + ')');
                if (result.CODE_MESSAGE =='SUCCESS') {
                    $('#fm1').form('clear');
                    $('#dlg1').dialog('close');
                    $('#dg').datagrid('reload');
                }
                $.messager.alert('Message', result.MESSAGE);
            }
        });
    }

</script>

	<script type="text/javascript">
        function doSearch() {
            $('#dg').datagrid('load', {
            	Tirage: $('#Tirage').combobox('getValues'),
                e:<?php echo $entrepriseId;?>       
            });

           // alert($('#Tirage').combobox('getValues'));
        }

    	$('#dg').datagrid({
            onDblClickRow:function(index,row){
                $('#dlg1').dialog('open').dialog('setTitle', 'Form - Modifier Limite');
                $('#fm1').form('clear');
                $('#fm1').form('load',{'Tirages1':row.TirageId,'Jeux1':row.Jeu,'Boule1':row.Boule,'Montant1':row.Montant,'StartDate1':row.DateDebut,'EndDate1':row.DateFin});

                id = row.Id;
                var operation_type= 'update';              
                $('#dlg1').window('center');
            }
        });


        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
        }
        function myparser(s) {
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d);
            } else {
                return new Date();
            }
        }

        function showButtons(val,row,index){
			var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="Supprimer(this)">Supprimer</button>&nbsp;';
			return s;
		}

        function Supprimer(obj){
            $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment supprimer cette limite?', function (r) {
                if (r) {
              		 var url = '../controllers/limite_boule_eliminer.php?u=<?php echo $userId;?>&Id='+obj.id;
            		 $.get( url, function(data) {
                	  if(data=='OK') {
                		  $('#dg').datagrid('reload');
                      } else {
            			 $.messager.alert('Message',data);
                      }	 
            		 });
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
                url: '../controllers/boule_limite_access.php?e=<?php echo $entrepriseId; ?>&l=' + row.Id,
                fitColumns: true,
                singleSelect: false,
                rownumbers: true,
                loadMsg: 'Chargement des banques en cours ...',
                height: '150px',
                checkOnSelect: true,
                selectOnCheck: true,
                columns: [
                    [
                        {field: 'Nom', title: 'Liste des banques', width: 40},
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
                        if (rows[i].EST_LIMITE == 'OUI') {                            
                        	//$(this).datagrid('selectRow', index);
                            $(this).datagrid('checkRow', i);                  
                        }
                    }  
                },
                 /*onClickRow: function (index, row){
               	 var limite =  $('#dg').datagrid('getSelected');
            	},*/
            	onCheck: function (index, row){ 
                	 var limite =  $('#dg').datagrid('getSelected');
            		 updateLimiteBoule('check',limite.Id,row.Id,'record');
           	    },
           	     onUncheck: function (index, row){
                	 var limite =  $('#dg').datagrid('getSelected');
            		 updateLimiteBoule('uncheck',limite.Id,row.Id,'record');
        	    },
        	    onSelectAll: function(){
               	 var limite =  $('#dg').datagrid('getSelected');
        		 updateLimiteBoule('check',limite.Id,0,'batch');
        	    },
        	    onUnselectAll: function() {
                   var limite =  $('#dg').datagrid('getSelected');
            	   updateLimiteBoule('uncheck',limite.Id,0,'batch');
        	    }
            });
            $('#dg').datagrid('fixDetailRowHeight', index);
        }
    });
 });

function updateLimiteBoule(action,limiteId,banqueId,operation){
 	 var url = '../controllers/boule_limite_update.php?e=<?php  echo $entrepriseId; ?>&u=<?php echo $userId; ?>&l='+limiteId+'&b='+banqueId+'&o='+operation+'&a='+action;
  	 $.get(url, function(data, status){
  	   //if(data == "OK") {
  		//$(dg).datagrid('reload')
  	  // }
  	}); 
}
</script>
	<script>
   $(document).ready(function() {   
	   $('#Banque').combobox('setValues','');
	   $('#Tirage').combobox('setValues','');
	   //$('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});	

        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }

        $('#ttBoule').click(function(){
			if($(this).prop("checked") == true){
				$('#Boule').textbox('setValue','TOUTES');
				$('#Boule').textbox('readonly',true);
        	    //alert("Checkbox is checked.");
        	}
        	else if($(this).prop("checked") == false){
				$('#Boule').textbox('setValue','');
				$('#Boule').textbox('readonly',false);
        	}
        }); 
    });
   </script>

</body>
</html>