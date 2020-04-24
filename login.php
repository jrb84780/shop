<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"])) {
    header("location: index.php");
    exit;
}

$username = "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pizza Shop</title>
	<meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="shop.css">
</head>

<body>
  <div class="topnav">
   <a class="active" href="index.php">Home</a>
   <a href="order.php">Order</a>
  </div>
          <form action="scripts/login.php" method="post">
            <div class="login_container">
                  <p>Username</p>
                  <input id=username type="text" name="username" class="input" value="<?php echo $username; ?>">
                  <p>Password</p>
                  <input id=password type="password" name="password" class="input">
                </div>
              <div class="form-group">
                  <button type="submit">submit</button>
              </div>
              <div class="login_container">
              <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
              </div>
          </form>

</body>
</html>
<script>

</script>
