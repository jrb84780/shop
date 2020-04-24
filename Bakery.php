<?php
function Connect(){
    $dbhost = "www.math-cs.ucmo.edu";
    $dbuser = "cs4130_sp2020";
    $dbpass = "tempPWD!";
    $dbname = "cs4130_sp2020";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);
    echo "Connected";
    return $conn;
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $fname = $_REQUEST["fname"];
    if (empty($fname))
        echo "please type in a name";
    $addr = $_REQUEST["addr"];

    $loafType = $_REQUEST["loafType"];
    if (empty($loafType))
        $loafType=null;
    $loafNo = $_REQUEST["loafNo"];
    if (empty($loafNo))
        $loafNo=0;

    $bagType = $_REQUEST["bagType"];
    if (empty($bagType))
        $bagType=null;
    $bagNo = $_REQUEST["bagNo"];
    if (empty($bagNo))
        $bagNo=0;

    $kwaType = $_REQUEST["kwaType"];
    if (empty($kwaType))
        $kwaType=null;
    $kwaNo = $_REQUEST["kwaNo"];
    if (empty($kwaNo))
        $kwaNo=0;

    $pepType = $_REQUEST["pepType"];
    if (empty($pepType))
        $pepType=null;
    $pepNo = $_REQUEST["pepNo"];
    if (empty($pepNo))
        $pepNo=0;

    $muffType = $_REQUEST["muffType"];
    if (empty($muffType))
        $muffType=null;
    $muffNo = $_REQUEST["muffNo"];
    if (empty($muffNo))
        $muffNo=0;

    $cookType = $_REQUEST["cookType"];
    if (empty($cookType))
        $cookType=null;
    $cookNo = $_REQUEST["cookNo"];
    if (empty($cookNo))
        $cookNo=0;

    $dohType = $_REQUEST["dohType"];
    if (empty($dohType))
        $dohType=null;
    $dohNo = $_REQUEST["dohNo"];
    if (empty($dohNo))
        $dohNo=0;

    $kekType = $_REQUEST["kekType"];
    if (empty($kekType))
        $kekType=null;
    $kekNo = $_REQUEST["kekNo"];
    if (empty($kekNo))
        $kekNo=0;

    $total = $_REQUEST["total"];

    //$query ="select * from JDC_Bakery_Orders;";
    $insertQuery="insert into JDC_Bakery_Orders(orderNo,fname,addr,orderTime,loafType,loafNo,bagType,bagNo,kwaType,kwaNo,pepType,pepNo,muffType,muffNo,cookType,cookNo,dohType,dohNo,kekType,kekNo,total) 
            values(DEFAULT,'$fname','$addr',now(),'$loafType','$loafNo','$bagType','$bagNo','$kwaType','$kwaNo','$pepType','$pepNo','$muffType','$muffNo','$cookType','$cookNo','$dohType','$dohNo','$kekType','$kekNo','$total') ";
}
?>
<head>
</head>
<body>
    <h1>Bakery l'Eizineym</h1>
    <h2>Normal</h2>
    <img id="loaf" src="http://pngimg.com/uploads/bread/bread_PNG2311.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="bag" src="http://www.pngpix.com/wp-content/uploads/2016/08/PNGPIX-COM-French-Bread-in-Basket-PNG-Image.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="kwa" src="https://www.stickpng.com/assets/images/580b57fbd9996e24bc43c0a2.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="pep" src="http://www.pngmart.com/files/1/Pepperoni-Pizza-Transparent-Background.png" width="200" height="200" SameSite="None">
    <br><br>
    $2.50&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $3.00&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $3.00&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $4.00
    <br><br>
    <input type="checkbox" id="order1" value="Loaf">I want a <b>loaf</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order2" value="Bag">I want a <b>baguette</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order3" value="Kwa">I want a <b>croissant</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order4" value="Pep">I want a <b>pizza</b>
    <br><br>
    Type:<select>
        <option value="wheatLoaf">Wheat</option>
        <option value="ryeLoaf">Rye</option>
        <option value="pumpLoaf">Pumpernickle</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="normalBag">Normal</option>
        <option value="garlicBag">Garlic</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="normalKwa">Normal</option>
        <option value="garlicKwa">Garlic</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="cheese">Cheese</option>
        <option value="pepperoni">Pepperoni</option>
        <option value="sausage">Sausage</option>
        <option value="supreme">Supreme</option>
    </select>
    <br><br>
    Amount:<input type="number" id="loafNo">
    Amount:<input type="number" id="bagNo">
    Amount:<input type="number" id="kwaNo">
    Amount:<input type="number" id="pepNo">
    <br><br>
    <h2>Treats</h2>
    <img id="muff" src="https://bjambis.com/images/muffin-transparent-blueberry-4.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="cook" src="http://www.pngall.com/wp-content/uploads/2016/07/Cookie-Download-PNG.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="doh" src="http://pngimg.com/uploads/donut/donut_PNG29.png" width="200" height="200" SameSite="None">&emsp;&emsp;
    <img id="kek" src="http://pngimg.com/uploads/chocolate_cake/chocolate_cake_PNG62.png" width="200" height="200" SameSite="None">
    <br><br>
    $1.25&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $0.75&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $1.25&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    $4.00
    <br><br>
    <input type="checkbox" id="order5" value="Muff">I want a <b>muffin</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order6" value="Cook">I want a <b>cookie</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order7" value="Doh">I want a <b>doughnut</b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    <input type="checkbox" id="order8" value="Kek">I want a <b>cake</b>
    <br><br>
    Type:<select>
        <option value="blue">Blueberry</option>
        <option value="straw">Strawberry</option>
        <option value="ban">Banana</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="chip">Chocolate Chip</option>
        <option value="sugarCook">Sugar</option>
        <option value="nut">Peanut Butter</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="chocDoh">Chocolate</option>
        <option value="sugarDoh">Sugar</option>
        <option value="nillDoh">Vanilla</option>
    </select>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
    Type:<select>
        <option value="chocKek">Chocolate</option>
        <option value="nillKek">Vanilla</option>
        <option value="strawKek">Strawberry</option>
    </select>
    <br><br>
    Amount:<input type="number" id="muffNo">
    Amount:<input type="number" id="cookNo">
    Amount:<input type="number" id="dohNo">
    Amount:<input type="number" id="kekNo">
    <br><br>
    <style>
        html {
            background-color: #cccc00;
            background-image:url("https://www.textures.com/system/gallery/photos/Brick/Modern/Brown/121453/BrickSmallBrown0456_3_600.jpg?v=5");
            text-align: center;
        }
        h1 {
            color: darkred;
            font-family: elephant;
            font-size:70px;
        }

        h2 {
            font-family:Showcard Gothic;
            font-size:30px;
        }
        img{
        <!--float:left;-->
        }
        body{
            background-image:url("https://images.freecreatives.com/wp-content/uploads/2016/03/White-Fabric-Texture-Background.jpg");
        }
        p{
            font-size:18px;
        }
    </style>

    <script>
        var total=0.00;

        function calcCost(){
            total=0.00;
            var order1 = document.getElementById("order1").checked;
            if(order1==1){
                var loafNo = document.getElementById("loafNo").value;
                total+=(loafNo*2.5);
            }
            var order2 = document.getElementById("order2").checked;
            if(order2==1){
                var bagNo = document.getElementById("bagNo").value;
                total+=(bagNo*3);
            }
            var order3 = document.getElementById("order3").checked;
            if(order3==1){
                var kwaNo = document.getElementById("kwaNo").value;
                total+=(kwaNo*3);
            }
            var order4 = document.getElementById("order4").checked;
            if(order4==1){
                var pepNo = document.getElementById("pepNo").value;
                total+=(pepNo*4);
            }
            var order5 = document.getElementById("order5").checked;
            if(order5==1){
                var muffNo = document.getElementById("muffNo").value;
                total+=(muffNo*1.25);
            }
            var order6 = document.getElementById("order6").checked;
            if(order6==1){
                var cookNo = document.getElementById("cookNo").value;
                total+=(cookNo*.75);
            }
            var order7 = document.getElementById("order7").checked;
            if(order7==1){
                var dohNo = document.getElementById("dohNo").value;
                total+=(dohNo*1.25);
            }
            var order8 = document.getElementById("order8").checked;
            if(order8==1){
                var kekNo = document.getElementById("kekNo").value;
                total+=(kekNo*4);
            }
            document.getElementById("totalCost").innerHTML = total;
        }
    </script>


<br><br>
<h2>Ready to order?</h2>
Name: <input type="text" name="fname">
Address: <input type="text" name="addr"><br><br>
<button onclick="calcCost()">Calculate cost</button>
Total cost: $<value id="totalCost"></value>
<input type="submit" name="submit" value="Place order!">
<br><br>
<h2>Our Story</h2>
<p>Once upon a time I had too much dough and yeast so I opened a bakery in my apartment despite lack of experience the end</p>
<br><br><br>
</body>