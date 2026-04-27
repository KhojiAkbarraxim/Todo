<?php
$pdo = new PDO("sqlite:/data/database.db");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Todo ID is missing.");
}

$stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ?");
$stmt->execute([$id]);
$todo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$todo) {
    die("Todo not found.");
}

$task = htmlspecialchars($todo['task'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Todo</title>

<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background: #f4f6f8;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.edit-card {
  width: 100%;
  max-width: 420px;
  background: #ffffff;
  padding: 30px;
  border-radius: 18px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.edit-card h1 {
  text-align: center;
  margin-bottom: 20px;
}

.edit-card label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
}

.edit-card input[type="text"] {
  width: 100%;
  padding: 14px;
  border: 1px solid #ccc;
  border-radius: 12px;
  font-size: 16px;
  box-sizing: border-box;
}

.edit-actions {
  margin-top: 20px;
  display: flex;
  gap: 10px;
}

.edit-actions button,
.cancel-btn {
  flex: 1;
  padding: 12px;
  border-radius: 12px;
  border: none;
  text-decoration: none;
  text-align: center;
  font-size: 16px;
  cursor: pointer;
}

.edit-actions button {
  background: #2563eb;
  color: white;
}

.cancel-btn {
  background: #e5e7eb;
  color: #111827;
}
</style>

</head>
<body>

<form class="edit-card" action="update.php" method="POST">
  <h1>Edit Todo</h1>

  <input type="hidden" name="id" value="<?= htmlspecialchars($todo['id'], ENT_QUOTES, 'UTF-8') ?>">

  <label for="task">Todo task</label>
  <input
    id="task"
    type="text"
    name="task"
    value="<?= $task ?>"
    required
  >

  <div class="edit-actions">
    <a href="index.php" class="cancel-btn">Cancel</a>
    <button type="submit">Update</button>
  </div>
</form>

</body>
</html>