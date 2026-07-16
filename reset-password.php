<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password | Travel Sri Lanka</title>
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

        .reset-card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            padding: 34px;
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
            line-height: 1.5;
            margin-bottom: 22px;
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
            margin-bottom: 16px;
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
            font-weight: bold;
        }

        .message {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 16px;
            text-align: center;
        }

        .error {
            background: #ffecec;
            color: #c0392b;
        }

        .success {
            background: #ecfff3;
            color: #1e8449;
        }

        .note {
            margin-top: 16px;
            font-size: 0.85rem;
            color: #777;
        }
    </style>
</head>
<body>
    <main class="reset-card">
        <h1>Reset Admin Password</h1>
        <p>Enter the admin email and choose a new admin password.</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="message error">
                <?php
                    $messages = [
                        'missing' => 'Please fill all fields.',
                        'invalid_email' => 'Please enter a valid email address.',
                        'password_mismatch' => 'Passwords do not match.',
                        'weak_password' => 'Password must include letters, numbers, and a special character.',
                        'not_found' => 'No admin account found with that email.'
                    ];
                    echo $messages[$_GET['error']] ?? 'Password reset failed.';
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="message success">Password updated. You can log in now.</div>
        <?php endif; ?>

        <form action="backend/reset_password.php" method="POST">
            <label for="email">Admin Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Update Password</button>
        </form>

        <p class="note">Classroom version: this updates only admin passwords directly. In a real website, password reset should use a secure email token.</p>
        <a class="back-link" href="login.html">Back to Login</a>
    </main>
</body>
</html>
