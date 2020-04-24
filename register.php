<?php

session_start();

if (isset($_SESSION["loggedin"])) {
    header("location: index.php");
    exit;
}
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT username FROM jb_users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO jb_users (username, password, isAdmin) VALUES (:username, :password, '0')";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);


            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
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
        <a id="myBtn">Login</a>
      </div> 

      <form class="index" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="login_container">
          <h3>Register</h3>
          <p>Enter your username</p>
          <input type="text" name="username" class="input" value="<?php echo $username; ?>">
          <p>Enter your password</p>
          <input type="password" name="password" class="input">
          <p class="label-txt">Confirm password</p>
          <input type="password" name="confirm_password" class="input" value="<?php echo $confirm_password; ?>">
          <button type="submit">submit</button>
        </div>
      </form>
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