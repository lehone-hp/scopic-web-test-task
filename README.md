# Scopic AuctionApp

This repository is made up of two folders(application); the front-end app (`web-app`) and the backend app (`backend`)

## Tools Used

The frontend application was build using `Vuejs v2.x` while the backend application was built with the `Laravel framework` with data being served from `MySQL` database.

## Database Schema

Below is the simple representation of the database schema of the application. Each User has a corresponding UserSetting record which keeps track of; 
- `max_auto_bid` which is the Maximum bid amount allocated for auto-bidding and 
- `auto_bid_reserve` which is the Bid Alert notification used to notify a user when a certain % of the maximum bid amount is reserved for bids.   

![Database Schema](./docs/db-schema.png?raw=true)

# Setup
### Requirements
- Git
- Apache web server
- MySQL database server
- Php ^7.4
- Composer
- Node.js
- npm

To setup the application, first clone this repository
```
git clone https://github.com/lehone-hp/scopic-web-test-task
```

### Backend Setup
Navigate to the `backend` sub-directory
```
cd backend
```

Install dependencies
```
composer install
```
Copy `.env-example` to `.env` and generate application key with 
```
php artisan key:generate
```
then open the `.env` file and setup your database credentials
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<db_name>
DB_USERNAME=<db_user>
DB_PASSWORD=<db_password>
```
Clear application cache so that changes in .env take effect
```
php artisan config:cache
```
Run database migrations and seeders for demo data which will create sample users, products and product categories for testing
```
php artisan migrate --seed
```
Now you can run the backend application with
```
php artisan serve
```

### Frontend Setup
To run the frontend application, 
```
cd web-app
```
Install javascript dependencies with
```
npm install
```
You can change the `Base URL` to the backend server by editing the `VUE_APP_API_BASE_URL` option in the `.env` file in `web-app`.

Now run the application and visit `http://localhost:8080` in your browser 
```
npm run serve
```

# Summary of Main Features
## Login
When the database seeder is run, the application will create 10 sample users with usernames `user1`, `user2`, `user3`,...,`user10`. Each of these users have the password, `password`.

All the pages on the frontend application have been protected with authentication so login is required

Dummy authentication was implemented as opposed to token based authentication

## Home Page – Item’s listing (preferably in gallery view)
Once logged in, the user gets redirected to the Home Page (Item's listing).

On this page, items are read from the backend via API calls and rendered using a grid view. The page contains a filter where
items (products) can be filtered based on
- Sort Order(Closing date and Min bid)
- Min Order
- Product Category

![Home Page](./docs/home-page.png?raw=true)

NB: Product images are rendered from [http://lorempixel.com/](http://lorempixel.com/)

## Item Detail Page
Clicking in `Bid Now` on an item on the Home Page will redirect the user to the Product Detail Page.

This pages displays the following information:
- Item image, name, min bid, the highest bid
- Countdown timer
- Button to place bid
- Prompt to activate auto-bidding for the item

![Product Detail Page](./docs/product-detail.png?raw=true)

## Bid Now functionality
From the Item detail page, the user can Place a Bid by clicking on `Place a bid` button which will open a modal dialog with an input field to enter the amount.

Here, the user is only allowed to place a bid equal to the minimum bid if there is no existing bid for the item or `highest_bid+1` if there is.

If the user is currently the highest bidder, the application prevents the user from out bidding themselves. 

## Auto-bidding functionality
To enable auto-bid for an item, the user has to check the input `Activate the auto-bidding`.

This makes and API call to the backend which does the following.
- If no bid has been made on the item, a minimum bid is made for the user and auto-bid activated
- If at least one bid has been made:
  - Simply Activate auto-bid if user is the highest bidder
  - Outbid the current bid by 1 and activate auto-bid if user is not highest bidder and user has enough funds available for autobidding

### Auto-bidding
Once a user places a bid on an item where multiple users have activated auto-bidding,
the system dispatches an event in the background to run the auto-bidding on the item.

This works by getting all bids that have `auto-bid` activated and who's corresponding user has enough funds to outbid the highest bid.
To prevent a deadlock situation where each auto-bid wants to outbid the highest bid at the same time, precedence is given to the earlier
bids over most recent bids. So giving `BidA`, `BidB`, `BidC` in the order of which they were made, `BidA` attempts to outbid followed by 
`BidB` and the `BidC`.

The process continues until all other auto-bids except one has enough funds to make the highest bid.

### Configuring Auto-bid
On the configuration page, user can set and edit existing `Maximum Bid Amount` and `Bid Alert Notification`.

A notification is displayed on this page if the % of maximum bids has been reserved for bids as shown below.

![Bid Alert Notidication](./docs/reserve-notif.png?raw=true)

## Logout
Clicking on the username in the top-right corner will display a dropdown menu with the option to logout.


# Demo
For convenience, the application has been hosted on [http://auction-app.lehone.net](http://auction-app.lehone.net). 
You can test by logging in with any of the users; `user1`, `user2` ... `user10` as mentioned in [Login Section](#login) 

