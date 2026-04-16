<!--Connecting to database-->
<?php
  $DATABASE=mysqli_connect("localhost","akyriakou6","XvWvBp7Jw7","akyriakou6");
?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Products</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="Styling.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		
		<header>
				
			<img  src="resources/logo_reverse.png" alt="University of Lancashire logo">
				
			<h1 class="headerHeading">Student Shop</h1>
					
			<!--Navigation links to the other pages of the store, displayed for devices with large screens (tablets and desktop)-->
			<nav id="headerNav">
				<a href="index.php" class="headerLink">Home</a>
				<a href="registration.php" class="headerLink">Register</a>
				<a href="products.php" class="headerLink">Products</a>
				<a href="cart.php" class="headerLink">Cart</a>			
			</nav>
				
			<!--Burger menu displayed for devices with smaller screens (phones). When the burger menu is present, the above links 
			disappear
			<img id="burgerMenu" src="resources/burgerIcon.png" alt="Burger Menu Icon">
			
			<!--These links appear when the burger menu icon is clicked. They are seperate from the other contents of the header as to not
			be part of the flexbox. In devices with large screens both the burger menu and its links disappear and the main navigation links above appear
			<nav id="burgerLinks">
				<a href="index.php" class="headerLink">Home</a>
				<a href="registration.php" class="headerLink">Register</a>
				<a href="products.php" class="headerLink">Products</a>
				<a href="cart.php" class="headerLink">Cart</a>				
			</nav>
				
			<!--Script element which connects the Index page to the ApplicationScript.js file, to check whenever the burger menu icon
			is clicked-->
				
		</header>
		
		<main>
		
			<!--Division which contain the filter that allows users to differentiate products from in and out of stock-->
			<div id="filter">
			
				<h2>Products</h2>
				
				<!--Filtering functionality is done with a <select> element. The default value of the element displays all the products. The "onchange" attribute calls the "changeProducts()" function inside the javascript file to alter the displayed products-->
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
				
				$sqlQuery="SELECT * FROM tbl_products";
					
				$sqlResponse=mysqli_query($DATABASE, $sqlQuery);
					
				while($row=mysqli_fetch_array($sqlResponse)){
					
					echo "<img src='".$row["product_src"]."' class='listingImage'/>";
					echo "<h4>".$row["product_title"]."</h4>";
					echo "<p>".$row["product_price"]."</p>";
					echo "<p>".$row["product_stock"]."</p>";
					echo "<p>".$row["product_desc"]."</p>";
					echo "</div>";
				}
			
			?>	
			</div>
			
			<!--This is an arrow icon which can be clicked to go to the top of the page.-->
			<img id="arrow" src="resources/images/arrow_icon.png" alt="Arrow icon used to go to the top of the page" onclick="goToTop()">
			
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