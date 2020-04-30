<?php
// Initialize the session
session_start();
if (isset($_SESSION['loggedin'])) {
    echo '<script>var loggedin = "true"; </script>';
} else {
    echo '<script>var loggedin = "false"; </script>';
}

?>

<!DOCTYPE html>
<html>

<head>
    Pizza Shop</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .small {
            background-position: center;
            background-image: url(img/pizza.png);
        }

        .medium {
            background-position: center;
            background-image: url(img/pizza.png);
        }

        .large {
            background-position: center;
            background-image: url(img/pizza.png);
        }
        .pricing {
          text-align:center;
        }
        .toppingTD{
          vertical-align:top;
        }
    </style>
</head>

<body>
    <div class="topnav">
        <a href="index.php">Home</a>
        <a class="active" href="order.php">Order</a>
        <?php if (isset($_SESSION['loggedin'])) {?>
        <a href="orderstatus.php">Order Status</a>
        <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {?>
        <a href="orderlist.php">Order List</a>
        <a href="statistics.php">Statistics</a>
        <?php }  ?>
        <a href="logout.php">Logout</a>
        <?php }  ?>
        <?php if (!isset($_SESSION['loggedin'])) {?>

        <a id="registerLink" href="javascript:register()">Register</a>
        <?php
 } ?>
    </div>

    <form id="regForm" action="scripts/submit.php" method="post">
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
            <br>
            <center>
                <h1>Build Your Pizza</h1>
                <div class="size-selector">
                    <table class="pricing">
                        <tr>
                            <th colspan="3">
                                Select pizza size
                            </th>
                            <tr>
                                <tr>
                                    <th>Small (10")</th>
                                    <th>Medium (12")</th>
                                    <th>Large (12")</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input id="small" class="small" type="radio" name="size" value="1" />
                                        <label style="background-size: 80px 80px;" class="size small" for="small"></label>
                                    </td>
                                    <td>
                                        <input id="medium" class="medium" type="radio" name="size" value="2" />
                                        <label style="background-size: 90px 90px;" class="size medium" for="medium"></label>
                                    </td>
                                    <td>
                                        <input id="large" class="large" type="radio" name="size" value="3" />
                                        <label style="background-size: 100px 100px;" class="size large" for="large"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Small: Starts at $5</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Medium: Starts at $7</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Large: Starts at $10</td>
                                </tr>
                    </table>
                    <p id="failureSize" style="color:red;" hidden>Please select a size</p>
                </div>
            </center>
        </div>

        <div class="tab">
            <center>
                <div>
                    <h2>Select Pizza Toppings</h2>
                    <table>
                        <tr>
                            <th colspan="3">
                                Each topping is 50&#162;
                            </th>
                            <tr>
                                <th>Cheeses</th>
                                <th>Meats</th>
                                <th>Veggies</th>
                            </tr>
                            <tr>
                                <td class="toppingTD">
                                    <input type="checkbox" id="cheddar" name="cheddar" value="1">
                                    <label for="cheddar">Cheddar</label><br>
                                    <input type="checkbox" id="mozzarella" name="mozzarella" value="1">
                                    <label for="mozzarella">Mozzarella</label><br>
                                    <input type="checkbox" id="gouda" name="gouda" value="1">
                                    <label for="gouda">Smoked gouda</label>
                                </td>
                                <td class="toppingTD">
                                    <input type="checkbox" id="pepperoni" name="pepperoni" value="1">
                                    <label for="pepperoni">Pepperoni</label><br>
                                    <input type="checkbox" id="sausage" name="sausage" value="1">
                                    <label for="pepperoni">Sausage</label><br>
                                    <input type="checkbox" id="bacon" name="bacon" value="1">
                                    <label for="bacon">bacon</label><br>
                                    <input type="checkbox" id="ham" name="ham" value="1">
                                    <label for="ham">Ham</label><br>
                                    <input type="checkbox" id="chicken" name="chicken" value="1">
                                    <label for="chicken">Chicken</label>
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
                    </table>
                </div>
            </center>
        </div>

        <div class="tab">
            <center>
                <h2>Special instructions</h2>
                <p id="failureSpecial" style="color:red;" hidden>Invalid input please do not type any special characters</p>
                <textarea id="specialInstr" class="specialInstr" name='inst' oninput="this.className = ''" rows="6" cols="100"></textarea>
            </center>
        </div>

        <div id="loginRealTab" class="tab">
            <div id="loggedIn">
                <center>
                    <h3 id="loginHeader">Please login to Finish Order</h3>
                    <p id="failureLogin" style="color:red;" hidden>Invalid username or password</p>
                    <input id=username class="username" placeholder="Username" type="text" name="username" class="input">
                    <input id=password class="password" placeholder="Password" type="password" name="password" class="input">
                    <button id="loginButton" type="button">Login</button>
                    <p>Login as admin - Username: admin Password: tester</p>
                    <p>Login as user - Username: user1 Password: tester</p>
                    <a id="noAccount" class="modalRegisterLink" href="javascript:register()">Sign up now</a>
                </center>
            </div>
        </div>

        <div style="overflow:auto;">
            <div style="float:right;">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            </div>
        </div>

        <!-- Circles which indicates the steps of the form: -->

        <div id="tabSpan" style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <input type="text" id="runningTot" name="bill" readonly value="" style="border: 0; font-size: 20px; display:none;" />
        </div>

    </form>
    

    <div id="registerLinkForm" class="orModal">
        <!-- Modal content -->
        <div id="regForm">
            <form name="register">
                <a id="close" class="close" href="javascript:close()">&times;</a>
                <br>
                <center>
                    <div id="regStatus">
                        <h3>Register</h3>
                        <p id="error" style="color:red;" hidden></p>
                        <input id=rUsername class="username" type="text" placeholder="Username" name="username" class="input" required>
                        <input id=rPassword class="password" type="password" placeholder="Password" name="password" class="input">
                        <input id=rcPassword class="password" type="password" placeholder="Password" name="password" class="input">
                        <button id="registerBtn" type="button">Create Account</button>
                    </div>
                </center>
            </form>
        </div>
    </div>
</body>

</html>
<script>
//Variables used for calulating price
var total = 0;
var numTops=0;
var numPizzas=1;
var size=0;
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

   //This function posts to login.php and refreshes page elements
    $("#loginButton").on('click', function() {;
        var user = $('#username').val();
        var pass = $('#password').val();
        $.post("scripts/login.php", {
                username: user,
                password: pass,
            })
            .done(function(result, status, xhr) {
                if (result == "success") {
                    loggedin = "true";
                    $("#topnav").load(location.href + " #topnav");
                    $("#loggedIn").replaceWith("<center><h2>Total</h2> Your total is: $" + total + "</center>");
                    document.getElementById("nextBtn").style.display = "block";
                    document.getElementById("nextBtn").innerHTML = "Submit Order";

                } else {
                    failureLogin.style.display = "block";
                }
            });
    });

    // This function will display the specified tab of the form ...
    function showTab(n) {

        var x = document.getElementsByClassName("tab");

        x[n].style.display = "block";
        // ... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }

        if (n == (x.length - 1)) {
          if(loggedin == "false"){
            document.getElementById("loginLink").style.display = "none";
            document.getElementById("nextBtn").innerHTML = "Submit Order";
            document.getElementById("nextBtn").style.display = "none";
          }
          if(loggedin == "true"){
            
            $("#loggedIn").replaceWith("<center><h2>Total</h2> Your total is: $" + total + "</center>");
            document.getElementById("nextBtn").innerHTML = "Submit Order";
          }
        } else {
          document.getElementById("nextBtn").innerHTML = "Next";
        }
        // ... and run a function that displays the correct step indicator:
        fixStepIndicator(n)
    }
    
    // This function will figure out which tab to display
    function nextPrev(n) {

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

        var sizeS = document.getElementById("small").checked;
        var sizeM = document.getElementById("medium").checked;
        var sizeL = document.getElementById("large").checked;
        if(sizeS == false && sizeM == false && sizeL == false ){
          failureSize.style.display = "block";
          valid = false;
        }

        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }
    
    
    //Bottom breadcrumb form indicator
    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {

            x[i].className = x[i].className.replace(" active", "");

        }
        //... and adds the "active" class to the current step:
        x[n].className += " active";
    }
    
    
    //Calculate total price of size radio buttons
    $('input[type=radio][name=size]').change(function() {

      size = this.value;
      $.post("scripts/total_price.php", {
              size: size,
              numTops: numTops,
              numPizzas: numPizzas,
          })
          .done(function(result, status, xhr) {
              document.getElementById("runningTot").value = result;
              total = result;
          });

    });

    //Calculate total price of checkboxes
    $('input[type=checkbox]').change(function () {
    numTops = $(":checkbox:checked").length;

    $.post("scripts/total_price.php", {
            size: size,
            numTops: numTops,
            numPizzas: numPizzas,
        })
        .done(function(result, status, xhr) {

            document.getElementById("runningTot").value = result;
            total = result;
        });
    });
    
    $('#rUsername').keypress(function (e) {
		    var regex = new RegExp("^[a-zA-Z0-9]+$");
		    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		    if (regex.test(str)) {
		        return true;
		    }
		    e.preventDefault();
		    return false;
		});
    
    $('#lLusername').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });
		
		$('#username').keypress(function (e) {
				var regex = new RegExp("^[a-zA-Z0-9]+$");
				var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
				if (regex.test(str)) {
						return true;
				}
				e.preventDefault();
				return false;
		});
    
		$("#registerBtn").on('click', function() {;
					 var user = $('#rUsername').val();
					 var pass = $('#rPassword').val();
					 var cPass = $('#rcPassword').val();
					 $.post("scripts/register.php", {
									 username: user,
									 password: pass,
									 cPassword: cPass,
							 })
							 .done(function(result, status, xhr) {
								 
									 if (result == "success") {
                     $("#regStatus").replaceWith("<center><h2>Success</h2></center>");
									 } 
									 
									 if (result == "This username is already taken") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else if (result == "Please enter a password") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
									 else if (result == "Password must have atleast 6 characters") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else if (result == "Please confirm password") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
									 else if (result == "Password did not match") {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 } 
									 else {
										 document.getElementById("error").innerHTML = result;
										 document.getElementById("error").style.display = "block";
									 }
							 });
			 });
		
var olModal = document.getElementById("loginLinkForm");
var orModal = document.getElementById("registerLinkForm");

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == olModal) {
    olModal.style.display = "none";
  }
	if (event.target == orModal) {
		orModal.style.display = "none";
	}
}

function register() {
   orModal.style.display = "block";
}
function close() {
  orModal.style.display = "none";
	olModal.style.display = "none";
}
</script>
