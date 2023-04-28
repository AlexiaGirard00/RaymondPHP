<?php 

    require("connexionPDO.php");

    $username = $_POST["floatingInput"];
    $password = $_POST["floatingPassword"];

    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = htmlentities($username);    //Mettre html en text
    $password = htmlentities($password);

    $username = mysqli_real_escape_string($connect, $username);     //Enlever les caractères spéciaux
    $password = mysqli_real_escape_string($connect, $password);

    $query = "SELECT * FROM `dbo.utilisateurs` WHERE CourrielUtilisateur = '$username' and MotDePasseUtilisateur = '$password' and ActifUtilisateur = 1;";

    $resulats = mysqli_query($connect, $query);

    $count = mysqli_num_rows($resulats);

    //debugToConsole($_POST["floatingInput"]);

    if ($count == 1) //Si retourne au moins un row = la query a fonctionné
    {
        session_start();

        $_SESSION["username"] = $username;
        $_SESSION["userpass"] = $password;

        header("Location:../admin.php");
    }
    else
    {   
        //J'ai choisi de retourner à la page de login si les inputs ne sont pas les bons, car je trouve que ça fait plus
        //de sens que d'envoyer l'utilisateur à l'index. Si on se fait renvoyer à l'index chaque fois qu'on fait une erreur dans un
        //des inputs, c'est fatiguant. 
        header("Location:../seconnecter.php");     
    }


    function debugToConsole($msg) { 
        echo "<script>console.log(".json_encode($msg).")</script>";
    }


?>
