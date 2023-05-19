<?php

session_start();
$errors = [];
$user_id = "";
// connexion BD
$db = mysqli_connect('localhost', 'root', '', 'raymond');

/*
  Envoyer un email pour réinitialiser le mot de passe
*/
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  //Vérifier que l'utilisateur existe
  $query = "SELECT CourrielUtilisateur FROM `dbo.utilisateurs` WHERE CourrielUtilisateur = '$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Votre email est requis");
  } else if (mysqli_num_rows($results) <= 0) {
    array_push($errors, "Désolé, aucun utilisateur n'existe avec cet e-mail");
  }
  //Générer un token unique
  $token = bin2hex(random_bytes(50));

  if (count($errors) == 0) {
    //Aller mettre le token et le email dans la table
    $sql = "INSERT INTO passwordreset(CourrielUtilisateur, Token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    //Envoyer le courriel avec le lien contenant le token pour réinitialiser le mot de passe
    $to = $email;
    $subject = "Réinitialisez votre mot de passe";
    $msg = "Bonjour, cliquez ici <a href=\"nouveauMDP.php?token=" . $token . "\">link</a> pour réinitialiser votre mot de passe sur le site.";
    $msg = wordwrap($msg, 70);
    $headers = "From: info@raymondstmichel.com";
    mail($to, $subject, $msg, $headers);
?>
    <script type="text/javascript">
      var email = <?php echo (json_encode($email)); ?>;

      window.location.href = "pending.php?email=" + email;
    </script>
<?php
  }
}

// Entrer un nouveau mot de passe
if (isset($_POST['new_password'])) {
  $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
  $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

  //Aller chercher le token qui vient du lien par email
  $token = $_POST['token'];
  if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Mot de passe requis");
  if ($new_pass !== $new_pass_c) array_push($errors, "Le mot de passe ne correspond pas");
  if (count($errors) == 0) {
    //Selectionner le email de l'utilisateur
    $sql = "SELECT `CourrielUtilisateur` FROM `passwordreset` WHERE token='$token' LIMIT 1";
    $results = mysqli_query($db, $sql);
    $email = mysqli_fetch_assoc($results)['CourrielUtilisateur'];

    if ($email) {
      $new_pass = md5($new_pass);
      $sql = "UPDATE `dbo.utilisateurs` SET `MotDePasseUtilisateur`='$new_pass' WHERE `CourrielUtilisateur`='$email'";
      $results = mysqli_query($db, $sql);
?>
      <script type="text/javascript">
        window.location.href = "seconnecter.php";
      </script>
<?php
    }
  }
}
?>