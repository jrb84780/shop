<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("location: ./index.php");
}
require_once "./config.php";
$userid = $_SESSION['userid'];
$time = $hours = $minutes = 0;

   $sql = "SELECT * FROM jb_orders WHERE order_complete IS NULL";
   if ($stmt = $pdo->prepare($sql)) {
       $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
       $param_userid = $userid;
       $stmt->execute();
       if ($stmt->rowCount() > 0) {
           while ($row = $stmt->fetch()) {
               $time++;
           }
       }
   }
$time = $time * 10;
if ($time > 59) {
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    if ($hours == 1) {
        $wait_time =  $hours . ' Hour' . ' and ' . $minutes . ' Minutes';
    } else {
        $wait_time =  $hours . ' Hours' . ' and ' . $minutes . ' Minutes';
    }
} else if($time < 59) {
    $wait_time =  $time . ' Minutes';
} else {
  $wait_time = 'You have no current';
}
?>

<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style/index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
</head>
<body>
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if (isset($_SESSION['loggedin'])) {?>
     <a class="active" href="orderstatus.php">Order Status</a>
     <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {?>
     <a href="orderlist.php">Order List</a>
     <a href="statistics.php">Statistics</a>
     <?php }  ?>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if (!isset($_SESSION['loggedin'])) {?>
     <a href="login.php">Login</a>
   <?php
 } ?>
  </div>

  <div id="orderlistForm" >
     <br>
     <div id="regForm" style="overflow: auto;">
     <center>
          <h3>Order Complete<h3>
          <p>Your current wait time is: <?php echo $wait_time ;?></p>      
      </center>
       </div>
   </div>
</body>
</html>