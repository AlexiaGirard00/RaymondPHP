
<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    require("config/connexionPDO.php");

?>
<?php include "includes/enteteAdmin.php"; ?>
<?php include "includes/menuAdmin.php"; ?>



<?php
//Définir les variables
$NomProduit = "";
$IdCategorie = "";
$DescriptionProduit = "";
$DimensionProduit = "";
$TypeDeBoisProduit = "";
$CapaciteProduit = "";
$PrixProduit = "";
$ImageChemin = "";
$EstActif = "";
$EstAnterieur = "";

$nom_err = $desc_err = $dim_err = $typeBois_err = $prix_err = $image_err = "";

$imageProcess = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    function resizeImage($resourceType, $image_width, $image_height, $resizeWidth, $resizeHeight)
    {
        //$resizeWidth = 100;
        //$resizeHeight = 100;
        $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
        imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
        return $imageLayer;
    }

    if (isset($_POST["form_submit"])) {
        $imageProcess = 0;
        if (is_array($_FILES)) {
            $fileName = $_FILES['upload_image']['tmp_name'];
            $sourceProperties = getimagesize($fileName);
            $resizeFileName = time();
            $uploadPath = "./uploads/";
            $fileExt = pathinfo($_FILES['upload_image']['name'], PATHINFO_EXTENSION);
            $uploadImageType = $sourceProperties[2];
            $sourceImageWidth = $sourceProperties[0];
            $sourceImageHeight = $sourceProperties[1];
            if ($sourceImageWidth > 300) {
                $new_width = 300;
                $new_height = $sourceImageHeight / ($sourceImageWidth / 300);
            } else {
                $new_width = $sourceImageWidth;
                $new_height = $sourceImageHeight;
            }

            switch ($uploadImageType) {
                case IMAGETYPE_JPEG:
                    $resourceType = imagecreatefromjpeg($fileName);
                    $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                    imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
                    break;

                case IMAGETYPE_GIF:
                    $resourceType = imagecreatefromgif($fileName);
                    $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                    imagegif($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
                    break;

                case IMAGETYPE_PNG:
                    $resourceType = imagecreatefrompng($fileName);
                    $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                    imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
                    break;

                    // case IMAGETYPE_JPG:
                    //     $resourceType = imagecreatefrompng($fileName);
                    //     $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                    //     imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt);
                    //     break;

                default:
                    $imageProcess = 0;
                    break;
            }
            move_uploaded_file($fileName, $uploadPath . $resizeFileName . "." . $fileExt);

            unlink($uploadPath . $resizeFileName . '.' . $fileExt);

            $imageProcess = 1;
        }
    }
    //************************************ VALIDATION DES CHAMPS *********************************** */
    //Valider le nom
    $input_name = trim($_POST["NomProduit"]);
    if (empty($input_name)) {
        $nom_err = "Entrer un nom.";
    } else {
        $NomProduit = $input_name;
    }

    //Valider la description
    $input_desc = trim($_POST["DescriptionProduit"]);
    if (empty($input_desc)) {
        $desc_err = "Entrer une descritpion.";
    } else {
        $DescriptionProduit = $input_desc;
    }

    //Valider la dimension
    $input_dim = trim($_POST["DimensionProduit"]);
    if (empty($input_dim)) {
        $dim_err = "Entrer une dimension.";
    } else {
        $DimensionProduit = $input_dim;
    }

    //Valider le type de bois
    $input_typeBois = trim($_POST["TypeDeBoisProduit"]);
    if (empty($input_typeBois)) {
        $typeBois_err = "Entrer un type de bois.";
    } else {
        $TypeDeBoisProduit = $input_typeBois;
    }

    //Valider le prix
    $input_prix = trim($_POST["PrixProduit"]);
    if ($input_prix == 0) {
        $typeBois_err = "Entrer un prix.";
    } else {
        $PrixProduit = $input_prix;
    }

    //Valider l'image
    $input_image = $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt;
    if (empty($input_image)) {
        $image_err = "Entrer une image.";
    } else {
        $ImageChemin = $input_image;
    }

    //Vérifier la valeur du select (categorie)
    $IdCategorie = $_POST['NomCategorie'];

    //Mettre la valeur de capacite
    $CapaciteProduit = $_POST["CapaciteProduit"];

    //Vérifier si actif ou anterieure est check
    $rb = $_POST["exampleRadios"];
    if ($rb == "actif") {
        $EstActif = 1;
        $EstAnterieur = 0;
    } else {
        $EstActif = 0;
        $EstAnterieur = 1;
    }


    //Vérifier les inputs avant de les envoyer à la BD
    if (empty($nom_err) && empty($desc_err) && empty($dim_err) && empty($typeBois_err) && empty($prix_err) && empty($prix_err) && empty($image_err)) {
        // prepare and bind
        $sql = "INSERT INTO `dbo.produits` (NomProduit, IdCategorieFK, DescriptionProduit, DimensionProduit, TypeDeBoisProduit, CapaciteProduit, PrixProduit, ImageChemin, EstAnterieure, ActifProduit) " .
            " VALUES ( ?, ?, ?, ?, ?, ?, ?, ?,?, ?)";


            
        if ($stmt = $connect->prepare($sql)) {
             //set avant de bind
            $stmt-> bind_param("sisssidsii", $NomProduit, $IdCategorie, $DescriptionProduit, $DimensionProduit, $TypeDeBoisProduit, $CapaciteProduit, $PrixProduit, $ImageChemin, $EstActif, $EstAnterieur);
           
            // $param_nom = $NomProduit;
            // $param_cat = $IdCategorie;
            // $param_desc = $DescriptionProduit;
            // $param_dim = $DimensionProduit;
            // $param_typeBois = $TypeDeBoisProduit;
            // $param_capacite = $CapaciteProduit;
            // $param_prix = $PrixProduit;
            // $param_image = $ImageChemin;
            // $param_actif = $EstActif;
            // $param_anterieure = $EstAnterieur;

            // $stmt->bindParam(":nom", $param_nom);
            // $stmt->bindParam(":cat", $param_cat);
            // $stmt->bindParam(":desc", $param_desc);
            // $stmt->bindParam(":dim", $param_dim);
            // $stmt->bindParam(":typeBois", $param_typeBois);
            // $stmt->bindParam(":capacite", $param_capacite);
            // $stmt->bindParam(":prix", $param_prix);
            // $stmt->bindParam(":image", $param_image);
            // $stmt->bindParam(":actif", $param_actif);
            // $stmt->bindParam(":anterieure", $param_anterieure);
        
            //Execute
            if ($stmt->execute()) {
                header("location: gestionProduits.php");
            } else {
                echo "Un problème est survenu";
            }
        }
    }
    //fermer statement et connection
    unset($stmt);
    unset($connect);
}
?>




    <div class="container my-5">

        <div class="d-flex justify-content-end mt-5">
            <a class="btn btn-secondary" href="admin.php">Retour</a>
        </div>
        <h2>Ajouter</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="NomProduit">Nom</label>
                <input type="text" class="form-control <?php echo (!empty($nom_err)) ? "is-invalid" : ""; ?>" id="NomProduit" name="NomProduit" value="<?php echo $NomProduit; ?>" placeholder="Entrer le nom du produit">
                <span class="invalid-feedback"><?php echo $nom_err; ?></span>
            </div>
            <div class="form-group">
                <label for="NomCategorie">Categorie</label>
                <select class="form-control" id="NomCategorie" name="NomCategorie" value="">
                    <?php
                    //Aller chercher le id et le nom des categories
                    $sql = "SELECT IdCategorie, NomCategorie FROM `dbo.categories`";

                    //Faire la query
                    $res = $connect->query($sql);

                    //Lire chaque ligne et ajouter option
                    while ($row = $res->fetch_assoc()) {
                        echo "
                                <option value='$row[IdCategorie]'>$row[NomCategorie]</option>
                            ";
                    }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="DescriptionProduit">Description</label>
                <input type="text" class="form-control <?php echo (!empty($desc_err)) ? "is-invalid" : ""; ?>" id="DescriptionProduit" name="DescriptionProduit" value="<?php echo $DescriptionProduit; ?>" placeholder="Entrer la description du produit">
                <span class="invalid-feedback"><?php echo $desc_err; ?></span>
            </div>
            <div class="form-group">
                <label for="DimensionProduit">Dimension</label>
                <input type="text" class="form-control <?php echo (!empty($dim_err)) ? "is-invalid" : ""; ?>" id="DimensionProduit" name="DimensionProduit" value="<?php echo $DimensionProduit; ?>" placeholder="Entrer la dimension du produit">
                <small id="dimensionHelp" class="form-text text-muted">Exemple : 9 x 5.5 po</small>
                <span class="invalid-feedback"><?php echo $dim_err; ?></span>
            </div>
            <div class="form-group">
                <label for="TypeDeBoisProduit">Type de bois</label>
                <input type="text" class="form-control <?php echo (!empty($typeBois_err)) ? "is-invalid" : ""; ?>" id="TypeDeBoisProduit" name="TypeDeBoisProduit" value="<?php echo $TypeDeBoisProduit; ?>" placeholder="Entrer le type de bois du produit">
                <span class="invalid-feedback"><?php echo $typeBois_err; ?></span>
            </div>
            <div class="form-group">
                <label for="CapaciteProduit">Capacité</label>
                <input type="number" min="0" class="form-control" id="CapaciteProduit" name="CapaciteProduit" value="<?php echo $CapaciteProduit; ?>" placeholder="Entrer la capacité du produit">
            </div>
            <div class="form-group">
                <label for="PrixProduit">Prix</label>
                <input type="number" min="0" class="form-control <?php echo (!empty($prix_err)) ? "is-invalid" : ""; ?>" id="PrixProduit" name="PrixProduit" value="<?php echo $PrixProduit; ?>" placeholder="Entrer le prix du produit">
                <span class="invalid-feedback"><?php echo $prix_err; ?></span>
            </div>

            <!-- SECTION UPLOAD IMAGE & RESIZE-->
            <!-- <div class="form-group col-md-3">
                <label class="required">Width</label>
                <input type="number" name="new_width" value="300" />
            </div>
            <div class="form-group col-md-3">
                <label class="required">Height</label>
                <input type="number" name="new_height" value="300"/>
            </div> -->
            <div class="form-group ">
                <label class="required">Choisi un image</label>
                <input type="file" name="upload_image" class="form-control" required>
            </div>
            <div style="text-align: center;">
                <script id="mNCC" language="javascript">
                    medianet_width = "728";
                    medianet_height = "90";
                    medianet_crid = "655540672";
                    medianet_versionId = "3111299";
                </script>
            </div>
            <!-- SECTION UPLOAD IMAGE & RESIZE-->

            <div class="form-group form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked>
                <label class="form-check-label" for="exampleRadios1" name="EstActif">Actif</label>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="1">
                <label class="form-check-label" for="exampleRadios2" name="EstAnterieure">Antérieure</label>
            </div>

            <button type="submit" name="form_submit" class="btn btn-primary">Ajouter</button>
        </form>

        <?php
        if ($imageProcess == 1) {
        ?>
            <div class="alert icon-alert with-arrow alert-success form-alter" role="alert">
                <i class="fa fa-fw fa-check-circle"></i>
                <strong> Success !</strong> <span class="success-message">Image Resize Successfully </span>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <img class="img-rounded img-responsive" alt="" src="<?php echo $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt; ?>" width="<?php echo $new_width; ?>" height="<?php echo $new_height; ?>">
                    <h4><b>Resize Image</b></h4>
                    <a href="<?php echo $uploadPath . "thump_" . $resizeFileName . '.' . $fileExt; ?>" download class="btn btn-danger"><i class="fa fa-download"></i> Download </a href="">
                </div>              
            </div>
        <?php
        }
        $imageProcess = 0;

        ?>

    </div>

    </div>
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
