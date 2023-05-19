<?php

include "includes/entete.php";
include "includes/menuDetails.php";

if (isset($_POST['submited'])) {

    if ($_POST['form2Example31']) {
        //On set 2 cookies un pour l'utilisateur et un pour le mot de passe

        //le nom du cookie "remembermeu" la valeur "$username" et la durée "time() + 31536000"
        setcookie($remembermeu, $username, time() + 31536000);

        //le nom du cookie "remembermep" la valeur "$password" et la durée "time() + 31536000"
        setcookie($remembermep, $password, time() + 31536000);
    }
    //Si la case est décochée
    elseif (!$_POST['form2Example31']) {

        //On cherche pour nos 2 cookies
        if (isset($_COOKIE['remembermeu'], $_COOKIE['remembermep'])) {
            //Nous les plaçons comme si ils avaient expirés
            $past = time() - 100;
            setcookie($remembermeu, $gone, $past);
            setcookie($remembermep, $gone, $past);
        }
    }
    //rememberme

}
?>

<body>
    <div class="hero route bg-image">
        <main id="main" style="margin-bottom:5%; margin-top:15%; ">
            <h1 class="pt-4" style="text-align:center">Se connecter</h1>
            <div class="container pt-5">
                <form name="f1" action="config/authentification.php" method="POST" style="margin-left: 17%;margin-right: 17%; color:black">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="floatingInput">Entrez votre adresse courriel</label>
                        <input type="email" id="floatingInput" name="floatingInput" autofocus autocomplete class="form-control" placeholder="Courriel" value="<?php if (isset($_COOKIE['remembermeu'])){echo $_COOKIE['remembermeu'];} ?>" />
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="floatingPassword">Entrez votre mot de passe</label>
                        <input type="password" id="floatingPassword" name="floatingPassword" autocomplete="" class="form-control" placeholder="Mot de passe" value="<?php if (isset($_COOKIE['remembermep'])){echo $_COOKIE['remembermep'];} ?>" />
                    </div>
                    <div class="row mb-4" style="font-size: x-large;">
                        <div class="col d-flex justify-content-center">
                            <div class="form-check" onclick="activeCocher()">
                                <input class="form-check-input" type="checkbox" value="1" id="form2Example31" name="form2Example31" style="border: 1px solid #ced4da;" <?php if (isset($_COOKIE['remembermeu'])){echo 'checked="checked"';}else { echo '';} ?> />
                                <label class="form-check-label" for="form2Example31"> Se souvenir de moi </label>
                            </div>
                        </div>
                        <div class="col">
                            <a href="entrerEmail.php" class="btn btn" style="background-color:#8D9D2B;">Mot de passe oublié ?</a>
                        </div>
                    </div>
                    <button type="submit" id="submited" name="submited" class="btn btn-light btn-block mb-4" style="background-color:#8D9D2B;">Se connecter</button>
                </form>
            </div>
        </main>
    </div>
</body>

<?php include "includes/piedDePage.php"; ?>
<script>
    function activeCocher() {
        if (document.getElementById('form2Example31').checked == 1) {
            couleur = "#8D9D2B";

        } else {
            couleur = "white";
        }
        document.getElementById('form2Example31').style.backgroundColor = couleur;
        document.getElementById('form2Example31').style.borderColor = couleur;
    }
</script>