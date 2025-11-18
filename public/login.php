<?php
session_start();
require_once '../src/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Job Tracker</title>

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #696969;
            color: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background-color: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        form input {
            width: 90%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: white;
            color: black;
        }

        button {
            font-family: 'Courier New', Courier, monospace;
            padding: 10px 14px;
            border: none;
            background: #a9a9a9;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            filter: brightness(75%);
        }

        .message {
            text-align: center;
            margin-bottom: 10px;
            color: #0f0;
        }

        .error {
            color: #f33;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        .register-link:hover {
            filter: brightness(75%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <?php if (!empty($error)) echo "<div class='message error'>$error</div>"; ?>

        <form method="POST" action="login.php">
            Email: <input type="email" name="email" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
        
        <a href="register.php" class="register-link">Don't have an account? Register</a>
    </div>
</body>
</html>