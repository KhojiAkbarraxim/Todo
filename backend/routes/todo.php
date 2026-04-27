<?php

// GET /todos
if ($uri === "/todos" && $method === "GET") {
    $stmt = $pdo->query("SELECT * FROM todos");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// POST /todos (create)
if ($uri === "/todos" && $method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (?)");
    $stmt->execute([$data["title"]]);

    echo json_encode(["message" => "created"]);
    exit;
}

// PUT /todos?id=1 (EDIT NAME)
if ($uri === "/todos" && $method === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("UPDATE todos SET title = ? WHERE id = ?");
    $stmt->execute([$data["title"], $data["id"]]);

    echo json_encode(["message" => "updated"]);
    exit;
}

// DELETE /todos?id=1
if ($uri === "/todos" && $method === "DELETE") {
    $id = $_GET["id"] ?? null;

    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "deleted"]);
    exit;
}