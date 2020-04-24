<?php
// Initialize the session
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["isAdmin"] == 0) {
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="shop.css">
</head>
<body>
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if(isset($_SESSION['loggedin'])){?>
     <a href="orderstatus.php">Order Status</a>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if(isset($_SESSION['isAdmin'])){?><a class="active" href="admin.php">Admin</a><?php }  ?>
   <?php if(!isset($_SESSION['loggedin'])){?>
     <a href="login.php">Login</a>
   <?php }  ?>
  </div> 
  

</body>
</html>
