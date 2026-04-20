<!--Connecting to database-->
<?php
	session_start();
	$DATABASE=mysqli_connect("localhost","akyriakou6","XvWvBp7Jw7","akyriakou6");
	
	if(isset($_GET['logout'])){
		if($_GET['logout']==='1'){
			$_SESSION['logged-in']=false;
			$_SESSION['username']='';
			session_destroy();
		}
	}
?>
<!--This HTML document contains all the code used to create the homepage of the shop-->
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
						if(isset($_SESSION['logged-in'])){
							if(htmlspecialchars($_SESSION['logged-in'])===true)
								echo "<a href='index.php?logout=1'>Sign Out</a>";
						}
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
						if(htmlspecialchars($_SESSION['logged-in'])===true)
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
					if(isset($_GET['logged-in'])){
						if($_SESSION["logged-in"]===true){
							echo "<h2>Hello ".htmlentities($_SESSION['username'])."</h2>";
						}
					}
				?>
			
				<h2>Offers</h2>
				
				<div id="offers">
				
				<?php
				
					$sqlQuery="SELECT * FROM tbl_offers";
					
					$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);
					mysqli_stmt_execute($sqlResponse);
					$result=mysqli_stmt_get_result($sqlResponse);
					
					while($row=mysqli_fetch_array($result)){
						
						echo "<div class='offer'>";
						echo "<h4>".htmlspecialchars($row['offer_title'])."</h4>";
						echo "<p>".htmlspecialchars($row['offer_desc'])."</p>";
						echo "</div>";
					}
					
					mysqli_stmt_close($sqlResponse);
					
				?>
				</div>
			
				<h2>Where opportunity creates success</h2>
				
				<p>Every student at The University of Central Lancashire is automatically a member of the Students' Union.<br>
				   We have to make life better for students inspiring you to succeed and achieve your goals.
				</p>
				
				<h4>Together</h4>
				
				<p><iframe src="resources/video.mp4" class="indexVideo" title="University of Lancashire video"></iframe></p>
				
				<h4>Join Our Global Community</h4>
				
				<p><iframe title="vimeo-player" src="https://player.vimeo.com/video/1071072056?h=d4263dcc56" class="indexVideo" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"   allowfullscreen></iframe></p>
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