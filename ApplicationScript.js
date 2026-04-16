const burgerImage =document.getElementById('burgerMenu');
const burgerLinks = document.getElementById('burgerLinks');

//addEventListener() checks if the burger menu icon is clicked. If it is, toggle() and classList() add a class name to burgerLinks which can be used to add specific styles in CSS when it is triggered (W3schools, 2025).
burgerImage.addEventListener('click', () => {
	console.log("clicked");
	burgerLinks.classList.toggle('active');
});
