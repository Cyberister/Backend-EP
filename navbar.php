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
