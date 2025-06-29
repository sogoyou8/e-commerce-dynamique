<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}
include '../includes/db.php';
include 'includes/header.php';
include 'includes/footer.php';

$id = $_GET['id'];
$query = $pdo->prepare("DELETE FROM orders WHERE id = ?");
$query->execute([$id]);

header("Location: list_orders.php");
exit;
?>