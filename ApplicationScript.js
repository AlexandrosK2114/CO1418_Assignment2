//Retrieving the divisions which contain the burger menu icon and burger menu links using the querySelector() method
//This section of the script is structured after part 7 of the CSS Media Queries Lab from week 8
const burgerMenu = document.getElementById("burgerMenu");
const burgerLinks = document.querySelector('#burgerLinks');

//addEventListener() checks if the burger menu icon is clicked. If it is, toggle() and classList() add a class name to burgerLinks which can be used to add specific styles in CSS when it is triggered (W3schools, 2025).
burgerMenu.addEventListener('click', () => {
    burgerLinks.classList.toggle('active');
});