<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["isAdmin"] == 0) {
    header("location: index.php");
    exit;
}
require_once "../config.php";
$index  = array();
$data   = array();
$update = array();

$i      = $orderid = $updateOrderCooked = $updateOrderComplete = $bill = 0;
$log = $order  = $dateCooked = $timeCooked = $dateComplete = $timeComplete = "";

foreach ($_POST as $key => $value) {
    if ($key == 'orderid') {
        $orderid = $value;
    } elseif ($key == 'order_cooked') {
        $order = $value;
    } elseif ($key == 'order_complete') {
        $order = $value;
    } elseif ($key == 'date_cooked') {
        $dateCooked = $value;
    } elseif ($key == 'time_cooked') {
        $timeCooked = $value;
    } elseif ($key == 'date_complete') {
        $dateComplete = $value;
    } elseif ($key == 'time_complete') {
        $timeComplete = $value;
    } elseif ($key == "updateOrderCooked") {
        $updateOrderCooked = 1;
    } elseif ($key == "updateOrderComplete") {
        $updateOrderComplete = 1;
    } elseif ($key == "bill") {
        $bill = $value;
    } else {
        $index[$i] = $key;
        $data[$i]  = $value;
    }
    $i++;
}
$timeDateCooked   = "order_cooked ='" . $dateCooked . " " . $timeCooked . "'";
$timeDateComplete = "order_complete ='" . $dateComplete . " " . $timeComplete . "'";
$bill = "bill='". $bill . "'";


if ((isset($_POST['time_cooked']) && isset($_POST['time_complete'])) || (isset($_POST['time_complete']) && isset($_POST['time_complete']))) {
    /*for ($i = 0; $i < sizeof($index); $i++) {
        $update[$i] = $index[$i] . "=" . "'". $data[$i] . "'";
    }*/
    $i = 0;
    foreach($index as $key){
        $update[$i] = $key . "=" . "'".$data[$i]."'";
        $i++;
    }
    $columns = implode(", ", $index);
    $values = implode(", ", $update);

    if ($updateOrderCooked == 1 && $updateOrderComplete == 1) {
      
        $sql = "UPDATE jb_orders SET $values,$bill,$timeDateCooked,$timeDateComplete WHERE orderid = '$orderid'";
        echo $sql;
        
    } elseif ($updateOrderCooked == 1 && $updateOrderComplete == 0) {
      
        $sql = "UPDATE jb_orders SET $values,$bill,$timeDateCooked WHERE orderid = '$orderid'";
        echo $sql;
        
    } elseif ($updateOrderComplete == 1 && $updateOrderCooked == 0) {
      
        $sql = "UPDATE jb_orders SET $values,$bill,$timeDateComplete WHERE orderid = '$orderid'";
        echo $sql;
        
    } else {
      
        $sql = "UPDATE jb_orders SET $values,$bill WHERE orderid = '$orderid'";
        echo $sql;
    }

    $log = $sql;
if ($stmt = $pdo->prepare($sql)) {

    $stmt->execute();
    header("location: ../orderlist.php");
}
} else {
  $columns = implode(", ", $index);
  $values  = implode(", ", $data);
    $sql = "UPDATE jb_orders SET $order = NOW() WHERE orderid = $value";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->execute();
        echo "success";
        $log = $sql;
        
    }
}


// Close statement
unset($stmt);
unset($pdo);

$file    = '../log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $log;
// Write the contents back to the file
file_put_contents($file, $current);
