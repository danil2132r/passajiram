<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') { header("Location: index.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO applications (user_id, transport_type, start_date, payment_method, status) VALUES (?, ?, ?, ?, 'Новая')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user_id'], $_POST['transport'], $_POST['date'], $_POST['payment']]);
    header("Location: cabinet.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Новая заявка</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <h2>Оформление заявки</h2>
        <form action="" method="POST">
            <div class="form-group"><label>Вид транспорта</label><select name="transport" required><option value="автобус">Автобус</option><option value="электробус">Электробус</option><option value="трамвай">Трамвай</option></select></div>
            <div class="form-group"><label>Дата начала</label><input type="date" name="date" required></div>
            <div class="form-group"><label>Способ оплаты</label><select name="payment" required><option value="Онлайн картой">Онлайн картой</option><option value="Наличными в офисе">Наличными в офисе</option><option value="По СБП">По СБП</option></select></div>
            <button type="submit">Отправить</button>
        </form>
        <button style="background: var(--color-gray);" onclick="window.location.href='cabinet.php'">Назад</button>
    </div>
</body>
</html>