<?php
	session_start();//Starting a session
	$DATABASE=mysqli_connect("localhost","akyriakou6","XvWvBp7Jw7","akyriakou6");//Connecting to the database
	
	//Execute only when the mentioned GET superglobal variable is set
	if(isset($_GET['logout'])){
		//Using a variable sent via GET to indicate log out
		if($_GET['logout']==='1'){

			//Removing all $_SESSION variable values and ending the session
			$_SESSION['logged-in']=false;
			$_SESSION['username']=null;
			$_SESSION['userID']=null;
			
			//Removing the cart cookie 
			if(isset($_COOKIE['cart'])){
				$cart=json_decode($_COOKIE['cart']);
				setcookie('cart',json_encode($cart),time() - (86400 * 30), "/");
			}

			session_destroy();
		}
	}
?>