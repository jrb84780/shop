
<?php
session_start();

require_once "../config.php";

$username = $_SESSION['username'];
$userid = $_SESSION['userid'];


if ($_POST["size"] != '1' && $_POST["size"] != '2' && $_POST["size"] != '3') {
    header("location: ../errorPage.php");
}

$index = array();
$data = array();
$i = 0;

foreach ($_POST as $key => $value) {
    $index[$i] = $key;
    $data[$i] = $value;
    if ($value != '0' && $value != '1' && $key != 'inst' && $key != 'size') {
        header("location: ../errorPage.php");
    }
    if ($key == 'inst') {
        $inst = $value;
    }
    $i++;
}

for ($i=0;$i<sizeof($data);$i++) {
    $data[$i] = "'$data[$i]'";
}

$columns = implode(", ", $index);
$values = implode(", ", $data);

$order_time = date("h:i:sa d-m-Y");

$sql = "INSERT INTO jb_orders(userid,username,$columns) VALUES (:userid,:username,$values)";

if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters

    $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
    $param_userid = $userid;
    
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $param_username = $_SESSION['username'];




    $stmt->execute();
} else {
    header("location: ../errorPage.php");
}

    // Close statement
    unset($stmt);
unset($pdo);

header("location: ../orderstatus.php");

?>
