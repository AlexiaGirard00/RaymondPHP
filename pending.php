<?php
    include('app_logic.php');
    include "includes/entete.php";
    include "includes/menuDetails.php";
?>

<div class="hero route bg-image">
    <main id="main" style="margin-bottom:5%; margin-top:15%; ">
        <h1 class="pt-4" style="text-align:center">Mot de passe perdu</h1>
        <div class="container pt-5">
            <form class="login-form" action="" method="" style="margin-left: 17%;margin-right: 17%; color:black">
                <p>
                    Nous avons envoyé un e-mail à  <b><?php echo $_GET['email'] ?></b> pour vous aider à récupérer votre compte. 
                </p>
                <p>Veuillez vous connecter à votre compte de messagerie et cliquer sur le lien que nous vous avons envoyé pour réinitialiser votre mot de passe.</p>
            </form>
            <div class="d-flex justify-content-center mt-5">
                <a href="index.php" class="btn btn-secondary" style="width:100px;">Accueil</a>
            </div>
        </div>
    </main>
</div>
</body>