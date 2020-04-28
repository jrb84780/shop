
<?php
session_start();

require_once "../config.php";
$x = 0;


if($_POST["size"] != '1' && $_POST["size"] != '2' && $_POST["size"] != '3'){
  header("location: ../404.php");
}

$index = array();
$data = array();
$i = 0;

foreach ($_POST as $key => $value) {
        $index[$i] = $key;
        $data[$i] = $value;
      if($value != '0' && $value != '1' && $key != 'inst' && $key != 'size'){
        header("location: ../404.php");
      }
      if($key == 'inst'){
        $inst = $value;
      }
$i++;
}

for($i=0;$i<sizeof($data);$i++){
    $data[$i] = "'$data[$i]'";
}

$columns = implode(", ",$index);
$values = implode(", ",$data);

$userid = $_SESSION['userid'];
$order_time = date("h:i:sa d-m-Y");

$sql = "INSERT INTO jb_orders(userid,$columns) VALUES (:userid,$values)";

if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters

    $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
    $param_userid = $userid;




    $stmt->execute();
} else {
    header("location: ../404.php");
}

    // Close statement
    unset($stmt);
unset($pdo);

header("location: ../orderstatus.php");

?>
