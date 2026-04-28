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
	
	//The following section is executed only when the user is logged-in and a form is submitted using the POST method
	if(isset($_SESSION['logged-in'])){
		if($_SESSION['logged-in']===true){
			if($_SERVER["REQUEST_METHOD"]==="POST"){
				
				//The following are executed only if the item ID is set
				if(isset($_GET['itemID'])){
					
					$itemID=(int)htmlspecialchars($_GET['itemID']);//Retrieving the item ID
					
					if(isset($_POST['action'])){
						
						//The following are executed only when the submitted form relates to adding a new review into the database
						if($_POST['action']==='2'){
							
							//Retrieving required information from the $_SESSION superglobal array
							$user=(int)$_SESSION['userID'];
							$username=$_SESSION['username'];
							
							//Retrieving the information from the form
							$reviewScore=(int)$_POST['reviewScore'];
							$reviewTitle=$_POST['reviewTitle'];
							$reviewDesc=$_POST['reviewDescription'];
							
							//Creating and preparing the sql query
							$sqlQuery="INSERT INTO tbl_reviews (user_id,product_id,review_title,review_desc,review_rating) VALUES(?,?,?,?,?)";
							$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
							//Binding the required parameters to it
							mysqli_stmt_bind_param($sqlResponse,'iissi',$user,$itemID,$reviewTitle,$reviewDesc,$reviewScore);
							mysqli_stmt_execute($sqlResponse);//Executing it
							mysqli_stmt_close($sqlResponse);//Closing it
						}
						//The following are executed only when the submitted form relates to adding an item into the cart
						else if($_POST['action']==='1'){
							
							//Retrieving the product id
							$productID=(int)$_POST['product_ID'];
							
							//If the cart cookie exists, retrieve it
							if(isset($_COOKIE['cart'])){
								$cart=json_decode($_COOKIE['cart']);
								array_push($cart,$productID);
							}
							//If it does not exist, create a new cart
							else{
								$cart=[];
								array_push($cart,$productID);
							}
							//Set the cart cookie. If it already exists it will be overwritten with new IDs
							setCookie('cart',json_encode($cart),time() + (86400 * 30), "/");
						}
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
		<title>Product</title>
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
				
					<?php
						//Execute the rest only if the item ID is set
						if(isset($_GET['itemID'])){
						
							$itemID=(int)htmlspecialchars($_GET['itemID']);//retrieve the id
							$itemScoreSum=0;
							$numOfReviews=0;
							
							//Create a query to retrieve the the ratings of the product
							$sqlQuery="SELECT review_rating FROM tbl_reviews WHERE product_id=?";
							$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
							mysqli_stmt_bind_param($sqlResponse,'i',$itemID);
							mysqli_stmt_execute($sqlResponse);
						
							$result=mysqli_stmt_get_result($sqlResponse);
							
							while($row=mysqli_fetch_array($result)){
								$itemScoreSum+=(int)$row['review_rating'];//add all the ratings
								$numOfReviews++;//find number of ratings
							}
							//Calculate the average rating if the there are ratings
							if($numOfReviews>0){
								$averageScore=number_format(($itemScoreSum/$numOfReviews),1);
							}
							mysqli_stmt_close($sqlResponse);
							
							//Create a query to retrieve the information of the product specified by the retrieved ID
							$sqlQuery="SELECT * FROM tbl_products WHERE product_id=?";
							$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
							mysqli_stmt_bind_param($sqlResponse,'i',$itemID);
							mysqli_stmt_execute($sqlResponse);
						
							if(mysqli_stmt_num_rows($sqlResponse)===0){
								
								$result=mysqli_stmt_get_result($sqlResponse);
								$row=mysqli_fetch_array($result);
								$querySring="?itemID=$itemID";
								
								$productID=$row['product_id'];
								$productStock=$row['product_stock'];
								
								echo "<div id='item'>";
								echo "<img id='itemImage' src='".$row['product_src']."'/>";
								echo "<div id='itemDesc'>";
								echo "<h2>".$row["product_title"]."</h2>";
								
								if($numOfReviews>0)
									echo "<h4>Product Score: $averageScore/5</h4>";
								
								echo "<h4>".$row["product_price"]."&pound;</h4>";
								echo "<p>".$row["product_desc"]."</p>";
								//Creating a from for adding the item to the cart
								echo "<form method='POST' onsubmit='return validateAddToCart(\"".$productStock."\")' action='item.php$querySring'>";
								echo "<input type='hidden' name='action' value='1'>";
								echo "<input type='hidden' name='product_ID' value='$productID'>";
								echo "<input type='hidden' name='product_Stock' value='$productStock'>";
								echo "<button type='submit' class='appButton'>Add to cart</button>";
								echo "</form>";
								echo "</div>";
								echo "</div>";
							}
							else
								echo "error";
							
							mysqli_stmt_close($sqlResponse);
						}
					?>
				
					<!--Form used to add new reviews into the databased for the specified item-->
					<h2>Reviews</h2>
					<form id='reviewForm'class="appForm "method="POST" action="item.php?itemID=<?=$itemID?>" onsubmit="return validateReview()">
						<h2>Add a review</h2>
						<p><label for="reviewScore">Score:</label><input type="number" id="reviewScore" name="reviewScore" min="1" max="5" required/></p>
						<p></label><input type="hidden" name="action" value='2'/></p>
						<p><label for="reviewTitle">Title:</label><input type="text" id="reviewTitle" name="reviewTitle" required/></p>
						<p><label for="reviewDescription">Description:</label><input type="text" id="reviewDescription" name="reviewDescription" required/></p>
						<button class="appButton" type="submit">Submit your review</button>
						<span id="errorMessage"></span>
					</form>
					
					<?php
						//Code which executes only when the item ID is set
						if($itemID){
							//Creating a query which retrieves all the reviews for the item
							$sqlQuery="SELECT * FROM tbl_reviews where product_id=?";
							$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
							mysqli_stmt_bind_param($sqlResponse,'i',$itemID);
							mysqli_stmt_execute($sqlResponse);
							$result=mysqli_stmt_get_result($sqlResponse);
							
							
							if($result){
								if(mysqli_num_rows($result)>0){
									
									//Displaying the information for each review, which was retrieved from the database
									while($row=mysqli_fetch_array($result)){
										
										$userID=(int)$row['user_id'];
										$sqlQuery="SELECT user_name FROM tbl_users WHERE user_id=? LIMIT 1";
										$sqlResponse2=mysqli_prepare($DATABASE,$sqlQuery);
										mysqli_stmt_bind_param($sqlResponse2,'i',$userID);
										mysqli_stmt_execute($sqlResponse2);
										mysqli_stmt_bind_result($sqlResponse2,$userName);
										mysqli_stmt_fetch($sqlResponse2);
										mysqli_stmt_close($sqlResponse2);
										
										echo "<div class='review'>";
										echo "<h4>".$row['review_title']."</h4>";
										echo "<h5>Score:".$row['review_rating']."</h5>";
										echo "<p>".$row['review_desc']."</p>";
										echo "<p>By: $userName</p>";
										echo "</div>";
									}
								}
								//If no reviews exist for the item, display an appropriate message
								else
									echo "<h4>There are no reviews for this product. Be the first to place one.</h4>";
							}
							mysqli_stmt_close($sqlResponse);
						}
					?>
					
					<script src="ApplicationScript.js"></script>
					
				
				</div>
				
				
		</main>
		
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