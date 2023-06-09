<?php

require "config/connexion.php";
include "includes/enteteAdmin.php";
include "includes/menuAdmin.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Trouver le id
    $id = trim($_POST["id"]);

    //Requete  Update
    $sql = "DELETE FROM `dbo.categories` WHERE IdCategorie = $id ";

    //Executer la requete
    $res = $connect->query($sql);

    if ($res) {
    ?>
        <script type="text/javascript">
            window.location.href = "gestionCategories.php";
        </script>
    <?php
    } else {
        echo "Un problème est survenu";
    }
}

//trouver le nom de la catégorie -- pas passé par URL car fonction verifierActif ne me laisse pas ajouter un 3e parametres... À vérifier
$id = $_GET["id"];
$sql = "SELECT NomCategorie FROM `dbo.categories` WHERE IdCategorie = $id";
$resultat = $connect->query($sql);
$nomCat = $resultat->fetch_array()[0] ?? "";
?>
    
<section class="section dashboard">
    <div class="container">
        <!--- Sous section titre et description  --->
        <div class="row">
            <div class="col-sm-12">
                <div class="title-box text-center">
                    <h3 class="title-a">Gestion des catégories</h3>
                    <p class="subtitle-a">Ici, je gère les catégories !</p>
                    <div class="line-mf"></div>
                </div>
            </div>
        </div><!-- Fin sous section titre -->
        <!-- Boucle pour afficher message  -->
        <div class="container my-5">
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Supprimer la catégorie  <?php echo $nomCat ?></h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>">
                            <p>Êtes-vous certain de vouloir supprimer cette catégorie ?</p>
                            <p>
                                <input type="submit" value="Oui" class="btn btn-danger">
                                <a href="gestionCategories.php" class="btn btn-secondary ml-2">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>   

<!-- jQuery CDN - Slim version (=without AJAX) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>