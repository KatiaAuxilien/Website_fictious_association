<?php include 'views/header.php' ?>
 <fieldset class="formulaire">
    <table class="tab">
      <form method="GET" action="">
            <thead class="centre">
        <tr>
            <th colspan="2"><h1>Création d'un événement</h1> </th>
        </tr>
        <tr>
          <td class="centre">
            <label for="nom">Titre de l'événement:</label>
          </td>
          <td>
            <input type="text" name="titre" class="rose" placeholder="Titre (30 caractères max)" maxlength="30">
          </td>
        </tr>
        <tr>
          <td class="centre">
            <label for="date">Date:</label>
          </td>
          <td>
            <input type="date" name="dateevenement" class="rose">
          </td>
        </tr>
        <tr>
          <tr>
          <td class="centre">
            <label for="Type">Type</label>
          </td>
          <td>
          <input name="type" type="radio" value="competition" />Compétition
            <input name="type" type="radio" value="convention" />Convention
            <input name="type" type="radio" value="LAN" />LAN 
            <input name="type" type="radio" value="stream" />Stream 
          </td>
        <tr>
          <td class="centre">
            <label for="Description">Description :</label><br/>
          </td>
        <td>
          <textarea name="description" rows="5" cols="50" placeholder="Décrivez votre évènement en 2500 caractères au maximum" maxlength="2500"></textarea>
        </td>
        <tr>
          <td class="centre">
            <input  class="centre" type="submit" value="Créer événement">
          </td>
        </tr>
      </form>
    </table>
  </fieldset>
<?php
$id=intval($_SESSION['user']['idUser'],10);

require_once 'lib/modele.php'; // Modele contient nos fonctions

$inscription_err = array(); // Utilisé par la vue pour afficher l'erreur

if (isset($_GET['type'])) {
    // Ca pourrait être identifiant, mot de passe, etc. La condition serait remplie même si les champs sont vides, le champ contiendra "".
if(empty($_GET['titre'])) {
      $inscription_err['err1'] = 'Titre vide';
   }
    // Vérification du titre
    $titre = "";
    if (isset($_GET['titre']) && !empty($_GET['titre'])) {
        $titre = filter_input(INPUT_GET, 'titre', FILTER_SANITIZE_STRING);
    }

    // Vérification de la description
    $description = "";
    if (isset($_GET['description']) && !empty($_GET['description'])) {
        $description = filter_input(INPUT_GET, 'description', FILTER_SANITIZE_STRING);
    }

    // Vérification de la date de l'événement
    if (empty($_GET['dateevenement'])) {
        $inscription_err['err7'] = 'Date de l\'événement obligatoire';
    }

    $dateevenement = $_GET['dateevenement'];

    $type=$_GET['type'];

    $db = connectDB();

    creer_event($db, $id, $titre, $type, $dateevenement, $description); // AJOUT DES AUTRES INFORMATIONS

    mysqli_close($db);
    header("Location: evenements.php"); // A CHANGER
    exit();
}
?>

<?php include 'views/footer.php' ?>
