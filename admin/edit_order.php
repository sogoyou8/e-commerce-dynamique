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
$query = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$query->execute([$id]);
$order = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    $query = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $query->execute([$status, $id]);

    header("Location: list_orders.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modifier une commande</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <section>
            <h2>Modifier une commande</h2>
            <form action="edit_order.php?id=<?php echo $id; ?>" method="post">
                <label for="status">Status :</label>
                <select name="status" id="status" required>
                    <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>En attente</option>
                    <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Expédiée</option>
                    <option value="delivered" <?php if ($order['status'] == 'delivered') echo 'selected'; ?>>Livrée</option>
                    <option value="cancelled" <?php if ($order['status'] == 'cancelled') echo 'selected'; ?>>Annulée</option>
                </select>
                <button type="submit">Modifier</button>
            </form>
        </section>
    </main>
</body>
</html>