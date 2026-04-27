<?php
$pdo = new PDO("sqlite:/data/database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
CREATE TABLE IF NOT EXISTS todos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  task TEXT NOT NULL,
  is_done INTEGER DEFAULT 0
)
");

$stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
$todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <h1>My Todos</h1>

  <form action="add.php" method="POST" class="add-form">
    <input type="text" name="task" placeholder="What needs to be done?" required autofocus>
    <button type="submit">Add</button>
  </form>

  <ul class="todo-list">
    <?php if (empty($todos)): ?>
      <li class="empty">No tasks yet. Add one above!</li>
    <?php endif; ?>

    <?php foreach ($todos as $todo): ?>
      <li class="<?= $todo['is_done'] ? 'done' : '' ?>">

        <form action="toggle.php" method="POST" class="inline">
          <input type="hidden" name="id" value="<?= $todo['id'] ?>">
          <button type="submit" class="check-btn">
            <?= $todo['is_done'] ? '✓' : '○' ?>
          </button>
        </form>

        <span class="task-text">
          <?= htmlspecialchars($todo['task']) ?>
        </span>

        <form action="delete.php" method="POST" class="inline">
          <input type="hidden" name="id" value="<?= $todo['id'] ?>">
          <button type="submit" class="delete-btn">✕</button>
          <a href="edit.php?id=<?= $todo['id'] ?>">Edit</a>
        </form>

      </li>
    <?php endforeach; ?>
  </ul>
</div>

</body>
</html>