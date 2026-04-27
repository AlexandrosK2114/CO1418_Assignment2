<?php
	//Including the php file with the database connection
	include 'conn.php';
	
	//Execute the following if a form submission occurs
	if($_SERVER["REQUEST_METHOD"]==="POST"){
		
		$error='';
		
		//Execute the following if the form is related to a login
		if(htmlspecialchars($_GET['action'])==='login'){
			
			//Retrieve values from POST superglobal array
			$email=trim($_POST["email"]);
			$password=$_POST["password"];
			
			//Prepare and execute a sql query to check if the email matches one inside the database
			$sqlQuery="SELECT user_id, user_name, user_pass FROM tbl_users WHERE user_email=? LIMIT 1";
			$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//prepare statement
			mysqli_stmt_bind_param($sqlResponse,'s',$email);//bind parameters to the statemnt
			mysqli_stmt_execute($sqlResponse);//execute the statement
			mysqli_stmt_store_result($sqlResponse);//store the result of the database's response

			
			if(mysqli_stmt_num_rows($sqlResponse)===1){//check if there is only 1 entry matching the email
				
				//bind the contents of the table entry to the following variables
				mysqli_stmt_bind_result($sqlResponse,$retrievedID,$retrievedName,$retrievedPass);
				mysqli_stmt_fetch($sqlResponse);
				
				//Using password_verify to ensure the retrieved hashed password is the same as the inserted password
				if(password_verify($password, $retrievedPass)){
					
					//If all is okay, create the session and set session variables
					$_SESSION["username"]=$retrievedName;
					$_SESSION["userID"]=$retrievedID;
					$_SESSION["logged-in"]=true;
					header("Location:index.php");//Redirect user to index page
					exit();//Stop the execution of the rest of the script
				}
				//If the passwords do not match, show an appropriate error
				else{
					$error="Wrong password. Please try again.";
				}
			}
			//If the database returned nothing, notify the user that they must have made a mistake
			else{
				$error="Wrong e-mail or password. Please try again.";
			}
		}
		//Execute the following if the form is related to registration
		else if(htmlspecialchars($_GET['action'])==='register'){
			
			$errors=[];
			$errorExists=false;
			
			//Retrieving all values from POST superglobal array
			$addedName=$_POST['name2'];
			$addedEmail=trim($_POST['email2']);//using trim() to remove spaces, if any exist
			$addedPassword=$_POST['password2'];
			$addedConfirmPassword=$_POST['confirmPassword'];
			$addedHomeAddress=$_POST['homeAddress'];
			
			//Using filter_var() and FILITER_VALIDATE_EMAIL to check if the email is valid
			//Otherwise, stop the process and display an error
			if(!filter_var($addedEmail,FILTER_VALIDATE_EMAIL)){
				$errorExists=true;
				$errors[]="The e-mail address you have provided is not valid";
			}
			
			//Checking if the added password is equal to the confirmation password
			//Otherwise, stop the process and display an error
			if($addedPassword!==$addedConfirmPassword){
				$errorExists=true;
				$errors[]="The passwords do not match.";
			}
			
			//Checking if the added username already exists inside the database
			if(!$errorExists){
				
				$sqlQuery="SELECT user_id FROM tbl_users WHERE user_name=?";
				$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//prepare the query
				mysqli_stmt_bind_param($sqlResponse,'s',$addedName);//bind the added username to it
				mysqli_stmt_execute($sqlResponse);//execute it
				mysqli_stmt_store_result($sqlResponse);//retrieve the result
				
				if(mysqli_stmt_num_rows($sqlResponse)>0){//if the response contains table records then stop the process
					$errorExists=true;
					//Display an appropriate error
					$errors[]="The username you have added is already in use. Choose another one.";
				}
				
				//End the sql query
				mysqli_stmt_close($sqlResponse);
			}
			
			//Checking if the added email is already inside the database
			if(!$errorExists){
				
				$sqlQuery="SELECT user_id FROM tbl_users WHERE user_email=?";
				$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//preparing the query
				mysqli_stmt_bind_param($sqlResponse,'s',$addedEmail);//binding the added email to it
				mysqli_stmt_execute($sqlResponse);//executing it
				mysqli_stmt_store_result($sqlResponse);//storing the result
				
				if(mysqli_stmt_num_rows($sqlResponse)>0){//If the qury yielded any results stop the process
					$errorExists=true;
					$errors[]="The e-mail you have added is already registered.";//Present an appropriate error
				}
				
				mysqli_stmt_close($sqlResponse);
			}
			
			//If all is well, insert the credentials into the tbl_users table of the database
			if(!$errorExists){
				
				//Using password_hash() and PASSWORD_DEFAULT to create a hash of the password and save that instead of the original
				$hashed_password=password_hash($addedPassword, PASSWORD_DEFAULT);
				$sqlQuery="INSERT INTO tbl_users (user_name,user_email,user_pass,user_address) VALUES(?,?,?,?)";
				$sqlResponse=mysqli_prepare($DATABASE,$sqlQuery);//preparing the query
				mysqli_stmt_bind_param($sqlResponse,"ssss",$addedName,$addedEmail,$hashed_password,$addedHomeAddress);//binding all the data to it
				mysqli_stmt_execute($sqlResponse);//executing it
				
				if($sqlResponse){
					$success=true;
				}
				else
					$success=false;
				
				mysqli_stmt_close($sqlResponse);
				
			}
		}
	}
