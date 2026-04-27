# CO1418 Assignment 2
## Alexandros Kyriakou
## G21304277
### Homepage URL: https://vesta.uclan.ac.uk/~akyriakou6/Semester2_Assignment/index.php
### GitHub Repository: https://github.com/AlexandrosK2114/CO1418_Assignment2
### Dummy email: dummy@uclan.ac.uk
### Dummy password: dummy2114
## Project information:
1. This file contains information about my solution for assignment 2 of the CO1418 module.
2. All files were updated to PHP and contain a connection to the Vesta server and database via the conn.php file.
3. Index page presents all available offers from the database via sql queries.
4. Index page presents a welcoming message for logged-in users.
5. All forms go through client-side validation before proceeding to the server via javascript, to avoid input errors.
6. Log in form evaluates whether the inserted email exists inside the database via sql query.
7. Log in form evaluates whether the inserted password matches the hashed password.
8. Registraition form utilises server-side validation to check if a username or email already exists inside the database.
9. Registration form utilises server-side functionality to has the inserted password and store it in an encrypted format.
10. Password validation prevents users from adding a password with less than 8 characters.
11. Logged-in users are presented with a 'Sign Out' link in the navigation menu, whereas guests with a 'Sign In' link.
12. Sessions and the $_SESSION superglobal array are utilised to keep track of whether a user has signed in.
13. Products are presented in the products page by quering the tbl_products inside the database.
14. The user is redirected to the login page if they try to add a product inside their cart without being logged-in.
15. Client side validation is used to check if a product is in store using its stock status in Javascript.
16. The GET method is utilised to view a product inside the item page by adding the its ID in the query string.
17. The item page presents the product using its ID retrieved from the GET method.
18. Within the item page, users may add the product in their cart, if logged-in.
19. Client-side validation is used once again to check whether the product is in stock.
20. The item page calculates and presents the products average score by querying the tbl_reviews of the database.
21. The item page presents all product reviews by querying the tbl_reviews of the database.
22. The item page contains a form for adding new reviews for the depicted product via the POST method.
23. A review is added by querying the tbl_reviews of the database and adding new records.
24. When the user is logged-in and chooses to add their first item into their cart, an array is created to house all product IDs the user chooses. This array is encoded with json format and stored as cookie.
25. Whenever the user wants to add a new product into their cart, the cart cookie is retrieved via $_COOKIE, decoded from its json format. The new ID is then pushed into the array.
26. The cart page retrieves the cart array from $_COOKIE and iterates through the saved `product IDs. For each iteration, a query is executed to tbl_prodcucts to retrieve its information.
27. The total price is calculated.
28. The user may press the 'Complete Order' button to submit their order. Upon doing so, a new record is inserted into tbl_orders with all the product IDs stored in the cart array. An appropriate message stating the successful creation of the order is also presented.
29. The cart cookie is deleted when the user logs off or when an order is created.
30. The cart page also contains a discount code form, which unfortunately does not work.
31. Security Considerations:
    1. All forms utilise the POST method to transmit data.
    2. htmlspecialchars() is utilised whenever data is retrieved from GET method variables.
    3. All queries to the database are prepared and binded to parameters before being executed.
    4. Only hashed passwords are saved into the database.
    5. No password below 8 characters can be added into the database.


