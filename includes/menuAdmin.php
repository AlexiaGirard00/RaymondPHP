<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" aria-label="">
            <div class="sidebar-header">
                <h3>ADMIN</h3>
            </div>
            <ul class="list-unstyled components">
                <p style="color: black;">Gestion du site Web</p>
                <li class="active"><a href="admin.php">Accueil</a></li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Gestion des produits</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="gestionProduitsActifs.php">Produits Actifs</a></li>
                        <li><a href="gestionProduitsAnterieures.php">Produits Antérieures</a></li>
                    </ul>
                </li>
                <li><a href="gestionCategories.php">Gestion des catégories</a></li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li><a href="index.php" class="download">Site WEB</a></li>
                <li><a href="config/deconnection.php" class="download">Se déconnecter</a></li>
            </ul>
        </nav>
        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    </div>
                    <button type="button" id="sidebarCollapse" class="btn btn-dark" style="color:#8D9D2B;">
                        <i class="fas fa-align-left"></i> Menu
                    </button>
                </div>
            </nav>