<?php
session_start();
if ($_POST) {
    $data = $_POST['data'];
    setcookie('beconnect_master', $data, time() + (86400 * 30), "/"); // 86400 = 1 day
    $data_obj = json_decode($data);
    $_SESSION[$data_obj->USERNAME] = $data;
    
} else {
    $data = $_COOKIE['beconnect_master'];
    $data_obj = json_decode($data);
}
if (!isset($data_obj) || !isset($_SESSION[$data_obj->USERNAME])) {
    header('Location: /master');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Be-Connect | MASTER</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome Icons -->
<link rel="stylesheet"
	href="../plugins/fontawesome-free/css/all.min.css">
<!-- IonIcons -->
<link rel="stylesheet"
	href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<nav
			class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" data-widget="pushmenu"
					href="#" role="button"><i class="fas fa-bars"></i></a></li>
				<li class="nav-item"><a class="nav-link" data-widget="fullscreen"
					href="#" role="button"> <i class="fas fa-expand-arrows-alt"></i>
				</a></li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item d-none d-sm-inline-block"><a href="change_password.php?u=<?php echo $data_obj->USERID; ?>" target="pageLoad_frame" 
					class="nav-link">Changer Mot de Passe</a></li>
				<li class="nav-item d-none d-sm-inline-block"><a href="../master/"
					class="nav-link">Se Deconnecter</a></li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="main.php" class="brand-link"> <img
				style="max-width: 20%; height: auto" src="../dist/img/logo1.jpeg"
				alt="Logo" class=" img-square elevation-3"> <span
				class="brand-text font-weight-light">Be-Connect</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user panel (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="../dist/img/avatar_user_1.png"
							class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block">Bonjour, <?php echo $data_obj->FIRSTNAME; ?></a>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column"
						data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						<!-- <li class="nav-header">Menu Principal</li>-->

						<li class="nav-item"><a href="main.php" class="nav-link"> <i
								class="nav-icon fa fa-university"></i>
								<p>GESTION ENTREPRISES</p>
						</a></li>
						
						<li class="nav-item"><a href="pos_devices.php?u=<?php echo $data_obj->USERID; ?>" target="pageLoad_frame" class="nav-link"> <i
								class="nav-icon fa fa-bars"></i>
								<p>GESTION POS DEVICES</p>
						</a></li>
						<?php if($data_obj->USERID == "1") {?>
						<li class="nav-item"><a href="numerosGagnants.php?u=<?php echo $data_obj->USERID; ?>" target="pageLoad_frame" class="nav-link"> <i
								class="nav-icon fa fa-bars"></i>
								<p>NUMEROS GAGNANTS</p>
						</a></li>
						<?php }?>

					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<!-- <div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h4 class="m-0">Dashboard</h4>
						</div>
					</div>
				</div>
			</div>-->
			<!-- /.content-header -->

			<!-- Main content -->
			<div class="content" style="margin: auto">
				<div class="container-fluid">
					<div class="row">
						<div id="code" class="col">
						
							<div id="mainArea" style="margin-top: 7px;">
								<iframe id ="pageLoad_frame" style="overflow: auto; " onload="iframeLoaded(this)"
									name="pageLoad_frame" frameborder="0" width="100%" height="auto"
									src="entreprises.php?u=<?php echo $data_obj->USERID; ?>"></iframe>
							</div>

						</div>
						<!-- Content to load here -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</div>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->

		<!-- Main Footer -->
		<footer class="main-footer">
			<strong>Copyright &copy; 2022-2050 <a
				href="http://beconnect-haiti.com">Be-Connect</a>.
			</strong> Tous Droits R&eacute;serv&eacute;s.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 1.0.0
			</div>
		</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<!-- jQuery -->
	<script src="../plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE -->
	<script src="../dist/js/adminlte.js"></script>

	<!-- OPTIONAL SCRIPTS 
	<script src="../plugins/chart.js/Chart.min.js"></script>-->
	<!-- AdminLTE for demo purposes -->
	<!-- <script src="../dist/js/demo.js"></script> -->
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!-- <script src="../dist/js/pages/dashboard3.js"></script>-->
	<script type="text/javascript"> 

	function iframeLoaded(iFrameID,stop) 
	{
		if(iFrameID) 
		{
			if(iFrameID.contentDocument){
				if (iFrameID.contentDocument.body)
					if (iFrameID.height != iFrameID.contentDocument.body.scrollHeight)
						iFrameID.height = iFrameID.contentDocument.body.scrollHeight;
			} else {
				iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight+ "px";
			}
		}
		
		setTimeout(function(){iframeLoaded(iFrameID,1);},1000);
		
		//if (!stop) update_themes();
	}

	</script>
	
	<script>
    $(document).ready(function() {
        function disableBack() { window.history.forward() }
        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
   </script>
</body>
</html>
