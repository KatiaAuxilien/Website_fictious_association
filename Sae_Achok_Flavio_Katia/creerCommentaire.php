<?php 
include 'views/header.php'; 
require_once 'lib/modele.php'; 


$db = connectDB();
if (isset($_POST['idEvenement'])) {
$idEvenement = $_POST['idEvenement'];
$contenu = $_POST['commentaire'];
$idUser = $_SESSION['user']['idUser'];

$idEvenement = filter_input(INPUT_POST,'idEvenement',FILTER_SANITIZE_NUMBER_INT);
$commentaire = filter_input(INPUT_POST,'commentaire', FILTER_SANITIZE_STRING);
$resultat = insertCommentaire($db,$idUser,$idEvenement,$contenu);
//test
if ($resultat[0]){
    echo "<script> alert(\"commentaire ajouté\")</script>";
} else {
    echo "<script> alert(\"Erreur lors de l'insertion\")</script>";
}

header('Location: Commentaires.php?action=voirComm&idEvenement=' . $idEvenement);
        exit();
}

?>
<fieldset class="formulaire">
<h2>Créer un commentaire</h2>
<form method="POST" action="creerCommentaire.php">
    <input type="hidden" name="idEvenement" value="<?php echo $_GET['idEvenement']; ?>">
    
    <div>
        <label for="commentaire">Commentaire :</label><br>
        <textarea name="commentaire" id="commentaire" rows="4" cols="50"></textarea>
    </div>
    
    <div>
        <input type="submit" value="Ajouter le commentaire">
    </div>
</form>
</fieldset>

<?php include 'views/footer.php'; ?>