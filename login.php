<?php
session_start();
require 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $stmt = $db->prepare('SELECT id, username, password FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit();
            } else {
                $error = 'Onjuist wachtwoord.';
            }
        } else {
            $error = 'Gebruikersnaam bestaat niet.';
        }
    } else {
        $error = 'Gebruikersnaam en wachtwoord zijn vereist.';
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="loginregeling.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="login-container">
        <h1>Inloggen</h1>
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username" class="visually-hidden">Gebruikersnaam</label>
            <input type="text" name="username" id="username" placeholder="Gebruikersnaam" required>

            <label for="password" class="visually-hidden">Wachtwoord</label>
            <input type="password" name="password" id="password" placeholder="Wachtwoord" required>

            <button type="submit">login</button>
        </form>
        <p class="mt-3"><a href="register.php" class="text-white">geen account? registreer hier</a></p>
    </div>
    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
