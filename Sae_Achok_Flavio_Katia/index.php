<?php 
session_start();
include 'views/header.php' ?>

<?php 
require_once 'lib/modele.php';
if(isset($_SESSION['onConnexion'])){
  if ($_SESSION['onConnexion'] && $_SESSION['usr_auth']) {
    echo "<script>alert(\"Connexion réussie ! Bienvenue ".$_SESSION['user']['identifiant']."\")</script>";
    $_SESSION['onConnexion'] = false;
  }
}
  ?>

    <body>
          <section class="accueil"><h1> Bienvenue dans notre site web</h1><h4>Nous sommes une association dédiée à l'inclusion des personnes handicapées dans le monde des jeux vidéo. Chez GameAbility, nous croyons fermement que le plaisir et l'épanouissement procurés par les jeux vidéo doivent être accessibles à tous, quelles que soient les différences et les limitations.</h4><br></section>
          <br>
          
<?php include 'views/footer.php' ?>