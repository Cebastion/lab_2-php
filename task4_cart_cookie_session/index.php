<?php
/**
 * Завдання 4. Спільне використання $_COOKIE та $_SESSION
 * - $_SESSION зберігає поточний кошик покупок
 * - $_COOKIE зберігає історію ("попередні покупки") між сеансами
 */
session_start();

$products = require __DIR__ . '/products.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Підрахунок загальної суми поточного кошика
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['qty'];
}

// Читання історії попередніх покупок з cookie
$previousPurchases = [];
if (isset($_COOKIE['previous_purchases'])) {
    $decoded = json_decode($_COOKIE['previous_purchases'], true);
    if (is_array($decoded)) {
        $previousPurchases = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 4 — Кошик покупок ($_COOKIE + $_SESSION)</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; }
        .section { border: 1px solid #ccc; border-radius: 8px; padding: 15px 20px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        button { padding: 6px 12px; cursor: pointer; border: none; border-radius: 4px; }
        .btn-add { background: #2980b9; color: #fff; }
        .btn-danger { background: #e74c3c; color: #fff; }
        .btn-success { background: #27ae60; color: #fff; }
        .muted { color: #777; }
    </style>
</head>
<body>
<h2>Завдання 4. Кошик покупок ($_COOKIE + $_SESSION)</h2>

<div class="section">
    <h3>Каталог товарів</h3>
    <table>
        <tr><th>Товар</th><th>Ціна</th><th></th></tr>
        <?php foreach ($products as $id => $p): ?>
        <tr>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo number_format($p['price'], 0, ',', ' '); ?> грн</td>
            <td>
                <form method="post" action="add_to_cart.php" style="margin:0;">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn-add">Додати в кошик</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="section">
    <h3>Поточний кошик (сесія)</h3>
    <?php if (empty($_SESSION['cart'])): ?>
        <p class="muted">Кошик порожній.</p>
    <?php else: ?>
        <table>
            <tr><th>Товар</th><th>Ціна</th><th>Кількість</th><th>Сума</th></tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo number_format($item['price'], 0, ',', ' '); ?> грн</td>
                <td><?php echo $item['qty']; ?></td>
                <td><?php echo number_format($item['price'] * $item['qty'], 0, ',', ' '); ?> грн</td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><strong>Разом: <?php echo number_format($total, 0, ',', ' '); ?> грн</strong></p>
        <form method="post" action="checkout.php" style="display:inline;">
            <button type="submit" class="btn-success">Оформити замовлення</button>
        </form>
        <form method="post" action="clear_cart.php" style="display:inline;">
            <button type="submit" class="btn-danger">Очистити кошик</button>
        </form>
    <?php endif; ?>
</div>

<div class="section">
    <h3>Попередні покупки (cookie, зберігаються 30 днів)</h3>
    <?php if (empty($previousPurchases)): ?>
        <p class="muted">Історія покупок поки порожня. Оформіть замовлення, щоб побачити її тут.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($previousPurchases as $purchase): ?>
                <li><?php echo htmlspecialchars($purchase); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
