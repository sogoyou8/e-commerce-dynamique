<?php
include 'includes/header.php';
include 'includes/db.php';

$query = $_GET['query'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE name LIKE ? OR description LIKE ?");
$stmt->execute(["%$query%", "%$query%"]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container py-4">
    <section class="search-results-section bg-light p-5 rounded shadow-sm">
        <h2 class="h3 mb-4 font-weight-bold">Résultats de recherche pour "<?php echo htmlspecialchars($query); ?>"</h2>
        <div class="row">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text font-weight-bold"><?php echo htmlspecialchars($product['price']); ?> €</p>
                                <a href="product_detail.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="btn btn-primary">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Aucun produit trouvé.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>