# PHP Backend Explanation for Travel Sri Lanka

This project now has a basic PHP + MySQL backend. PHP runs on the server. HTML, CSS, and JavaScript run in the browser.

## What PHP Does Here

PHP receives form data from your website and saves it into MySQL.

In this project:

- `backend/register.php` saves new users.
- `backend/login.php` checks user email and password.
- `backend/contact.php` saves contact form messages.
- `backend/save_booking.php` saves trip bookings.
- `backend/admin_login.php` checks admin login.
- `admin-dashboard.php` shows users, bookings, and contact messages to the admin.
- `backend/db.php` connects PHP to MySQL.
- `database/schema.sql` creates the database tables.

## Database Connection

File: `backend/db.php`

```php
$pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
```

Meaning:

- `$host` is usually `localhost`.
- `$database` is the database name.
- `$username` is the MySQL username.
- `$password` is the MySQL password.
- `PDO` is a safe way to connect PHP with databases.

## Forms and PHP

Example from login:

```html
<form action="backend/login.php" method="POST">
```

Meaning:

- `action` tells the browser which PHP file receives the form.
- `method="POST"` sends the data privately in the request body.

Input names are important:

```html
<input name="email">
```

PHP reads that value like this:

```php
$email = $_POST['email'];
```

## Register

File: `backend/register.php`

It receives:

- name
- email
- password

The password is not saved directly. PHP converts it into a safe hash:

```php
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
```

Then it saves the user:

```php
INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)
```

The question marks are placeholders. They help protect the database from SQL injection.

## Login

File: `backend/login.php`

PHP first finds the user by email:

```php
SELECT id, name, email, password_hash FROM users WHERE email = ?
```

Then it checks the password:

```php
password_verify($password, $user['password_hash'])
```

If the password is correct, PHP stores the user in a session:

```php
$_SESSION['user_id'] = $user['id'];
```

A session remembers the logged-in user while they use the website.

## Contact Form

File: `backend/contact.php`

The contact form sends:

- name
- email
- message

PHP saves those into the `contact_messages` table.

## Booking Form

File: `backend/save_booking.php`

The booking page uses JavaScript to calculate the total price. When the user submits payment details, JavaScript adds hidden inputs to the form:

- selected cities
- vehicle name
- vehicle price
- travel days
- guide option
- total amount
- payment method

PHP receives those values and saves them into the `bookings` table.

For bank transfer, PHP also saves the uploaded receipt image into:

```text
uploads/receipts/
```

## How to Set Up MySQL

1. Open phpMyAdmin or MySQL command line.
2. Import this file:

```text
database/schema.sql
```

3. Check `backend/db.php`.
4. If your MySQL password is not empty, update this line:

```php
$password = '';
```

For XAMPP, the default is often:

```php
$username = 'root';
$password = '';
```

## How to Run the Project

Use a PHP server such as XAMPP.

Put the project inside:

```text
xampp/htdocs/
```

Then open:

```text
http://localhost/Travel_Srilanka 1.0/index.html
```

Do not open PHP-connected pages only by double-clicking the file, because PHP needs a server.

## Main PHP Syntax You Should Know

Variables start with `$`:

```php
$name = 'Sadew';
```

Arrays can store many values:

```php
$_POST['email']
```

`if` checks a condition:

```php
if ($email === '') {
    echo 'Email is required';
}
```

`require_once` imports another PHP file:

```php
require_once 'db.php';
```

`header()` redirects to another page:

```php
header('Location: ../login.html');
exit;
```

`exit` stops PHP after redirecting.

## Important Security Ideas

- Use `password_hash()` for passwords.
- Use prepared statements with `?` placeholders.
- Validate email with `filter_var()`.
- Do not trust form data without checking it.
- Do not store real card details in a student project.

This backend is basic and good for learning. For a real travel company website, payment processing and admin security would need much stronger protection.

## Admin Dashboard

The admin dashboard is separate from normal users.

Admin login page:

```text
admin-login.php
```

Admin dashboard page:

```text
admin-dashboard.php
```

The dashboard starts with this check:

```php
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}
```

Meaning: if the admin is not logged in, PHP redirects them back to the admin login page.

The dashboard reads data from MySQL:

```php
$users = $pdo->query('SELECT id, name, email, created_at FROM users')->fetchAll();
```

It then prints the results in HTML tables.

When displaying database values, it uses:

```php
htmlspecialchars()
```

This helps prevent XSS attacks when showing user-submitted data.
