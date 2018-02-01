#### checkout my new ecommerce project [here](https://github.com/davidtrushkov/marketplace)  ####

# store
A ecommerce store using Laravel 5.2


This is a e-commerce store I made mostly using Laravel 5.2. This store is a fully functional e-commerce store with a full back-end,
where admins can create categories, brands, products (along with images) and an admin dashboard. It has a full Stripe integration, 
along with the a shopping cart, checkout, quantity items tracking, user functionality and more.


### FUNCTIONALITY: ###

* Browse through products by category, brand, or search bar.
* Search by specific product traits.
* Update your cart, checkout.
* Process billing through Stripe.
* Admin features.
* Full Admin dashboard.
* Post products, brands, categories, and control quantity.
* Ability to use Test Admin user.


### CODE USED: ###

* Laravel 5.2.
* PHP/mySQL.
* Javasrcipt/jQuery.
* HTML/CSS/SASS/LESS.
* Bootstrap/Boostrap MD.


#### Things to change when downloaded ####

*You will need to make an account with [Stripe] (https://stripe.com/) and google anaylitics to use keys required for this website*

* Go into .env file and change Database AND Email credentials.
* Go to config/mail.php, and change email credentials.
* Go to app/Http/Controllers/OrderController.php, Line 107 ( change Stripe secret key to your own Stripe secret key ).
* Go to resources/views/admin/dash.blade.php and change  -- YOUR CLIENT ID HER -- for google analytics.
* Go to resources/views/app.blade.php and change  -- YOUR CLIENT ID HER -- for google analytics AND your Stripe publish key to your own publish key.


Live website demo here:
[here] (http://davidtrushkov.com/store/)
( http://davidtrushkov.com/store/ ) 

*If you want to see admin area, click on Login and it will tell the email and password to use*

## How to set this project up ##

+ Rename root folder to store.
+ Root into store/src directory and call "php artisan key:generate" to generate new key.
+ Create a database, and migrate tables.
+ Add credentials to the .env file including email details.
+ To make someone admin, go into users table and insert 1 under admin column.
+ --- to verfiy user, make sure to set token column to NULL and verifed to 1 if your on `localhost`.
