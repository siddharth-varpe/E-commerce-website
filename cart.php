<?php 
require 'config.php'; 
require 'header.php'; 

$cartItems = $_SESSION['cart'] ?? [];
$cartProducts = [];
$total = 0;

if (!empty($cartItems)) {
    $placeholders = str_repeat('?,', count($cartItems) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cartItems));
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $qty = $cartItems[$row['id']];
        $row['quantity'] = $qty;
        $row['subtotal'] = $row['price'] * $qty;
        $total += $row['subtotal'];
        $cartProducts[] = $row;
    }
}
?>
<main class="container cart-page">
    <h1 class="section-title">Your Shopping Bag</h1>
    
    <?php if (empty($cartProducts)): ?>
        <div class="empty-cart text-center">
            <i class="fas fa-shopping-bag fa-4x text-light mb-3"></i>
            <h2>Your bag is relatively empty</h2>
            <p class="text-light">Discover the latest fashion trends and fill your bag.</p>
            <a href="index.php" class="btn btn-large mt-3">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($cartProducts as $item): ?>
                    <div class="cart-item">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-img">
                        <div class="cart-item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="text-light">
                                ₹<?= number_format($item['price'], 2) ?> &times; <?= $item['quantity'] ?>
                            </p>
                            <p class="font-bold text-primary mt-3">
                                ₹<?= number_format($item['subtotal'], 2) ?>
                            </p>
                        </div>
                        <form action="cart_action.php" method="POST">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn-danger" title="Remove Item">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹<?= number_format($total, 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span class="text-primary font-bold">FREE</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>₹<?= number_format($total, 2) ?></span>
                </div>
                <!-- Traditional form logic for checkout mock -->
                <form action="index.php" method="GET">
                    <button type="submit" class="btn btn-block btn-large mt-3" onclick="alert('Proceeding to secure checkout!')">
                        <i class="fas fa-lock"></i> Secure Checkout
                    </button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php require 'footer.php'; ?>
