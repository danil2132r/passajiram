<?php
session_start();
require_once 'db.php';
$error = '';
$success = isset($_GET['success']) ? "Регистрация успешна! Войдите." : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $password) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['fio'] = $user['fio'];
        if ($user['role'] === 'admin') header("Location: admin.php");
        else header("Location: cabinet.php");
        exit;
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Вход</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <h1>Вход</h1>
        <?php if ($success): ?><p style="color: green; text-align: center;"><b><?= $success ?></b></p><?php endif; ?>
        <?php if ($error): ?><p class="error-hint" style="text-align: center;"><?= $error ?></p><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group"><label>Логин</label><input type="text" name="login" required></div>
            <div class="form-group"><label>Пароль</label><input type="password" name="password" required></div>
            <button type="submit">Войти</button>
        </form>
        <p style="text-align: center;">Еще не зарегистрированы? <a href="register.php">Регистрация</a></p>
    </div>
</body>
</html>