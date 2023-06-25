<?php
require_once 'lib/modele.php'; //Modele contient nos fonctions

// On ne peut pas créer de compte si une session est déjà ouverte
if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']) {
   header("Location: index.php"); //A CHANGER
   exit();
}

$inscription_err = array();  // utilisé par la vue pour afficher l'erreur

//Certaines vérifications peuvent être faites dans les balises input directement.
/*Erreur 1 : Identifiants
Erreur 2 : Mdp
Erreur 3 : mdp verif
Erreur 4 : Email
Erreur 5 : Nom
Erreur 6 : Prenom
Erreur 7 : Date
Erreur 8 : Genre
Erreur 9 : Situation
Erreur 10 : SQL */

if (isset($_POST['identifiant'])) { //Ca pourrait être identifiant, mot de passe ect.. la condition serait remplie car même si les champs sont vide, le champ contiendra "".

  //Verifications identifiant
   if (empty($_POST['identifiant']) && isset($_POST['identifiant'])) {
      $inscription_err['err1'] = 'Identifiant vide';
   }
  if(!empty($_POST['identifiant']) && strlen($_POST['identifiant']) > 30)
  {
    $inscription_err['err1'] = 'Identifiant trop long';
  }
  
  $identifiant = "";
  if (empty($inscription_err['err1']) && !empty($_POST['identifiant'])) {
   $identifiant = filter_input(INPUT_POST, 'identifiant', FILTER_SANITIZE_SPECIAL_CHARS); 
  //Value of the requested variable on success, false if the filter fails, or null if the var_name variable is not set. 
   if (!$identifiant) {
     $inscription_err['err1'] = 'Identifiant invalide, pas de caractères spéciaux svp.';
   }
  }

  //Verifications mdp
   if (empty($_POST['motdepasse'])) {
      $inscription_err['err2'] = 'Mot de passe vide';
   }
  
   if (empty($_POST['motdepassecheck'])) {
      $inscription_err['err3'] = 'Verification obligatoire !';
    }
     if (!empty($_POST['motdepassecheck']) && !empty($_POST['motdepasse']) && ($_POST['motdepasse'] !=$_POST['motdepassecheck']) ) {
      $inscription_err['err3'] = 'Mots de passe non identiques';
   }

  //Verification email
  
  if (empty($_POST['addrmail'])) {
      $inscription_err['err4']= 'Addresse mail vide';
   }
    $addrmail = "";
   if (isset($_POST['addrmail']) && !empty($_POST['addrmail'])) {
      $addrmail = filter_input(INPUT_POST, 'addrmail', FILTER_SANITIZE_EMAIL); //On assainit l'email
      if (!filter_var($addrmail, FILTER_VALIDATE_EMAIL)) {  //On vérifie qu'après avoir assainit l'email est valide.
        $inscription_err['err4'] = 'Addresse mail invalide';
      }
   } // Si tout est bon pour l'email, on appellera $addrmail pour récupérer la valeur.

    //Verification prénom et nom
    $nom = "";
    if (isset($_POST['nom']) && !empty($_POST['nom'])) {
     $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING); 
     if (!$nom) {
       $inscription_err['err5'] = 'Nom invalide.';
     }
    }
    
    $prenom = "";
    if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING); 
     if (!$prenom) {
       $inscription_err['err6'] = 'Prénom invalide.';
     }
    }
    
    //Verifications autres
    if (empty($_POST['genre'])) {
        $inscription_err['err8']= 'Genre obligatoire';
     }
    if (empty($_POST['situation'])) {
        $inscription_err['err9']= 'Situation obligatoire';
     }
    if (empty($_POST['datedenaissance'])) {
      $inscription_err['err7']= 'Date de naissance obligatoire';
    }

  
  if(!empty($inscription_err))
  {
    goto vue_inscription;
  }

  $genre = $_POST['genre'];
  $datedenaissance =  $_POST['datedenaissance'];
  $situation =  $_POST['situation'];
  $motdepasse = $_POST['motdepasse'];
  $db = connectDB();
  
[$success, $error] = inscrire($db, $identifiant, $motdepasse, $addrmail,$datedenaissance,$genre,$situation); //AJOUT DES AUTRES INFROMATIONS
                                   
   if ($success) { 
     if($situation == 'handicap') 
     {
       if(!empty($_POST['typehandicap'])){
         $handicap = $_POST['typehandicap'];
         [$successH,$errorH] = setInfoUser($db,'handicap',$handicap,$identifiant);
         if(!$successH)
         {
           $inscription_err['err9'] = $errorH;
         }
        }
     }
     if(strlen($nom) != 0)
     {
       [$successN,$errorN] = setInfoUser($db,'nom',$nom,$identifiant); //A REGLER
       if(!$successN)
       {
         $inscription_err['err5'] = $errorN;
       }
     }
     if(strlen($prenom) != 0)
     {
       [$successP,$errorP]= setInfoUser($db,'prenom',$prenom,$identifiant); //A REGLER
       if(!$successP)
       {
         $inscription_err['err6'] = $errorP;
       }
     }
     
      mysqli_close($db);
      header("Location: index.php"); //A CHANGER
      exit();
   } else {
      $inscription_err['err10'] = $error; //Erreur identifiant ou mail déjà pris.
     mysqli_close($db);
     goto vue_inscription;
   }  
                                   
}

vue_inscription:
   include 'views/form_inscription_site.php';
?>