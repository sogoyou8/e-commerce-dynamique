<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}
include '../includes/db.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $query = $pdo->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $query->execute([$name, $email, $role, $id]);

    header("Location: list_users.php");
    exit;
}
include 'includes/header.php';
?>
<main>
    <section>
        <h2>Modifier un utilisateur</h2>
        <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle :</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Utilisateur</option>
                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </section>
</main>
<?php include 'includes/footer.php'; ?>