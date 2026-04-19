<!--Connecting to database-->
<?php
	session_start();
	$DATABASE=mysqli_connect("localhost","akyriakou6","XvWvBp7Jw7","akyriakou6");
	
	if($_SERVER["REQUEST_METHOD"]==="POST"){
		
		$error="";
		
		if($_GET['action']==='login'){
			
			
			$email=trim($_POST["email"]);
			$password=trim($_POST["password"]);
			
			$request="SELECT user_name,user_email,user_pass FROM tbl_users WHERE user_email='$email'";
			$response=mysqli_query($DATABASE,$request,MYSQLI_ASSOC);
			
			$row=mysqli_fetch_assoc($response);
			
			if($row!==null){
				$retrievedEmail=$row["user_email"];
				$retrievedPass=$row["user_pass"];
			
				if($email===$retrievedEmail && $password===$retrievedPass){
					$_SESSION["username"]=$row["user_name"];
					$_SESSION["logged-in"]=true;
					$_SESSION["error"]="";
					header("Location:index.php");
				}
			}
			else{
				$error="Wrong e-mail or password. Please try again";
			}
		}
		else if($_GET['action']==='register'){
			
			$errorExists=false;
			
			$addedName=trim($_POST['name2']);
			$addedEmail=trim($_POST['email2']);
			$addedPassword=trim($_POST['password2']);
			$addedConfirmPassword=trim($_POST['confirmPassword']);
			$addedHomeAddress=$_POST['homeAddress'];
			
			if(!filter_var($addedEmail,FILTER_VALIDATE_EMAIL)){
				$errorExists=true;
			}
			
			if($addedPassword!==$addedConfirmPassword){
				$errorExists=true;
			}
			
			if(!$errorExists){
				
				$request="SELECT user_id FROM tbl_users WHERE user_name='$addedName'";
				$response=mysqli_query($DATABASE,$request);
				
				$row=mysqli_fetch_array($response);
				
				if($row!==null)
					$errorExists=true;
			}
			
			if(!$errorExists){
				
				$request="SELECT user_id FROM tbl_users WHERE user_email='$addedEmail'";
				$response=mysqli_query($DATABASE,$request);
				
				$row=mysqli_fetch_array($response);
				
				if($row!==null)
					$errorExists=true;
			}
			
			if(!$errorExists){
					
				$request="INSERT INTO tbl_users (user_name,user_email,user_pass,user_address) VALUES('$addedName','$addedEmail','$addedPassword','$addedHomeAddress')";
				
				$response=mysqli_query($DATABASE,$request);
				
			}
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
					<a href="login.php">Sign In</a>					
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
				<a href="login.php">Sign In</a>
			</nav>
				
		</header>
		
		<script src="ApplicationScript.js"></script>
		
		<main>
			
			<div id="loginContent">
			
				<h2>Sign In</h2>
				<p>Signing into your account allows you to buy merchendise and leave product reviews</p>
				
				<form id="loginForm" action="login.php?action=login" method="POST">
				
					<p><label for="email">E-mail Adress: </label><input type="email" id="email" name="email" required></p>
					<p><label for="password">Password: </label><input type="password" id="password" name="password" required></p>
					
					<p><button type="submit">Log-in</button></p>
					
					<span id="logInErrorMessage">
					<?php
						if($_SERVER["REQUEST_METHOD"]==="POST"){
							if($error!==""){
								echo "<p>".$error."</p>";
							}
						}
					?>
					</span>
					
				</form>
				
				<h2>Sign Up</h2>
				<p>Not registered? Create a student shop account using the following form</p>
				
				<form id="registerForm" action="login.php?action=register" method="POST">
				
					<p><label for="name2">Full Name:</label><input type="text" id="name2" name="name2"></p>
					<p><label for="email2">E-mail Adress:</label><input type="email" id="email2" name="email2"></p>
					<p>Your password should contain at least 8 characters, one uppercase letter, one number and one lowercase letter</p>
					<p><label for="password2">Password:</label><input type="password" id="password2" name="password2"></p>
					<p><label for="confirmPassword">Confirm Password:</label><input type="password" id="confirmPassword" name="confirmPassword"></p>
					<p><label for="homeAddress">Home Address:</label><input type="text" id="homeAddress" name="homeAddress"></p>
					
					<p><button type="submit">Create Account</button></p>
				
				<form>
				
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