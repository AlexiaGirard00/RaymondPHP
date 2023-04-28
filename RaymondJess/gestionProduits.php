<?php
if (!isset($_SESSION)) {
  session_start();
}

require("config/connexionPDO.php");

?>
<?php include "includes/enteteAdmin.php"; ?>
<?php include "includes/menuAdmin.php"; ?>

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
                        Ici, je gère mes créations !
                      </p>
                      <div class="line-mf"></div>
                    </div>
                  </div>
                </div><!-- Fin sous section titre -->
                <!--- Sous section produit de la section boutique --->
                <!-- Boucle pour afficher tous les produits -->                   
          

      
          
              <a class="btn btn-dark mt-3 mb-3" href="ajouterProduit.php" style="color: #7386D5;">Ajouter</a>
              <div class="row d-flex">
             
                <?php

                    //Aller chercher tous les produits + le nom de la categorie
                    $query = "SELECT p.IdProduit, p.NomProduit, p.DescriptionProduit, p.PrixProduit, c.NomCategorie, p.ImageChemin FROM `dbo.produits` AS p JOIN `dbo.categories` AS c on p.IdCategorieFK = c.IdCategorie";

                    //Faire la query
                    $res = $connect->query($query);

                    //***********  Pourquoi quand je vérifie avec res, ça ne marche plus ? */
                    // if($resul){
                    //     die("Une erreur est survene : " . $connect->error);
                    // }

                    //Lire chaque ligne
                    while ($row = $res->fetch_assoc()) {

            echo  " <div class='col-md-4'> <!--SAME-->
                      <div class='work-box'><!--SAME-->
                        <a href=".$row['ImageChemin']." data-gallery='portfolioGallery' class='portfolio-lightbox'><!--Image agrandit-->
                          <div class='work-img'><!--SAME-->
                            <img src='".$row['ImageChemin']."' alt='produit' class='img-fluid'><!--Image-->
                          </div>
                        </a>
                        <div class='work-content'><!--SAME-->
                          <div class='row'><!--SAME-->
                            <div class='col-sm-8'><!--SAME-->
                              <h2 class='w-title'>".$row['NomProduit']."</h2><!--Titre/NomProduit-->
                              <div class='w-more'><!--SAME-->
                                <span class='w-ctegory'>".$row['NomCategorie']."</span> / <span class='w-date'>".$row['PrixProduit']." $ </span><!--categorieProduit/PrixProduit-->
                              </div>
                            </div>
                            <div class='col-sm-4'><!--SAME-->
                              <div class='w-like'><!--SAME-->                             
                                    <a href='modifierProduit.php?id=$row[IdProduit]' class='btn btn-dark' style='color:#7386D5;'><span class='bi bi-pencil-square' style='color:#7386D5;'></span></a>
                                    <a href='supprimerProduit.php?id=$row[IdProduit]&nom=$row[NomProduit]' class='btn btn-dark' style='color:#7386D5;'><span class='bi bi-trash3-fill' style='color:#7386D5;'></span></a>                             
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
  $(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
      $('#sidebar').toggleClass('active');
    });
  });
</script>



