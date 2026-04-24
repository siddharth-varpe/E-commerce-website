<?php 
require 'config.php'; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found! <a href='index.php'>Go Back</a>");
}

require 'header.php'; 
?>
<main class="container product-page">
    <div class="product-details">
        <div class="product-image-container">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-large-image">
        </div>
        <div class="product-info">
            <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price">₹<?= number_format($product['price'], 2) ?></p>
            <p class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            
            <form action="cart_action.php" method="POST" style="margin-top: 1rem;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <button type="submit" class="btn btn-large">
                    <i class="fas fa-shopping-bag"></i> Add to Cart
                </button>
            </form>
            <a href="index.php" class="btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </div>
</main>
<?php require 'footer.php'; ?>
