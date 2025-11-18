<?php
session_start();
require_once '../src/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_job'])) {
    $company = $_POST['company'];
    $position = $_POST['position'];
    $status = $_POST['status'];
    $applied_date = $_POST['applied_date'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("INSERT INTO jobs (user_id, company, position, status, applied_date, notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $company, $position, $status, $applied_date, $notes]);
}

$stmt = $pdo->prepare("SELECT * FROM jobs WHERE user_id = ? ORDER BY applied_date DESC");
$stmt->execute([$user_id]);
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Job Tracker</title>
    
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
            background-color: #696969;
            color: #fff;
        }

        h2 {
            margin-bottom: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #f8f8f8;
            text-align: left;
            color: #000;
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

        .btn-edit, .btn-delete, .logout-btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-family: 'Courier New', Courier, monospace;
            margin-right: 5px;
            font-size: 0.9em;
            background-color: #a9a9a9;
        }

        .btn-delete:hover {
            background-color: red;
        }

        .btn-edit:hover, .logout-btn:hover {
            filter: brightness(75%);
        }

        .status-applied, .status-interviewing, .status-offer, .status-rejected {
            background-color: #a9a9a9;
            color: black;
            padding: 4px 8px;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h2>
        <a href="logout.php" class="logout-btn">Logout</a>

        <h3>Add a New Job</h3>
        <form method="POST" action="dashboard.php">
            Company: <input type="text" name="company" required><br><br>
            Position: <input type="text" name="position" required><br><br>
            Status:
            <select name="status">
                <option value="applied">Applied</option>
                <option value="interviewing">Interviewing</option>
                <option value="offer">Offer</option>
                <option value="rejected">Rejected</option>
            </select><br><br>
            Applied Date: <input type="date" name="applied_date"><br><br>
            Notes: <textarea name="notes"></textarea><br><br>
            <button type="submit" name="add_job">Add Job</button>
        </form>

        <h3>Your Jobs</h3>
        <table border="1" cellpadding="5">
            <tr>
                <th>Company</th>
                <th>Position</th>
                <th>Status</th>
                <th>Applied Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['company']); ?></td>
                    <td><?php echo htmlspecialchars($job['position']); ?></td>
                    <td>
                        <?php 
                        $status_class = '';
                        switch($job['status']) {
                            case 'applied': $status_class = 'status-applied'; break;
                            case 'interviewing': $status_class = 'status-interviewing'; break;
                            case 'offer': $status_class = 'status-offer'; break;
                            case 'rejected': $status_class = 'status-rejected'; break;
                        }
                        ?>
                        <span class="<?php echo $status_class; ?>">
                            <?php echo ucfirst($job['status']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($job['applied_date']); ?></td>
                    <td><?php echo htmlspecialchars($job['notes']); ?></td>
                    <td>
                        <a href="edit_job.php?id=<?php echo $job['id']; ?>" class="btn-edit">Edit</a>
                        <a href="delete_job.php?id=<?php echo $job['id']; ?>" class="btn-delete"
                            onclick="return confirm('Are you sure you want to delete this?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>