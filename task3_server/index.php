<?php
/**
 * Завдання 3. Робота з $_SERVER
 * - IP-адреса клієнта, User-Agent, PHP_SELF, метод запиту, шлях до файлу
 * - автоматичне перенаправлення, якщо запит не є POST
 */

// Якщо метод запиту НЕ POST - перенаправляємо на форму, яка виконує POST-запит
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: form.php');
    exit;
}

// Збір даних із $_SERVER
$clientIp      = $_SERVER['REMOTE_ADDR'] ?? 'невідомо';
$userAgent     = $_SERVER['HTTP_USER_AGENT'] ?? 'невідомо';
$scriptSelf    = $_SERVER['PHP_SELF'] ?? 'невідомо';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'невідомо';
$scriptPath    = $_SERVER['SCRIPT_FILENAME'] ?? 'невідомо';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 3 — Робота з $_SERVER</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 50px auto; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #ccc; padding: 10px; text-align: left; word-break: break-all; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
<h2>Завдання 3. Інформація з $_SERVER</h2>
<p>Цей запит було надіслано методом <strong>POST</strong>, тому редиректу не відбулось.</p>

<table>
    <tr><th>Параметр</th><th>Значення</th></tr>
    <tr><td>IP-адреса клієнта (REMOTE_ADDR)</td><td><?php echo htmlspecialchars($clientIp); ?></td></tr>
    <tr><td>Браузер (HTTP_USER_AGENT)</td><td><?php echo htmlspecialchars($userAgent); ?></td></tr>
    <tr><td>Назва скрипта (PHP_SELF)</td><td><?php echo htmlspecialchars($scriptSelf); ?></td></tr>
    <tr><td>Метод запиту (REQUEST_METHOD)</td><td><?php echo htmlspecialchars($requestMethod); ?></td></tr>
    <tr><td>Шлях до файлу на сервері (SCRIPT_FILENAME)</td><td><?php echo htmlspecialchars($scriptPath); ?></td></tr>
</table>

<p><a href="form.php">← Повернутись до форми</a></p>
</body>
</html>
