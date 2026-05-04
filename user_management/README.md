# PHP Signup/Login Project with 60-Second Idle Logout

## Features

- Signup form with username and password
- Stores users in MySQL database
- Passwords are stored securely using `password_hash()`
- Login form validates credentials using `password_verify()`
- Stores logged-in user data in PHP session
- Sets a cookie for login idle time of 60 seconds
- Automatically logs out user after the idle cookie expires

## Setup Steps

1. Copy this folder into your local server directory.

   For XAMPP:

   ```text
   C:\xampp\htdocs\php_login_idle_project
   ```

2. Start Apache and MySQL from XAMPP.

3. Open phpMyAdmin:

   ```text
   http://localhost/phpmyadmin
   ```

4. Import `database.sql`.

5. Check database settings in `config.php`.

   Default:

   ```php
   $host = "localhost";
   $dbname = "php_login_demo";
   $db_user = "root";
   $db_pass = "";
   ```

6. Open the project:

   ```text
   http://localhost/php_login_idle_project/signup.php
   ```

## Test Flow

1. Register a new user.
2. Login using the same username and password.
3. You will be redirected to `dashboard.php`.
4. Stay idle for more than 60 seconds.
5. Refresh the page.
6. You will be redirected to login page with timeout message.

## Important Note

Cookies expire in the browser, but PHP can only redirect the user when the browser makes the next request. That is why the dashboard includes a refresh meta tag after 65 seconds.
