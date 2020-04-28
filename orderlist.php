<?php
// Initialize the session
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("location: index.php");
    exit;
}
require_once "config.php";
$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style/index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="style/datetimepicker_css.js"></script>
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
  <div class="main-image">
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if(isset($_SESSION['loggedin'])){?>
     <a class="active" href="orderlist.php">Order Status</a>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if(isset($_SESSION['isAdmin'])){?><a href="admin.php">Admin</a><?php }  ?>
   <?php if(!isset($_SESSION['loggedin'])){?>
     <a href="login.php">Login</a>
   <?php }  ?>
  </div>

    
  <div id="orderlistForm" class="oModal">
     <br>
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
              
              
              $sql = "SELECT * FROM jb_orders WHERE userid = :userid Order By orderid Desc";
              if ($stmt = $pdo->prepare($sql)) {
              $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
              $param_userid = $userid;
              $stmt->execute();
              if ($stmt->rowCount() > 0) {
                  while ($row = $stmt->fetch()) {
                      ?>
                       <tr data-href="<?php echo $row['orderid'];?>">
                         <td><?php echo $row['orderid'];?></td>
                         <td><?php echo $_SESSION['username']?></td>
                         <td><?php echo $row['bill'];?></td>
                         <td colspan = "2"><?php echo date('g:ia - m/j/y',strtotime($row['order_time'])); ?></td>
                         <td id="cookedID"><?php if($row['order_cooked'] != ""){echo date('g:ia - m/j/y',strtotime($row['order_cooked']));} else {echo '<button id="autoCooked" type="button" value="'. $row["orderid"] .'">Cooked</button>';} ?></td>
                         <td id="completeID"><?php if($row['order_complete'] != ""){echo date('g:ia - m/j/y',strtotime($row['order_complete']));} else {echo '<button id="autoComplete" type="button" value="'. $row["orderid"] .'">Complete</button>';} ?></td>
                         <td id="viewID"><button id="view" type="button" onclick="viewOrder(<?php echo $row['orderid'];?>)">View</button></td>
                       </tr>

                     <?php
                  }
              }
          }?>
        </table>
      </center>
       </div>
       </div>
     
     <div id="cookedForm" class="cModal">
       <!-- Modal content -->
       <div id="regForm">
         <form>
           <a id="close" class="close"  href="javascript:close()">&times;</a>
           <br>
             <center>
               <div id=viewForm>
              <h3>Order Details</h3>
               <input type="Text" id="date" maxlength="25" size="25"/>
               <img src="img/cal.gif" onclick="javascript:NewCssCal ('date','MMddyyyy','dropdown',true,'12')" style="cursor:pointer"/>
               <button id="cooked" type="button">Cooked</button>
               <button id="complete" type="button">Complete</button>
               <div>
             </center>
         </form>				
     </div>
   </div>
   </div>
</body>
</html>
<script>

var orderid ="";
var cModal = document.getElementById("cookedForm");
var oModal = document.getElementById("orderlistForm");

function viewOrder() {
   oModal.style.display= "none";
   document.getElementById("viewForm").innerHTML = "<?php
            $count = 0;
            $sql = "SELECT * FROM jb_orders WHERE userid = :userid Order By orderid Desc";
            if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
            $param_userid = $userid;
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                }
            }
        }?>" +
        "<p>dsgdfg</p>"
   cModal.style.display = "block";
   
}
window.onclick = function(event) {
  if (event.target == cModal) {
    cModal.style.display = "none";
    oModal.style.display= "block";
  }
	if (event.target == dModal) {
		dModal.style.display = "none";
    oModal.style.display= "block";
	}
}

function close() {
  cModal.style.display = "none";
  oModal.style.display= "block";
}

$("#autoCooked").on('click', function() {
  orderid = $(this).attr('value');
  $.post("scripts/updateOrder.php", {
          order_cooked:"order_cooked",
          orderid: orderid,
      })
      .done(function(result, status, xhr) {
            window.location.href = "orderlist.php";
      });
});

$("#autoComplete").on('click', function() {
  orderid = $(this).attr('value');
  $.post("scripts/updateOrder.php", {
          order_complete:"order_complete",
          orderid: orderid,
      })
      .done(function(result, status, xhr) {
            window.location.href = "orderlist.php";
      });
});

</script>
