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
    <style>
       body {
           
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
           
            background-color: #333;
        }

        .login-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            max-width: 400px;
            width: 100%;
            color: white;
            text-align: center;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
            margin: auto;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            background-color: #333;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #e50914;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #e50914;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
           
        }

        button:hover {
            background-color: #f6121d;
        }

        .error-message {
            color: #e87c03;
            margin-bottom: 20px;
            font-size: 14px;
        }


    </style>
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
