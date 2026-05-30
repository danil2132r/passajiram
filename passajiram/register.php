<?php
session_start();
require_once 'db.php';
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) $error = "Логин только из латинских букв и цифр!";
    else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) $error = "Логин занят!";
        else {
            $stmt = $pdo->prepare("INSERT INTO users (login, password, fio, dob, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$login, $_POST['password'], trim($_POST['fio']), $_POST['dob'], trim($_POST['phone']), trim($_POST['email'])]);
            header("Location: index.php?success=1"); exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Регистрация</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <div class="header"><h1>Регистрация</h1></div>
        <?php if ($error): ?><p class="error-hint" style="text-align:center;"><?= $error ?></p><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group"><label>Логин (лат. и цифры, мин 6)</label><input type="text" name="login" minlength="6" required></div>
            <div class="form-group"><label>Пароль (мин 8)</label><input type="password" name="password" minlength="8" required></div>
            <div class="form-group"><label>ФИО</label><input type="text" name="fio" required></div>
            <div class="form-group"><label>Дата рождения</label><input type="date" name="dob" required></div>
            <div class="form-group"><label>Телефон</label><input type="tel" name="phone" required></div>
            <div class="form-group"><label>E-mail</label><input type="email" name="email" required></div>
            <button type="submit"><img src="icon.png" class="icon" alt=""> Зарегистрироваться</button>
        </form>
        <p style="text-align: center;"><a href="index.php">Уже есть аккаунт? Войти</a></p>
    </div>
</body>
</html>
