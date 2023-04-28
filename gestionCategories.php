<?php 
    if (!isset($_SESSION)) {
        session_start();
    }
    require("config/connexion.php");
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
                        Gestion des catégories de produits
                      </h3>
                      <p class="subtitle-a">
                        Ici, je gère les catégories !
                      </p>
                      <div class="line-mf"></div>
                    </div>
                  </div>
                </div><!-- Fin sous section titre -->
                <!--- Sous section produit de la section boutique --->
                <!-- Boucle pour afficher tous les produits -->                   
          


                <div class="container my-5">
                    <h2>Liste categories</h2>
                    <a class="btn btn-primary mt-3" href="ajouterCategorie.php">Ajouter</a>
                    <div class="row mt-5">
                        <?php
                
                            //Aller chercher toutes les catégories + le count de combien de produit dans la categorie --- le LEFT est important dans la query sinon le count ne fonctionne pas avec le resultat 0
                            //$query = "SELECT * FROM `dbo.categories`";
                            $query = "SELECT c.IdCategorie, c.NomCategorie, c.DescriptionCategorie, count(p.IdProduit) FROM `dbo.categories` AS c LEFT JOIN `dbo.produits` AS p on c.IdCategorie = p.IdCategorieFk group by c.IdCategorie";

                            //Faire la query
                            $res = $connect->query($query);
                        
                            //Lire chaque ligne
                            while ($row = $res->fetch_assoc()) {

                                $sql = "SELECT count(IdProduit) FROM `dbo.produits` WHERE IdCategorieFk = $row[IdCategorie]";
                                /*(if($resultat = mysqli_query($connect, $sql)){
                                    $count = mysqli_num_rows($resultat);
                                }*/
                                $resultat = $connect->query($sql);
                                $count = $resultat->fetch_array()[0] ?? "";
                                echo "
                                    <div class='col-md-4'>
                                        <div class='card mb-5' style='height: 200px'>                                    
                                            <div class='card-body'>
                                                <h5 class='card-title'>$row[NomCategorie]</h5>
                                                <p class='card-text'>$row[DescriptionCategorie]</p>
                                                <p class='card-text'>Produits : $count</p>
                                                <div>
                                                    <a href='modifierCategorie.php?id=$row[IdCategorie]' class='btn btn-secondary'>Modifier</a>
                                                    <a onClick='verifierActif($count, $row[IdCategorie])' href='#' class='btn btn-danger'>Supprimer</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ";
                            }
                        ?>                        
                    </div>
                </div>    
            </div>
        </div>
    </body>
</html>
    <!--jQuery CDN - Slim version (=without AJAX) -->
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

        function verifierActif(count, id){
            if(count == 0){
                window.location.href = "supprimerCategorie.php?id=" + id;
            }else{
                alert("Vous ne pouvez pas supprimer une catégorie qui contient des produits.");
            }
        }
    </script>


