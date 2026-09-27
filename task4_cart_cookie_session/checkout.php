<?php
/**
 * "Оформлення замовлення":
 * поточний кошик із сесії додається до cookie "previous_purchases"
 * (тобто зберігається як історія покупок між сеансами), після чого сесійний кошик очищується.
 */
session_start();

if (!empty($_SESSION['cart'])) {
    // Читаємо попередні покупки з cookie (якщо є)
    $previous = [];
    if (isset($_COOKIE['previous_purchases'])) {
        $decoded = json_decode($_COOKIE['previous_purchases'], true);
        if (is_array($decoded)) {
            $previous = $decoded;
        }
    }

    // Додаємо назви товарів із поточного кошика до списку попередніх покупок
    foreach ($_SESSION['cart'] as $item) {
        $previous[] = $item['name'] . ' (' . $item['qty'] . ' шт.)';
    }

    // Обмежимо історію останніми 20 записами
    $previous = array_slice($previous, -20);

    // Зберігаємо cookie на 30 днів
    setcookie('previous_purchases', json_encode($previous, JSON_UNESCAPED_UNICODE), time() + 30 * 24 * 60 * 60, '/');

    // Очищаємо кошик поточної сесії
    $_SESSION['cart'] = [];
}

header('Location: index.php');
exit;
