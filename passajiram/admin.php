<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

if (isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], (int)$_POST['app_id']]);
    $_SESSION['msg'] = "Статус изменен!";
    header("Location: admin.php"); exit;
}
$stmt = $pdo->query("SELECT a.*, u.fio FROM applications a JOIN users u ON a.user_id = u.id ORDER BY a.id DESC");
$apps = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Админка</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container">
        <div class="header"><h1>Управление заявками</h1></div>
        <?php if (isset($_SESSION['msg'])): ?>
            <p style="background: #28a745; color: white; padding: 10px; text-align: center; margin: 0;"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></p>
        <?php endif; ?>
        
        <?php foreach ($apps as $app): ?>
        <div class="card">
            <p><b><?= htmlspecialchars($app['fio']) ?></b> (<?= $app['transport_type'] ?>)</p>
            <form action="" method="POST" style="display:flex; gap:10px;">
                <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                <select name="status" style="flex-grow:1; padding:5px;">
                    <option <?= $app['status'] == 'Новая' ? 'selected' : '' ?>>Новая</option>
                    <option <?= $app['status'] == 'Идет обучение' ? 'selected' : '' ?>>Идет обучение</option>
                    <option <?= $app['status'] == 'Обучение завершено' ? 'selected' : '' ?>>Обучение завершено</option>
                </select>
                <button type="submit" name="update_status" style="margin:0; padding:5px 15px;">ОК</button>
            </form>
        </div>
        <?php endforeach; ?>
        <button class="btn-secondary" onclick="window.location.href='logout.php'">Выйти</button>
    </div>
</body>
</html>
