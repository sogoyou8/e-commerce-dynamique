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

// Supprimer les enregistrements associés dans la table favorites
$query = $pdo->prepare("DELETE FROM favorites WHERE item_id = ?");
$query->execute([$id]);

// Supprimer les images associées au produit
$query = $pdo->prepare("SELECT image FROM product_images WHERE product_id = ?");
$query->execute([$id]);
$images = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($images as $image) {
    $file_path = "../assets/images/" . $image['image'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

$query = $pdo->prepare("DELETE FROM product_images WHERE product_id = ?");
$query->execute([$id]);

// Supprimer le produit
$query = $pdo->prepare("DELETE FROM items WHERE id = ?");
$query->execute([$id]);

header("Location: list_products.php");
exit;
?>