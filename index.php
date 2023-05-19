<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<?php include "includes/entete.php"; ?>

<?php include "includes/menu.php"; ?>

<?php include "config/connexion.php"; ?>

<!-- ======= Hero Section ======= -->
<div id="hero" class="hero route bg-image" style="background-image: url(assets/img/overlay-bg1.png)">
  <div class="overlay-itro"></div>
  <div class="hero-content display-table">
    <div class="table-cell">
      <div class="container">
        <h1 class="hero-title mb-4">Tourneur sur bois</h1>
        <h2 class="mb-2" style="color:#8D9D2B">Raymond St-michel</h2>
      </div>
    </div>
  </div>
</div><!-- End Hero Section -->

<main id="main">
  <!-- ======= Boutique Section ======= -->
  <section id="boutique" class="portfolio-mf sect-pt4 route">
    <div class="container" style="width: 1600px;">
      <!--- Sous section titre et description de la section boutique --->
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Ma Boutique
            </h3>
            <p class="subtitle-a">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div><!-- Fin sous section titre -->
      <!--- Sous section produit de la section boutique --->
      <!-- Boucle pour afficher tous les produits -->
      <div class='row d-flex'><!--SAME-->
        <?php
        $filtres = mysqli_query($connect, "SELECT `dbo.categories`.`IdCategorie`, `dbo.categories`.`NomCategorie` FROM `dbo.categories` WHERE `dbo.categories`.`ActifCategorie` = true;");
        ?>
        <!-- Inserer bouton de tri! -->
        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class=" btn filter-active">Tous</li>
              <?php
              while ($row = mysqli_fetch_array($filtres)) {
                echo  "<li data-filter='.filter-" . $row['IdCategorie'] . "' class='btn'>" . $row['NomCategorie'] . "</li>";
              }
              ?>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

          <?php
          $resultat = mysqli_query($connect, "SELECT `dbo.produits`.`IdProduit`,`NomProduit`, `dbo.categories`.`NomCategorie`, `dbo.produits`.`IdCategorieFK`, `dbo.produits`.`PrixProduit`, `dbo.produits`.`ActifProduit`
          FROM `dbo.produits` 
            LEFT JOIN `dbo.categories` ON `dbo.produits`.`IdCategorieFk` = `dbo.categories`.`IdCategorie` WHERE `dbo.produits`.`ActifProduit` = TRUE");
          //boucle pour afficher toute les cartes

          while ($row = mysqli_fetch_array($resultat)) {

            //Aller chercher les images du produit en cours
            $chemin = "";
            $queryImage = "SELECT ImageChemin FROM `dbo.imageproduit` WHERE IdProduitFk = " . $row['IdProduit'] . "";
            //Faire la query
            $resImage = $connect->query($queryImage);
            $rowImage = $resImage->fetch_array();
            if (!empty($rowImage)) {
              $chemin = $rowImage['ImageChemin'];
            }
            //FIN aller chercher les images du produits

            //echo pour eviter les erreurs                    
            echo  " <div class='col-md-3 portfolio-item filter-" . $row['IdCategorieFK'] . "'> <!--SAME-->
                      <div class='work-box'><!--SAME-->

                        <a href=" . $chemin . " data-gallery='portfolioGallery' class='portfolio-lightbox'><!--Image agrandit-->
                          <div class='work-img'><!--SAME-->
                            <img src=" . $chemin . " alt='' class='img-fluid'><!--Image-->
                          </div>
                        </a>

                        <div class='work-content'><!--SAME-->
                          <div class='row'><!--SAME-->
                            <div class='col-sm-8'><!--SAME-->
                              <h2 class='w-title'>" . $row['NomProduit'] . "</h2><!--Titre/NomProduit-->
                              <div class='w-more'><!--SAME-->
                                <span class='w-ctegory'>" . $row['NomCategorie'] . "</span> / <span class='w-date'>" . $row['PrixProduit'] . " $ </span><!--categorieProduit/PrixProduit-->
                              </div>
                            </div>
                            <div class='col-sm-4'><!--SAME-->
                              <div class='w-like'><!--SAME-->                             
                                <a href='portfolio-details.php?id=$row[IdProduit]'> <span class='bi bi-plus-circle'></span></a><!--SAME-->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>";
          } //input type 'hidden' permet de caché l'imput.. donc présent mais non vue pas l'utilisateur
          // mysqli_close($connect);
          ?>
        </div>
      </div>
    </div>
  </section><!-- End Boutique Section -->
  

  <!-- ======= Counter Section ======= -->
  <div class="section-counter paralax-mf bg-image" style="background-image: url(assets/img/overlay-bg1.png)">
    <div class="overlay-mf"></div>
    <div class="container position-relative">
      <div class="row">
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="bi bi-check"></i></span>
            </div>
            <div class="counter-num">
              <p data-purecounter-start="0" data-purecounter-end="450" data-purecounter-duration="1" class="counter purecounter"></p>
              <span class="counter-text">WORKS COMPLETED</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="bi bi-journal-richtext"></i></span>
            </div>
            <div class="counter-num">
              <p data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="counter purecounter"></p>
              <span class="counter-text">YEARS OF EXPERIENCE</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="bi bi-people"></i></span>
            </div>
            <div class="counter-num">
              <p data-purecounter-start="0" data-purecounter-end="550" data-purecounter-duration="1" class="counter purecounter"></p>
              <span class="counter-text">TOTAL CLIENTS</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="bi bi-award"></i></span>
            </div>
            <div class="counter-num">
              <p data-purecounter-start="0" data-purecounter-end="48" data-purecounter-duration="1" class="counter purecounter"></p>
              <span class="counter-text">AWARD WON</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- End Counter Section -->


  <!-- ======= Oeuvres Anterieures Section ======= -->
  <section id="oeuvres" class="portfolio-mf sect-pt4 route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              Oeuvres Antérieures
            </h3>
            <p class="subtitle-a">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            </p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="row">

        <?php


        $resultat = mysqli_query($connect, "SELECT `dbo.produits`.`IdProduit`,`dbo.produits`.`NomProduit`, `dbo.categories`.`NomCategorie`, `dbo.produits`.`PrixProduit`, `dbo.produits`.`DateProduit`
          FROM `dbo.produits` 
            LEFT JOIN `dbo.categories` ON `dbo.produits`.`IdCategorieFK` = `dbo.categories`.`IdCategorie` WHERE `dbo.produits`.`ActifProduit` = 0 ORDER BY `dbo.produits`.`DateProduit` DESC LIMIT 3");


        //boucle pour afficher toute les cartes
        while ($row = mysqli_fetch_array($resultat)) {
          //Aller chercher les images du produit en cours
          $chemin = "";
          $queryImage = "SELECT ImageChemin FROM `dbo.imageproduit` WHERE IdProduitFk = " . $row['IdProduit'] . "";
          //Faire la query
          $resImage = $connect->query($queryImage);
          $rowImage = $resImage->fetch_array();
          if (!empty($rowImage)) {
            $chemin = $rowImage['ImageChemin'];
          }
          //FIN aller chercher les images du produits            
          //echo pour eviter les erreurs                    
          echo  " <div class='col-md-4'> <!--SAME-->
                      <div class='work-box'><!--SAME-->
                        <a href=" . $chemin . " data-gallery='portfolioGallery' class='portfolio-lightbox'><!--Image agrandit-->
                          <div class='work-img'><!--SAME-->
                            <img src=" . $chemin . " alt='' class='img-fluid'><!--Image-->
                          </div>
                        </a>
                        <div class='work-content'><!--SAME-->
                          <div class='row'><!--SAME-->
                            <div class='col-sm-8'><!--SAME-->
                              <h2 class='w-title'>" . $row['NomProduit'] . "</h2><!--Titre/NomProduit-->
                              <div class='w-more'><!--SAME-->
                                <span class='w-ctegory'>" . $row['NomCategorie'] . "</span> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>";
        }  ?>

      </div>
    </div>
  </section><!-- End Oeuvres Anterieures Section -->

  <!-- ======= Testimonials Section ======= -->
  <div class="testimonials paralax-mf bg-image" style="background-image: url(assets/img/overlay-bg1.png)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

              <div class="swiper-slide">
                <div class="testimonial-box">
                  <div class="author-test">
                    <img src="assets/img/testimonial-2.jpg" alt="" class="rounded-circle b-shadow-a">
                    <span class="author">Daniel Laplante</span>
                  </div>
                  <div class="content-test">
                    <p class="description lead">
                      Les produits sont magnifiques
                    </p>
                  </div>
                </div>
              </div><!-- End testimonial item -->

              <div class="swiper-slide">
                <div class="testimonial-box">
                  <div class="author-test">
                    <img src="assets/img/testimonial-4.jpg" alt="" class="rounded-circle b-shadow-a">
                    <span class="author">Jessika</span>
                  </div>
                  <div class="content-test">
                    <p class="description lead">
                      Raymond est vraiment SUPER !!

                    </p>
                  </div>
                </div>
              </div><!-- End testimonial item -->
            </div>
            <div class="swiper-pagination"></div>
          </div>

          <!-- <div id="testimonial-mf" class="owl-carousel owl-theme">
          
        </div> -->
        </div>
      </div>
    </div>
  </div><!-- End Testimonials Section -->



  <!-- ======= A propos Section ======= -->
  <section id="apropos" class="about-mf sect-pt4 route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="box-shadow-full">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div>
                    <div class="about-img" style="padding-right: 5%;">
                      <img src="assets/img/raymond2.jpg" class="img-fluid rounded b-shadow-a" alt="Raymond">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="about-me pt-4 pt-md-0">
                  <div class="title-box-2">
                    <h5 class="title-left">
                      À propos de moi
                    </h5>
                  </div>
                  <p class="lead text-justify">
                    Je suis Raymond St-Michel, un jeune homme de 79 ans.<br>
                    Jadis, je tournais de grosses pièces de bois. Suite à une fâcheuse chute, je tourne de petites pièces tels bols ,
                    assiettes, urnes et autres.
                    Je me suis laissé convaincre de vendre mes créations puisque selon mon épouse "nous manquons d'espace ". <br>
                    Voici le résultat, rincez vous l'oeil !<br>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End A propos Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(assets/img/overlay-bg1.png)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="contact" class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="title-box-2">
                    <h5 class="title-left">
                      Envoyez-nous un message
                    </h5>
                  </div>
                  <div>
                    <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Nom complet" required>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Courriel" required>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Sujet" required>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                          </div>
                        </div>
                        <div class="col-md-12 text-center my-3">
                          <div class="loading">Chargement</div>
                          <div class="error-message"></div>
                          <div class="sent-message">Votre message a été envoyé. Merci!</div>
                        </div>
                        <div class="col-md-12 text-center">
                          <button type="submit" class="button button-a button-big button-rouded">Envoyer</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="title-box-2 pt-4 pt-md-0">
                    <h5 class="mt-1" style="color:white;">

                    </h5>
                  </div>
                  <div class="more-info">
                    <p class="lead">
                    <div class="iframe-rwd">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d88709.02114419514!2d-73.14623197513446!3d45.98809624393948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sfr!2sca!4v1681763260696!5m2!1sfr!2sca" width="311" height="667" style="border:0;" title="Googlemap" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div>
                      <b>HORAIRE : </b> Sur rendez-vous
                    </div>

                    <div>
                      <b>MODE DE PAIEMENT : </b> Virement Interac
                    </div>
                    </p>
                    <ul class="list-ico">
                      <li><span class="bi bi-person-fill"></i></span> Raymond St-Michel</li>
                      <li><span class="bi bi-geo-alt-fill"></span> Sainte-Victoire-de-Sorel, QC J0G 1T0</li>

                      <!-- <li><span class="bi bi-phone"></span> (617) 557-0089</li> -->
                      <li><span class="bi bi-envelope-fill"></span> stmichelraymond.gmail.com</li>
                      <li><span class="bi bi-facebook"></span><a href="https://www.facebook.com/profile.php?id=100012047497640">Contactez-moi ! </a></li>
                    </ul>
                  </div>

                  <div class="socials">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php include "includes/piedDePage.php"; ?>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min2.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>