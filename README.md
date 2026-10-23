# Market_App

A simple PHP-based marketplace web application for listing and browsing products, services, and rentals in a local area. Users can search listings by keyword, category, and city, while advertisers can register, log in, and create new listings with images.

## Features

- Browse listings by category:
  - Products
  - Services
  - Rentals
- Search listings by:
  - keyword
  - category
  - city
- Advertiser registration and login
- Create, edit, and delete listings
- Upload product/service images
- View listing details
- Responsive front-end for basic marketplace browsing

## Tech Stack

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Apache / local web server

## Project Structure

```text
Market_App/
├── index.php                  # Homepage and main search page
├── products.php               # Product listings page
├── services.php               # Service listings page
├── rentals.php                # Rental listings page
├── advertiser_dashboard.php   # Advertiser dashboard
├── category_listings.php      # Category-specific listing UI
├── css/                       # Stylesheets
├── js/                        # JavaScript files
├── images/                    # Application images and uploaded listing images
├── php/
│   ├── config.php            # Database configuration
│   ├── functions.php          # Shared helper functions
│   ├── create_listing.php     # Create listing form and logic
│   ├── edit_listing.php       # Edit listing logic
│   ├── delete_listing.php     # Delete listing logic
│   ├── listing_details.php    # Individual listing details page
│   ├── login.php              # Advertiser login/registration page
│   ├── logout.php             # Logout functionality
│   ├── search.php             # Search logic
│   ├── send_message.php       # Messaging functionality
│   └── upload.php             # Upload processing
└── README.md
```

## Requirements

Before running the app, make sure you have:

- PHP 7.4+ (or newer)
- MySQL database server
- Apache or another local web server
- A local PHP environment such as:
  - XAMPP
  - WAMP
  - MAMP
  - Laragon

## Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/hlayiseko01/Market_App.git
```

2. Move the project into your web server root:

- XAMPP: `htdocs`
- WAMP: `www`
- MAMP: `htdocs`

3. Configure your database connection in `php/config.php`.

Example:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'your_password');
define('DB_NAME', 'market_app');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
```

4. Create the required MySQL database and tables.

Example schema:

```sql
CREATE DATABASE market_app;
USE market_app;

CREATE TABLE advertisers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    suburb VARCHAR(100)
);

CREATE TABLE listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES advertisers(id)
);
```

5. Start your local web server.

6. Open the app in your browser:

```text
http://localhost/Market_App/
```

## How It Works

### Customer Flow

- Open the homepage.
- Search for a listing by keyword, category, or city.
- View category pages such as products, services, or rentals.
- Open a listing to see details.

### Advertiser Flow

- Go to the advertiser login/register page.
- Register a new account.
- Log in to the dashboard.
- Create a new listing.
- Upload an image and set a category and price.
- Publish the listing for browsing.

## Important Notes

- The app currently uses a local MySQL configuration and is intended for local development.
- The database credentials in `php/config.php` should be updated before deployment.
- The project is a basic prototype and could be improved with:
  - validation and stronger security practices
  - user roles and permissions
  - admin management panel
  - better search/filtering
  - REST API or modern front-end framework
  - environment variables for configuration

## Security Reminder

This project is not production-ready as-is. To improve security before deployment, consider:

- moving database credentials to environment variables
- validating and sanitizing all user input more strictly
- using prepared statements consistently everywhere
- hashing and securing session management properly
- avoiding hardcoded credentials in source files
- restricting file upload types and sizes

## Future Improvements

- Add admin moderation for listings
- Add categories and subcategories
- Add map-based location search
- Improve UI/UX with a modern styling system
- Add user profile pages
- Add messaging between buyers and sellers
- Add pagination and sorting

## License

This project does not currently include a license file. If you want to publish it publicly, you may want to add one such as MIT or Apache 2.0.

## Author

Market_App by hlayiseko01

## Contributing

Contributions are welcome. If you want to improve the project:

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request

---

If you want, I can also generate:
- a more polished README with badges and screenshots
- a README in Afrikaans or English
- a version tailored for GitHub with a cleaner project presentation
- a database setup file (`database.sql`) for this app
