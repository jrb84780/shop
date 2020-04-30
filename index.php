<?php
// Initialize the session
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pizza Shop</title>
		<meta charset="utf-8">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<link rel="stylesheet" type="text/css" href="style.css">
			</head>
			<body >
				<div class="topnav">
					<a class="active" href="index.php">Home</a>
					<a href="order.php">Order</a>
					<?php if (isset($_SESSION['loggedin'])) {?>
					<a href="orderstatus.php">Order Status</a>
					<?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {?>
					<a href="orderlist.php">Order List</a>
					<a href="statistics.php">Statistics</a>
					<?php }  ?>
					<a href="logout.php">Logout</a>
					<?php }  ?>
					<?php if (!isset($_SESSION['loggedin'])) {?>
					<a id="loginLink" href="javascript:login()">Login</a>
					<a id="registerLink" href="javascript:register()">Register</a>
					<?php } ?>
				</div>
				<div class="body-text">
					<center>
						<h1 style="padding:30px;text-align: center;">Welcome to Pizza Palace!</h1>
						<button onclick="window.location.href = 'order.php';">Order Now</button>
						<?php if (!isset($_SESSION['loggedin'])) {
    echo '<button type="button" onclick="login()">Login</button>';} ?>
					</center>
				</div>
			</div>
			<div id="loginForm" class="lModal">
				<!-- Modal content -->
				<div id="regForm">
					<form>
						<a id="close" class="close"  href="javascript:close()">&times;</a>
						<br>
							<center>
								<h3 id="loginHeader">Login</h3>
								<p id="failureLogin" style="color:red;" hidden>Invalid username or password</p>
								<input id=username class="username" type="text" placeholder="Username" name="username" class="input">
									<input id=password class="password" type="password" placeholder="Password" name="password" class="input">
										<button id="loginBtn" type="button">Login</button>
										<p>Login as admin - Username: admin Password: tester</p>
										<p>Login as user - Username: user1 Password: tester</p>
										<a id="noAccount" class="modalRegisterLink" href="javascript:register()">Sign up now</a>
									</center>
								</form>
							</div>
						</div>
						<div id="registerForm" class="rModal">
							<!-- Modal content -->
							<div id="regForm">
								<form name="register">
									<a id="close" class="close"  href="javascript:close()">&times;</a>
									<br>
										<center>
											<h3>Register</h3>
											<p id="error" style="color:red;" hidden></p>
											<input id=rUsername class="username" type="text" placeholder="Username" name="username" class="input" required>
												<input id=rPassword class="password" type="password" placeholder="Password" name="password" class="input">
													<input id=rcPassword class="password" type="password" placeholder="Password" name="password" class="input">
														<button id="registerBtn" type="button">Create Account</button>
													</center>
												</form>
											</div>
										</body>
									</html>
									<script>
// Get the modal

 $("#loginBtn").on('click', function() {
        var user = $('#username').val();
        var pass = $('#password').val();
        $.post("scripts/login.php", {
                username: user,
                password: pass,
            })
            .done(function(result, status, xhr) {
                if (result == "success") {
									
									window.location.href = "index.php";
                } else {
                    failureLogin.style.display = "result";
                }
            });
    });
		
		$('#rUsername').keypress(function (e) {
		    var regex = new RegExp("^[a-zA-Z0-9]+$");
		    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		    if (regex.test(str)) {
		        return true;
		    }
		    e.preventDefault();
		    return false;
		});
		
		$('#username').keypress(function (e) {
				var regex = new RegExp("^[a-zA-Z0-9]+$");
				var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				if (regex.test(str)) {
						return true;
				}
				e.preventDefault();
				return false;
		});

		$("#registerBtn").on('click', function() {;
					 var user = $('#rUsername').val();
					 var pass = $('#rPassword').val();
					 var cPass = $('#rcPassword').val();
					 $.post("scripts/register.php", {
									 username: user,
									 password: pass,
									 cPassword: cPass,
							 })
							 .done(function(result, status, xhr) {
								 
									 if (result == "success") {
										 window.location.href = "index.php";
									 } 
									 
									 if (result == "This username is already taken") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else if (result == "Please enter a password") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
									 else if (result == "Password must have atleast 6 characters") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else if (result == "Please confirm password") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
									 else if (result == "Password did not match") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
							 });
			 });
		
var lModal = document.getElementById("loginForm");
var rModal = document.getElementById("registerForm");

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == lModal) {
    lModal.style.display = "none";
  }
	if (event.target == rModal) {
		rModal.style.display = "none";
	}
}

function login() {
   lModal.style.display = "block";
}
function register() {
   rModal.style.display = "block";
}
function close() {
  rModal.style.display = "none";
	lModal.style.display = "none";
}
 </script>