<?php
session_start();
if (isset($_COOKIE['beconnect'])) {
    $obj = json_decode($_COOKIE['beconnect']);
    //setcookie('beconnect', "", time() + (86400 * 30), "/");
    setcookie("beconnect", "", time() - 3600);
    unset($_SESSION[$obj->USERNAME]);
    $_SESSION[$obj->USERNAME] = "";
     
}
//echo $_COOKIE['beconnect'];
//echo  $_SESSION['test1'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Be-Connect | Log in</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet"
	href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="./dist/css/adminlte.min.css">

<!-- my custom style -->
<link rel="stylesheet" href="./dist/css/mystyle.css">


<style type="text/css">

.btn-primary {
  color: #fff;
  background-color: #00539e;
  border-color: #00539e;
  box-shadow: none;
}

.btn-primary:hover {
  color: #fff;
  background-color: #f58a1f;
  border-color: #f58a1f;
}

.card-primary.card-outline {
  border-top: 3px solid #f58a1f;
}


body {
  background-image: url('./dist/img/background.jpeg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}

</style>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="#" class="h1"><img style="max-width: 45%; height: auto"
					src="./dist/img/beconnect.jpg" /> <!-- <b>Be-Connect</b>--></a>
			</div>
			<div class="card-body">
				<div class="input-group mb-3" style="text-align: center">
					<div id="output" style="display: none; width: 100%"
						class="alert alert-primary">Error Message Here</div>
				</div>

				<form id="login_form" action="./controllers/login.php" method="post">
					<div class="input-group mb-3">
						<input id="username" name="username" type="text"
							class="form-control" placeholder="Nom Utilisateur" />
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input id="password" name="password" type="password"
							class="form-control" placeholder="Mot de Passe" />
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">

						<!-- /.col -->
						<div class="col-4">
							<input type="submit" name="submit" class="btn btn-primary btn-block" value="Connecter"/>
						</div>
						<!-- /.col -->
						<div align="center">
							<span id="loader" style="display: none;"
								class="login-loader-text"> <img width="16px" height="16px"
								src="./dist/img/loader_login.gif" /> &nbsp; Connexion en
								cours...
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
	<script src="./plugins/jquery/jquery.min.js"></script>
	<script src="./plugins/jquery-redirect/jquery.redirect.js"></script>
	<!-- Bootstrap 4 -->
	<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="./dist/js/adminlte.min.js"></script>
	<script src="./plugins/jquery-form/jquery.form.js"></script>
	<script src="./dist/js/utility.js"></script>


	<script>

       $("#login_form").submit(function(event) {
          event.preventDefault(); //prevent default action 
          var username = $("#username").val();
          var password = $("#password").val();

         if(!isNullOrEmpty(username) && !isNullOrEmpty(password)){ 
          $("#loader").css("display","inline");
          $("#output").css("display","none");

          let post_url = $(this).attr("action"); //get form action url
          let request_method = $(this).attr("method"); //get form GET/POST method
          let form_data = $(this).serialize(); //Encode form elements for submission	
          
          $.ajax({
              url: post_url,
              type: request_method,
              data: form_data
            }).done(function(response) {
                
              $("#loader").css("display","none");
              const loginObj = JSON.parse(response);
              if(loginObj.CODE_MESSAGE =="SUCCESS"){
               var data = {'data':response};
               if(loginObj.IS_FIRST_LOGIN =="YES"){ 
        	      $.redirect("./admin/changepassword.php",data,"POST",null,null,true);
        	      
               } else {
            	  $.redirect("./admin/main.php",data,"POST",null,null,true);
               }
              
              } else {
                  $("#output").addClass("class","alert alert-danger");
                  $("#output").css("display","block");
                  $("#output").html(loginObj.MESSAGE);		
              }
              
            }).fail(function(data) {
            
              $("#loader").css("display","none");
              $("#output").addClass("alert alert-danger");
              $("#output").css("display","block");
              $("#output").html("Le serveur n'est pas disponible."); 
            });
         }else{
             $("#output").addClass("alert alert-danger");
             $("#output").css("display","block");
             $("#output").html("Le nom utilisateur et le mot de passe sont obligatoires.");   
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
