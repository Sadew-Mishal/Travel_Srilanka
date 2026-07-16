<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Travel Sri Lanka</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e88e5, #2ecc71);
            padding: 20px;
        }

        .admin-login {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 8px;
            text-align: center;
        }

        p {
            color: #666;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2ecc71;
            color: #fff;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
        }

        .back-link {
            display: block;
            margin-top: 18px;
            color: #1e88e5;
            text-align: center;
            text-decoration: none;
        }

        .error {
            background: #ffecec;
            color: #c0392b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <main class="admin-login">
        <h1>Admin Login</h1>
        <p>Access bookings, users, and contact messages.</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Invalid admin email or password.</div>
        <?php endif; ?>

        <form action="backend/admin_login.php" method="POST">
            <label for="email">Admin Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <a class="back-link" href="index.html">Back to website</a>
    </main>
</body>
</html>
