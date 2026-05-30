<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header("Location: index.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], (int)$_POST['app_id']]);
    header("Location: admin.php");
    exit;
}

$stmt = $pdo->query("SELECT a.id, a.transport_type, a.status, u.fio FROM applications a JOIN users u ON a.user_id = u.id ORDER BY a.id DESC");
$all_apps = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head><meta charset="UTF-8"><title>Панель администратора</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="app-container" style="max-width: 100%; width: 100%;">
        <div style="padding: 20px;">
            <h1>Управление заявками</h1>
            <button style="background: var(--color-gray);" onclick="window.location.href='logout.php'">Выйти</button>
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <tr style="background: var(--color-primary); color: white;">
                    <th style="padding: 10px; border: 1px solid gray;">ID</th><th style="padding: 10px; border: 1px solid gray;">Пользователь</th>
                    <th style="padding: 10px; border: 1px solid gray;">Транспорт</th><th style="padding: 10px; border: 1px solid gray;">Статус</th><th style="padding: 10px; border: 1px solid gray;">Действие</th>
                </tr>
                <?php foreach ($all_apps as $app): ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid gray;"><?= $app['id'] ?></td>
                    <td style="padding: 10px; border: 1px solid gray;"><?= htmlspecialchars($app['fio']) ?></td>
                    <td style="padding: 10px; border: 1px solid gray;"><?= htmlspecialchars($app['transport_type']) ?></td>
                    <td style="padding: 10px; border: 1px solid gray;"><?= htmlspecialchars($app['status']) ?></td>
                    <td style="padding: 10px; border: 1px solid gray;">
                        <form action="" method="POST" style="display: flex; gap: 10px; margin: 0;">
                            <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                            <select name="status">
                                <option value="Новая" <?= $app['status'] == 'Новая' ? 'selected' : '' ?>>Новая</option>
                                <option value="Идет обучение" <?= $app['status'] == 'Идет обучение' ? 'selected' : '' ?>>Идет обучение</option>
                                <option value="Обучение завершено" <?= $app['status'] == 'Обучение завершено' ? 'selected' : '' ?>>Обучение завершено</option>
                            </select>
                            <button type="submit" name="update_status" style="margin: 0; padding: 5px;">Сохранить</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>