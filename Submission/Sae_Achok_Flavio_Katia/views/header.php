<!-- <?php session_start(); ?> -->
 
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="style/css/style.css">
  <link rel="stylesheet" href="style/css/formulaire.css">
<link rel="icon" href="./style/images/logo.png" type="image/png">
  <meta charset="UTF-8">
  <title>GameAbility</title>

  <header><img class="header" src=style/images/gameability.png></header>
  <nav class="centre">
    <ul>
      <a href="index.php" class="bouton">Accueil</a>
      <a href="informations.php" class="bouton">Informations</a>
      <a href="evenements.php" class="bouton">Evenements</a>
      <?php 
        if(!isset($_SESSION['usr_auth']) || !$_SESSION['usr_auth'] ) // 
        {
          echo "<a href=\"connexion.php\" class=\"bouton\">Connexion</a>";
        } 
      ?>
      <?php 
          if(isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){
            echo "<a href=\"profile.php\" class=\"bouton\">Profil</a><a href=\"deconnexion.php\" class=\"bouton\">Déconnexion</a>";
          }
      ?>
          
    </ul>
  </nav>
</head>
<body>