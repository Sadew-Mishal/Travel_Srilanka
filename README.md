# Travel Sri Lanka

First-year first-semester web project for a Sri Lanka travel website.

## Project structure

```text
Travel_Srilanka 1.0/
|-- index.html
|-- login.html
|-- booking.html
|-- booking-copy.html
|-- backend/
|-- database/
|-- uploads/
|-- assets/
|   |-- css/
|   |   `-- styles.css
|   |-- js/
|   |   `-- main.js
|   `-- images/
|       |-- gallery/
|       `-- other website images
|-- PHP_EXPLANATION.md
`-- README.md
```

## Main files

- `index.html` - home page
- `login.html` - login and sign-up page
- `booking.html` - tour booking page
- `booking-copy.html` - second copy of the tour booking page
- `backend/` - PHP files for register, login, contact, and booking
- `database/schema.sql` - MySQL database and table setup
- `uploads/receipts/` - uploaded bank transfer receipts
- `PHP_EXPLANATION.md` - beginner PHP explanation for this project
- `assets/css/styles.css` - home page styles
- `assets/js/main.js` - home page JavaScript
- `assets/images/` - all image files

## PHP and MySQL setup

1. Start Apache and MySQL using XAMPP.
2. Import `database/schema.sql` into MySQL or phpMyAdmin.
3. Check the database username/password in `backend/db.php`.
4. Open the site through `http://localhost/...`, not by double-clicking the HTML file.
