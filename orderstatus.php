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

  <link rel="stylesheet" type="text/css" href="shop.css">
  <style>
      .order_list {
        border-radius: 15px;
        background: gray;
        padding: 20px;
        width: 10%;
        height: 10%;

        display: flex;
        align-items: center;
        justify-content: center;
      }
  </style>
</head>
<body>
  <div class="topnav">
   <a href="index.php">Home</a>
   <a href="order.php">Order</a>
   <?php if(isset($_SESSION['loggedin'])){?>
     <a class="active" href="orderstatus.php">Order Status</a>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if(isset($_SESSION['isAdmin'])){?><a href="admin.php">Admin</a><?php }  ?>
   <?php if(!isset($_SESSION['loggedin'])){?>
     <a href="login.php">Login</a>
   <?php }  ?>
  </div>
  <div class="container">
     <br>
          <!-- This first section is to query the database for username,avatar, and online status-->
           <?php
              $count = 0;
              $sql = "SELECT * FROM jb_orders WHERE userid = :userid";
              if ($stmt = $pdo->prepare($sql)) {
              $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
              $param_userid = $userid;
              $stmt->execute();
              if ($stmt->rowCount() > 0) {
                  while ($row = $stmt->fetch()) {
                      ?>
                      <div class="col-md-2" style="border-radius:20px;padding-bottom:50px;background-color: grey;margin: 10px;height:10%; width:10%; display: flex; align-items: center; justify-content: center;">
                         <p><?php echo $row['orderid'];?>
                         <?php echo $_SESSION['username']?>
                         <?php echo $row['order_time'] ?></p>
                      </div>

                     <?php
                  }
              }
          }?>
         </div>

</body>
</html>
