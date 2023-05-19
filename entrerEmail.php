<?php
    include('app_logic.php');
    include "includes/entete.php";
    include "includes/menuDetails.php"; 
?>

<div class="hero route bg-image">
    <main id="main" style="margin-bottom:5%; margin-top:15%; ">
        <h1 class="pt-4" style="text-align:center">Mot de passe oublié</h1>
        <div class="container pt-5">
            <form class="" action="entrerEmail.php" method="post" style="margin-left: 17%;margin-right: 17%; color:black">
                <!-- form validation messages -->
                <?php include('messages.php'); ?>
                <div class="form-outline mb-4">
                    <label class="form-label" for="email">Entrez votre adresse courriel</label>
                    <input type="email" id="email" name="email" autofocus autocomplete class="form-control" placeholder="Courriel" />
                </div>
                <div class="form-label">
                    <button type="submit" name="reset-password" class="btn btn-primary btn-block mb-4">Envoyer</button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>





