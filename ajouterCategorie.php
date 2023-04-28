<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once("config/connexion.php");
    include_once "includes/enteteAdmin.php";
    include_once "includes/menuAdmin.php";


    //Définir les variables
    $NomCategorie = "";
    $DescriptionCategorie = "";
    $ActifCategorie = "";

    $nom_err = $desc_err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        //************************************ VALIDATION DES CHAMPS *********************************** */
        //Valider le nom
        $input_name = trim($_POST["NomCategorie"]);
        if(empty($input_name)){
            $nom_err = "Entrer un nom.";
        }else{
            $NomCategorie = $input_name;
        }

        //Valider la description
        $input_desc = trim($_POST["DescriptionCategorie"]);
        if(empty($input_desc)){
            $desc_err = "Entrer une descritpion.";
        }else{
            $DescriptionCategorie = $input_desc;
        }

        //Mettre actif
        $ActifCategorie = 1;


        //Vérifier les inputs avant de les envoyer à la BD
        if(empty($nom_err) && empty($desc_err)){
            $sql = "INSERT INTO `dbo.categories` (NomCategorie, DescriptionCategorie, ActifCategorie) VALUES (:nom, :desc, :actif)";

            if($stmt = $pdo->prepare($sql)){
                //set avant de bind
                $param_nom = $NomCategorie;
                $param_desc = $DescriptionCategorie;
                $param_actif = $ActifCategorie;

                $stmt->bindParam(":nom", $param_nom);
                $stmt->bindParam(":desc", $param_desc);
                $stmt->bindParam(":actif", $param_actif);

                //Execute
                if($stmt->execute()){
                    //header("location: gestionProduits.php");
                ?>
                    <script type="text/javascript">
                        window.location.href = "gestionCategories.php";
                    </script>
                <?php
                }else {
                    echo "Un problème est survenu";
                }
            }
        }
        //fermer statement et connection
        unset($stmt);
        unset($pdo);
        

    }
    ?>

    <div class="container my-5">

        <div class="d-flex justify-content-end mt-5">
            <a class="btn btn-secondary" href="gestionCategories.php">Retour</a>
        </div>
        <h2>Ajouter</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="NomCategorie">Nom</label>
                <input type="text" class="form-control <?php echo (!empty($nom_err)) ? "is-invalid" : ""; ?>" id="NomCategorie" name="NomCategorie" value="<?php echo $NomCategorie; ?>" placeholder="Entrer le nom de la catégorie">
                <span class="invalid-feedback"><?php echo $nom_err;?></span>
            </div>
            <div class="form-group">
                <label for="DescriptionCategorie">Description</label>
                <input type="text" class="form-control <?php echo (!empty($desc_err)) ? "is-invalid" : ""; ?>" id="DescriptionCategorie" name="DescriptionCategorie" value="<?php echo $DescriptionCategorie; ?>" placeholder="Entrer la description du produit">
                <span class="invalid-feedback"><?php echo $desc_err;?></span>
            </div>
            
            <button type="submit" name="form_submit" class="btn btn-primary">Ajouter</button>
        </form>
        

    </div>

    </div>
    </div>    


    </body>
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