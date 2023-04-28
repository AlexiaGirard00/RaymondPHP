<?php 
   function getData($query, $connect)
   {
      //Execute Query
      $resultats= mysqli_query($connect, $query);  
   
      //recevoir DATA (fetch)
      $posts=mysqli_fetch_all($resultats, MYSQLI_ASSOC);
  
      //libere les $resutlats (on en a plus de besoin quand ils sont dans $posts)
      mysqli_free_result($resultats);
   
      //fermer connexion
      mysqli_close($connect);
      return $posts;
   }
 ?>