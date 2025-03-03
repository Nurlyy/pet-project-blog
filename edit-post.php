<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id =  $_SESSION['user_id'];

if($_SEVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $context = $_POST['context'];

    try {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, context = ? WHERE id=? AND user_id = ?");
        $stmt->execute([$title, $context, $post_id, $user_id]);
        header("Location: index.php");
        exit;
    }   catch (PDOException $e) {
        $error = "Ошибка при обновлении поста $post_id: " . $e->getMessage();
    }
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=? AND user_id = ?");
$stmt->execute([$post_id, $user_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post) {
    header("Location:index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование поста</title>
</head>
<body>
    <h1>Редактирование поста</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="title">Заголовок:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
        <label for="content">Содержимое:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        <button type="submit">Сохранить</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>

