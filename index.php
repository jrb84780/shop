<?php
// Initialize the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Pizza Shop</title>
	<meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="shop.css">
</head>
<body >
  <div class="topnav">
   <a class="active" href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if(isset($_SESSION['loggedin'])){?>
     <a href="orderstatus.php">Order Status</a>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1){?><a href="admin.php">Admin</a><?php }  ?>
   <?php if(!isset($_SESSION['loggedin'])){?>
     <a id="myBtn">Login</a>
   <?php }  ?>
  </div>
  
    <div class="index">
      <div class="login_container">
        <h1 style="font-size:50px">Welcome to The Pizza Shop</h1>
        <button onclick="window.location.href = 'order.php';">Order Now</button>
      </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <form class="login" action="scripts/login.php" method="post">
          <div class="login_container">
            <span class="close">&times;</span>
            <h3>Please login</h3>
                <p>Username</p>
                <input id=username type="text" name="username" class="input">
                <p>Password</p>
                <input id=password type="password" name="password" class="input">
              </div>
            <div class="form-group">
                <button type="submit">submit</button>
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
      </div>
    </div>
</body>
</html>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
 </script>