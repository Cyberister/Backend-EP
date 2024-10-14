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

$stmt = $db->prepare('DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id');
$stmt->execute([
    'task_id' => $task_id,
    'user_id' => $_SESSION['user_id'],
]);

header('Location: index.php');
exit();
?>