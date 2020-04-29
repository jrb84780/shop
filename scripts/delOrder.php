<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["isAdmin"] == 0) {
    header("location: index.php");
    exit;
}
require_once "../config.php";

$orderid = $_POST['orderid'];

$sql = "DELETE FROM jb_orders WHERE orderid = :orderid";

if ($stmt = $pdo->prepare($sql)) {
  $stmt->bindParam(':orderid', $param_orderid, PDO::PARAM_INT);
  $param_orderid = $orderid;
    if ($stmt->execute()) {$stmt->execute();
    echo "success";
    exit();
  } else {
  echo "Order not deleted. Please contact your admin.";
  exit();
  }
}
?>