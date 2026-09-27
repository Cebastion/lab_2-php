<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 3 — Форма для POST-запиту</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; text-align: center; }
        button { padding: 10px 20px; font-size: 15px; background: #2980b9; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Вас було перенаправлено сюди, тому що запит був GET</h2>
    <p>Натисніть кнопку нижче, щоб надіслати POST-запит і побачити інформацію про сервер.</p>
    <form method="post" action="index.php">
        <button type="submit">Надіслати POST-запит</button>
    </form>
</body>
</html>
