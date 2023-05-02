<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" aria-label="">
            <div class="sidebar-header">
                <h3>ADMIN</h3>
            </div>

            <ul class="list-unstyled components">
                <p style="color: black;">Gestion du site Web</p>
                <li class="active">
                    <a href="admin.php">Accueil</a>                   
                </li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Gestion des produits</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="gestionProduitsActifs.php">Produits Actif</a>
                        </li>
                        <li>
                            <a href="gestionProduitsAnterieures.php">Produits Antérieure</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="gestionCategories">Gestion des catégories</a>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="index.php" class="download">Site WEB</a>
                </li>  
                <li>
                    <a href="config/deconnection.php" class="download">Se deconnecter</a>
                </li>               
            </ul>

            <ul>

            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light" aria-label="">
                <div class="container-fluid">                   

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul> -->
                    </div>
                    <button type="button" id="sidebarCollapse" class="btn btn-dark" style="color:#7386D5;">
                        <i class="fas fa-align-left"></i> Menu
                        
                    </button>                    
                    <!-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button> -->
                </div>              
            </nav>

