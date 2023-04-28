<?php

    //section servant à authentifier l'utilisateur avec les données de la BD 
    require('connexion.php');

    $username = $_POST['floatingInput'];
    $password = $_POST['floatingPassword'];


    //Nettoyage des inputs
    //Remove the backslash (\)
    $username = stripslashes($username);
    $password = stripslashes($password);

    //htmlentities — Convert all applicable characters to HTML entities
    $username = htmlentities($username);
    $password = htmlentities($password);

    //Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    
   // $username = mysqli_real_escape_string($connect, $username);
    $username = mysqli_real_escape_string($connect, $_POST["floatingInput"]); 

   // $password= mysqli_real_escape_string($connect, $password);    
    $password = mysqli_real_escape_string($connect, $_POST["floatingPassword"]);  


//  **************ne pas oublié d'aller modifier dans BD md5 au password*****************
   // $password = md5($password); 
    

    //requete à la BD 
    //$query = "SELECT * FROM dbo.utilisateurs WHERE CourrielUtilisateur = '$username' and MotDePasseUtilisateur = '$password' ";
     $query = "SELECT * FROM `dbo.utilisateurs` WHERE CourrielUtilisateur = '$username' and MotDePasseUtilisateur = '$password' and ActifUtilisateur = 1;";

     //$query =" SELECT * from utilisateurs where CourrielUtilisateur = '$username' AND MotDePasseUtilisateur = '$password'";
    //$query =" SELECT * from utilisateurs where username= 'misszest' AND userpass= 'patate43'";

    //mise dans un variable des résultats de la requête
    $resultats = mysqli_query($connect, $query);

    $row = mysqli_fetch_array($resultats, MYSQLI_ASSOC);

    $count = mysqli_num_rows($resultats);
    if ($count == 1) {//Si retourne au moins un row = la query a fonctionné
   
        session_start();

        $_SESSION["username"] = $username;
        $_SESSION["userpass"] = $password;

        header("Location: ../admin.php");
    } else {  
        //J'ai choisi de retourner à la page de login si les inputs ne sont pas les bons, car je trouve que ça fait plus
        //de sens que d'envoyer l'utilisateur à l'index. Si on se fait renvoyer à l'index chaque fois qu'on fait une erreur dans un
        //des inputs, c'est fatiguant. 
       
        header("Location: ../seconnecter.php");
        print "<h2>PHP is Fun!</h2>";
    }
   
?>