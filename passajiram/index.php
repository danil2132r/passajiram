<?php
session_start();
require_once 'db.php';
$error = '';
$success = isset($_GET['success']) ? "Регистрация успешна! Войдите." : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([trim($_POST['login'])]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $_POST['password']) {
        $_SESSION['user_id'] = $user['id']; $_SESSION['role'] = $user['role']; $_SESSION['fio'] = $user['fio'];
        header("Location: " . ($user['role'] === 'admin' ? "admin.php" : "cabinet.php")); exit;
    } else { $error = "Неверный логин или пароль!"; }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Вход</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <div class="header">
            <img src="icon.png" alt="Логотип" class="logo">
            <h1>Пассажирам.РФ</h1>
        </div>
        <h2 style="text-align:center; border:none;">Авторизация</h2>
        <?php if ($success): ?><p style="color: green; text-align: center;"><?= $success ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error-hint" style="text-align: center;"><?= $error ?></p><?php endif; ?>
        
        <form action="" method="POST">
            <div class="form-group"><label>Логин</label><input type="text" name="login" required></div>
            <div class="form-group"><label>Пароль</label><input type="password" name="password" required></div>
            <button type="submit"><img src="icon.png" class="icon" alt=""> Войти</button>
        </form>
        <p style="text-align: center;">Нет аккаунта? <a href="register.php">Регистрация</a></p>
    </div>
</body>
</html>
