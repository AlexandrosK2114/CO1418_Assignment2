<!--This HTML document contains all the code used to create the homepage of the shop-->
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Homepage</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="GeneralStyling.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		
		<!--This section displays a header which contains the university logo, navigation links and a burger menu for smaller devices-->
		
		<header>
				
			<img class="headerLogo" src="resources/images/logo_reverse.png" alt="University of Lancashire logo">
				
			<h1 class="headerHeading">Student Shop</h1>
					
			<!--Navigation links to the other pages of the store, displayed for devices with large screens (tablets and desktop)-->
			<nav id="headerNav">
				<a href="Index.html" class="headerLink">Home  </a>
				<a href="Products.html" class="headerLink">Products</a>
				<a href="Cart.html" class="headerLink">Cart  </a>			
			</nav>
				
			<!--Burger menu displayed for devices with smaller screens (phones). When the burger menu is present, the above links 
			disappear-->
			<!--Division is used to create a background for the burger menu's icon and the spans the small bars inside it-->
			<div id="burgerMenu">
				<span></span>
				<span></span>
				<span></span>
			</div>
			
			<!--These links appear when the burger menu icon is clicked. They are seperate from the other contents of the header as to not
			be part of the flexbox. In devices with large screens both the burger menu and its links disappear and the main navigation links above appear-->
			<nav id="burgerLinks">
				<a href="Index.html">Home</a>
				<a href="Products.html">Products</a>
				<a href="Cart.html">Cart</a>				
			</nav>
				
			<!--Script element which connects the Index page to the ApplicationScript.js file, to check whenever the burger menu icon
			is clicked-->
			<script src="ApplicationScript.js"></script>
				
		</header>
		
		<main>
			
			<!--Videos are displayed into the Index page using the <iframe> element. One of them displays a video from the "resources" file and the other from UCLan's website-->
		
			<h2>Where opportunity creates success</h2>
			
			<p>Every student at The University of Central Lancashire is automatically a member of the Students' Union.<br>
			   We have to make life better for students inspiring you to succeed and achieve your goals.
			</p>
			
			<h4>Together</h4>
			
			<p><iframe src="resources/video/video.mp4" class="indexVideo" title="University of Lancashire video"></iframe></p>
			
			<h4>Join Our Global Community</h4>
			
			<p><iframe title="vimeo-player" src="https://player.vimeo.com/video/1071072056?h=d4263dcc56" class="indexVideo" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"   allowfullscreen></iframe></p>
				
		</main>
		
		<footer>
				
			<div>
				<h4 class="footerHeading">Links</h4>
				<p class="footerText"><a class="footerLink" href="https://www.lancashiresu.co.uk/">Student Union Page</a></p>
			</div>
		
			<div>
				<h4 class="footerHeading">Contact Us</h4>
				<p class="footerText">Telephone: +44 (0)1772 201201</p>
				<p class="footerText">Email: suinformation@uclan.ac.uk</p>
			</div>
			
			<div>
				<h4 class="footerHeading">Location</h4>
				<p class="footerText">Preston, Lancashire, UK, PR1 2HE</p>
			</div>
				
		</footer>
	
	</body>
	
</html>