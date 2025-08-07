<?php
session_start();
require_once("../dbconnect.php");

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, username, email, role FROM users ORDER BY id DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Users - Admin Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        :root {
            --purple-dark: #4a284e;
            --purple-medium: #6a3e6f;
            --purple-light: #9e6fa0;
            --cream: #f4f1e6;
            --white: #ffffff;
            --gray-dark: #333;
            --gray-light: #f5f5f5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-light);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background-color: var(--purple-dark);
            color: var(--white);
            padding: 30px;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 40px;
            color: var(--cream);
        }

        .sidebar a {
            display: block;
            color: var(--cream);
            text-decoration: none;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-weight: 600;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--purple-medium);
            transform: translateX(5px);
        }

        .logout {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .logout a {
            color: var(--cream);
        }

        .main {
            margin-left: 280px;
            padding: 40px;
            width: calc(100% - 280px);
        }

        h1 {
            color: var(--purple-dark);
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background-color: var(--purple-light);
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .role-admin {
            color: green;
            font-weight: 600;
        }

        .role-customer {
            color: #333;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Lunchbox Admin</h2>
    <a href="dashboard.php">🍱 View Orders</a>
    <a href="#">🥪 Manage Products</a>
    <a href="viewuser.php" class="active">📋 View Users</a>
    <a href="#">📈 Sales Reports</a>
    <a href="#">⚙️ Settings</a>

    <div class="logout">
        <a href="../logout.php">🚪 Logout</a>
    </div>
</div>

<div class="main">
    <h1>All Registered Users</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user["id"]); ?></td>
                    <td><?php echo htmlspecialchars($user["username"]); ?></td>
                    <td><?php echo htmlspecialchars($user["email"]); ?></td>
                    <td class="role-<?php echo $user["role"]; ?>">
                        <?php echo ucfirst($user["role"]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
