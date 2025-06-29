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
$query = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$query->execute([$id]);
$product = $query->fetch(PDO::FETCH_ASSOC);

$query = $pdo->prepare("SELECT * FROM product_images WHERE product_id = ? ORDER BY position");
$query->execute([$id]);
$product_images = $query->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_product'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $images = $_FILES['images'];
        $image_order = $_POST['image_order'];

        $query = $pdo->prepare("UPDATE items SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
        $query->execute([$name, $description, $price, $stock, $id]);

        // Mettre à jour l'ordre des images
        $order = explode(',', $image_order);
        foreach ($order as $position => $image_id) {
            $query = $pdo->prepare("UPDATE product_images SET position = ? WHERE id = ?");
            $query->execute([$position, $image_id]);
        }

        // Ajouter de nouvelles images
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!empty($images['name'][0])) {
            for ($i = 0; $i < count($images['name']); $i++) {
                $image = $images['name'][$i];
                $image_type = $images['type'][$i];

                if (in_array($image_type, $allowed_types)) {
                    if ($images['error'][$i] === UPLOAD_ERR_OK) {
                        $target = "../assets/images/" . basename($image);
                        if (move_uploaded_file($images['tmp_name'][$i], $target)) {
                            $query = $pdo->prepare("INSERT INTO product_images (product_id, image, position) VALUES (?, ?, ?)");
                            $query->execute([$id, $image, count($product_images) + $i]);
                        } else {
                            echo "Erreur lors du téléchargement de l'image.";
                            exit;
                        }
                    } else {
                        echo "Erreur lors du téléchargement de l'image.";
                        exit;
                    }
                } else {
                    echo "Seuls les fichiers d'image (JPEG, PNG, GIF) sont autorisés.";
                    exit;
                }
            }
        }

        header("Location: list_products.php");
        exit;
    } elseif (isset($_POST['delete_images_submit'])) {
        $delete_images = $_POST['delete_images'];
        foreach ($delete_images as $image_id) {
            $query = $pdo->prepare("SELECT image FROM product_images WHERE id = ?");
            $query->execute([$image_id]);
            $image = $query->fetch(PDO::FETCH_ASSOC);
            if ($image && isset($image['image'])) {
                $file_path = "../assets/images/" . $image['image'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                $query = $pdo->prepare("DELETE FROM product_images WHERE id = ?");
                $query->execute([$image_id]);
            }
        }

        header("Location: edit_product.php?id=$id");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modifier un produit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
        .existing-images img {
            cursor: move;
        }
    </style>
</head>
<body>
    <main class="container py-4">
        <section class="bg-light p-5 rounded shadow-sm">
            <h2 class="h3 mb-4 font-weight-bold">Modifier un produit</h2>
            <form action="edit_product.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom :</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea name="description" id="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix :</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock :</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="images" class="form-label">Ajouter des images :</label>
                    <input type="file" name="images[]" id="images" class="form-control" accept="image/jpeg, image/png, image/gif" multiple>
                </div>
                <input type="hidden" name="image_order" id="image_order">
                <button type="submit" name="update_product" class="btn btn-primary">Modifier</button>
            </form>
            <h3 class="h4 mt-4">Images existantes</h3>
            <form action="edit_product.php?id=<?php echo $id; ?>" method="post">
                <div class="existing-images d-flex flex-wrap" id="sortable">
                    <?php if ($product_images): ?>
                        <?php foreach ($product_images as $image): ?>
                            <div class="me-2 mb-2" data-id="<?php echo $image['id']; ?>">
                                <img src="../assets/images/<?php echo htmlspecialchars($image['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-thumbnail" width="100">
                                <input type="checkbox" name="delete_images[]" value="<?php echo $image['id']; ?>"> Supprimer
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune image disponible.</p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-danger mt-3" name="delete_images_submit">Supprimer les images sélectionnées</button>
            </form>
        </section>
    </main>
    <script>
        $(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', { attribute: 'data-id' });
                    $("#image_order").val(order.join(','));
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>