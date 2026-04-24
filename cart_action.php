<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $product_id = (int)$_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($action === 'add' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
        $_SESSION['message'] = 'Cool item added to your bag!';
    } elseif ($action === 'remove' && $product_id > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        $_SESSION['message'] = 'Item removed from your bag.';
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: " . $referer);
    exit;
}
