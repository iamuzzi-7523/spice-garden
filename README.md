# 🍽️ Spice Garden — Restaurant Reservation System

Spice Garden is a PHP and MySQL-based restaurant reservation web application. It allows users to create an account, log in securely, browse the restaurant menu, add dishes to a virtual table, make a reservation, and view their previous reservations.

The project was developed as a full-stack web development project using PHP, MySQL, HTML, and CSS, with a focus on authentication, session management, database interaction, and basic web security.

## ✨ Features

- User registration and account creation
- Secure password hashing
- User login and password verification
- Session-based authentication
- Protected pages for authenticated users
- Restaurant menu with multiple food categories
- Add dishes to a virtual table
- Remove individual dishes from the table
- Calculate the total price of selected dishes
- Restaurant reservation form
- Store reservations in MySQL
- Store reservation items separately
- Reservation confirmation page
- View previous reservations
- Logout and session destruction
- CSRF token protection for cart operations
- Prepared SQL statements for user registration and login
- Environment-based database configuration
- UTF-8 (`utf8mb4`) database connection

## 🛠️ Technologies Used

| Technology | Purpose                                 |
| ---------- | --------------------------------------- |
| PHP 8.2    | Backend application logic               |
| MySQL      | Database management                     |
| HTML5      | Page structure and forms                |
| CSS3       | Styling and visual design               |
| Apache     | Local web server                        |
| XAMPP      | Local PHP/MySQL development environment |
| Git        | Version control                         |
| GitHub     | Source code hosting                     |

## 🔐 Security Measures

The project includes several security improvements implemented during development:

- Passwords are stored using PHP's `password_hash()`.
- Passwords are verified using `password_verify()`.
- User registration and login use prepared SQL statements.
- Session-based authentication protects restricted pages.
- Session cookies are configured with `HttpOnly`.
- Session cookies use `SameSite=Lax`.
- Session strict mode is enabled through the session configuration.
- CSRF tokens are used for protected cart operations.
- Database credentials are stored outside the repository using environment variables.
- `.env` is excluded from Git through `.gitignore`.
- User-controlled output displayed in the cart is escaped using `htmlspecialchars()`.

## 🗄️ Database

The application uses a MySQL database named:

```text
spicegarden_db
```

The database contains three main tables:

### `users`

Stores registered user accounts.

```text
user_id
username
email
password
```

### `reservations`

Stores restaurant reservation information.

```text
reservation_id
username
people_count
reservation_time
notes
```

### `reservation_items`

Stores the dishes associated with each reservation.

```text
reservation_id
dish_name
price
```

The database schema is included in:

```text
database/schema.sql
```

## 📂 Project Structure

```text
spice-garden/
│
├── database/
│   └── schema.sql
│
├── images/
│   ├── Chef's/
│   ├── Dishes/
│   └── Restaurant/
│
├── about.php
├── add_to_cart.php
├── cart.php
├── checkout.php
├── config.php
├── index.php
├── Login.html
├── Login.php
├── logout.php
├── menu.php
├── remove_item.php
├── session_config.php
├── SignUp.html
├── SignUp.php
├── style.css
├── success.php
├── view_reservations.php
│
├── .env.example
├── .gitignore
└── .hintrc
```

## 🚀 Application Flow

```text
User
 │
 ├── Sign Up
 │      ↓
 │   Account Created
 │
 ├── Login
 │      ↓
 │   Authenticated Session
 │
 └── Menu
        ↓
   Select Dishes
        ↓
   Your Table / Cart
        ↓
   Checkout
        ↓
   Enter Reservation Details
        ↓
   Reservation Created
        ↓
   Success Page
        ↓
   View Reservations
```

## 💻 Running the Project Locally

### Requirements

Before running the project, install:

- XAMPP
- Apache
- MySQL
- PHP 8.x

### 1. Clone the repository

```bash
git clone https://github.com/iamuzzi-7523/spice-garden.git
```

### 2. Place the project in XAMPP

Move the project folder into the XAMPP `htdocs` directory.

Example:

```text
D:\Applications\Xampp\Xampp\htdocs\spice-garden
```

### 3. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Create the database

Create a MySQL database named:

```text
spicegarden_db
```

### 5. Import the database schema

Import the following file into the database:

```text
database/schema.sql
```

### 6. Configure the database connection

Create a `.env` file in the project root based on `.env.example`.

Example:

```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=spicegarden_db
```

> Do not commit the `.env` file to GitHub. It is intentionally excluded through `.gitignore`.

### 7. Start the application

Open the following URL in your browser:

```text
http://localhost/spice-garden/
```

## 🔑 Main Application Pages

| File                    | Purpose                           |
| ----------------------- | --------------------------------- |
| `index.php`             | Home page                         |
| `about.php`             | About page                        |
| `menu.php`              | Restaurant menu                   |
| `SignUp.php`            | User registration processing      |
| `Login.php`             | User authentication               |
| `logout.php`            | Logout and session destruction    |
| `add_to_cart.php`       | Adds a dish to the session cart   |
| `cart.php`              | Displays selected dishes          |
| `remove_item.php`       | Removes a selected dish           |
| `checkout.php`          | Processes restaurant reservations |
| `success.php`           | Displays reservation confirmation |
| `view_reservations.php` | Displays previous reservations    |
| `config.php`            | Database connection               |
| `session_config.php`    | Session security configuration    |

## 🧪 Tested Functionality

The following functionality was tested during development:

- User registration
- Duplicate email handling
- User login
- Password verification
- Authentication-protected pages
- Adding dishes to the table
- Removing dishes from the table
- Cart total calculation
- Checkout and reservation creation
- Reservation confirmation
- Cart clearing after successful reservation
- Viewing reservations
- Protection against accessing restricted pages without login
- Invalid reservation ID handling
- SQL injection cleanup using prepared statements
- Session security configuration
- Git repository tracking and `.env` exclusion

## 📌 Project Status

**Completed**

The current version is a functional local restaurant reservation system developed for learning and portfolio purposes.

## 👨‍💻 Author

**Mohammed Uzair**

Student Developer

## 📄 License

This project was created for educational and portfolio purposes.
