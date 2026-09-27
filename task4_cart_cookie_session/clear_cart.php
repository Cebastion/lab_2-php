<?php
/**
 * Очищення кошика поточної сесії (без оформлення замовлення)
 */
session_start();
$_SESSION['cart'] = [];
header('Location: index.php');
exit;
