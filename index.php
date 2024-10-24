<?php
session_start();
require 'db.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$stmt = $db->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Takenbeheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">


</head>

<body>

    <?php require 'navbar.php'; ?>

    <div class="container my-4">
        <h1 class="text-center">Takenbeheer</h1>
        <?php if ($user_id && !empty($tasks)): ?>
            <div class="table-responsive">
                <table class="table table-striped task-table">
                    <thead>
                        <tr>
                            <th>Titel</th>
                            <th>Beschrijving</th>
                            <th>Deadline</th>
                            <th>Prioriteit</th>
                            <th>Voltooid</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['description']); ?></td>
                                <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                <td><?php echo $task['completed'] ? 'Ja' : 'Nee'; ?></td>
                                <td class="task-actions">
                                    <a href="edit_task.php?task_id=<?php echo $task['id']; ?>" class="btn btn-success btn-sm">Bewerken</a>
                                    <a href="delete_task.php?task_id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm">Verwijderen</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (!$user_id): ?>
            <p class="text-center">Log in om uw taken te bekijken.</p>
        <?php else: ?>
            <p class="text-center">Geen taken nog :/</p>
        <?php endif; ?>
    </div>
    <div class="text-center mb-4">
        <img src="foto1.jpg" alt="Beschrijving van de afbeelding" class="img-fluid" id="image">
    </div>

    <div class="container text-center">
        <a href="add_task.php" class="btn btn-success">Nieuwe Taak Toevoegen</a>
    </div>
    <div class="quote text-center my-4">
        <blockquote class="blockquote bg-success

 text-light p-3 rounded">
            <p>Selim ~ &quot;Elke taak is een stap naar jouw doel. Maak ze waar!&quot;</p>

        </blockquote>
    </div>


    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>