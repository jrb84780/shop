
<?php
session_start();
if (!isset($_POST["log"])) {
    header("location: ../index.php");
    exit;
}
require_once "../config.php";
$size = $_POST['size'];
$POSTvaluesToCheck = array('cheese', 'pepperoni', 'sausage', 'bacon', 'ham', 'peppers');
$results = array();
$cheese = $pepperoni = $sausage = $bacon = $ham = $peppers = $x = 0;
$array = "";

foreach($POSTvaluesToCheck as $key) {
  if(isset($_POST[$key])) {
    $results[$x] = $key;
    if($key == 'cheese'){
      $cheese = 1;

    }
    if($key == 'pepperoni'){
      $pepperoni = 1;

    }
    else if($key == 'sausage'){
      $sausage = 1;

    }
    else if($key == 'bacon'){
      $bacon = 1;

    }
    else if($key == 'ham'){
      $ham = 1;

    }
    else if($key == 'peppers'){
      $peppers = 1;

    }
    $x++;
  }
}

foreach($results as $value) {
    $array .= " " .$value;
}


$userid = $_SESSION['userid'];
$order_time = date("h:i:sa d-m-Y");
$sql = "INSERT INTO jb_orders (userid, size, cheese, pepperoni, sausage, ham, peppers, bacon)
VALUES (:userid, :size, :cheese, :pepperoni, :sausage, :ham, :peppers, :bacon)";

if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
    $stmt->bindParam(":size", $param_size, PDO::PARAM_STR);
    $stmt->bindParam(":cheese", $param_cheese, PDO::PARAM_STR);
    $stmt->bindParam(":pepperoni", $param_pepperoni, PDO::PARAM_STR);
    $stmt->bindParam(":sausage", $param_sausage, PDO::PARAM_STR);
    $stmt->bindParam(":bacon", $param_bacon, PDO::PARAM_STR);
    $stmt->bindParam(":ham", $param_ham, PDO::PARAM_STR);
    $stmt->bindParam(":peppers", $param_peppers, PDO::PARAM_STR);


    // Set parameters
    $param_userid = $userid;
    $param_size = $size;
    $param_cheese = $cheese;
    $param_pepperoni = $pepperoni;
    $param_sausage =  $sausage;
    $param_bacon = $bacon;
    $param_ham = $ham;
    $param_peppers = $peppers;
    $param_order_time = $order_time;
    $stmt->execute();
}

    // Close statement
    unset($stmt);
unset($pdo);

$log = "size: " . $_POST["size"] . " " . $pepperoni . " ". $array ."\n" ;
$file = '../log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $log;
// Write the contents back to the file
file_put_contents($file, $current);
//header("location: ../orderstatus.php");
unset($results);
header("location: ../orderstatus.php");
?>
