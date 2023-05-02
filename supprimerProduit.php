<?php 
    require "config/connexion.php";

    //if(isset($_POST["id"]) && !empty(trim($_POST["id"]))){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Trouver le id
        $id = trim($_POST["id"]);    

        //Trouver actif
        $actif = trim($_POST["actif"]); 

        if($actif == 1){
            //Requete  Update
            $sql = "UPDATE `dbo.produits` SET ActifProduit = 0 WHERE IdProduit = $id ";
        }else {
            //Requete  Update
            $sql = "UPDATE `dbo.produits` SET ActifProduit = 1 WHERE IdProduit = $id ";
        }

        

        //Executer la requete
        $res = $connect->query($sql);

        if ($res){
        ?>
            <script type="text/javascript">
                window.location.href = "gestionProduitsActifs.php";
            </script>
        <?php 
        }else {
            echo "Un problème est survenu";
        }         

    }
    include "includes/enteteAdmin.php"; 
    include "includes/menuAdmin.php"; 


    //vérifier si on veut supprimer ou activer un produit
    if($_GET["actif"] == 1) {
        $action = "Désactiver";
        $message = "Êtes-vous certain de vouloir désactiver ce produit ?";
        $href = "gestionProduitsActifs.php";
    }else{
        $action = "Réactiver";
        $message = "Êtes-vous certain de vouloir réactiver ce produit ?";
        $href = "gestionProduitsAnterieures.php";
    }
?>


        <div class="container-fluid" style="width: 1000px;">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3"><?php echo $action; ?> <?php echo trim($_GET["nom"]); ?></h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>">
                            <input type="hidden" name="actif" value="<?php echo trim($_GET["actif"]); ?>">
                            <p><?php echo $message; ?></p>
                            <p>
                                <input type="submit" value="Oui" class="btn btn-danger">
                                <a href=<?php echo $href; ?> class="btn btn-secondary ml-2">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>