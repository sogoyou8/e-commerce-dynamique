<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}
include '../includes/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $role = 'admin';

    // Vérifier si l'email existe déjà
    $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $query->execute([$email]);
    $email_exists = $query->fetchColumn();

    if ($email_exists) {
        $error = "L'email $email existe déjà.";
    } else {
        $query = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $query->execute([$name, $email, $hashed_password, $role]);
        $success = "Administrateur créé avec succès.";
    }
}
include 'includes/header.php';
include 'includes/footer.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Créer un administrateur</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <section>
            <h2>Créer un administrateur</h2>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="create_admin.php" method="post">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" required>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Créer</button>
            </form>
        </section>
    </main>
</body>
</html>