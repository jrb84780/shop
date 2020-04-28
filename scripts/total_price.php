<?php
$sizeCost = 0;
$size = $_POST['size'];
$numPizzas = $_POST['numPizzas'];
$numTops = $_POST['numTops'];

   if($size == 1){
     $sizeCost = 5;
   }
   if($size == 2){
     $sizeCost = 7;
   }
   if($size == 3){
     $sizeCost = 10;
   }
    $top = 0.50;
    $total = ($numPizzas*$sizeCost) + ($numTops*$top);
    echo number_format($total, 2);
?>
