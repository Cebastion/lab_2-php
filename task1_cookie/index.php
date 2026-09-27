<?php
/**
 * Завдання 1. Робота з $_COOKIE
 * - форма для введення імені користувача
 * - збереження імені в cookie на 7 днів
 * - привітання користувача, якщо cookie вже встановлено
 * - видалення cookie за кнопкою
 */

// Обробка відправлення форми (збереження cookie)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && trim($_POST['username']) !== '') {
    $username = trim($_POST['username']);
    // Зберігаємо cookie на 7 днів (7 * 24 * 60 * 60 секунд)
    setcookie('username', $username, time() + 7 * 24 * 60 * 60, '/');
    header('Location: index.php');
    exit;
}

// Обробка видалення cookie
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Ставимо термін дії у минуле - cookie видаляється
    setcookie('username', '', time() - 3600, '/');
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 1 — Робота з $_COOKIE</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; }
        input, button { padding: 8px; font-size: 15px; }
        .box { border: 1px solid #ccc; border-radius: 8px; padding: 20px; }
        .btn-delete { background: #e74c3c; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .btn-save { background: #2980b9; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
<h2>Завдання 1. Робота з $_COOKIE</h2>

<div class="box">
<?php if (isset($_COOKIE['username'])): ?>
    <p>Привіт, <strong><?php echo htmlspecialchars($_COOKIE['username']); ?></strong>! Раді знову вас бачити 🙂</p>
    <p>Це ім'я було збережено в cookie на попередньому візиті (термін дії — 7 днів).</p>
    <form method="get">
        <input type="hidden" name="action" value="delete">
        <button type="submit" class="btn-delete">Видалити cookie</button>
    </form>
<?php else: ?>
    <p>Cookie з іменем ще не встановлено. Введіть ваше ім'я:</p>
    <form method="post">
        <input type="text" name="username" placeholder="Ваше ім'я" required>
        <button type="submit" class="btn-save">Зберегти в cookie</button>
    </form>
<?php endif; ?>
</div>

</body>
</html>
