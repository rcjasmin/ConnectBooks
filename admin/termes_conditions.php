<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Termes et Conditions</title>
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

	  <div id="Main" align="center">
				<div id="tb"
					style="padding-top: 20px; padding-right: 30px; padding-bottom: 35px; padding-left: 30px;">
					<div id="dlg" class="easyui-panel" title="Virement Bancaire"
						style="width: 100%; max-width: 650px; padding: 30px 60px;"data-options="left:570,top:60">
						<form id="fm" method="POST" novalidate>
							<label><b>Termes et Conditions: </b></label><br/><br/>
                			    <div class="fitem" style="margin-bottom: 12px">
        
        							<input type="text" id="message" name="message"
        								class="easyui-textbox"  style="width: 100%;height: 100px; margin-bottom: 12px"
        								data-options="multiline:true,required:true"  >
        						</div><br/>
							
							<label><b>Montant maximum d'un ticket autoris&eacute; &agrave; supprimer par vendeur:</b></label><br/>
							<label><b><span style="font-size: 10px; color: red;">[Mettre 0 pour Illimit&eacute;]</span></b></label>	
							<div class="fitem" style="margin-bottom: 12px">
								<input type="text" id="montantTicket" name="montantTicket"
									class="easyui-numberbox"  value="0.00" style="width: 100%;height: 30px" precision="0" required="true"  >
							</div>

						</form>


						<div style="text-align: center; padding: 5px 0">
							<div id="dlg-buttons">
								<a id="btn_add" href="javascript:void(0)" onclick="Save()" class="easyui-linkbutton c6"
									iconCls="icon-ok"  style="width: 150px">Sauvegarder</a>
								<a href="javascript:void(0)" class="easyui-linkbutton"
									iconCls="icon-cancel" onclick="javascript:$('#fm').form('reset')"
									style="width: 100px">Annuler</a>
							</div>

						<div align="center">
							<span id="loader" style="display: none;"
								class="login-loader-text"> <img width="16px" height="16px"
								src="../dist/img/loader_login.gif" /> &nbsp; Processing...
							</span>
						</div>
						</div>

					</div>
				</div>
	</div>

	
	<script type="text/javascript">
        function Save() {
        	var url = '../controllers/termes_conditions.php?e=<?php echo $entrepriseId;?>&action=post';
        	$.messager.progress({height:60, text:'Processing Request...'});
        	$.post(url, { message: $('#message').textbox('getValue'), montantTicket:$('#montantTicket').numberbox('getValue')})
        	  .done(function(data) {
                  setTimeout(() => { 
                      $.messager.progress('close');
                      $.messager.alert('Message', data); 
                   }, 1000);
        		 
        	  });
        }
        
    </script>
    
    

   <script>
   $(document).ready(function() {   	
	   $('#dlg').dialog('open').dialog('setTitle', 'Form - Param&egrave;tres Generaux');
		 var url = '../controllers/termes_conditions.php?e=<?php echo $entrepriseId;?>&action=get';
		 $.get( url, function(data) {
			 var data = eval('(' + data + ')');
			 $('#message').textbox('setValue',data.ReceiptMessage);
			 $('#montantTicket').numberbox('setValue',data.MontantMaxTicketaSupprimer); 
			 //$.messager.alert('Message',data.ReceiptMessage);
			 
		 });

	   
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
   </script>
  
    </body>
</html>