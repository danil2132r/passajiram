<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$_SESSION['user_id']]);
$applications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Личный кабинет</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <h2>Кабинет: <?= htmlspecialchars($_SESSION['fio']) ?></h2>
        <div class="slider-container">
            <button class="slider-btn prev">❮</button>
            <div class="slide active" style="background-color: var(--color-primary);">Обучение на автобус</div>
            <div class="slide" style="background-color: var(--color-dark);">Обучение на трамвай</div>
            <div class="slide" style="background-color: var(--color-gray);">Обучение на электробус</div>
            <div class="slide" style="background-color: #333;">Лучшие инструкторы</div>
            <button class="slider-btn next">❯</button>
        </div>
        <button onclick="window.location.href='apply.php'">+ Новая заявка</button>
        <button style="background: var(--color-gray);" onclick="window.location.href='logout.php'">Выйти</button>

        <h2>Мои заявки</h2>
        <?php foreach ($applications as $app): ?>
            <div class="card">
                <h3><?= htmlspecialchars($app['transport_type']) ?></h3>
                <p class="aux-text">Статус: <?= htmlspecialchars($app['status']) ?></p>
                <p>Дата старта: <?= date('d.m.Y', strtotime($app['start_date'])) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>