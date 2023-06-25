<?php include 'views/header.php';
require_once 'lib/modele.php'; 
  $db = connectDB();
  $idEvent = $_GET['idEvenement'];
  $infoevenement = getInformationsEvenement($db,$idEvent);
  $idCreateur = $infoevenement['idCreateur'];
  $createur = getIdentifiantById($db,$idCreateur);

  $Participants = getParticipantEvenement($db,$idEvent);
mysqli_close($db);
?>


<style>
.image-ronde{
  width : 40px; height : 40px;
  border: solid #FFFFFF;
  -moz-border-radius : 20px;
  -webkit-border-radius : 20px;
  border-radius : 20px;
}

.hidden {
  display: none;
}
  
table, tr {  
  border: 1px solid black; 
  border-left: none; 
  border-right: none; 
  border-collapse: collapse; 
}

.commentaire
{
  color: black;
  background-color: white;
  text-align: center;
  }

</style>

<!-- La classe s'appelle formulaire, mais ici nous l'utilisons uniquement pour l'affichage. -->
<fieldset class="formulaire"> 
  <table class = "tab">
    <thead>
      <td>
        <tr colspan="2"> <h2> <?php echo $infoevenement['titre']; ?> </h2> </tr>
      </td>
    </thead>
    <tr>
      <th>
        Date
      </th>
      <td>
        <label> <?php echo $infoevenement['dateEvenement']; ?> </label>
      </td>
    </tr>
    <tr>
      <th>
        Type
      </th>
      <td>
        <label> <?php echo $infoevenement['type']; ?></label>
      </td>
    </tr>
    <tr>
      <th>
        Publié par 
      </th>
      <td>
        <label> <?php echo $createur['identifiant'] ?> </label>
      </td>
    </tr>
    <tr>
      <th>
        Description
      </th>
      <td rowspan="3">
        <label> <?php echo $infoevenement['description'] ?> </label>
      </td>
    </tr>
  </table>

  <table class = "tab">
    <thead>
      <tr class="centre">
        <td colspan="2"> <h3> Participants </h3> </td>
      </tr >
    </thead>
      <?php foreach ($Participants as $participant) 
      { 
        $pdp = "";
        if(strlen($participant['imgUrl']) != 0)
        {
          $pdp = $participant['imgUrl'];
        }
        else{
          $pdp = "./style/images/image-de-profil.png";
        }
      echo "<tr class=\"centre\">
      <td><img class=\"image-ronde\" src=\"".$pdp."\"></td>
      <td>{$participant['identifiant']}</td>
      </tr>;";
      }
    ?>

  </table>
  
<?php
$db = connectDB();
$infosEvenement=array();
//pour les commentaires
    $idEvenement = $_GET['idEvenement'];
    //$idUser = $_SESSION['user']['idUser'];
    $Commentaires = getCommentaires($db,$idEvenement);
    $infosEvenement = getInformationsEvenement($db,$idEvenement);
    echo"<h3>Commentaires</h3>";

    foreach ($Commentaires as $Commentaire){   
      $pdp = "";
        if(strlen($Commentaire['imgUrl']) != 0)
        {
          $pdp = $Commentaire['imgUrl'];
        }
        else{
          $pdp = "./style/images/image-de-profil.png";
        }
      echo "
      <p><img class=\"image-ronde\" src=\"".$pdp."\"><label>{$Commentaire['identifiant']} <p class=\"commentaire\" >{$Commentaire['contenu']}";      
      }
?>
<?php
      if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){
        echo "<p class=\"centre\"><a href=\"creerCommentaire.php?idEvenement=$idEvenement\" class=\"bouton\">Commenter</a></p>";
      } 
?>

</fieldset>
<?php include 'views/footer.php' ?>