<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $completed = $_POST['completed'] === 'yes' ? 1 : 0;

    if (!empty($due_date) && DateTime::createFromFormat('Y-m-d', $due_date) !== false) {
        $stmt = $db->prepare('INSERT INTO tasks (user_id, title, description, due_date, priority, completed) VALUES (:user_id, :title, :description, :due_date, :priority, :completed)');
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'priority' => $priority,
            'completed' => $completed,
        ]);

        header('Location: index.php');
        exit();
    } else {
     
        echo "Ongeldige vervaldatum. Zorg ervoor dat de datum in het juiste formaat staat.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Taak Toevoegen</title>
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
    <h1>Nieuwe Taak Toevoegen</h1>
    <form action="add_task.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Titel</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Beschrijving</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Deadline</label>
            <input type="date" name="due_date" id="due_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="form-label">Prioriteit</label>
            <select name="priority" id="priority" class="form-select" required>
                <option value="low">Laag</option>
                <option value="medium">Gemiddeld</option>
                <option value="high">Hoog</option>
            </select>
        </div>
      
        <button type="submit" class="btn btn-success">Taak Toevoegen</button>
    </form>
</div>

<?php require "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
