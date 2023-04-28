<?php


// Include config file
include "includes/entete.php";

include "includes/menuDetails.php";

?>

<body>
    <!-- ======= Hero Section ======= -->
    <div class="hero route bg-image">

        <main id="main" style="margin-bottom:5%; margin-top:15%; ">
            <h1 class="pt-4" style="text-align:center">Se connecter</h1>
            <div class="container pt-5">

                <form name="f1" action="config/authentification.php" method="POST" style="margin-left: 17%;margin-right: 17%; color:black">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="floatingInput">Entrez votre adresse courriel</label>
                        <input type="email" id="floatingInput" name="floatingInput" autofocus autocomplete class="form-control" placeholder="Courriel" />

                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="floatingPassword">Entrez votre mot de passe</label>
                        <input type="password" id="floatingPassword" name="floatingPassword" autocomplete="" class="form-control" placeholder="Mot de passe" />

                    </div>

                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4" style="font-size: x-large;">
                        <div class="col d-flex justify-content-center">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                <label class="form-check-label" for="form2Example31"> Se souvenir de moi </label>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Simple link 
                        <a href="ForgotMP.asp">Mot de passe oublié ?</a>-->
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal" onclick="document.getElementById('exampleModal').setAttribute('aria-hidden','false');document.getElementById('exampleModal').style.display='block';document.getElementById('exampleModal').style.opacity='1'; document.getElementById('exampleModal').className='modal top fade show'">
                                Mot de passe perdu?
                            </button>
                            <!-- Modal -->
                            <div class="modal top fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                                <div class="modal-dialog" style="width: 300px;">
                                    <div class="modal-content text-center">
                                        <div class="modal-header h5 text-white bg-primary justify-content-center">
                                            Mot de passe perdu ?
                                        </div>

                                        <div class="modal-body px-5">
                                            <p class="py-2" style="text-align:justify;">
                                                Entrer votre adresse courriel et nous vous enverrons un courriel avec des instructions pour changer votre mot de passe.

                                            </p>
                                            <div class="form-outline">
                                                <label class="form-label" for="typeEmail">Entrez votre courriel :</label>
                                                <input type="email" id="typeEmail" class="form-control my-3" />

                                            </div>
                                            <a href="seconnecter.php" class="btn btn-primary w-100"> Envoyer moi un courriel</a>
                                            <p class="py-2" style="text-align:justify;">
                                                *N'oubliez pas d'aller voir vos indésirables.

                                            </p>


                                        </div>
                                        <div class="text-white bg-primary justify-content-center" >
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><a href="seconnecter.php" style="color:white">Fermer</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary btn-block mb-4">Se connecter</button>

                </form>
            </div>
        </main>
    </div><!-- End Hero Section -->
</body>



<?php include "includes/piedDePage.php"; ?>