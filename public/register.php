<?php
require_once '../src/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
    if ($stmt->execute([$email, $password_hash])) {
        echo "Registration successful!";
    } else {
        echo "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Job Tracker</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>