<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    require("config/connexion.php");

    include "includes/enteteAdmin.php"; 
    include "includes/menuAdmin.php"; 


    //Définir les variables
    $IdCategorie = "";
    $NomCategorie = "";
    $DescriptionCategorie = "";;
    $ActifCategorie = "";

    $nom_err = $desc_err = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
    
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

        //Vérifier si actif ou anterieure est check
        $rb = $_POST["exampleRadios"];
        if($rb == "actif"){
            $ActifCategorie = 1;
        }else {
            $ActifCategorie = 0;
        }


        //Vérifier les inputs avant de les envoyer à la BD
        if(empty($nom_err) && empty($desc_err)){
            $sql = "UPDATE `dbo.categories` SET NomCategorie = :nom, DescriptionCategorie = :desc, ActifCategorie = :actif WHERE IdCategorie = $id ";

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
        
    }else {

        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = trim($_GET["id"]);

            $sql = "SELECT * FROM `dbo.categories` WHERE IdCategorie = :id";
            if($stmt = $pdo->prepare($sql)){
                //set
                $param_id = $id;
                //bind
                $stmt->bindParam(":id", $param_id);

                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $IdCategorie = $row["IdCategorie"];
                        $NomCategorie = $row["NomCategorie"];
                        $DescriptionCategorie = $row["DescriptionCategorie"];
                        $ActifCategorie = $row["ActifCategorie"];

                    }else {
                        echo "Un problème est survenu";
                    }
                }else {
                    echo "Un problème est survenu";
                }
            }
            //fermer statement et connection
            unset($stmt);
            unset($pdo);
        }else {
            echo "Un problème est survenu";
        }
    }
    ?>

    <div class="container my-5">

        <div class="d-flex justify-content-end mt-5">
            <a class="btn btn-secondary" href="gestionCategories.php">Retour</a>
        </div>
        <h2>Modifier</h2>
        <form action="<?php echo htmlspecialchars(($_SERVER["PHP_SELF"])); ?>" method="post">
            <input type="text" hidden name="id" value="<?php echo $IdCategorie; ?>">
            <div class="form-group">
                <label for="NomCategorie">Nom</label>
                <input type="text" class="form-control <?php echo (!empty($nom_err)) ? "is-invalid" : ""; ?>" id="NomCategorie" name="NomCategorie" value="<?php echo $NomCategorie; ?>" placeholder="Entrer le nom de la catégorie">
                <span class="invalid-feedback"><?php echo $nom_err;?></span>
            </div>
            <div class="form-group">
                <label for="DescriptionCategorie">Description</label>
                <input type="text" class="form-control <?php echo (!empty($desc_err)) ? "is-invalid" : ""; ?>" id="DescriptionCategorie" name="DescriptionCategorie" value="<?php echo $DescriptionCategorie; ?>" placeholder="Entrer la description de la catégorie">
                <span class="invalid-feedback"><?php echo $desc_err;?></span>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="actif" <?php echo ($ActifCategorie == 1) ? "checked" : ""; ?>>
                <label class="form-check-label" for="exampleRadios1">Actif</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="inactif" <?php echo ($ActifCategorie == 0) ? "checked" : ""; ?>>
                <label class="form-check-label" for="exampleRadios2">Inactif</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>

    </div>

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

