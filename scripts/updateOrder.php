
<?php
session_start();

require_once "../config.php";
$index = array();
$data = array();
$orderid = 0;
$order = "";

foreach ($_POST as $key => $value) {
        if($key == 'orderid'){
          $orderid = $value;
        }
        else if($key == 'order_cooked'){
            $order = $value;
        }
        else if($key == 'order_complete'){
            $order = $value;
        }
}
//$timestamp = now();
$log = "UPDATE jb_orders SET $order = NOW() WHERE orderid = $value";
$sql = "UPDATE jb_orders SET $order = NOW() WHERE orderid = $value";


if ($stmt = $pdo->prepare($sql)) {

    $stmt->execute();
    echo "success";
    exit();
}

    // Close statement
    unset($stmt);
unset($pdo);

$file = '../log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $log;
// Write the contents back to the file
file_put_contents($file, $current);
?>
