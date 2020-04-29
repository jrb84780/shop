<?php

$columnName = array();
$data = array();
$i = 0;
$log = "\n";
foreach ($_POST as $key => $value) {
    $columnName[$i] = $key;
    $data[$i] = "'".$value."'";
    $log .= $columnName[$i] . ": " . $data[$i];
    $i++;
}
$log .= "\n";

$file = '../log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= $log;
// Write the contents back to the file
file_put_contents($file, $current);
