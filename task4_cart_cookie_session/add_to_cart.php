<?php
/**
 * Додавання товару до кошика поточної сесії
 */
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int) $_POST['product_id'];
    $products = require __DIR__ . '/products.php';

    if (isset($products[$productId])) {
        // Якщо товар вже є в кошику - збільшуємо кількість
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty']++;
        } else {
            $_SESSION['cart'][$productId] = [
                'name'  => $products[$productId]['name'],
                'price' => $products[$productId]['price'],
                'qty'   => 1,
            ];
        }
    }
}

header('Location: index.php');
exit;
