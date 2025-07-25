<?php
require_once "dbconnect.php";
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "select * from admin where email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $adminInfo = $stmt->fetch();

    if ($adminInfo) {
        if (password_verify($password, $adminInfo["password"])) {
            echo "Login successful!";
        } else {
            $errorMessage = "Invalid input";
        }
    } else {
        $errorMessage = "Invalid input";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0a1d37; /* Navy blue background */
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background-color: #ffffff;
            color: #0a1d37;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .btn-navy {
            background-color: #0a1d37;
            color: #fff;
        }

        .btn-navy:hover {
            background-color: #0d2a4d;
        }

        label {
            font-weight: bold;
        }

        .alert-danger {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <?php require_once("navbarcopy.php"); ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-card">
                    <h3 class="mb-4 text-center">Admin Login</h3>
                    <form action="adminLogin.php" method="post">
                        <?php
                        if (isset($errorMessage)) {
                            echo "<p class='alert alert-danger'>$errorMessage</p>";
                        }
                        ?>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-navy w-100" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
