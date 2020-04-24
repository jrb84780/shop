<?php
// Initialize the session
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_POST["username"])) {
    header("location: ../index.php");
    exit;
}

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
                            header("location: index.php");
                            }
                        }
                    }
                }
            }
        // Close statement
        unset($stmt);
    // Close connection
    unset($pdo);
    $username = "";
    $password = "";
    header("location: ../index.php");
  }
?>
