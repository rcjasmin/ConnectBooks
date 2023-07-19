<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Termes et Conditions</title>
   <?php

    $userId = (isset($_GET['u'])) ? htmlentities($_GET['u']) : NULL;

    if(!isset($userId)){
        header('Location: index.php');
        exit();
    }
    require_once '../classes/Utility.php';
    require '../admin/easyui_inc.php';
    $url_combobox_tirages2 = "../controllers/tirages_combobox.php?r=2";
    $url_combobox = "entreprises_combobox.php?r=1";
   ?> 

</head>
<body>	
	  <div id="Main" align="center" style="height: 400px;">
      
        <div id="dlg" class="easyui-dialog" style="width: 600px; height: auto; padding:20px;" closed="false" buttons="#dlg-buttons">
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
                    <label style="font-weight: bold">Num&eacute;ro Lotto 3 Chiffres:</label>
                    <div class="fitem">
                        <input id="txtLotto3" name="txtLotto3" style="height: 30px; width: 100%;"  class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[3]'" />
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Num&eacute;ro 2eme Lot:</label>
                    <div class="fitem">
                        <input id="txtLo2" name="txtLo2" style="height: 30px; width: 100%;" class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[2]'" />
                    </div>
                   </td>
                </tr>
                
               <tr> 
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Num&eacute;ro 3eme Lot:</label>
                    <div class="fitem">
                        <input id="txtLo3" name="txtLo3" style="height: 30px; width: 100%;" class="easyui-textbox" 
                        required="true" data-options="validType:'NbreDigits[2]'"/>
                    </div>
                   </td>
                  <td style="width: 50%;">
                    <label style="font-weight: bold">Entreprise(s):</label>
                    <div class="fitem">
						<input id="txtEntreprise" name="txtEntreprise"
						 style="height: 30px; width: 100%;" class="easyui-combobox"
						 data-options="valueField:'Id',textField:'Nom',url:'<?php echo $url_combobox; ?>',required:true,editable:true,multiple:true"
						 panelHeight="200px" />
                    </div>
                  </td>
                </tr>
             </table>
            </form>
        </div>
        <div id="dlg-buttons">
            <a id ="saveBtn" href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="save()" style="width: 140px;">Sauvegarder</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width: 140px;">Annuler</a>
        </div>
	</div>
	
	<script type="text/javascript">
    function save() {
          var url = 'numeros_gagnants_controller.php?u=<?php echo $userId;?>&e='+ $('#txtEntreprise').combobox('getValues');
          $('#fm').form('submit', {
              url: url,
              onSubmit: function () {
                  return $(this).form('validate');
              },
              success: function (result) {
                $('#fm').form('clear');
                $.messager.alert('Message', 'Numeros Gagnants ajoutes avec success.');
              }
          });
      }
        
    </script>
       
   <script>
   $(document).ready(function() {   	
	   $('#dlg').dialog('open').dialog('setTitle', 'Form - Numeros Gagnants');
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='index.php';
        }
    });
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
    </script>
  
    </body>
</html>