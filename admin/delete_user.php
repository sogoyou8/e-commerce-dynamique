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

// Vérifiez que l'utilisateur existe
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Supprimez les enregistrements associés dans les tables référencées
    $query = $pdo->prepare("DELETE FROM favorites WHERE user_id = ?");
    $query->execute([$id]);

    // Supprimez l'utilisateur
    $query = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $query->execute([$id]);
    $_SESSION['message'] = "Utilisateur supprimé avec succès.";
} else {
    $_SESSION['message'] = "Utilisateur introuvable.";
}

header("Location: list_users.php");
exit;
?>