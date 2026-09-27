<?php
/**
 * Завдання 5. Час активності сесії
 * - $_SESSION['last_activity'] відстежує час останньої активності
 * - якщо з моменту останньої активності минуло більше 5 хв (300 с) - сесія завершується автоматично
 */
session_start();

const TIMEOUT_SECONDS = 300; // 5 хвилин

$sessionExpired = false;

// Перевірка неактивності
if (isset($_SESSION['last_activity'])) {
    $inactiveFor = time() - $_SESSION['last_activity'];
    if ($inactiveFor > TIMEOUT_SECONDS) {
        // Сесія протухла - очищаємо
        $_SESSION = [];
        session_destroy();
        session_start();
        $sessionExpired = true;
    }
}

// Обробка форми "входу" (просто задаємо ім'я користувача, щоб продемонструвати роботу з сесією)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && trim($_POST['username']) !== '') {
    $_SESSION['username'] = trim($_POST['username']);
    $_SESSION['login_time'] = time();
}

// Оновлюємо час останньої активності при кожному завантаженні сторінки
$_SESSION['last_activity'] = time();

$timeLeft = TIMEOUT_SECONDS;
if (isset($_SESSION['last_activity'])) {
    $timeLeft = TIMEOUT_SECONDS - (time() - $_SESSION['last_activity']);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 5 — Таймаут сесії</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 550px; margin: 50px auto; }
        .box { border: 1px solid #ccc; border-radius: 8px; padding: 20px; }
        .warning { color: #e67e22; }
        #countdown { font-weight: bold; }
    </style>
</head>
<body>
<h2>Завдання 5. Автоматичне завершення сесії через неактивність</h2>

<div class="box">
<?php if ($sessionExpired): ?>
    <p class="warning">Ваша сесія була завершена через неактивність понад 5 хвилин. Увійдіть знову.</p>
<?php endif; ?>

<?php if (isset($_SESSION['username'])): ?>
    <h3>Привіт, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
    <p>Час входу: <?php echo date('H:i:s', $_SESSION['login_time']); ?></p>
    <p>Час до автоматичного завершення сесії:
        <span id="countdown"><?php echo TIMEOUT_SECONDS; ?></span> сек.
        (оновіть сторінку, щоб продовжити сесію)
    </p>
    <p><small>Якщо не оновлювати сторінку більше 5 хвилин, сесія буде автоматично знищена
    при наступному завантаженні.</small></p>
<?php else: ?>
    <p>Введіть ім'я, щоб почати сесію:</p>
    <form method="post">
        <input type="text" name="username" placeholder="Ваше ім'я" required>
        <button type="submit">Почати сесію</button>
    </form>
<?php endif; ?>
</div>

<script>
// Простий візуальний зворотний відлік на клієнті (не впливає на серверну перевірку)
let seconds = <?php echo TIMEOUT_SECONDS; ?>;
const el = document.getElementById('countdown');
if (el) {
    setInterval(() => {
        seconds--;
        if (seconds >= 0) el.textContent = seconds;
    }, 1000);
}
</script>
</body>
</html>
