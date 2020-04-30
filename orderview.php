<?php
// Initialize the session
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["isAdmin"] == 0) {
    header("location: index.php");
    exit;
}

if (isset($_GET['orderid'])) {
    $orderid = $_GET['orderid'];
} else {
    header("location: errorPage.php");
}

require_once "config.php";

$skipKey = array('orderid','userid','username','num_pizzas','inst','bill','order_time','order_cooked','order_complete');


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
  
$sql = "SELECT * FROM jb_orders WHERE orderid = :orderid";
if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(":orderid", $param_orderid, PDO::PARAM_STR);
    $param_orderid = $orderid;
    $stmt->execute();
    $stmt->rowCount();
    $row = $stmt->fetch();
}
if($row['orderid'] == "" || $row['orderid'] == null){
  header("location: errorPage.php");
}
if ($row['order_cooked'] != null || $row['order_cooked'] != '') {
    $cookedDate = date('Y-m-d', strtotime($row['order_cooked']));
    $cookedTime = date('H:i:s', strtotime($row['order_cooked']));

} else {
    $cookedDate = "";
    $cookedTime = "";
}

if ($row['order_complete'] != null || $row['order_complete'] != '') {
    $completeDate = date('Y-m-d', strtotime($row['order_complete']));
    $completeTime = date('H:i:s', strtotime($row['order_complete']));
} else {
    $completeDate = "";
    $completeTime = "";
}
$userid = $row['userid'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pizza Shop</title>
	<meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if (isset($_SESSION['loggedin'])) {?>
     <a href="orderstatus.php">Order Status</a>
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



     <form id="regForm" action="scripts/updateOrder.php" method="post" style="overflow: auto;">
     <center>
          
              <table>
                <tr>
                <th colspan="3"><h4>Order: <?php echo $row['orderid'];?> / Customer: <?php echo $row['username'];?></h4><br></th>
              </tr>
                <tr>
                  <th colspan="3">
                    Pizza Size
                  </th>
                <tr>
                  <td style="text-align:right;">
                    <input id="small" class="small" type="radio" name="size" value="1"></input>
                    <label>Small</label>
                  </td>
                  <td style="text-align:center;">
                    <input id="medium" class="medium" type="radio" name="size" value="2"></input>
                    <label>Medium</label>
                  </td>
                  <td style="text-align:left;">
                    <input id="large" class="large" type="radio" name="size" value="3" />
                    <label>Large</label>
                  </td>
                </tr>

              <th>Cheeses</th>
              <th>Meats</th>
              <th>Veggies</th>
            </tr>
            <tr>
              <td class="toppingTD">
                  <input type="checkbox" id="cheddar" name="cheddar" value="1">
                  <label  for="cheddar">Cheddar</label><br>
                  <input type="checkbox" id="mozzarella" name="mozzarella" value="1">
                  <label  for="mozzarella">Mozzarella</label><br>
                  <input type="checkbox" id="gouda" name="gouda" value="1">
                  <label  for="gouda">Smoked gouda</label>
              </td>
              <td class="toppingTD">
                  <input type="checkbox" id="pepperoni" name="pepperoni" value="1">
                  <label  for="pepperoni">Pepperoni</label><br>
                  <input type="checkbox" id="sausage" name="sausage" value="1">
                  <label for="pepperoni">Sausage</label><br>
                  <input type="checkbox" id="bacon" name="bacon" value="1">
                  <label for="bacon">bacon</label><br>
                  <input type="checkbox" id="ham" name="ham" value="1">
                  <label for="ham">Ham</label><br>
                  <input type="checkbox" id="chicken" name="chicken" value="1">
                  <label  for="chicken">Chicken</label>
              </td>
              <td class="toppingTD">
                <input type="checkbox" id="peppers" name="peppers" value="1">
                <label for="peppers">Peppers</label><br>
                <input type="checkbox" id="onions" name="onions" value="1">
                <label for="onions">Onions</label><br>
                <input type="checkbox" id="tomatoes" name="tomatoes" value="1">
                <label for="tomatoes">Tomatoes</label>

              </td>
            </tr>

            <tr>
              <th>Cooked</th>
              <th></th>
              <th>Complete</th>
            </tr>

            <tr>
              <td>Date:  <input type="date" id="date_cooked" name="date_cooked" value="<?php echo $cookedDate; ?>" min="2020-01-01"><br>
               Time:  <input type="time" id="time_cooked" name="time_cooked" value="<?php echo $cookedTime; ?>" min="09:00" max="22:00"><br>
               <input type="checkbox" id="updateOrderCooked" name="updateOrderCooked" value="1">
               <label for="updateOrderCooked">Update Time</label>
            </td>
            <td></td>
              <td>Date:  <input type="date" id="date_complete" name="date_complete" value="<?php echo $completeDate; ?>" min="2020-01-01"><br>
               Time:  <input type="time" id="time_complete" name="time_complete" value="<?php echo $completeTime; ?>" min="09:00" max="22:00"><br>
               <input type="checkbox" id="updateOrderComplete" name="updateOrderComplete" value="1">
               <label for="updateOrderComplete">Update Time?</label>
            </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align:center;">Total:<input id="runningTot" name="bill" type="number" value="<?php echo $row['bill']; ?>" step=".01" style="width:5em;text-align:center;" required></td>
            </tr>
            <tr>
              </td>
            </tr>
            </table>
            <br>
            <input type="number" name="orderid" value="<?php echo $row['orderid'];?>" hidden></input>
            <button type="submit" style="width:20%">Update Order</button>
            <button id="delOrder" type="button" style="width:20%; background-color:black">Delete</button>
      </center>
    </form>
    
    <div id="dModal" class="dModal">
      <!-- Modal content -->
      <div id="regForm" style="background-color:black;color:white; width:10%">
        <form>
          <a id="close" class="close"  href="javascript:close()">&times;</a>
          <br>
            <center>
              <h3>Are you sure you want to delete this order?</h3>
              <p id="error" style="color:red;" hidden></p>
              <button id="yes" type="button">Yes</button>
              <button id="no" onclick="close()" type="button" style="background-color:gray;">No</button>
            </center>
        </form>				
    </div>
    



</body>
</html>
<script>
var total = <?php echo $row['bill']; ?>;
var orderid = <?php echo $row['orderid']; ?>;
var dModal = document.getElementById("dModal");
var size = 0;
var numTops=0;
var numPizzas=1;
<?php 

foreach($colN as $key){
    if($key == 'size' && $row[$key] == 1){
     ?>$( "#small" ).prop( "checked", true );size = 1;<?php
  }
  else if($key == 'size' && $row[$key] == 2){
    ?>$( "#medium" ).prop( "checked", true ); size = 2;<?php
}
  else if($key == 'size' && $row[$key] == 3){
    ?>$( "#large" ).prop( "checked", true ); size = 3;<?php
} else if($row[$key] == 1) { ?>
   $( "#<?php echo $key; ?>" ).prop( "checked", true );<?php
}
};?>



$("#delOrder").on('click', function() {
        dModal.style.display = "block";
   });
//Calculate total price of size radio buttons
$("#yes").on('click', function() {
       $.post("scripts/delOrder.php", {
               orderid: orderid,
           })
           .done(function(result, status, xhr) {
               if (result == 'success') {
                 alert("Order Deleted");
                 window.location.href = "orderlist.php";
               } else {
                 
                 document.getElementById("error").innerHTML = result;
                 document.getElementById("error").style.display = "block";
               }
           });
   });
   
   $("#no").on('click', function() {
      dModal.style.display = "none";
      });
      
//Get radio button value
$('input[type=radio]').change(function () {
  size = this.value;
  
});
//Calculate total price of checkboxes
$('input[type=checkbox],input[type=radio]').change(function () {
var checked = $(this).is(':checked');



numTops = $(":checkbox:checked").length;

$.post("scripts/total_price.php", {
        size: size,
        numTops: numTops,
        numPizzas: numPizzas,
    })
    .done(function(result, status, xhr) {
        if(checked == true){
          total += result;
        } else {
          total -= result;
        }
        document.getElementById("runningTot").value = result;
        
    });
});

window.onclick = function(event) {
  if (event.target == dModal) {
    dModal.style.display = "none";
  }

}

function close() {
  dModal.style.display = "none";

}

</script>
