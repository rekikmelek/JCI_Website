<!DOCTYPE html>
<html>  
<head>
  <meta charset="utf-8">
  <title>Admin JCI Sfax</title>
  <link rel="stylesheet" href="node_modules/admin-lte/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="Assets/node_modules/admin-lte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="node_modules/admin-lte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
<?php include 'Components/base_admin.php'; ?>

<div style="margin-left:240px;">
    <div class="container-fluid">
        <h1 class="mt-4 mb-4">Bienvenue sur le Dashboard Admin JCI Sfax</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x mb-2"></i>
                        <h5 class="card-title">Membres</h5>
                        <p class="card-text" style="font-size:2rem;">123</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                        <h5 class="card-title">Événements</h5>
                        <p class="card-text" style="font-size:2rem;">12</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-2x mb-2"></i>
                        <h5 class="card-title">Actualités</h5>
                        <p class="card-text" style="font-size:2rem;">5</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-user-shield fa-2x mb-2"></i>
                        <h5 class="card-title">Admins</h5>
                        <p class="card-text" style="font-size:2rem;">2</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'Components/footer.php'; ?>
</div>

<script src="node_modules/admin-lte/plugins/jquery/jquery.min.js"></script>
<script src="node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/admin-lte/dist/js/adminlte.min.js"></script>
</body>
</html>