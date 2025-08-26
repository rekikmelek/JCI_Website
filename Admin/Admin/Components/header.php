<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: Auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>JCI Sfax Admin</title>
    <link rel="stylesheet" href="../assets/adminlte.min.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm mb-4">
        <div style='margin: 1%;'>
            <a class="navbar-brand" href="#">
                <img src="Assets/Pictures/logo_jci sfax.png" alt="Logo" style="height:40px;">
            </a>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Bienvenue, <?php echo $_SESSION['admin_name']; ?></span>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="Auth/logout.php">Déconnexion</a>
            </li>
        </ul>
    </nav>