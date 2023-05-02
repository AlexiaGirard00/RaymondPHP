<?php
if (!isset($_SESSION)) {
    session_start();
}
require("config/connexion.php");
include "includes/enteteAdmin.php";
include "includes/menuAdmin.php";

//Définir les variables
define("msgErreur", "Un problème est survenu");
$NomProduit = "";
$IdCategorie = "";
$DescriptionProduit = "";
$DimensionProduit = "";
$TypeDeBoisProduit = "";
$CapaciteProduit = "";
$PrixProduit = "";
$EstActif = "";
$ArrayImageChemin = array();

$nom_err = $desc_err = $dim_err = $typeBois_err = $prix_err = $image_err = "";

//Gestion Resize & Upload
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


    // verifier si case est coché pour effacer = delete l'entré via ID du CHECK

    if (isset($_POST["image1"]) && !empty(trim($_POST["image1"]))) {
        if ($_POST['image1'] = '1') {
            $sqlImage = "SELECT ImageChemin FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage1'] . "";
            $stmt = $pdo->prepare($sqlImage);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            echo $sqlImage;

            //Effacer le fichier X dans le repertoire uploads et ajouter ce code dans les 3 deletes
      
                if (unlink($row["ImageChemin"])) {
                    echo 'Le fichier ' . $row["ImageChemin"]. ' a bien été effacé';
                } else {
                    echo 'Le fichier ' . $row["ImageChemin"]. ' n\'a pas pu être effacé';
                }
            

            $sqlImage = "DELETE FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage1'] . "";
            $stmt = $pdo->prepare($sqlImage);
            $stmt->execute();

           
        }
    }
    if (isset($_POST["image2"]) && !empty(trim($_POST["image2"]))) {
        if ($_POST['image2'] = '2') {
            $sqlImage = "DELETE FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage2'] . "";
            $stmt = $pdo->prepare($sqlImage);
            $stmt->execute();
            echo "DELETE FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage2'] . "";
        }
    }
    if (isset($_POST["image3"]) && !empty(trim($_POST["image3"]))) {
        if ($_POST['image3'] = '3') {
            $sqlImage = "DELETE FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage3'] . "";
            $stmt = $pdo->prepare($sqlImage);
            $stmt->execute();
            echo "DELETE FROM `dbo.imageproduit` WHERE IdImageProduit = " . $_POST['checkimage3'] . "";
        }
    }


    $uploadPath = "./uploads/";
    $imageProcess = 0;
    $i = 0;
    $fileNames = array_filter($_FILES['upload_image']['name']);
    if (!empty($fileNames)) {
        foreach ($_FILES['upload_image']['name'] as $key => $val) {
            // File upload path 
            $fileName = basename($_FILES['upload_image']['name'][$key]);
            $targetFilePath = $uploadPath . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
            if (in_array($fileType, $allowTypes)) {
                // Upload file to server

                if (move_uploaded_file($_FILES["upload_image"]["tmp_name"][$key], $targetFilePath)) {
                    $sourceProperties = getimagesize($targetFilePath);
                    $resizeFileName = substr(strval(microtime()), 2, 8);
                    $uploadImageType = $sourceProperties[2];
                    $sourceImageWidth = $sourceProperties[0];
                    $sourceImageHeight = $sourceProperties[1];
                    // Check whether file type is valid 
                    if ($sourceImageWidth > 300) {
                        $new_width = 300;
                        $new_height = $sourceImageHeight / ($sourceImageWidth / 300);
                    } else {
                        $new_width = $sourceImageWidth;
                        $new_height = $sourceImageHeight;
                    }


                    switch ($uploadImageType) {
                        case IMAGETYPE_JPEG:
                            $resourceType = imagecreatefromjpeg($targetFilePath);
                            $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                            imagejpeg($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileType);
                            break;

                        case IMAGETYPE_GIF:
                            $resourceType = imagecreatefromgif($targetFilePath);
                            $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                            imagegif($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileType);
                            break;

                        case IMAGETYPE_PNG:
                            $resourceType = imagecreatefrompng($targetFilePath);
                            $imageLayer = resizeImage($resourceType, $sourceImageWidth, $sourceImageHeight, $new_width, $new_height);
                            imagepng($imageLayer, $uploadPath . "thump_" . $resizeFileName . '.' . $fileType);
                            break;

                        default:
                            break;
                    }



                    unlink($targetFilePath);
                    //Array Image db insert sql 
                    $ArrayImageChemin[$i] = $uploadPath . "thump_" . $resizeFileName . '.' . $fileType;
                } else {
                    $errorUpload .= $_FILES['upload_image']['name'][$key] . ' | ';
                }
            } else {
                $errorUploadType .= $_FILES['upload_image']['name'][$key] . ' | ';
            }
            $i = $i + 1;

        }
    }
}




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST["id"];

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
        $desc_err = "Entrer une description.";
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

    //******** CODE POUR L'IMAGE********** */
    //Valider l'image

    $ImageChemin = "";

    //Vérifier la valeur du select (categorie)
    $IdCategorie = $_POST['NomCategorie'];

    //Mettre la valeur de capacite
    $CapaciteProduit = $_POST["CapaciteProduit"];

    //Vérifier si actif ou anterieure est check
    $rb = $_POST["exampleRadios"];
    if ($rb == "actif") {
        $EstActif = 1;
    } else {
        $EstActif = 0;
    }

    //Vérifier les inputs avant de les envoyer à la BD
    if (empty($nom_err) && empty($desc_err) && empty($dim_err) && empty($typeBois_err) && empty($prix_err) && empty($image_err)) {
        $sql = "UPDATE `dbo.produits` SET NomProduit = :nom, IdCategorieFk = :cat, DescriptionProduit = :desc, DimensionProduit = :dim, " .
            " TypeDeBoisProduit = :typeBois, CapaciteProduit = :capacite, PrixProduit = :prix, " .
            " ActifProduit = :actif WHERE IdProduit = $id ";

        if ($stmt = $pdo->prepare($sql)) {
            //set avant de bind
            $param_nom = $NomProduit;
            $param_cat = $IdCategorie;
            $param_desc = $DescriptionProduit;
            $param_dim = $DimensionProduit;
            $param_typeBois = $TypeDeBoisProduit;
            $param_capacite = $CapaciteProduit;
            $param_prix = $PrixProduit;
            $param_actif = $EstActif;

            $stmt->bindParam(":nom", $param_nom);
            $stmt->bindParam(":cat", $param_cat);
            $stmt->bindParam(":desc", $param_desc);
            $stmt->bindParam(":dim", $param_dim);
            $stmt->bindParam(":typeBois", $param_typeBois);
            $stmt->bindParam(":capacite", $param_capacite);
            $stmt->bindParam(":prix", $param_prix);
            $stmt->bindParam(":actif", $param_actif);

            //Execute
            if ($stmt->execute()) {
                // upload des images
                //Execute
               
                $lastid = $id;
               
                for ($i = 0; $i < sizeof($ArrayImageChemin); $i++) {
                    $sqlImage = "INSERT INTO `dbo.imageproduit` (IdProduitFk,ImageChemin) VALUES (:IdProduit, :ImageChemin)";
                    if ($stmtimage = $pdo->prepare($sqlImage)) {
                        //set avant de bind
                        $param_idproduit = $lastid;
                        $param_imagechemin = $ArrayImageChemin[$i];

                        $stmtimage->bindParam(":IdProduit", $param_idproduit);
                        $stmtimage->bindParam(":ImageChemin", $param_imagechemin);
                        $stmtimage->execute();
                    }
                }
                


                if ($EstActif == 1) {
?>
                    <script type="text/javascript">
                       //  window.location.href = "gestionProduitsActifs.php";
                    </script>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                     // window.location.href = "gestionProduitsAnterieures.php";
                    </script>
<?php
                }
            } else {
                echo msgErreur;
            }
        }
    }
    //fermer statement et connection
    unset($stmt);
    unset($pdo);
} else {
    // afficher produit

    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM `dbo.produits` WHERE IdProduit = :id";
        if ($stmt = $pdo->prepare($sql)) {
            //set
            $param_id = $id;
            //bind
            $stmt->bindParam(":id", $param_id);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $IdProduit = $row["IdProduit"];
                    $NomProduit = $row["NomProduit"];
                    $IdCategorie = $row["IdCategorieFk"];
                    $DescriptionProduit = $row["DescriptionProduit"];
                    $DimensionProduit = $row["DimensionProduit"];
                    $TypeDeBoisProduit = $row["TypeDeBoisProduit"];
                    $CapaciteProduit = $row["CapaciteProduit"];
                    $PrixProduit = $row["PrixProduit"];

                    $EstActif = $row["ActifProduit"];
                } else {
                    echo msgErreur;
                }
            } else {
                echo msgErreur;
            }
        }
        //fermer statement et connection
        unset($stmt);
        unset($pdo);
    } else {
        echo msgErreur;
    }
}
?>

