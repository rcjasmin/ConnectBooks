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
	<?php  
	   $url = "../controllers/boules_gagnantes.php?u=".$userId."&e=".$entrepriseId;
	   $url_combobox_tirages = "../controllers/tirages_combobox.php?r=1&e=".$entrepriseId;
	   $url_combobox_tirages2 = "../controllers/tirages_combobox.php?r=2&e=".$entrepriseId;
	
	?>		
	  <div id="Main" align="center">
		<table id="dg" class="easyui-datagrid"
			style="width: 100%; height:500px; font-size:12px" url=<?php echo $url; ?>
			title="LISTE DES NUMEROS GAGNANTS" iconCls="" toolbar="#tb" rownumbers="true"
			pagination="true" singleSelect="true">

			<thead>
				<tr>
				    <th field=Tirage style="width: 200px;" sortable="true">Tirage</th>
					<th field=LOTO3 style="width: 200px;" sortable="true">Lotto 3</th>
					<th field="LO2" style="width: 230px;" sortable="true">2&egrave;me Lot</th>
					<th field="LO3" style="width: 230px;" sortable="true">3&egrave;me Lot</th>
					<th field="DateTirage" style="width: 200px;" sortable="true">Date Tirage</th>
				</tr>
			</thead>
		</table>
		
        <div id="tb" style="padding: 3px">

				<div id="tb" style="padding: 5px; height: auto">
					<div style="margin-bottom: 5px">
						<table>
							<tr>
								<td><span>Tirage(s):</span></td>
								<td><span>Date Tirage:</span></td>
							</tr>
							<tr>
							 <td>
                                <input id="Tirage" name="Tirage" style="height: 28px; width: 165px;" class="easyui-combobox"
            					data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages; ?>', required:false,editable:true"
            					panelHeight="200px" />
							 </td>
							 <td>
							  <input class="easyui-datebox" id="DateTirage" name="DateTirage"
									data-options="formatter:myformatter,parser:myparser"
									style="width: 165px; height: 28px; line-height: 20px">
							 </td>
							</tr>
						</table>

						<table> 
						    <tr>
                         		<td><span>Num&eacute;ro [Boule]:</span></td>
							</tr>

							<tr>
								<td> 
									<input id="Boule" name="Boule" style="line-height: 26px; height: 28px; border: 1px solid #ccc;">
								</td>
							</tr>
						</table>
					</div>
        		<a href="#" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Rechercher</a>
        		<span class="alignment" style="float: right; margin-right: 3px;">
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-bricks" plain="false" onclick="openForm()">Ajouter Num&eacute;ros</a>
        			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-deleteitinerary" plain="false" onclick="Supprimer()">Supprimer Num&eacute;ros</a>
        	    </span>
             </div>
          </div>   
        
        <div id="dlg" class="easyui-dialog" style="width: 600px; height: auto; padding:20px;" closed="true" buttons="#dlg-buttons">
            <form id="fm" method="POST" novalidate>
            
               <table style="width: 100%;" cellspacing="8">
                <tr> 
                  <td style="width: 50%;">
                     <label style="font-weight: bold">Tirage:</label>
                      
                    <div class="fitem">
                         <input id="txtTirage" name="txtTirage" style="height: 30px; width: 100%;" class="easyui-combobox"
        					data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox_tirages2; ?>',
        					required:true,editable:true"
        					panelHeight="200px" />
               
                    </div>
                   </td>
                   <td style="width: 50%;">
                    <label style="font-weight: bold">Date Tirage :</label>
                    <div class="fitem">
					  <input class="easyui-datebox" id="txtDateTirage" name="txtDateTirage"
							data-options="formatter:myformatter,parser:myparser" required="true"
							style="width: 100%; height: 30px;">
                    </div>
                   </td>
                </tr>
                
                <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Lotto 3 Chiffres:</label>
                    <div class="fitem">
                        <input id="txtLotto3" name="txtLotto3" style="height: 30px; width: 100%;"  class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[3]'" />
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">2&egrave;me Lot:</label>
                    <div class="fitem">
                        <input id="txtLo2" name="txtLo2" style="height: 30px; width: 100%;" class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[2]'" />
                    </div>
                   </td>
                </tr>
                
               <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">3&egrave;me Lot:</label>
                    <div class="fitem">
                        <input id="txtLo3" name="txtLo3" style="height: 30px; width: 100%;" class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[2]'"/>
                    </div>
                   </td>
                  <td style="width: 50%;">

                   </td>
                </tr>
             </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a id ="saveBtn" href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="addNumeros()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
	var url='';
        function doSearch() {
            $('#dg').datagrid('load', {
                Tirage: $('#Tirage').combobox('getValue'),
                DateTirage: $('#DateTirage').datebox('getValue'),
                Boule: $('#Boule').val(),
                e:<?php echo $entrepriseId;?>       
            });
        }
       
        function openForm() {
        	  url = '../controllers/ajouter_numeros_gagnants.php?u=<?php echo $userId;?>&e=<?php echo $entrepriseId;?>&id=0';
              $('#dlg').dialog('open').dialog('setTitle', 'Form - Ajouter Numeros Gagnants');
              $('#fm').form('clear');
              $('#dlg').window('center');
        }


        function addNumeros() {
           $.messager.progress({height:60, text:'Execution en cours...'});
           var txtTirage = $('#txtTirage').combobox('getValue');
           var txtDateTirage = $('#txtDateTirage').datebox('getValue');
           var xurl = '../controllers/numeros_gagnants_statut.php?e=<?php echo $entrepriseId;?>&txtTirage='+txtTirage+'&txtDateTirage='+txtDateTirage;
 
            $('#fm').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                   if(result=='OK'){
                     $('#fm').form('clear');
                     $('#dlg').dialog('close');
                     $('#dg').datagrid('reload');

                     /*$.get( xurl, function(data) {
            			 alert(data);		 
            		 });            
                     var tem ='';
                     do {
                		 $.get( xurl, function(data) {
                			 tem = data;		 
                		 });
                    	}
                    	while (tem != 'TERMINE');*/

                     setTimeout(() => { 
                         $.messager.progress('close');
                         $('#dg').datagrid('reload');
                      }, 2000);
                     
                   } else {
                	   
                       setTimeout(() => { 
                           $.messager.progress('close');
                           $.messager.alert('Message', result);
                        }, 500);
                   }
                }
            });
        }
        
    </script>
    
   <script type="text/javascript">
   $.extend($.fn.validatebox.defaults.rules, {
	    NbreDigits: {
	        validator: function(value, param){
	        	const regex = /[0-9]+/g;
	        	return (value.match(regex) && value.length==param[0]);
	        	// && value%1==0 && !value.includes('.')
	        },
	        message: 'SVP, ce champs doit contenir {0} digits numeriques.'
	    }
	});



   </script>
   <script>
   $(document).ready(function() {   	
	   $('#dg').datagrid({pageSize: 9, pageList: [9, 18, 27,36]});
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>

   
    <script>
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
        /*$( window ).resize(function() {
            $('#dg').datagrid('resize');
        });  */ 

        function showButtons(val,row,index){
			var s = '&nbsp;<button id="'+row.Id+'" value="'+row.Id+'" style="width:80px; padding:4px" onclick="Supprimer(this)">Supprimer</button>&nbsp;';
			return s;
		} 

        function Supprimer(){

            var row = $('#dg').datagrid('getSelected');
            if(row != null) {
              $.messager.confirm('Confirmation Suppression', 'Voulez vous vraiment supprimer ces numeros gagnants?', function (r) {
                if (r) {
              		 var url = '../controllers/numeros_gagnants_eliminer.php?u=<?php echo $userId;?>&Id='+row.Id;
            		 $.get( url, function(data) {
                	  if(data=='OK') {
                		  $('#dg').datagrid('reload');
                      } else {
            			 $.messager.alert('Message',data);
                      }	 
            		 });
                }
               });
            } else {
            	$.messager.alert('Message', 'SVP, selectionnez la ligne a supprimer.');
            }
        }   
    </script>
    </body>
</html>