<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT a.*, r.review_text FROM applications a LEFT JOIN reviews r ON a.id = r.application_id WHERE a.user_id = ? ORDER BY a.id DESC");
$stmt->execute([$_SESSION['user_id']]);
$apps = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Кабинет</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <div class="header" style="display: flex; align-items: center; gap: 15px;">
            <img src="icon.png" alt="Аватар" style="width: 50px; border-radius: 50%; background: white;">
            <h1 style="text-align: left; font-size: 20px;"><?= htmlspecialchars($_SESSION['fio']) ?></h1>
        </div>

        <div class="slider-container">
            <button class="slider-btn prev">❮</button>
            <div class="slide active"><img src="slide1.png" alt="Автобус"><div class="slide-title">Обучение на автобус</div></div>
            <div class="slide"><img src="slide2.png" alt="Троллейбус"><div class="slide-title">Обучение на троллейбус</div></div>
            <div class="slide"><img src="slide3.png" alt="Автобус"><div class="slide-title">Обучение на автобус (практика)</div></div>
            <div class="slide"><img src="slide4.png" alt="Правила"><div class="slide-title">Правила ПДД</div></div>
            <button class="slider-btn next">❯</button>
        </div>

        <button onclick="window.location.href='apply.php'"><img src="icon.png" class="icon" alt=""> Новая заявка</button>
        <h2>Мои заявки</h2>

        <?php foreach ($apps as $app): ?>
            <div class="card">
                <div class="card-header"><img src="icon.png" class="icon" alt=""><?= htmlspecialchars($app['transport_type']) ?></div>
                <p>Статус: <b><?= $app['status'] ?></b></p>
                <p>Старт: <?= date('d.m.Y', strtotime($app['start_date'])) ?></p>
                <?php if ($app['status'] !== 'Новая'): ?>
                    <?php if ($app['review_text']): ?>
                        <p class="aux-text" style="background:#f0f0f0; padding:10px; border-radius:5px;">"<?= htmlspecialchars($app['review_text']) ?>"</p>
                    <?php else: ?>
                        <button style="margin:5px 0; padding:8px;" onclick="window.location.href='review.php?app_id=<?= $app['id'] ?>'">Оставить отзыв</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button class="btn-secondary" onclick="window.location.href='logout.php'">Выйти</button>
    </div>
    <script src="script.js"></script>
</body>
</html>
