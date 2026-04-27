<?php
$pdo = new PDO("sqlite:/data/database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;
$task = trim($_POST['task'] ?? '');

if (!$id || $task === '') {
    die("Invalid input.");
}

$stmt = $pdo->prepare("UPDATE todos SET task = ? WHERE id = ?");
$stmt->execute([$task, $id]);

header("Location: index.php");
exit;