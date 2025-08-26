<?php
session_start();
include('../config/config.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['mot_de_passe'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['nom'];
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Email non trouvé";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion Admin JCI Sfax</title>
    <link rel="stylesheet" href="../Assets/node_modules/admin-lte/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../Assets/css/login.css">
</head>

<body>
    <div class="login-box">
        <div class="login-logo">
            <img src="../Assets/Pictures/logo_jci sfax.png" alt="Logo JCI Sfax">
            <div style="font-size:1.3rem;font-weight:bold;color:#007bff;">JCI Sfax Admin</div>
        </div>
        <div class="card shadow">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Connectez-vous à votre espace admin</p>
                <form method="POST">
                    <div class="input-group mb-6">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-envelope text-primary"></i></span>
                        <input type="email" name="email" class="form-control border-start-0" placeholder="Email" required>
                    </div>
                    <div class="input-group mb-6">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-primary"></i></span>
                        <input type="password" name="password" class="form-control border-start-0" placeholder="Mot de passe" required>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button type="submit" name="login" class="btn btn-success">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../Assets/node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
    <script src="../Assets/node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/node_modules/admin-lte/dist/js/adminlte.min.js"></script>
</body>

</html>