?>
<!--This HTML document contains all the code used to create the homepage of the shop-->
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Sign-In</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="Styling.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	
	<body>
		
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
			
			<!--These links appear when the burger menu icon is clicked. #In devices with large screens both the burger menu and its links disappear and the main navigation links above appear-->
			<nav id="burgerLinks">
				<a href="index.php">Home</a>
				<a href="products.php">Products</a>
				<a href="cart.php">Cart</a>
				<a href="login.php">Sign In</a>
			</nav>
				
		</header>
		
		<main>
			
			<!--Message which appears after successful or unsuccessful registration-->
			<?php
			//Execute only when a registration form is submitted
			if($_SERVER["REQUEST_METHOD"]==="POST"){
				if(htmlspecialchars($_GET['action'])==='register'){
					//Display all errors which have occurred
					echo "<div id='registrationMessage'>";
					if($errorExists){
						echo "<h2>Your registration was unsuccessful.</h2>";
						for($i=0; $i<count($errors); $i++)
							echo "<p>".$errors[$i]."</p>";
					}
					//Inform of successful registration
					else{
						if($success)
							echo "<h2>Your registration was succesful. Please sign into your account.</h2>";
						//If any problems occurred with the sql query, echo error to indicate that
						else
							echo"error";
					}
					echo "</div>";
				}
			}
			?>
			
			<!--Main section of the page-->
			<div id="loginContent">
			
				<h2>Sign In</h2>
				<p>Signing into your account allows you to buy merchendise and leave product reviews.</p>
				
				<!--Form used to log in-->
				<form class="appForm" id="loginForm" action="login.php?action=login" method="POST" onsubmit="return validateLogIn()">
				
					<p><label for="email">E-mail Adress: </label><input type="email" id="email" name="email" required></p>
					<p><label for="password">Password: </label><input type="password" id="password" name="password" required></p>
					
					<p><button class="appButton" type="submit">Sign-in</button></p>
					
					<span id="loginErrorMessage">
					<?php
						//Execute only for form submission
						if($_SERVER["REQUEST_METHOD"]==="POST"){
							//Display login error if one has occurred.
							if($error!==""){
								echo "<p>".$error."</p>";
							}
						}
					?>
					</span>
					
				</form>
			
				<h2>Sign Up</h2>
				<p>Not registered? Create a student shop account using the following form.</p>
				
				<!--Form used to registration -->
				<form class="appForm" id="registerForm" action="login.php?action=register" method="POST" onsubmit="return validateRegistration()">
				
					<p><label for="name2">Name:</label><input type="text" id="name2" name="name2" required></p>
					<p><label for="email2">E-mail Adress:</label><input type="email" id="email2" name="email2" required></p>
					<p>Your password should contain at least 8 characters, one uppercase letter, one number and one lowercase letter</p>
					<p><label for="password2">Password:</label><input type="password" id="password2" name="password2" required></p>
					<p><label for="confirmPassword">Confirm Password:</label><input type="password" id="confirmPassword" name="confirmPassword" required></p>
					<p><label for="homeAddress">Home Address:</label><input type="text" id="homeAddress" name="homeAddress" required></p>
					<p><button class="appButton" type="submit">Create Account</button></p>
					<!--Span element used to show client-side validation errors-->
					<span id="registrationError"></span>

				<form>
				
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