<?php
session_start();
require_once 'db.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $password = $_POST['password']; 
    $fio = trim($_POST['fio']);
    $dob = $_POST['dob'];
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
    $stmt->execute([$login]);
    
    if ($stmt->fetch()) {
        $error = "Пользователь с таким логином уже существует!";
    } else {
        $sql = "INSERT INTO users (login, password, fio, dob, phone, email) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $password, $fio, $dob, $phone, $email]);
        header("Location: index.php?success=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Регистрация</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <h1>Регистрация</h1>
        <?php if ($error): ?><p class="error-hint" style="text-align:center;"><?= $error ?></p><?php endif; ?>
        <form action="" method="POST">
            <div class="form-group"><label>Логин</label><input type="text" id="login_reg" name="login" minlength="6" required><span class="error-hint" id="login-error"></span></div>
            <div class="form-group"><label>Пароль</label><input type="password" name="password" minlength="8" required></div>
            <div class="form-group"><label>ФИО</label><input type="text" name="fio" required></div>
            <div class="form-group"><label>Дата рождения</label><input type="date" name="dob" required></div>
            <div class="form-group"><label>Телефон</label><input type="tel" name="phone" required></div>
            <div class="form-group"><label>E-mail</label><input type="email" name="email" required></div>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <p style="text-align: center;"><a href="index.php">Уже есть аккаунт? Войти</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>