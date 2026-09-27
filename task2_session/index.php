<?php
/**
 * Завдання 2. Робота з $_SESSION
 * - форма входу (логін і пароль)
 * - збереження даних користувача в сесії після успішного входу
 * - перевірка наявності активної сесії
 * - кнопка "Вихід" (logout.php)
 */
session_start();

// Тестові облікові дані (у реальному проєкті — перевірка в БД + хешування паролю)
const VALID_LOGIN = 'admin';
const VALID_PASSWORD = '12345';

$error = '';

// Обробка форми входу
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'], $_POST['password'])) {
    if ($_POST['login'] === VALID_LOGIN && $_POST['password'] === VALID_PASSWORD) {
        $_SESSION['user'] = [
            'login'     => $_POST['login'],
            'login_time' => date('Y-m-d H:i:s'),
        ];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Невірний логін або пароль!';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 2 — Робота з $_SESSION</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; }
        input, button { padding: 8px; font-size: 15px; }
        .box { border: 1px solid #ccc; border-radius: 8px; padding: 20px; }
        .error { color: #e74c3c; }
        .btn-logout { background: #e74c3c; color: #fff; border: none; border-radius: 4px; cursor: pointer; padding: 8px 14px; }
        .btn-login { background: #27ae60; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
<h2>Завдання 2. Робота з $_SESSION</h2>

<div class="box">
<?php if (isset($_SESSION['user'])): ?>
    <h3>Вітаємо, <?php echo htmlspecialchars($_SESSION['user']['login']); ?>!</h3>
    <p>Ви увійшли о: <?php echo htmlspecialchars($_SESSION['user']['login_time']); ?></p>
    <p>ID вашої сесії: <?php echo htmlspecialchars(session_id()); ?></p>
    <form action="logout.php" method="post">
        <button type="submit" class="btn-logout">Вихід</button>
    </form>
<?php else: ?>
    <h3>Вхід в систему</h3>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <form method="post">
        <input type="text" name="login" placeholder="Логін" required><br><br>
        <input type="password" name="password" placeholder="Пароль" required><br><br>
        <button type="submit" class="btn-login">Увійти</button>
    </form>
    <p><small>Тестові дані: логін <b>admin</b>, пароль <b>12345</b></small></p>
<?php endif; ?>
</div>

</body>
</html>
