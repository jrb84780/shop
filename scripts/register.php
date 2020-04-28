<?php

session_start();

// Include config file
require_once "../config.php";
$username = $_POST['username'];
$username = $_POST['password'];
$username = $_POST['cPassword'];
// Define variables and initialize with empty values



// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        echo "Please enter a username.";
        exit();
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
                    echo "This username is already taken";
                    exit();
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        echo "Please enter a password";
        exit();
    } elseif (strlen(trim($_POST["password"])) < 6) {
        echo "Password must have atleast 6 characters";
        exit();
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["cPassword"]))) {
        echo "Please confirm password";
        exit();
    } else {
        $cPassword = trim($_POST["cPassword"]);
        if (empty($password_err) && ($password != $cPassword)) {
            echo "Password did not match";
            exit();
        }
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($cPassword_err)) {

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
                echo "success";
                exit();
            } else {
                echo "Something went wrong. Please try again later";
                exit();
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>