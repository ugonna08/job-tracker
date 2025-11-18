<?php
session_start();
require_once '../src/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$job_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("DELETE FROM jobs WHERE id = ? AND user_id = ?");
$stmt->execute([$job_id, $user_id]);

header("Location: dashboard.php");
exit();
?>