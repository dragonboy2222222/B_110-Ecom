<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "customer") {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunchbox - Your Daily Meals</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

        :root {
            --purple-dark: #4a284e;
            --purple-medium: #6a3e6f;
            --purple-light: #9e6fa0;
            --cream: #f4f1e6;
            --white: #ffffff;
            --gray-dark: #333333;
            --gray-light: #eeeeee;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: var(--purple-dark);
            color: var(--cream);
            padding: 1.2rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .navbar a {
            color: var(--cream);
            text-decoration: none;
            font-weight: 600;
            margin-left: 25px;
            padding: 8px 15px;
            border-radius: 6px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar a:hover {
            background-color: var(--purple-medium);
            color: var(--white);
        }

        .container {
            flex-grow: 1;
            padding: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 30px auto;
        }

        .card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .card .icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--purple-medium);
        }

        .card h3 {
            margin-top: 0;
            color: var(--purple-dark);
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .card p {
            color: var(--gray-dark);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            padding: 25px;
            background: var(--purple-dark);
            color: var(--cream);
            margin-top: auto; /* Pushes footer to the bottom */
            font-size: 0.9rem;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }
            .navbar h1 {
                margin-bottom: 15px;
            }
            .navbar div {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .navbar a {
                margin: 5px 10px;
            }
            .container {
                padding: 20px;
                grid-template-columns: 1fr; /* Stack cards on small screens */
            }
            .card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Lunchbox Delivers! 🍱</h1>
        <div>
            <a href="#">Menu</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <span class="icon">✨</span>
            <h3>Explore Our Menu</h3>
            <p>Discover a wide variety of delicious and healthy lunch options, freshly prepared for you daily.</p>
        </div>

        <div class="card">
            <span class="icon">👤</span>
            <h3>My Account</h3>
            <p>Manage your profile, update delivery addresses, and review your past orders with ease.</p>
        </div>

        <div class="card">
            <span class="icon">💬</span>
            <h3>Help & Support</h3>
            <p>Have a question or need assistance? Our friendly support team is here to help you.</p>
        </div>

        <div class="card">
            <span class="icon">🎉</span>
            <h3>Today's Specials</h3>
            <p>Don't miss out on our exclusive daily deals and exciting promotions just for you!</p>
        </div>
    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Lunchbox Delivers. All rights reserved.
    </div>

</body>
</html>
