
<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once("config/connexion.php");
    include_once "includes/enteteAdmin.php";
    include_once "includes/menuAdmin.php";


    //Définir les variables
    $NomProduit = "";
    $IdCategorie = "";
    $DateProduit = "";
    $DescriptionProduit = "";
    $DimensionProduit = "";
    $TypeDeBoisProduit = "";
    $CapaciteProduit = "";
    $PrixProduit = "";
    $EstActif = "";
    $ArrayImageChemin = array();
    $i = 0;
    $uploadPath = "./uploads/";

    $nom_err = $desc_err = $dim_err = $typeBois_err = $prix_err = $image_err = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        function resizeImage($resourceType, $image_width, $image_height, $resizeWidth, $resizeHeight)
        {
            //$resizeWidth = 100;
            //$resizeHeight = 100;
            $imageLayer = imagecreatetruecolor($resizeWidth, $resizeHeight);
            imagecopyresampled($imageLayer, $resourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $image_width, $image_height);
            return $imageLayer;
        }

        if (isset($_POST['form_submit'])) { 
            // File upload configuration 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 


            // recuperer les inputs et en faire un array()      

            $fileNames = array_filter($_FILES['files']['name']); 
            if (!empty($fileNames)){                 
                foreach ($_FILES['files']['name'] as $key => $val) { 
                    // 

                    // File upload path 
                    $fileName = basename($_FILES['files']['name'][$key]);
                    $targetFilePath = $uploadPath . $fileName; 
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                  
                    if (in_array($fileType, $allowTypes)) { 
                        // Upload file to server

                        if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)){ 
                            $sourceProperties = getimagesize($targetFilePath);
                            $resizeFileName = substr(strval(microtime()), 2, 8);
                            $uploadImageType = $sourceProperties[2];
                            $sourceImageWidth = $sourceProperties[0];
                            $sourceImageHeight = $sourceProperties[1];
                            // Check whether file type is valid 
                            if ($sourceImageWidth > 416) {
                                $new_width = 416;
                                $new_height = $sourceImageHeight / ($sourceImageWidth / 416) ;
                            }else {
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
                        }else{ 
                            $errorUpload .= $_FILES['files']['name'][$key].' | '; 
                        } 
                    }else{ 
                        $errorUploadType .= $_FILES['files']['name'][$key].' | '; 
                    }
                $i = $i+1;
                } 
                // Error message 
                $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
                $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
                $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 

                if(!empty($insertValuesSQL)){ 
                    $insertValuesSQL = trim($insertValuesSQL, ','); 
                    // Insert image file name into database 
                    $insert = $db->query("INSERT INTO images (file_name, uploaded_on) VALUES $insertValuesSQL"); 
                    if($insert){ 
                        $statusMsg = "Files are uploaded successfully.".$errorMsg; 
                    }else{ 
                        $statusMsg = "Sorry, there was an error uploading your file."; 
                    } 
                }else{ 
                    $statusMsg = "Upload failed! ".$errorMsg; 
                } 
            }else{ 
                $statusMsg = 'Please select a file to upload.'; 
            } 
        } 
         //************************************ VALIDATION DES CHAMPS *********************************** */
        //Valider le nom
        $input_name = trim($_POST["NomProduit"]);
        if(empty($input_name)){
            $nom_err = "Entrer un nom.";
        }else{
            $NomProduit = $input_name;
        }

        //Valider la description
        $input_desc = trim($_POST["DescriptionProduit"]);
        if(empty($input_desc)){
            $desc_err = "Entrer une description.";
        }else{
            $DescriptionProduit = $input_desc;
        }

        //Valider la dimension
        $input_dim = trim($_POST["DimensionProduit"]);
        if(empty($input_dim)){
            $dim_err = "Entrer une dimension.";
        }else{
            $DimensionProduit = $input_dim;
        }

        //Valider le type de bois
        $input_typeBois = trim($_POST["TypeDeBoisProduit"]);
        if(empty($input_typeBois)){
            $typeBois_err = "Entrer un type de bois.";
        }else{
            $TypeDeBoisProduit = $input_typeBois;
        }

        //Valider le prix
        $input_prix = trim($_POST["PrixProduit"]);
        if($input_prix == 0){
            $typeBois_err = "Entrer un prix.";
        }else{
            $PrixProduit = $input_prix;
        }

        //Valider l'image
        $input_image = $uploadPath . "thump_" . $resizeFileName . '.' . $fileType;
        if(empty($input_image)){
            $image_err = "Entrer une image.";
        }else{
            $ImageChemin = $input_image;
        }

        //Vérifier la valeur du select (categorie)
        $IdCategorie = $_POST['NomCategorie'];

        //Mettre la valeur de capacite
        $CapaciteProduit = $_POST["CapaciteProduit"];

        //Vérifier si actif ou anterieure est check
        // $rb = $_POST["exampleRadios"];
        // if($rb == "actif"){
        //     $EstActif = 1;
        //     $EstAnterieur = 0;
        // }else {
        //     $EstActif = 0;
        //     $EstAnterieur = 1;
        // }

        //Mettre actif
        $EstActif = 1;
        $DateProduit = Date("Y/m/d");
     

        //Vérifier les inputs avant de les envoyer à la BD
        if(empty($nom_err) && empty($desc_err) && empty($dim_err) && empty($typeBois_err) && empty($prix_err)&& empty($image_err)){
            $sql = "INSERT INTO `dbo.produits` (NomProduit, IdCategorieFk, DescriptionProduit, DimensionProduit, TypeDeBoisProduit, CapaciteProduit, PrixProduit, DateProduit, ActifProduit) ".
                " VALUES (:nom, :cat, :desc, :dim, :typeBois, :capacite, :prix, :date , :actif)";

            if($stmt = $pdo->prepare($sql)){
                //set avant de bind
                $param_nom = $NomProduit;
                $param_cat = $IdCategorie;
                $param_desc = $DescriptionProduit;
                $param_dim = $DimensionProduit;
                $param_typeBois = $TypeDeBoisProduit;
                $param_capacite = $CapaciteProduit;
                $param_prix = $PrixProduit;
                $param_date = $DateProduit;
                $param_actif = $EstActif;

                $stmt->bindParam(":nom", $param_nom);
                $stmt->bindParam(":cat", $param_cat);
                $stmt->bindParam(":desc", $param_desc);
                $stmt->bindParam(":dim", $param_dim);
                $stmt->bindParam(":typeBois", $param_typeBois);
                $stmt->bindParam(":capacite", $param_capacite);
                $stmt->bindParam(":prix", $param_prix);
                $stmt->bindParam(":date", $param_date);
                $stmt->bindParam(":actif", $param_actif);

                //Execute
                if($stmt->execute()){
                    $lastid = $pdo->lastInsertId();
                    //header("location: gestionProduits.php");
                echo $lastid;
                    for ($i=0;$i<sizeof($ArrayImageChemin) ;$i++) {
                        $sqlImage = "INSERT INTO `dbo.imageproduit` (IdProduitFk,ImageChemin) VALUES (:IdProduit, :ImageChemin)";
                        if($stmtimage = $pdo->prepare($sqlImage)){
                            //set avant de bind
                            $param_idproduit = $lastid;
                            $param_imagechemin = $ArrayImageChemin[$i];
        
                            $stmtimage->bindParam(":IdProduit", $param_idproduit);
                            $stmtimage->bindParam(":ImageChemin", $param_imagechemin);
                            $stmtimage->execute();
                        }
                    }
                ?>
                    <script type="text/javascript">
                       window.location.href = "gestionProduitsActifs.php";
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
            <a class="btn btn-secondary" href="gestionProduitsActifs.php">Retour</a>
        </div>
        <h2>Ajouter</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="NomProduit">Nom</label>
                <input type="text" class="form-control <?php echo (!empty($nom_err)) ? "is-invalid" : ""; ?>" id="NomProduit" name="NomProduit" value="<?php echo $NomProduit; ?>" placeholder="Entrer le nom du produit">
                <span class="invalid-feedback"><?php echo $nom_err;?></span>
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
                        while($row = $res->fetch_assoc()){
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
                <span class="invalid-feedback"><?php echo $desc_err;?></span>
            </div>
            <div class="form-group">
                <label for="DimensionProduit">Dimension</label>
                <input type="text" class="form-control <?php echo (!empty($dim_err)) ? "is-invalid" : ""; ?>" id="DimensionProduit" name="DimensionProduit" value="<?php echo $DimensionProduit; ?>" placeholder="Entrer la dimension du produit">
                <small id="dimensionHelp" class="form-text text-muted">Exemple : 9 x 5.5 po</small>
                <span class="invalid-feedback"><?php echo $dim_err;?></span>
            </div>
            <div class="form-group">
                <label for="TypeDeBoisProduit">Type de bois</label>
                <input type="text" class="form-control <?php echo (!empty($typeBois_err)) ? "is-invalid" : ""; ?>" id="TypeDeBoisProduit" name="TypeDeBoisProduit" value="<?php echo $TypeDeBoisProduit; ?>" placeholder="Entrer le type de bois du produit">
                <span class="invalid-feedback"><?php echo $typeBois_err;?></span>
            </div>
            <div class="form-group">
                <label for="CapaciteProduit">Capacité</label>
                <input type="number" min="0" class="form-control" id="CapaciteProduit" name="CapaciteProduit" value="<?php echo $CapaciteProduit; ?>" placeholder="Entrer la capacité du produit">
            </div>
            <div class="form-group">
                <label for="PrixProduit">Prix</label>
                <input type="number" min="0" class="form-control <?php echo (!empty($prix_err)) ? "is-invalid" : ""; ?>" id="PrixProduit" name="PrixProduit" value="<?php echo $PrixProduit; ?>" placeholder="Entrer le prix du produit">
                <span class="invalid-feedback"><?php echo $prix_err;?></span>
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

            <div class="form-group">
                <label class="required">Choisi ton image # 1:</label>
            
                <input type="file" name="files[]" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="required">Choisi ton image # 2:</label>
         
                <input type="file" name="files[]" class="form-control" >
            </div>

            <div class="form-group">
                <label class="required">Choisi ton image # 3 :</label>
              
                <input type="file" name="files[]" class="form-control" >
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
