<?php
require_once 'backend/db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit;
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$users = $pdo->query('SELECT id, name, email, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$messages = $pdo->query('SELECT id, full_name, email, message, created_at FROM contact_messages ORDER BY created_at DESC')->fetchAll();
$bookings = $pdo->query(
    'SELECT b.*, u.email AS user_email
     FROM bookings b
     LEFT JOIN users u ON b.user_id = u.id
     ORDER BY b.created_at DESC'
)->fetchAll();

$totalUsers = count($users);
$totalMessages = count($messages);
$totalBookings = count($bookings);
$totalRevenue = array_sum(array_map(fn($booking) => (float) $booking['total_amount'], $bookings));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Travel Sri Lanka</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
            color: #2c3e50;
        }

        header {
            background: #1f2d3d;
            color: #fff;
            padding: 20px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        header a {
            color: #fff;
            background: #e74c3c;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        main {
            padding: 30px 6%;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
        }

        .stat-card span {
            display: block;
            color: #777;
            margin-bottom: 8px;
        }

        .stat-card strong {
            font-size: 1.7rem;
            color: #1e88e5;
        }

        section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }

        h2 {
            padding: 18px 20px;
            background: #eef5fb;
            color: #1f2d3d;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        th,
        td {
            padding: 13px 15px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #fafafa;
            color: #555;
        }

        .empty {
            padding: 18px 20px;
            color: #777;
        }

        .message-cell {
            max-width: 360px;
            white-space: normal;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Admin Dashboard</h1>
            <p>Logged in as <?php echo e($_SESSION['admin_name']); ?></p>
        </div>
        <a href="backend/admin_logout.php">Logout</a>
    </header>

    <main>
        <div class="stats">
            <div class="stat-card">
                <span>Total Users</span>
                <strong><?php echo e($totalUsers); ?></strong>
            </div>
            <div class="stat-card">
                <span>Total Bookings</span>
                <strong><?php echo e($totalBookings); ?></strong>
            </div>
            <div class="stat-card">
                <span>Contact Messages</span>
                <strong><?php echo e($totalMessages); ?></strong>
            </div>
            <div class="stat-card">
                <span>Estimated Revenue</span>
                <strong>Rs. <?php echo e(number_format($totalRevenue, 2)); ?></strong>
            </div>
        </div>

        <section>
            <h2>Bookings</h2>
            <?php if (!$bookings): ?>
                <p class="empty">No bookings yet.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Cities</th>
                                <th>Vehicle</th>
                                <th>Days</th>
                                <th>Guide</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Receipt</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo e($booking['id']); ?></td>
                                    <td>
                                        <?php echo e($booking['customer_name']); ?><br>
                                        <?php echo e($booking['whatsapp_number']); ?><br>
                                        <?php echo e($booking['user_email'] ?? 'Guest booking'); ?>
                                    </td>
                                    <td><?php echo e($booking['selected_cities']); ?></td>
                                    <td><?php echo e($booking['vehicle_name']); ?></td>
                                    <td><?php echo e($booking['travel_days']); ?></td>
                                    <td><?php echo $booking['guide_added'] ? 'Yes' : 'No'; ?></td>
                                    <td>Rs. <?php echo e(number_format((float) $booking['total_amount'], 2)); ?></td>
                                    <td><?php echo e($booking['payment_method']); ?></td>
                                    <td>
                                        <?php if ($booking['receipt_file_name']): ?>
                                            <a href="uploads/receipts/<?php echo rawurlencode($booking['receipt_file_name']); ?>" target="_blank">View</a>
                                        <?php else: ?>
                                            None
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($booking['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h2>Contact Messages</h2>
            <?php if (!$messages): ?>
                <p class="empty">No contact messages yet.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?php echo e($message['id']); ?></td>
                                    <td><?php echo e($message['full_name']); ?></td>
                                    <td><?php echo e($message['email']); ?></td>
                                    <td class="message-cell"><?php echo e($message['message']); ?></td>
                                    <td><?php echo e($message['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <section>
            <h2>Registered Users</h2>
            <?php if (!$users): ?>
                <p class="empty">No users yet.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo e($user['id']); ?></td>
                                    <td><?php echo e($user['name']); ?></td>
                                    <td><?php echo e($user['email']); ?></td>
                                    <td><?php echo e($user['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
