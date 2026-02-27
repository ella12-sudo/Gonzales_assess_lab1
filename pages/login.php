<?php
session_start();

// If already logged in, redirect to index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Static admin login
    if ($username === "admin" && $password === "admin") {
        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="dashboard_style.css">
    <style>
        /* Login Form Styling */
        .form-container {
            max-width: 350px;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin: 80px auto;
            font-family: Arial, sans-serif;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-container label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .form-container input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: linear-gradient(to right, #5f6de0, #7b4de0);
            cursor: pointer;
        }

        .form-container .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login Form</h2>

    <?php if ($error != ""): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>