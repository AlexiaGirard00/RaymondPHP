<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once("config/connexion.php");
    include_once "includes/enteteDetails.php";
    include_once "includes/menuDetails.php";


      //Trouver le id
      $id = trim($_GET["id"]);  
      

      //Requete SQL
      //Requete  Update
      $sql = "SELECT * FROM `dbo.produits` p LEFT JOIN `dbo.categories` c on p.IdCategorieFk = c.IdCategorie  WHERE IdProduit = $id ";

      //Faire la query
      $resultat = $connect->query($sql);
      $row = mysqli_fetch_assoc($resultat);
    
      //Aller chercher les images du produit en cours
      $chemin = "";
      $queryImage = "SELECT ImageChemin FROM `dbo.imageproduit` WHERE IdProduitFk = ".$row['IdProduit']."";
      //Faire la query
      $resImage = $connect->query($queryImage);

      //FIN aller chercher les images du produits
      

      
      
   



?>



  <div class="hero hero-single route bg-image" style="background-image: url(assets/img/overlay-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="hero-content display-table">
      <div class="table-cell">
        <div class="container">
          <h2 class="hero-title mb-4">Détails de la création </h2>
          <!-- <ol class="breadcrumb d-flex justify-content-center">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active">Portfolio Details</li>
          </ol> -->
        </div>
      </div>
    </div>
  </div>

  <main id="main">

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <!-- INSERER LE CAROUSSEL ICI -->
                <?php 
                while ($rowImage = mysqli_fetch_array($resImage)) {?>
                  <div class="swiper-slide">
                    <img src="<?php echo $rowImage['ImageChemin'];?>" alt="Image">
                  </div>
                <!-- FIN INSERER LE CAROUSSEL ICI -->
                  <?php }?>
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
          

          <div class="col-lg-4">
            <div class="portfolio-info">

              <h3>Informations </h3>
              <ul>
                <li><strong>Catégorie</strong>: <?php echo $row["NomCategorie"];?></li>
                <li><strong>Nom</strong>: <?php echo $row["NomProduit"];?></li>
                <li><strong>Description</strong>: <?php echo $row["DescriptionProduit"];?></li>
                <li><strong>Dimension</strong>: <?php echo $row["DimensionProduit"];?></li>
                <li><strong>Type de bois</strong>: <?php echo $row["TypeDeBoisProduit"];?></li>
                <li><strong>Capacité</strong>: <?php echo $row["CapaciteProduit"];?> </li>
                <li><strong>Prix</strong>: <?php echo $row["PrixProduit"];?> $</li>            

                <!-- <li><strong>Project URL</strong>: <a href="#">www.example.com</a></li> -->
              </ul>
            </div>

            <!-- <div class="portfolio-description">
              <h3>Vous êtes interessé par mes créations ?</h3>
              <p>
                Contactez-moi via le formulaire <a href="index.php#contact" style="color:blue;"> Contact </a> ou via <a href="https://www.facebook.com/profile.php?id=100012047497640" style="color:blue;">Facebook</a> .     
              </p>
            </div> -->
          </div>

        </div>
        <div class="row gy-4 ">
          <div class="portfolio-description" style="text-align: -webkit-center;">
                <h3>Vous êtes interessé par mes créations ?</h3>
                <p>
                  Contactez-moi via le formulaire <a href="index.php#contact" style="color:blue;"> Contact </a> ou via <a href="https://www.facebook.com/profile.php?id=100012047497640" style="color:blue;">Facebook</a> .     
                </p>
          </div>      
        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <?php include "includes/piedDePage.php"; ?>