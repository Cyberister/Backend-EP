<?php
require 'db.php'; 

$menuItems = '';
$usernameDisplay = '';

if (isset($_SESSION['user_id'])) {
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Uitloggen</a>
        </li>
    ';
    $usernameDisplay = isset($_SESSION['username']) ? 
        '<span class="username-box">' . htmlspecialchars($_SESSION['username']) . '</span>' : '';
} else {
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link" href="register.php">Registreren</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Inloggen</a>
        </li>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="foto.jpg" alt="Logo" class="rounded-circle" width="40" height="40"> 
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <?php echo $menuItems; ?>
            </ul>
            <?php if ($usernameDisplay): ?>
                <div class="navbar-text ms-3"> 
                    <?php echo $usernameDisplay; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
nav.navbar {
    padding: 10px 15px; 
    background-color: #000022;
}

nav.navbar .navbar-brand img {
    width: 40px;
    height: 40px; 
    border-radius: 50%; 
}



nav.navbar a {
    font-size: 16px; 
    padding: 5px 10px; 
}

.username-box {
    background-color: #f5f5f5 ; 
    color: green;
    padding: 3px 8px; 
    font-size: 14px; 
    border-radius: 50px; 
    margin-left: 10px;
}
</style>
    
</body>
</html>