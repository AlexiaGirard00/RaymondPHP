<?php 
    if (!isset($_SESSION)) {
        session_start();
    }
    require("config/connexion.php");
?>
<?php include "includes/enteteAdmin.php"; ?>
<?php include "includes/menuAdmin.php"; ?>
                <div class="container my-5">
                    <h2>Liste categories</h2>
                    <a class="btn btn-primary mt-3" href="ajouterProduit.php">Ajouter</a>
                    <div class="row mt-5">
                        <?php
                
                        //Aller chercher tous les produits + le nom de la categorie
                            $query = "SELECT p.IdProduit, p.NomProduit, p.DescriptionProduit, p.PrixProduit, c.NomCategorie FROM `dbo.produits` AS p JOIN `dbo.categories` AS c on p.IdCategorieFK = c.IdCategorie";

                            //Faire la query
                            $res = $connect->query($query);
                        
                            //***********  Pourquoi quand je vérifie avec res, ça ne marche plus ? */
                            // if($resul){
                            //     die("Une erreur est survene : " . $connect->error);
                            // }
                        
                            //Lire chaque ligne
                            while ($row = $res->fetch_assoc()) {
                                echo "
                                    <div class='col-md-4'>
                                        <div class='card mb-5' style='height: 200px'>
                                    
                                            <div class='card-body'>
                                                <h5 class='card-title'>$row[NomProduit]</h5>
                                                <h6 class='card-subtitle mb-2 text-muted'>$row[NomCategorie]</h6>
                                                <p class='card-text'>$row[DescriptionProduit]</p>
                                                <div class='row d-flex'>
                                                    <a href='modifierProduit.php?id=$row[IdProduit]' class='btn btn-secondary'>Modifier</a>
                                                    <a href='supprimerProduit.php?id=$row[IdProduit]' class='btn btn-danger'>Supprimer</a>
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


