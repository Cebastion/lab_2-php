<?php
/**
 * Очищення даних сесії та перенаправлення на головну сторінку
 */
session_start();

// Очищаємо всі змінні сесії
$_SESSION = [];

// Видаляємо cookie сесії (якщо використовується)
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

// Знищуємо сесію на сервері
session_destroy();

// Перенаправлення на головну сторінку
header('Location: index.php');
exit;
