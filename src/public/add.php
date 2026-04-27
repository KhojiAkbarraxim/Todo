<?php
$pdo = new PDO("sqlite:/data/database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = trim($_POST["task"]);

    if (!empty($task)) {
        $stmt = $pdo->prepare("INSERT INTO todos (task) VALUES (:task)");
        $stmt->execute([
            ":task" => $task
        ]);
    }
}

header("Location: index.php");
exit;
?>