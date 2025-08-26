<nav id="sidebarMenu" class="bg-light border-right sidebar"
    style="width:220px;position:fixed;height:100%;top:0;left:0;z-index:100;transition:width 0.3s;">
    <div class="sidebar-heading text-primary font-weight-bold mt-4 mb-3 text-center">
        <button id="sidebarToggle" class="btn btn-link"><i class="fas fa-bars"></i></button> Menu
    </div>
    <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action bg-light"><i
                class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
        <a href="Postes/index.php" class="list-group-item list-group-item-action bg-light"><i
                class="fas fa-users mr-2"></i> Postes</a>
        <a href="Membres/index.php" class="list-group-item list-group-item-action bg-light"><i
                class="fas fa-users mr-2"></i> Membres</a>
        <a href="Events/index.php" class="list-group-item list-group-item-action bg-light"><i
                class="fas fa-calendar-alt mr-2"></i> Événements</a>
        <a href="Auth/logout.php" class="list-group-item list-group-item-action bg-light text-danger"><i
                class="fas fa-sign-out-alt mr-2"></i> Déconnexion</a>
    </div>
</nav>
<script>
    document.getElementById('sidebarToggle').onclick = function () {
        var sidebar = document.getElementById('sidebarMenu');
        sidebar.style.width = sidebar.style.width === '60px' ? '220px' : '60px';
    };
</script>