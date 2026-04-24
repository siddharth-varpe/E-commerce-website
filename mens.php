<?php 
require 'config.php'; 
require 'header.php'; 
?>
<main class="container">
    <section class="hero hero-fashion" style="padding: 4rem 1.5rem; margin-bottom: 2rem;">
        <div class="hero-content">
            <h1>Men's Collection</h1>
            <p>Elevate your wardrobe with our latest premium styles for men.</p>
        </div>
    </section>

    <div class="product-grid">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM products WHERE category = 'Men' ORDER BY id ASC");
            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <article class="card">
                <a href="product.php?id=<?= $product['id'] ?>" class="card-img-wrapper">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="card-img" loading="lazy">
                </a>
                <div class="card-body">
                    <a href="product.php?id=<?= $product['id'] ?>">
                        <h3 class="card-title"><?= htmlspecialchars($product['name']) ?></h3>
                    </a>
                    <p class="card-price">₹<?= number_format($product['price'], 2) ?></p>
                    
                    <form action="cart_action.php" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-block">
                            <i class="fas fa-shopping-bag"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </article>
        <?php 
            endwhile;
        } catch (Exception $e) {
            echo "<p class='text-danger'>Error fetching products. Make sure to import the latest database.sql!</p>";
        }
        ?>
    </div>
</main>
<?php require 'footer.php'; ?>
