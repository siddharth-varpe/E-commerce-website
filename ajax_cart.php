<?php
require 'config.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($action === 'add') {
    $id = (int) $input['product_id'];
    if ($id > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
        $count = array_sum($_SESSION['cart']);
        echo json_encode(['success' => true, 'count' => $count, 'message' => 'Item added to cart!']);
        exit;
    }
} elseif ($action === 'remove') {
    $id = (int) $input['product_id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    $count = array_sum($_SESSION['cart']);
    echo json_encode(['success' => true, 'count' => $count]);
    exit;
} elseif ($action === 'get_count') {
    $count = array_sum($_SESSION['cart']);
    echo json_encode(['success' => true, 'count' => $count]);
    exit;
} elseif ($action === 'get_cart') {
    $cartItems = $_SESSION['cart'];
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
    echo json_encode(['success' => true, 'cart' => $cartProducts, 'total' => $total]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
