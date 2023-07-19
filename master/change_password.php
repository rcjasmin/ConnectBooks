<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Entreprises</title>
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
	  $url = "entreprises_data.php?u=".$userId;
	?>		
	  <div id="Main" align="center">

		<div id="dlg" class="easyui-panel"
			style="width: 400px; height: auto; padding: 20px;" closed="false"
			buttons="#dlg-buttons">
			<!--  <div class="ftitle">Information du d&eacute;partement</div>-->
			<form id="fm" method="POST" novalidate>
				<label style="font-weight: bold">Mot De Passe:</label>
				<div class="fitem">
					<input id="CurrentPassword" name="CurrentPassword"
						style="height: 30px; width: 100%;" class="easyui-passwordbox"
						required="true" />
				</div>
				<br /> <label style="font-weight: bold">Nouveau Mot De Passe:</label>
				<div class="fitem">
					<input id="NewPassword" name="NewPassword"
						style="height: 30px; width: 100%;" class="easyui-passwordbox"
						required="true" />
				</div>

				<br /> <label style="font-weight: bold">Repeter Nouveau Mot De
					Passe:</label>
				<div class="fitem">
					<input id="NewPasswordConfirm" name="NewPasswordConfirm"
						style="height: 30px; width: 100%;" class="easyui-passwordbox"
						required="true" />
				</div>
			</form>
			<br/>
			<div style="text-align: center; padding: 5px 0">
				<a href="javascript:void(0)" class="easyui-linkbutton c6"
					iconCls="icon-ok" onclick="save()" style="width: 140px;">Sauvegarder</a>
				<a href="javascript:void(0)" class="easyui-linkbutton"
					iconCls="icon-cancel"
					onclick="javascript:$('#dlg').dialog('close')"
					style="width: 140px;">Annuler</a>
			</div>

		</div>

		<script type="text/javascript">
	var url='';

        function save() {
            url = 'update_password.php?&u=<?php echo $userId;?>';
            //$.messager.alert('Message', url);

             $('#fm').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (result) {
                    var result = eval('(' + result + ')');
                    $.messager.alert('Message', result);
                    $('#fm').form('clear');
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


    <script>
        $( window ).resize(function() {
            $('#dg').datagrid('resize');
        });        
    </script>
    </body>
</html>