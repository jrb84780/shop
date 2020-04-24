
<?php
session_start();
if (!isset($_POST["log"])) {
    header("location: ../index.php");
    exit;
}
$POSTvaluesToCheck = array('cheese', 'pepperoni', 'sausage', 'bacon', 'ham', 'peppers');
$results = array();
$cheese = $pepperoni = $sausage = $bacon = $ham = $peppers = $x = 0;
$array = "";

foreach($POSTvaluesToCheck as $key) {
  if(isset($_POST[$key])) {
    $results[$x] = $key;
    $x++;
  }
}

foreach($results as $value) {
    $array .= $value;
}

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
?>
