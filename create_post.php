<?php

session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $context = $_POST['context'];
    $user_id = $_SESSION['user_id'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, context) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $context]);
        header("Location: index.php");
        exit;
    }   catch (PDOException $e) {
        $error = "Ошибка при добавлении поста: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление поста</title>
</head>
<body>
    <h1>Добавление поста</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="title">Заголовок:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="context">Содержимое:</label>
        <textarea id="context" name="context" required></textarea><br>
        <button type="submit">Добавить</button>
    </form>
    <a href="index.php">Назад</a>
</body>
</html>