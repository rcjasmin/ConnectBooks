<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Dashboard</title>
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
	<div id="Main" align="center">

		<div>
			<!--<h1 align="center">Welcome to the Lottery Management System !!!</h1>-->
			<br />
			<p align="center">
				<img src="../dist/img/DASHBOARD.png" width="800px"
					height="500px" />
			</p>
		</div>
	</div>

<script>
    $(document).ready(function() {   	
        var page = parent.document.URL.split('/').pop();
        if(page!="main.php"){
           window.location.href ='404.php';
        }
    });
</script>

</body>
</html>