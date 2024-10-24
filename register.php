<?php
require 'db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = '';

    if (empty($username) || empty($password)) {
        $error = "gebruikersnaam en wachtwoord vereist";
    } else {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "gebruikersnaam bestaat al";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $db->prepare($sql);

            if ($stmt->execute(['username' => $username, 'password' => $hashedPassword])) {
                header("Location: index.php");
                exit();
            } else {
                $error = "er is een fout gevonden, je kan het opnieuw proberen.";
            }
        }
    }

    $_SESSION['error'] = $error;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="loginregeling.css">
</head>
<body>
 
<?php require "navbar.php"; ?>

    <div class="login-container">
        <h1>Registreren</h1>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <label for="username" class="visually-hidden">Gebruikersnaam</label>
            <input type="text" name="username" id="username" placeholder="Gebruikersnaam" required>

            <label for="password" class="visually-hidden">Wachtwoord</label>
            <input type="password" name="password" id="password" placeholder="Wachtwoord" required>

            <button type="submit">Registreren</button>
        </form>
        <p class="mt-3"><a href="login.php" class="text-white">Al een account? Log in</a></p>
    </div>

    <?php require "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
