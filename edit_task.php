<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['task_id'])) {
    header('Location: index.php');
    exit();
}

$task_id = $_GET['task_id'];

$stmt = $db->prepare('SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id');
$stmt->execute([
    'task_id' => $task_id,
    'user_id' => $_SESSION['user_id'],
]);
$task = $stmt->fetch();

if (!$task) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $completed = $_POST['completed'] === 'yes' ? 1 : 0;

    $stmt = $db->prepare('UPDATE tasks SET title = :title, description = :description, due_date = :due_date, priority = :priority, completed = :completed WHERE id = :task_id');
    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date,
        'priority' => $priority,
        'completed' => $completed,
        'task_id' => $task_id,
    ]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taak Bewerken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
}

.container {
    flex: 1;
}

footer {
    background-color: #000022;
    padding: 20px 0;
    margin-top: auto;
}

footer p, footer a {
    color: white;
    transition: color 0.3s ease;    
}

footer a:hover {
    color: #e50914;
}

@media (max-width: 576px) {
    footer p, footer a {
        font-size: 14px;
    }
}

@media (min-width: 576px) {
    footer p, footer a {
        font-size: 16px;
    }
}
    </style>
<?php require 'navbar.php'; ?>

<div class="container my-4">
    <h1>Taak Bewerken</h1>
    <form action="edit_task.php?task_id=<?php echo $task_id; ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Titel</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Beschrijving</label>
            <textarea name="description" id="description" class="form-control" required><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Deadline</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="completed" class="form-label">Voltooid?</label>
            <select name="completed" id="completed" class="form-select" required>
                <option value="yes" <?php echo $task['completed'] ? 'selected' : ''; ?>>Ja</option>
                <option value="no" <?php echo !$task['completed'] ? 'selected' : ''; ?>>Nee</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Prioriteit</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="low" <?php echo $task['priority'] === 'low' ? 'selected' : ''; ?>>Laag</option>
                <option value="medium" <?php echo $task['priority'] === 'medium' ? 'selected' : ''; ?>>Gemiddeld</option>
                <option value="high" <?php echo $task['priority'] === 'high' ? 'selected' : ''; ?>>Hoog</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">opslaan</button>
    </form>
</div>


<?php require "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
