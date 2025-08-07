<!DOCTYPE html>
<html>
<head>
    <title>Neon Calculator</title>
    <style>
        body {
            background-color: #000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
        }

        h2 {
            color: #00ffff;
            text-shadow: 0 0 5px #00ffff, 0 0 10px #00ffff;
        }

        form {
            display: inline-block;
            background-color: #111;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #00ffff;
        }

        input[type="number"] {
            padding: 10px;
            margin: 10px;
            width: 150px;
            background-color: #222;
            border: none;
            color: #00ffff;
            border-bottom: 2px solid #00ffff;
            font-size: 18px;
        }

        input[type="submit"] {
            background-color: #000;
            color: #00ffff;
            border: 2px solid #00ffff;
            padding: 10px 20px;
            margin: 10px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            text-shadow: 0 0 5px #00ffff;
        }

        input[type="submit"]:hover {
            background-color: #00ffff;
            color: #000;
            box-shadow: 0 0 10px #00ffff;
        }

        h3 {
            margin-top: 20px;
            color: #00ffcc;
            text-shadow: 0 0 5px #00ffcc;
        }
    </style>
</head>
<body>

    <?php
    $num1 = $num2 = $result = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operation = $_POST["operation"];

        switch ($operation) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Cannot divide by zero.";
                }
                break;
            default:
                $result = "Invalid operation.";
        }
    }
    ?>

    <h2>🧮 Calculator</h2>

    <form method="post">
        <input type="number" name="num1" placeholder="Enter Number 1" value="<?= htmlspecialchars($num1) ?>" required><br>
        <input type="number" name="num2" placeholder="Enter Number 2" value="<?= htmlspecialchars($num2) ?>" required><br>

        <input type="submit" name="operation" value="+">
        <input type="submit" name="operation" value="-">
        <input type="submit" name="operation" value="*">
        <input type="submit" name="operation" value="/">
    </form>

    <?php if ($result !== ""): ?>
        <h3>Result: <?= $result ?></h3>
    <?php endif; ?>

</body>
</html>