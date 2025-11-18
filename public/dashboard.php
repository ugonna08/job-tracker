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
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h2>
    <a href="logout.php">Logout</a>

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
                <td><?php echo htmlspecialchars($job['status']); ?></td>
                <td><?php echo htmlspecialchars($job['applied_date']); ?></td>
                <td><?php echo htmlspecialchars($job['notes']); ?></td>
                <td>
                    <a href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a>
                    <a href="delete_job.php?id=<?php echo $job['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>