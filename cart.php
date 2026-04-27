<?php
	//Including the php file with the database connection
	include 'conn.php';

	$orderSuccessful=false;
	
	//Retrive the cart cookie if it exists
	if(isset($_COOKIE['cart'])){
		$cart=json_decode($_COOKIE['cart']);
	}
	
	//Execute the following only when the user is logged-in
	if(isset($_SESSION['logged-in'])){
		if($_SESSION['logged-in']===true){
			
			//Execute only upon form submission with POST
			if($_SERVER['REQUEST_METHOD']==='POST'){
				if(isset($_POST['orderComplete'])){
					//Execute only if the form refers to completing an order
					if($_POST['orderComplete']==='1'){
						
						$user=(int)$_SESSION['userID'];//Retrieving the user id from SESSION
						$allIDs='';
						
						//Adding all product ids from the cart into a single string
						for($i=0; $i<count($cart); $i++){
							if($i!==count($cart)-1)
								$allIDs.=$cart[$i].",";
							else
								$allIDs.=$cart[$i];//only for the last product id
						}
						//Creating a query to insert the order into the database
						$sqlQuery="INSERT INTO tbl_orders (user_id,product_ids) VALUES(?,?)";
						$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
						mysqli_stmt_bind_param($sqlResponse,'is',$user,$allIDs);
						
						//If the query was successful, create a session variable to indicate it
						//Delete the cart cookie
						//Reload the page
						if(mysqli_stmt_execute($sqlResponse)){
							$_SESSION['orderSuccessful']=true;
							setcookie('cart',json_encode($cart),time() - (86400 * 30), "/");
							header("Location:cart.php");
							exit();//Do not execute the rest 
						}
						else
							echo "error";
					}
				}
			}
		}	
	}
