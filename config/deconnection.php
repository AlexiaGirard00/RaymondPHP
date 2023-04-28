<?php    
    // // Initialize the session
    // session_start();
    
    // // Unset all of the session variables
    // $_SESSION = array();
    
    // // Destroy the session.
    // session_destroy();
    
    // // Redirect to login page
    // header("location: connexion.php");
    // exit; 




    // //valide la presence d'une  session en cours
    // session_start();   
    // //destruction de la session
    // session_destroy();    
    // session_unset();  
    // //redirection
    //                                 //***** Attention dossier peut changer !!!!  */
    // header("location: index.php");   
    // die();
   


    
    if (!isset($_SESSION)) {
        session_start();

        unset($_SESSION["username"]);
        unset($_SESSION["userpass"]);

        session_destroy();
        
        //Retourner à la page de login, je trouve que ça fait plus de sens que de retourner à l'index
        header("Location:../index.php");
    }
?>



