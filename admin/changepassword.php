<?php
session_start();
if ($_POST) {
    $data = $_POST['data'];
    setcookie('beconnect', $data, time() + (86400 * 30), "/"); // 86400 = 1 day
} else {
    $data = $_COOKIE['beconnect'];
}
//echo $_COOKIE['beconnect'];
$data_obj = json_decode($data);
if ($data_obj->IS_FIRST_LOGIN == 'NO') {
    header('Location: main.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Be-Connect | Update Password</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet"
	href="../plugins/fontawesome-free/css/all.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet"
	href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../dist/css/adminlte.min.css">

<!-- my custom style -->
<link rel="stylesheet" href="../dist/css/mystyle.css">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h1"><img style="max-width: 30%; height: auto"
					src="../dist/img/logo.jpg" /> <!-- <b>Be-Connect</b>--></a>
			</div>
			<div class="card-body">
				<div class="input-group mb-3" style="text-align: center">
					<div id="output" style="display: none; width: 100%"
						class="alert alert-primary">Error Message Here</div>
				</div>

				<form id="update_password_form"
					action="../controllers/updatepassword.php" method="post">

					<div class="input-group mb-3">
						<input id="password" name="password" type="password"
							class="form-control" placeholder="Nouveau Mot de Passe" />
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>

					<div class="input-group mb-3">
						<input id="password_repeat" name="password_repeat" type="password"
							class="form-control" placeholder="Repeter Nouveau Mot de Passe" />
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">

						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Update</button>
						</div>
						<!-- /.col -->
						<div align="center">
							<span id="loader" style="display: none;"
								class="login-loader-text"> <img width="16px" height="16px"
								src="../dist/img/loader_login.gif" /> &nbsp; Mise &agrave; jour
								en cours...
							</span>
						</div>
					</div>
				</form>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="../plugins/jquery/jquery.min.js"></script>
	<script src="../plugins/jquery-redirect/jquery.redirect.js"></script>
	<!-- Bootstrap 4 -->
	<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../dist/js/adminlte.min.js"></script>
	<script src="../plugins/jquery-form/jquery.form.js"></script>
	<script src="../dist/js/utility.js"></script>

	<script>
      
       $("#update_password_form").submit(function(event) {
          event.preventDefault(); //prevent default action 
          var password_repeat = $("#password_repeat").val();
          var password = $("#password").val();

         if(!isNullOrEmpty(password_repeat) && !isNullOrEmpty(password)){ 
           if(password == password_repeat){
              $("#loader").css("display","inline");
              $("#output").css("display","none");
    
              let post_url = $(this).attr("action"); //get form action url
              let request_method = $(this).attr("method"); //get form GET/POST method	
              let params ={"username":"<?php echo $data_obj->USERNAME;?>","password":password};

              //alert(JSON.stringify(params));
              
              $.ajax({
                  url: post_url,
                  type: request_method,
                  data: params
                }).done(function(response) {
                  $("#loader").css("display","none");
                  const data = JSON.parse(response);
                  //alert(response);
                  if(data.CODE_MESSAGE =="SUCCESS"){
                	  var loginData = {'data':response};
                	  $.redirect("main.php",loginData,"POST",null,null,true);
                  } else {
                      $("#output").addClass("class","alert alert-danger");
                      $("#output").css("display","block");
                      $("#output").html(data.MESSAGE);		
                  }
                  
                }).fail(function(data) {
                
                  $("#loader").css("display","none");
                  $("#output").addClass("alert alert-danger");
                  $("#output").css("display","block");
                  $("#output").html("Le serveur n'est pas disponible."); 
                });
           } else {
               $("#output").addClass("alert alert-danger");
               $("#output").css("display","block");
               $("#output").html("Mot de passe mal repeter.");               }
         }else{
             $("#output").addClass("alert alert-danger");
             $("#output").css("display","block");
             $("#output").html("Tous les champs sont obligatoires.");   
         }           
        });


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
