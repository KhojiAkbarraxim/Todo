<?php
$pdo = new PDO("sqlite:/data/database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) $_POST["id"];

    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->execute([
        ":id" => $id
    ]);
}

header("Location: index.php");
exit;
?>