<?php
require_once '../src/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    if ($stmt->execute([$email, $password_hash])) {
        echo "Registration successful! You can now <a href='login.php'>login</a>";
    } else {
        echo "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Job Tracker</title>
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

        .login-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        .login-link:hover {
            filter: brightness(75%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        <?php
            if (!empty($success)) echo "<div class='message'>$success</div>"; 
            if (!empty($error)) echo "<div class='message error'>$error</div>"; 
        ?>

        <form method="POST" action="register.php">
            Email: <input type="email" name="email" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <button type="submit">Register</button>
        </form>

        <a href="login.php" class="login-link">Already have an account? Login</a>
    </div>
</body>
</html>