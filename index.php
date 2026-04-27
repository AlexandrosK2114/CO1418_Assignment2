<?php include 'conn.php';?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Homepage</title>
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
					if(isset($_SESSION['logged-in'])){
						if($_SESSION['logged-in']===true)
							echo "<a href='index.php?logout=1'>Sign Out</a>";
					}
					else
						echo"<a href='login.php'>Sign In</a>";
				?>			
			</nav>
				
		</header>
		
		<script src="ApplicationScript.js"></script>
		
		<main>
			
			<div id="indexMain">
			
				<?php
					//Presenting a welcoming message if the user is logged-in
					if(isset($_SESSION['logged-in'])){
						if($_SESSION["logged-in"]===true){
							echo "<h2>Hello ".$_SESSION['username']."</h2>";
						}
					}
				?>
			
				<h2>Offers</h2>
				
				<div id="offers">
				
				<?php
					//Presenting all the available offers from the database
					$sqlQuery="SELECT * FROM tbl_offers";
					
					$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//preparing the query
					mysqli_stmt_execute($sqlResponse);//executing it
					$result=mysqli_stmt_get_result($sqlResponse);//retrieving the result
					
					while($row=mysqli_fetch_array($result)){//Retrieving each table row as an aerray
						
						//Displaying offer information using the fetched array
						echo "<div class='offer'>";
						echo "<h4>".htmlspecialchars($row['offer_title'])."</h4>";
						echo "<p>".htmlspecialchars($row['offer_desc'])."</p>";
						echo "</div>";
					}
					
					//Closing the query
					mysqli_stmt_close($sqlResponse);
					
				?>
				</div>
			
				<h2>Where opportunity creates success</h2>
				
				<p>Every student at The University of Central Lancashire is automatically a member of the Students' Union.<br>
				   We have to make life better for students inspiring you to succeed and achieve your goals.
				</p>
				
				<h4>Together</h4>
				
				<iframe src="resources/video.mp4" class="indexVideo" title="University of Lancashire video"></iframe>
				
				<h4>Join Our Global Community</h4>
				
				<iframe title="vimeo-player" src="https://player.vimeo.com/video/1071072056?h=d4263dcc56" class="indexVideo" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"   allowfullscreen></iframe>
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