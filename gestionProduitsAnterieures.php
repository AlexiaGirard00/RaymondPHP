<?php
  if (!isset($_SESSION)) {
    session_start();
  }

  require_once("config/connexion.php");
  include_once "includes/enteteAdmin.php";
  include_once "includes/menuAdmin.php"; 
?>

<section class="section dashboard">
  <div class="container">
    <!--- Sous section titre et description de la section boutique --->
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Gestion de Ma Boutique
            </h3>
            <p class="subtitle-a">
              Ici, je gère les produits antérieures !
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div><!-- Fin sous section titre -->
      <!--- Sous section produit de la section boutique --->
      <!-- Boucle pour afficher tous les produits -->                   
    
    <div class="row d-flex">
      <?php
          //Aller chercher tous les produits + le nom de la categorie
          $query = "SELECT p.IdProduit, p.NomProduit, p.DescriptionProduit, p.PrixProduit, c.NomCategorie, p.ActifProduit FROM `dbo.produits` AS p JOIN `dbo.categories` AS c on p.IdCategorieFk = c.IdCategorie WHERE p.ActifProduit = 0";

          //Faire la query
          $res = $connect->query($query);

          //Lire chaque ligne
          while ($row = $res->fetch_assoc()) {

            //Aller chercher les images du produit en cours
            $chemin = "";
            $queryImage = "SELECT ImageChemin FROM `dbo.imageproduit` WHERE IdProduitFk = ".$row['IdProduit']." LIMIT 1";
            //Faire la query
            $resImage = $connect->query($queryImage);
            //FIN aller chercher les images du produits
            
            echo  
              "<div class='col-md-4'>
                <div class='work-box'>                           
                  <section id='portfolio-details' class='portfolio-details'>
                    <div class='portfolio-details-slider swiper'>
                      <div class='swiper-wrapper align-items-center'>";
                        while ($rowImage = mysqli_fetch_array($resImage)) {
                          echo
                            "<div class='swiper-slide'>
                              <img src='".$rowImage['ImageChemin']."' alt='Image'>
                            </div>"
                          ;
                        }
                    echo 
                      "</div>
                          <div class='swiper-pagination'></div>
                    </div>
                  </section>
                  <div class='work-content'>
                    <div class='row'>
                      <div class='col-sm-8'>
                        <h2 class='w-title'>".$row['NomProduit']."</h2><!--Titre/NomProduit-->
                        <div class='w-more'>
                          <span class='w-ctegory'>".$row['NomCategorie']."</span> / <span class='w-date'>".$row['PrixProduit']." $ </span>
                        </div>
                      </div>
                      <div class='col-sm-4'>
                        <div class=''>                             
                          <a href='modifierProduit.php?id=$row[IdProduit]' class='btn btn-dark' style='color:#7386D5;'><span class='bi bi-pencil-square' style='color:#7386D5;'></span></a>
                          <a href='supprimerProduit.php?id=$row[IdProduit]&nom=$row[NomProduit]&actif=$row[ActifProduit]' class='btn btn-dark' style='color:#7386D5;'><span class='bi bi-plus-circle-fill' style='color:#7386D5;'></span></a>                             
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";   
          }
        ?>
    </div> 
  </div> 
</section>
</body>

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
<script src="assets/js/main.js"></script>



