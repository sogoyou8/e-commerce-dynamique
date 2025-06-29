<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
include 'includes/header.php';
include 'includes/db.php';
?>
<main>
    <section>
        <h2>Dashboard</h2>
        <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> !</p>
        <p>Utilisez le menu pour gérer les produits, les utilisateurs et les commandes.</p>
        <ul>
            <li><a href="list_products.php">Gérer les produits</a></li>
            <li><a href="list_users.php">Gérer les utilisateurs</a></li>
            <li><a href="list_orders.php">Gérer les commandes</a></li>
            <li><a href="create_admin.php">Créer un administrateur</a></li>
        </ul>
    </section>
</main>
<?php include 'includes/footer.php'; ?>