<div class="container my-5">

    <div class="d-flex justify-content-end mt-5">
        <a class="btn btn-secondary" href="admin.php">Retour</a>
    </div>
    <h2>Modifier <?php echo $NomProduit; ?> </h2>
    <form action="<?php echo htmlspecialchars(($_SERVER["PHP_SELF"])); ?>" method="post" enctype="multipart/form-data">
        <input type="text" hidden name="id" value="<?php echo $IdProduit; ?>">
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
                    if ($row['IdCategorie'] == $IdCategorie) {
                        echo "
                                    <option value='$row[IdCategorie]' selected>$row[NomCategorie]</option>
                                ";
                    } else {
                        echo "
                                    <option value='$row[IdCategorie]'>$row[NomCategorie]</option>
                                ";
                    }
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


        <div id="Upload1"></div>
        <div class="form-group">
            <label class="required">Modifier Principale</label>
            <input id="image1" disabled type="file" name="upload_image[]" class="form-control">
        </div>

        <div id="Upload2"></div>
        <div class="form-group">
            <label class="required">Modifier image #1</label>
            <input id="image2" disabled type="file" name="upload_image[]" class="form-control">
        </div>

        <div id="Upload3"></div>
        <div class="form-group">
            <label class="required">Modifier image #2</label>
            <input id="image3" disabled type="file" name="upload_image[]" class="form-control">
        </div>



        <?php
        //Aller chercher les images du produit en cours
        $chemin = "";


        $queryImage = "SELECT ImageChemin,IdImageProduit FROM `dbo.imageproduit` WHERE IdProduitFk = " . $id . "";
        //Faire la query
        $resImage = $connect->query($queryImage);
        $numero = 1;
        while ($rowImage = mysqli_fetch_array($resImage)) { ?>
            <script>
                document.getElementById("Upload<?php echo $numero ?>").innerHTML = '<div class="swiper-slide mb-3 mt-3">' +
                    '<img src="<?php echo $rowImage['ImageChemin']; ?>" alt="Image">' +
                    '</div>' +
                    '<div>' +
                    '<input type="checkbox" onclick="activerFichier(<?php echo $numero ?>)" name="image<?php echo $numero ?>" value="<?php echo $numero ?>" >' +
                    '<input hidden name="checkimage<?php echo $numero ?>" value="<?php echo $rowImage['IdImageProduit']; ?>"' + '<label for="image" style="padding-left:1%;"> Cocher pour effacer</label><br>' +
                    '</div>';
            </script>
            <!-- FIN INSERER LE CAROUSSEL ICI -->
        <?php $numero = $numero + 1;
        } ?>


        <!-- <input type="text" class="form-control <?php echo (!empty($image_err)) ? "is-invalid" : ""; ?>" id="ImageChemin" name="ImageChemin" value=""> -->

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
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="actif" <?php echo ($EstActif == 1) ? "checked" : ""; ?>>
            <label class="form-check-label" for="exampleRadios1">Actif</label>
        </div>
        <div class="form-group form-check">
            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="anterieure" <?php echo ($EstActif == 0) ? "checked" : ""; ?>>
            <label class="form-check-label" for="exampleRadios2">Antérieure</label>
        </div>
        <div class="mt-3 mb-3">
            <button type="submit" class="btn btn-primary">Modifier</button>
        </div>


    </form>

</div>

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
    // fonction pour activer/desactiver à partir d'un checkbox
    function activerFichier(obj) {
        if (eval('document.getElementById("image' + obj + '")').disabled == true) {
            eval('document.getElementById("image' + obj + '")').disabled = false;
        } else {
            eval('document.getElementById("image' + obj + '")').disabled = true;
        }

    }

    <?php for ($i = $numero; $i <= 3; $i++) {
        echo "activerFichier(" . $i . ");";
    } ?>
</script>