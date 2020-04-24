<?php
// Initialize the session
session_start();

if (isset($_SESSION["loggedin"])) {
    $loggedin = 1;
} else {
    $loggedin = 0;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="shop.css">
</head>
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}
.size-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
.small{background-image:url(img/radio-button.png);}
.medium{background-image:url(img/radio-button.png);}
.large{background-image:url(img/radio-button.png);}

.size-selector input:active +.size{opacity: 1;}
.size-selector input:checked +.size{
    -webkit-filter: none;
       -moz-filter: none;
            filter: none;
}
.size{
    cursor:pointer;
    background-repeat:no-repeat;
    display:inline-block;
    width:80px;height:80px;
    -webkit-transition: all 100ms ease-in;
       -moz-transition: all 100ms ease-in;
            transition: all 100ms ease-in;
    -webkit-filter: brightness(1.8) grayscale(1) opacity(.3);
       -moz-filter: brightness(1.8) grayscale(1) opacity(.3);
            filter: brightness(1.8) grayscale(1) opacity(.3);
}
.size:hover{
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
}

/* Extras */
a:visited{color:#888}
a{color:#444;text-decoration:none;}
p{margin-bottom:.3em;}
h1 {
  text-align: center;
}

input[type="text"] {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

input[type="checkbox"] {

  zoom: 2;
}


/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
<body>
  <div class="topnav">
   <a href="index.php">Home</a>
   <a class="active" href="order.php">Order</a>
   <?php if(isset($_SESSION['loggedin'])){?>
     <a href="orderstatus.php">Order Status</a>
     <a href="logout.php">Logout</a>
   <?php }  ?>
   <?php if(isset($_SESSION['isAdmin'])){?><a href="admin.php">Admin</a><?php }  ?>
   <?php if(!isset($_SESSION['loggedin'])){?>
     <a href="login.php">Login</a>
   <?php }  ?>
  </div>
<form id="regForm" action="scripts/submit.php" method="post">

<h1>Build Your Pizza</h1>

<!-- One "tab" for each step in the form: -->
<div class="tab">
  <br>
    <center><div class="size-selector">
        <h2>Select Pizza Size</h2>
        <input  id="small" type="radio" name="size" value="1" checked />
        <label style="background-size: 50px 50px;" class="size small" for="small"></label>
        <input  id="medium" type="radio" name="size" value="2" />
        <label style="background-size: 60px 60px;" class="size medium"for="medium"></label>
        <input  id="large" type="radio" name="size" value="3" />
        <label style="background-size: 70px 70px;" class="size large"for="large"></label>
    </div></center>
  </div>

<div class="tab">
  <center><div>
    <h2>Select Pizza Toppings</h2>
    <input type="checkbox" id="cheese" name="cheese" value="cheese" checked>
    <label style="zoom: 2" for="cheese">Cheese</label>
    <input type="checkbox" id="sausage" name="sausage" value="sausage">
    <label style="zoom: 2" for="pepperoni">Sausage</label>
    <input type="checkbox" id="pepperoni" name="pepperoni" value="pepperoni">
    <label style="zoom: 2" for="pepperoni">Pepperoni</label><br>
    <input type="checkbox" id="bacon" name="bacon" value="bacon">
    <label style="zoom: 2" for="bacon">bacon</label>
    <input type="checkbox" id="ham" name="ham" value="ham">
    <label style="zoom: 2" for="ham">Ham</label>
    <input type="checkbox" id="peppers" name="peppers" value="peppers">
    <label style="zoom: 2" for="peppers">Peppers</label>
    <input type="hidden" id="log" name="log" value="true">
  </div></center>
</div>

<div class="tab">
 <p><input placeholder="Address" oninput="this.className = ''"></p>
 <p><input placeholder="mm" oninput="this.className = ''"></p>
 <p><input placeholder="yyyy" oninput="this.className = ''"></p>
</div>

<div class="tab">Login Info:
 <p><input placeholder="Username..." oninput="this.className = ''"></p>
 <p><input placeholder="Password..." oninput="this.className = ''"></p>
</div>

<div style="overflow:auto;">
 <div style="float:right;">
   <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
   <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
 </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
 <span class="step"></span>
 <span class="step"></span>
 <span class="step"></span>
 <span class="step"></span>
</div>

</form>


  <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <form class="login" action="scripts/login.php" method="post">
        <div class="login_container">
          <span class="close">&times;</span>
          <h3>Please login to order</h3>
              <p>Username</p>
              <input id=username type="text" name="username" class="input">
              <p>Password</p>
              <input id=password type="password" name="password" class="input">

                  <button type="submit">submit</button>

              <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
      </form>
    </div>
  </div>
  </body>
</html>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


// When the user clicks the button, open the modal
var loggedin = <?php  if(isset($_SESSION["loggedin"])) {echo 1;} else {echo 0;} ?>;
if( loggedin == "0") {
window.onload = function() {
  modal.style.display = "block";
 }
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  window.location = "index.php";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    window.location = "index.php";
  }
}

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

</script>
