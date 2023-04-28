<?php
    try {
        //creer la connexion à la base donné 
        //Enter your Host, username, password, database below.
        $connect = mysqli_connect('localhost', 'Jessika', 'Patate1989', 'raymond') ;
        

    }catch (Exception $e) {


        //Vérifier la connexion à la BD
        if (mysqli_connect_errno()) {
            //Connection echoué
            echo'Échec de connexion à la base de données! <br> Code erreur: ' . mysqli_connect_errno();
            // en mode debug okay, en mode client on ne veut pas afficher le code d'érreur on veut un msg personnalisé de problème rencontré
            die();
        }
    }

        //permet d'aficher les é À..etc..
        mysqli_set_charset($connect, 'utf8');
?>