<?php
session_start();
require_once '../src/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$job_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = ? AND user_id = ?");
$stmt->execute([$job_id, $user_id]);
$job = $stmt->fetch();

if (!$job) {
    echo "Job not found or access denied.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = $_POST['company'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $applied_date = $_POST['applied_date'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("UPDATE jobs SET company = ?, position = ?, status = ?, applied_date = ?, notes = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$company, $position, $status, $applied_date, $notes, $job_id, $user_id]);

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Job - Job Tracker</title>

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #696969;
            color: white;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background-color: black;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        h2 {
            margin-bottom: 15px;
            text-align: center;
        }

        form input {
            padding: 8px;
            width: 90%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form select {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form input[type="date"] {
            width: 75px; 
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

        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: white;
            text-decoration: none;
        }

        .back-link:hover {
            filter: brightness(75%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Job</h2>
        <form method="POST" action="">
            Company: <input type="text" name="company" value="<?php echo htmlspecialchars($job['company']); ?>" required><br><br>
            Position: <input type="text" name="position" value="<?php echo htmlspecialchars($job['position']); ?>" required><br><br>
            Status:
            <select name="status">
                <option value="applied" <?php if ($job['status'] === 'applied') echo 'selected'; ?>>Applied</option>
                <option value="interviewing" <?php if ($job['status'] === 'interviewing') echo 'selected'; ?>>Interviewing</option>
                <option value="offer" <?php if ($job['status'] === 'offer') echo 'selected'; ?>>Offer</option>
                <option value="rejected" <?php if ($job['status'] === 'rejected') echo 'selected'; ?>>Rejected</option>
            </select><br><br>
            Applied Date: <input type="date" name="applied_date" value="<?php echo htmlspecialchars($job['applied_date']); ?>"><br><br>
            Notes: <textarea name="notes"><?php echo htmlspecialchars($job['notes']); ?></textarea><br><br>
            <button type="submit">Update Job</button>
        </form>
        
        <a href="dashboard.php" class="back-link">Back to Dashboard</a>
    </div>    
</body>
</html>
