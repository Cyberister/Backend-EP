<?php
session_start();

$menuItems = '';

if (isset($_SESSION['user_id'])) {
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Uitloggen</a>
        </li>';
} else {
    $menuItems = '
        <li class="nav-item">
            <a class="nav-link" href="register.php">Registreren</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Inloggen</a>
        </li>';
}
