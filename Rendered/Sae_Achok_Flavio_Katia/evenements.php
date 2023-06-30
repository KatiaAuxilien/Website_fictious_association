<?php include 'views/header.php'; 
// session_start();
require_once 'lib/modele.php'; 



// On détruit la session si l'utilisateur clique sur "Sign out"
if (isset($_POST['action']) && $_POST['action'] == 'signout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

$db = connectDB();

if(isset($_GET['filtre'])){
$filtre=$_GET['filtre'];}else{
  $filtre='aucun';
}

if (isset($_GET['types'])) {
    $typesSelectionnes = $_GET['types'];
} else {
    $typesSelectionnes = [];
}

$Evenements= getEvenements_Filtre($db,$filtre,$typesSelectionnes);

if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']) {
$users = getInfosUser($db,$_SESSION['user']['identifiant']);

}
if(isset($_GET['action'])){
    if($_GET['action']==='inscrire' && isset($_GET['idEvenement'])){
    $idEvenement = $_GET['idEvenement'];
    $idUser = $_SESSION['user']['idUser'];
    $resultat = setInscriptionEvenement($db, $idUser, $idEvenement);

if ($resultat[0]) {
    echo "<script> alert(\"Inscription réussie !\")</script>";
} else {
    echo "<script> alert(\"Vous êtes déjà inscrit\")</script>";
}
}
}
  


// On ne peut plus se connecter si une session est déjà ouverte
if (!isset($_SESSION['usr_auth'])) {
    goto vue_evenements;
}


vue_evenements:
include 'views/vue_evenements.php'?>
<?php include 'views/footer.php' ?>
