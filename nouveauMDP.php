<?php
  include('app_logic.php');
  include "includes/entete.php";
  include "includes/menuDetails.php";
?>

<div class="hero route bg-image">
  <main id="main" style="margin-bottom:5%; margin-top:15%; ">
    <h1 class="pt-4" style="text-align:center">Nouveau mot de passe</h1>
    <div class="container pt-5 d-flex justify-content-center">
      <form class="login-form" action="new_password.php" method="post" style="margin-left: 17%;margin-right: 17%; color:black">
        <!-- form validation messages -->
        <?php include('messages.php'); ?>
        <div class="form-outline mb-4">
          <label class="form-label">Nouveau mot de passe</label>
          <input type="password" name="new_pass" class="form-control">
        </div>
        <div class="form-outline mb-4">
          <input hidden name="token" value="<?php echo $_GET['token']?>" />
          <label class="form-label">Confirmer le nouveau mot de passe</label>
          <input type="password" name="new_pass_c" class="form-control">
        </div>
        <div class="form-outline mb-4">
          <button type="submit" name="new_password" class="login-btn">Envoyer</button>
        </div>
      </form>
    </div>
  </main>
</div>
</body>