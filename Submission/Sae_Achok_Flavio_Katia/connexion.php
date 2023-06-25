<?php
require_once 'lib/modele.php';
session_start();

// On ne peut plus se connecter si une session est déjà ouverte
if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']) {
    header("Location: index.php"); //A CHANGER
    exit();
}

$connexion_err = array();  // variable utilisée par la vue pour affichée l'erreur

if (isset($_POST['identifiant']) && isset($_POST['motdepasse'])) {
    if (empty($_POST['identifiant'])) {
        $connexion_err['err1'] = 'Identifiant vide';
    } 
    if (empty($_POST['motdepasse'])) {
        $connexion_err['err2'] = 'Mot de passe vide';
    }
  if(!empty($connexion_err))
  {
    goto connexion_view;
  }
  
    $motdepasse = $_POST['motdepasse'];
    $identifiant = filter_input(INPUT_POST, 'identifiant', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$identifiant) {
        $connexion_err['err1'] = 'Identifiant invalide.';
    }
  
  if(!empty($connexion_err))
  {
    goto connexion_view;
  }

    $db = connectDB();
    [$success, $error, $tableuser] = verifier_connexion($db, $identifiant, $motdepasse);
    mysqli_close($db);
    if ($success) {
        $_SESSION['usr_auth'] = true;
        $_SESSION['user'] = $tableuser;
        $_SESSION['onConnexion'] = true;
        header("Location: index.php"); //A CHANGER
        exit();
    } else {
        $connexion_err['err3'] = $error;
      goto connexion_view;
    }
}

connexion_view:
    include 'views/form_connexion_site.php';
?>