?>
<!--This HTML document contains all the code used to create the homepage of the shop-->
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Cart</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="Styling.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		
		<!--This section displays a header which contains the university logo, navigation links and a burger menu for smaller devices-->
		
		<header>
			
			<div>
			
				<img id="uclanLogo" src="resources/logo_reverse.png" alt="University of Lancashire logo"/>
					
				<h1 class="headerHeading">Student Shop</h1>
						
				<!--Navigation links to the other pages of the store, displayed for devices with large screens (tablets and desktop)-->
				<nav id="regularLinks">
					<a href="index.php">Home</a>
					<a href="products.php">Products</a>
					<a href="cart.php">Cart</a>
					<?php 
						//If the user is logged-in, a sign out link is displayed
						if(isset($_SESSION['logged-in'])){
							if($_SESSION['logged-in']===true)
								echo "<a href='index.php?logout=1'>Sign Out</a>";
							else
								echo"<a href='login.php'>Sign In</a>";
						}
						//Otherwise a link to the login page is displayed
						else
							echo"<a href='login.php'>Sign In</a>";
					?>			
				</nav>
					
				<!--Burger menu displayed for devices with smaller screens (phones). When the burger menu is present, the above links 
				disappear-->
				<img id="burgerMenu" src="resources/burgerIcon.png" alt="Burger Menu Icon">
			
			</div>
			
			<!--These links appear when the burger menu icon is clicked. They are seperate from the other contents of the header as to not
			be part of the flexbox. In devices with large screens both the burger menu and its links disappear and the main navigation links above appear-->
			<nav id="burgerLinks">
				<a href="index.php">Home</a>
				<a href="products.php">Products</a>
				<a href="cart.php">Cart</a>
				<?php 
					//If the user is logged-in, a sign out link is displayed
						if(isset($_SESSION['logged-in'])){
							if($_SESSION['logged-in']===true)
								echo "<a href='index.php?logout=1'>Sign Out</a>";
							else
								echo"<a href='login.php'>Sign In</a>";
						}
						//Otherwise a link to the login page is displayed
						else
							echo"<a href='login.php'>Sign In</a>";
				?>			
			</nav>
				
		</header>
		
		<main>
			<!--The cart section of the page-->
			<div id="cart">
				
				<?php
				//If an order has been submitted, display an appropriate message
				if(isset($_SESSION['orderSuccessful'])){
					if($_SESSION['orderSuccessful']===true){
						echo "<h2>Your order has been completed.</h2>";
						$_SESSION['orderSuccessful']=false;//Setting the SESSION variable to false to stop displaying the message upon reloading
					}
				}
				?>
				<h2>Your Cart</h2>
				
				<?php
					//Execute only when the cart cookie is set 
					if(isset($_COOKIE['cart'])){
						//Check if the cart has items in it
						if(count($cart)>0){
							$total=0;//variable used to calculate the total price
							
							echo "<ul id='cartList'>";//Creating list element to display the cart items
							
							//Iterating through each id and using it in a query to retrieve the product information
							for($i=0; $i<count($cart); $i++){
								
								$currentID=(int)$cart[$i];
								
								$sqlQuery="SELECT * FROM tbl_products WHERE product_id=?;";
								$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
								mysqli_stmt_bind_param($sqlResponse,'i',$currentID);
								mysqli_stmt_execute($sqlResponse);
								$result=mysqli_stmt_get_result($sqlResponse);
								
								$row=mysqli_fetch_array($result);
								$total+=(float)$row['product_price'];//adding the product's price to the total
								
								//Displaying the product
								echo "<li class='cartItem'>";
								echo "<img class='cartImage' src='".$row['product_src']."'/>";
								echo "<div class='cartItemDesc'>";
								echo "<h2>".$row['product_title']."</h2>";
								echo "<h4>".$row['product_price']."&pound;</h4>";
								echo "<button class='appButton'>Remove</button>";
								echo "</div>";
								echo "</li>";
							}
							echo "</ul>";
							
							//Code for coupon validation (NOT WORKING)
							$couponApplied=false;
							$couponValidated=false;
							
							/*if($_SERVER["REQUEST_METHOD"]==='POST'){
								if(isset($_POST['discountCode'])){
									$code="%".$_POST['discountCode']."%";
									
									$sqlQuery2='SELECT offer_id FROM tbl_offers WHERE offer_desc LIKE ?';
									$sqlResponse2=mysqli_prepare($DATABASE,$sqlQuery2);
									mysqli_stmt_bind_param($sqlResponse2,'s',$code);
									mysqli_stmt_execute($sqlResponse2);
									$result=mysqli_stmt_get_result($sqlResponse2);	
									
									if($result && mysqli_num_rows($result)===1){
										$total=total-total*0.25;
										$couponApplied=true;
										$couponValidated=true;
									}
								}
							}
							
							if($couponValidated){
								echo "<h2>Your discount code has been applied successfully!</h2>";
							}*/
							
							echo "<h4>Your total: $total&pound;</h4>";//Displaying the total price
							
							//Displaying a discount code form if no code has been applied
							if(!$couponApplied){
								echo "<form class='appForm'>";
								echo "<h2>Apply a discount code</h2>";
								echo "<p><input type='text' name'discountCode' id='discountCode'></p>";
								echo "<button class='appButton' type='button'>Validate</button>";
								echo "</form>";
								
								if($_SERVER["REQUEST_METHOD"]==='POST'){
									if(isset($_POST['discountCode'])){
										if(!$couponValidated)
											echo "<h2>Your discount code could not be validated</h2>";
									}
								}
							}
							
							//Displaying a form used to complete the order
							echo "<p><form method='POST' action='cart.php'>";
							echo "<input type='hidden' name='orderComplete' value='1'>";
							echo "<button class='appButton' type='submit'>Complete Order</button>";
							echo "</form></p>";
						}
						//Displaying an appropriate message if the cart is empty
						else{
							echo "<h4>Your cart is empty!</h4>";
							echo "<h4>Start shopping!</h4>";
						}
					}
					//Displaying an appropriate message if the cart cookie is not set
					else{
						echo "<h4>Your cart is empty!</h4>";
						echo "<h4>Start shopping!</h4>";
					}
				?>
				
			</div>
			
		</main>
		
		<script src="ApplicationScript.js"></script>
		
		<footer>
				
			<div>
				<h2>Links</h2>
				<a href="https://www.lancashiresu.co.uk/">Student Union Page</a>
			</div>
		
			<div>
				<h2>Contact Us</h2>
				<p>Telephone: +44 (0)1772 201201</p>
				<p>Email: suinformation@uclan.ac.uk</p>
			</div>
			
			<div>
				<h2>Location</h2>
				<p>Preston, Lancashire, UK, PR1 2HE</p>
			</div>
				
		</footer>
	
	</body>
	
</html>