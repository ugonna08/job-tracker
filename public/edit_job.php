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
</head>
<body>
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
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
