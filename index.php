<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT p.id, p.title, p.context, p.created_at, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
</head>
<body>
    <h1>Блог</h1>
    <a href="create_post.php">Добавить новый пост</a>
    <a href="logout.php">Выйти</a>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo htmlspecialchars($post['context']); ?></p>
                <small>Автор: <?php echo htmlspecialchars($post['username']); ?>, Дата: <?php echo htmlspecialchars($post['created_at']); ?></small>
                <a href="edit_post.php?id=<?php echo htmlspecialchars($post['id']); ?>">Редактировать</a>
                <a href="delete_post.php?id=<?php echo htmlspecialchars($post['id']); ?>">Удалить</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>