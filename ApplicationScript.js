const burgerImage =document.getElementById('burgerMenu');
const burgerLinks = document.getElementById('burgerLinks');

//addEventListener() checks if the burger menu icon is clicked. If it is, toggle() and classList() add a class name to burgerLinks which can be used to add specific styles in CSS when it is triggered (W3schools, 2025).
burgerImage.addEventListener('click', () => {
	console.log("clicked");
	burgerLinks.classList.toggle('active');
});

//Validating the log in credentials
function validateLogIn(){
	
	//Retrieving values from the input elements
	let email=document.getElementById("email").value;
	let pass=document.getElementById("password").value;
	
	//If any of the values are missing, stop the form submission
	if(email===undefined || email===null || email===""){
		displayError("Please enter an email",'loginErrorMessage');
		return false;
	}
	
	if(pass===undefined || pass===null || pass===""){
		displayError("Please enter a password.",'loginErrorMessage');
		return false;
	}

	return true;
		
}

//Validating user registration
function validateRegistration(){
	
	//Retrieving values from input elements
	let email=document.getElementById("email2").value;
	let name=document.getElementById("name2").value;
	let pass=document.getElementById("password2").value;
	let confirmPassword=document.getElementById("confirmPassword").value;
	let homeAddress=document.getElementById("homeAddress").value;
	
	//In case any of the input elements are empty, stop the form submission
	if(email===undefined || email===null || email===""){
		displayError("Please enter an email",'registrationError');
		return false;
	}
	
	if(name===undefined || name===null || name===""){
		displayError("Please enter a username.",'registrationError');
		return false;
	}
	
	if(pass===undefined || pass===null || pass===""){
		displayError("Please enter a password.",'registrationError');
		return false;
	}
	
	if(confirmPassword===undefined || confirmPassword===null || confirmPassword===""){
		displayError("Please confirm your password.",'registrationError');
		return false;
	}
	
	if(homeAddress===undefined || homeAddress===null || homeAddress===""){
		displayError("Please enter a home address.",'registrationError');
		return false;
	}
	
	//If the password is less than 8 characters, stop the form submission
	if(pass.length<8){
		displayError("Your password must contain 8 or more characters.","registrationError");
		return false;
	}
	
	//If the password is not the same as the confirmation password, stop the form submission
	if(pass!==confirmPassword){
		displayError("The two passwords do not match.","registrationError");
		return false;
	}
	
	//If all the above are okay, procede to submitting the form
	return true;
	
}

//Validating new item reviews before form submissions
function validateReview(){
	
	//Checking whether the user is logged-in 
	let logInStatus=document.getElementById("logInIndicator").innerText;
	
	if(logInStatus==='true')
		console.log("not logged in");
	else{
		displayError("Please sign-in first.",'errorMessage');
		return false;
	}
	
	//Retrieving form values
	let title=document.getElementById("reviewTitle").value;
	let score=document.getElementById("reviewScore").value;
	let desc=document.getElementById("reviewDescription").value;
	
	//Ending the process if any of the input elements were left empty
	if(tittle==='' || title===undefined || title===null){
		displayError("Please provide a title for your review.",'errorMessage');
		return false;
	}
	
	if(score==='' || score===undefined || score===null){
		displayError("Please provide a score.",'errorMessage');
		return false;
	}
	
	if(desc==='' || desc===undefined || desc===null){
		displayError("Please provide a description for your review.",'errorMessage');
		return false;
	}
	
	//If the provided error was outside of the 1-5 range, stop the process and display an appropriate message
	if(score>5 || score<0){
		displayError("The score must be between 1 and 5.",'errorMessage');
		return false;
	}
	
	return true;
	
}

//Function which displays client-side valisdation errors
function displayError(error,id){
	let block=document.getElementById(id);
	block.innerHTML="<p>"+error+"</p";
}

//document.getElementById("selector").addEventListener('change',changeProducts());

function changeProducts(){
	
	//Accessing the value in the <select> element
	let selected=document.getElementById("selector").value;
	let products=document.getElementById("products").children;
	console.log(products.length);
	
	console.log(selected);
	console.log(products);
	
	/*Using switch() to change the products based on the user's choice. For every option, a for loop is used to iterate through the tshirts array and check which product has the specified stock status. If it matches that of the user's choice it is displayed using .style.display="block", otherwise it is hidden with style.display="none"*/
	switch(selected){
		
		case "In stock":
		for(let i=0; i<products.length; i++){
			
			let value=products[i].getAttribute("value");
			
			if(value==="out-of-stock")
				products[i].style.display="none";
			else
				products[i].style.display="flex";
		}
		
			break;
		
		case "Out of stock":
		for(let i=0; i<products.length; i++){
			let value=products[i].getAttribute("value");
			
			if(value==="good-stock" || value==="low-stock")
				products[i].style.display="none";
			else
				products[i].style.display="flex";
		}
		
			break;
		
		//By deafult, all products are shown
		default:
		for(let i=0; i<products.length; i++)
			products[i].style.display="flex";
	}
}

//Validating whether the user can add an item to the cart
function validateAddToCart(stock){
	
	//Checking whether the user is logged-in
	//Ending the process if not
	let logInStatus=document.getElementById("logInIndicator").innerText;
	
	if(logInStatus==='false'){
		console.log(logInStatus);
		alert("Please sign in first.");
		window.location.href="login.php";
		return false;
	}

	//Ending the process if the product is not in stock
	if(stock==="out-of-stock"){
		alert("This product is not in stock.");
		return false;
	}
	
	alert("Item added to your cart.");
	return true;
	
}

// When the user clicks on the button, the user is taken back to the top
//Code used from W3schools.
function goToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0; 
}