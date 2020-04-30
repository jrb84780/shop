<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['isAdmin'] != 1) {
    header("location: index.php");
}
//List of skipped columns
$skipKey = array('orderid','userid','username','size','num_pizzas','inst','bill','order_time','order_cooked','order_complete');


$colN = array();
$skip = 0;

//Get list of columns
$sql = "SHOW columns FROM jb_orders";

  if ($stmt = $pdo->prepare($sql)) {
      $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
          while ($col = $stmt->fetch()) {
              foreach ($skipKey as $key) {
                  if ($col['Field'] == $key) {
                      $skip = 1;
                  }
              }
              if ($skip == 0) {
                  $colN[] = $col['Field'];
              } else {
                  $skip = 0;
              }
          }
      }
  }




$sumColN = array();
$sumCol = "";
$total = 0;
$count = 0;
//Queries column values
for ($i=0;$i<sizeOf($colN);$i++) {
    $sumColN[$i] = 'SUM('.$colN[$i].')' . " AS " . $colN[$i];
}
$sumCol = implode(", ", $sumColN);

//Queries column total values
$sql = "SELECT $sumCol FROM jb_orders";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->execute();
        $row = $stmt->fetch();
    }
      foreach ($colN as $key) {
          $total += $row[$key];
      }

      foreach ($colN as $key) {
          $dataPoints[$count] = array("label"=> "$key", "y" => ($row[$key]/$total)*100);
          $count++;
      }

      $sCount = 0;
      $mCount = 0;
      $lCount = 0;
      $uCount = 0;
      $sql = "SELECT size FROM jb_orders";
      $count = 0;
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    if ($row['size'] == 1) {
                        $sCount += 1;
                    } elseif ($row['size'] == 2) {
                        $mCount += 1;
                    } elseif ($row['size'] == 3) {
                        $lCount += 1;
                    } else {
                        $uCount += 1;
                    }
                }
            }
        }

        $BarDataPoints[0] = array("y" => $sCount, "label"=> "Small");
        $BarDataPoints[1] = array("y" => $mCount, "label"=> "Medium");
        $BarDataPoints[2] = array("y" => $lCount, "label"=> "Large");
        if ($uCount != 0) {
            $BarDataPoints[3] = array("y" => $uCount, "label"=> "Promo");
        }




?>
<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
window.onload = function() {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: "Popular toppings"
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});

var barChart = new CanvasJS.Chart("barChartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Most Common Pizza Sizes"
	},
	axisY: {
		title: "Number of Pizza's"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## Count",
		dataPoints: <?php echo json_encode($BarDataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});

chart.render();
barChart.render();

}
</script>
</head>
<body>
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if (isset($_SESSION['loggedin'])) {?>
     <a href="orderstatus.php">Order Status</a>
     <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {?>
     <a href="orderlist.php">Order List</a>
     <a class="active" href="statistics.php">Statistics</a>
     <?php }  ?>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if (!isset($_SESSION['loggedin'])) {?>
     <a href="login.php">Login</a>
   <?php 
 } ?>
  </div>
  <form id="regForm" action="scripts/updateOrder.php" method="post" style="overflow: auto;">
<center>
<div id="chartContainer" style="height: 370px; width: 50%;"></div><br>
<div id="barChartContainer" style="height: 370px; width: 50%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</center>
</div>
</body>
</html>
