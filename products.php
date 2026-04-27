<?php
	//Including the php file with the database connection
	include 'conn.php';
	
	//A hidden indicator which tells if the user is logged-in or not is created for use in javascript
	if(isset($_SESSION['logged-in'])){
		if($_SESSION['logged-in']===true)
			echo "<span id='logInIndicator'style='display:none;'>true</span>";
	}
	else
		echo "<span id='logInIndicator'style='display:none;'>false</span>";

	//The following are executed only when the user is logged-in
	if(isset($_SESSION['logged-in'])){
		if($_SESSION['logged-in']===true){
			//Execution occurs only when a form is submitted via POST
			//The following code adds the item ID to the cart cookie
			if($_SERVER['REQUEST_METHOD']==='POST'){
				
				$productID=(int)$_POST['product_ID'];
				
				//If the cart cookie exists, retrieve it
				if(isset($_COOKIE['cart'])){
					$cart=json_decode($_COOKIE['cart']);//decoding the JSON format
					array_push($cart,$productID);//add the new ID into the cart
				}
				//If it does not exist, create a new cart
				else{
					$cart=[];
					array_push($cart,$productID);
				}
				//Set the cart cookie. If it already exists it will be overwritten with new IDs
				setCookie('cart',json_encode($cart),time() + (86400 * 30), "/");//encoding the cart array into JSON format
			}
		}
	}
?>
<!--This HTML document contains all the code used to create the homepage of the shop-->
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Products</title>
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
		
			<div>
				<!--Division which contain the filter that allows users to differentiate products from in and out of stock-->
				<div id="filter">
				
					<h2>Products</h2>

					<p>Filter: 
						<select id="selector" onchange="changeProducts()">
							<option value="All products">All products</option>
							<option value="In stock">In stock</option>
							<option value="Out of stock">Out of stock</option>
						</select>
					</p>
				
				</div>
				
				<!--This division is used to display all the product listings-->
				<div id="products">
				<?php
					//Retrieving all the products from the database and displaying them using the following query
					$sqlQuery="SELECT * FROM tbl_products";	

					$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//preparing the query
					mysqli_stmt_execute($sqlResponse);//executing it
					$result=mysqli_stmt_get_result($sqlResponse);//retrieving the result
					mysqli_stmt_close($sqlResponse);//closing the query after retrieval
					
					while($row=mysqli_fetch_array($result)){//retrieving each table record as an array until there are no more
						
						$productID=$row['product_id'];//Retrieving the product id
						$productStock=$row['product_stock'];//Retrieving the product stock
						
						//Displaying each product using each fetched array
						echo "<div class='product' value='".$productStock."'><img src='".$row["product_src"]."' class='listingImage'/>";
						echo "<div class='productDesc'>";
						echo "<h2>".$row["product_title"]."</h2>";
						echo "<h4>".$row["product_price"]."&pound;</h4>";
						echo "<p>".$row["product_desc"]."</p>";
						echo "<p><a href='item.php?itemID=".$row['product_id']."'>View</a></p>";
						echo "<form method='POST' onsubmit='return validateAddToCart(\"".$productStock."\")' action='products.php'>";
						echo "<input type='hidden' name='product_ID' value='$productID'>";
						echo "<input type='hidden' name='product_Stock' value='$productStock'>";
						echo "<button type='submit' class='appButton'>Add to cart</button>";
						echo "</form>";
						echo "</div>";
						echo "</div>";
					}
				
				?>
				</div>
				
			</div>
			
			<!--This is an arrow icon which can be clicked to go to the top of the page.-->
			<img id="arrow" src="resources/arrow_icon.png" alt="Arrow icon used to go to the top of the page" onclick="goToTop()">
		
			<script src="ApplicationScript.js"></script>
			
		</main>
		
		<footer>
				
			<div>
				<h2>Links</h2>
				<p><a class="footerLink" href="https://www.lancashiresu.co.uk/">Student Union Page</a></p>
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