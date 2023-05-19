  <!-- ======= Footer ======= -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="copyright-box">
            <p class="copyright">&copy; <?php echo date('Y'); ?><strong> Marché Conclu</strong></p>

          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <?php
  //affichage du username si username n'est pas vide
      if (isset($_SESSION["username"]) == 1) {            
          if ($_SESSION["username"]!== "") { ?>
              <script> 
                if(document.getElementById('seconnecter')){
                document.getElementById('seconnecter').href = 'admin.php';
                document.getElementById('seconnecter').innerHTML = 'Section Admin';}
              </script>
  <?php   }          
      }        
  ?>   
  
  
          




</html>

