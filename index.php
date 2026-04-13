<!--This HTML document contains all the code used to create the homepage of the shop-->
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Homepage</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="Styling.css" type="text/css">
		<script src="ApplicationScript.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		
		<!--This section displays a header which contains the university logo, navigation links and a burger menu for smaller devices-->
		
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
		
			<div id="indexMain">
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