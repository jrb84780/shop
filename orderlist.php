<?php
// Initialize the session
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["isAdmin"] == 0) {
    header("location: index.php");
    exit;
}
require_once "config.php";

$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html>
<head>
	Pizza Shop</title>
	<meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
</head>
<style>
table { 
  width: 100%; 
  border-collapse: collapse; 
}

@media 
only screen and (max-width: 1100px),
(min-device-width: 768px) and (max-device-width: 1100px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;) for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/

	td:nth-of-type(1):before { content: "Order ID"; }
	td:nth-of-type(2):before { content: "Username"; }
	td:nth-of-type(3):before { content: "Cost"; }
	td:nth-of-type(4):before { content: "Submitted"; }
	td:nth-of-type(5):before { content: "Cooked"; }
	td:nth-of-type(6):before { content: "Complete"; }
	td:nth-of-type(7):before { content: "View"; }
}
</style>
<body>
  
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if (isset($_SESSION['loggedin'])) {?>
     <a href="orderstatus.php">Order Status</a>
     <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {?>
     <a class="active" href="orderlist.php">Order List</a>
     <a href="statistics.php">Statistics</a>
     <?php }  ?>
     <a href="logout.php">Logout</a>
   <?php }  ?>
  </div>

    

     <div id="regForm" style="overflow: auto;">
     <center>
       <table class="pricing" border=1 frame=void rules=rows style="height:100%;width:100%;" >
        <tr>
          <th>Order ID</th>
          <th>Username</th>
          <th>Cost</th>
          <th colspan = "2">Submitted</th>
          <th>Cooked</th>
          <th>Complete</th>
          <th>View</th>
        <tr>
           <?php
              
              
              $sql = "SELECT * FROM jb_orders Order By orderid Desc";
              if ($stmt = $pdo->prepare($sql)) {
                  $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
                  $param_userid = $userid;
                  $stmt->execute();
                  if ($stmt->rowCount() > 0) {
                      while ($row = $stmt->fetch()) {
                          ?>
                       <tr data-href="<?php echo $row['orderid']; ?>">
                         <td><?php echo $row['orderid']; ?></td>
                         <td><?php echo $row['username']?></td>
                         <td><?php echo $row['bill']; ?></td>
                         <td colspan = "2"><?php echo date('g:ia - m/j/y', strtotime($row['order_time'])); ?></td>
                         <td id="cookedID"><?php if ($row['order_cooked'] != "") {
                              echo date('g:ia - m/j/y', strtotime($row['order_cooked']));
                          } else {
                              echo '<button id="autoCooked" type="button" onclick="autoCooked('. $row["orderid"] .')">Cooked</button>';
                          } ?></td>
                         <td id="completeID"><?php if ($row['order_complete'] != "") {
                              echo date('g:ia - m/j/y', strtotime($row['order_complete']));
                          } else {
                              echo '<button id="autoComplete" type="button" onclick="autoComplete('. $row["orderid"] .')">Complete</button>';
                          } ?></td>
                         <td id="viewID"><button id="view" type="button" onclick="viewOrder(<?php echo $row['orderid']; ?>)">View</button></td>
                       </tr>

                     <?php
                      }
                  }
              }?>
        </table>
      </center>
       </div>

   </div>
 
</body>
</html>
<script>

function viewOrder(orderid) {
      var orderid = 'orderview.php?orderid=' + orderid;
      window.location = orderid;
}

function autoCooked(orderid) {
  $.post("scripts/updateOrder.php", {
          order_cooked:"order_cooked",
          orderid: orderid,
      })
      .done(function(result, status, xhr) {
            window.location.href = "orderlist.php";
      });
}

function autoComplete(orderid){
  $.post("scripts/updateOrder.php", {
          order_complete:"order_complete",
          orderid: orderid,
      })
      .done(function(result, status, xhr) {
            window.location.href = "orderlist.php";
      });
    }
    
</script>
