<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
$toastMessage = $_SESSION['message'] ?? null;
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chic Threads | Premium Fashion</title>
    <!-- Elegant Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if ($toastMessage): ?>
    <div class="toast show" id="toast">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($toastMessage) ?>
    </div>
    <?php endif; ?>

    <nav class="navbar">
        <div class="nav-container container">
            <a href="index.php" class="brand">
                <i class="fas fa-tshirt"></i> Chic Threads
            </a>
            <ul class="nav-links">
                <li><a href="index.html">Shop</a></li>
                <li><a href="mens.php">Men's</a></li>
                <li><a href="womens.php">Women's</a></li>
            </ul>
            <div class="nav-cart">
                <a href="cart.php" class="cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count"><?= $cartCount ?></span>
                </a>
            </div>
        </div>
    </nav>
