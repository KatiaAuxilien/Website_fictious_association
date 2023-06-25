<?php include 'views/header.php'; 
require_once 'lib/modele.php'; 

$db = connectDB();
$infosEvenement=array();
//pour les commentaires
if(isset($_GET['action'])){
    if($_GET['action']==='voirComm' && isset($_GET['idEvenement'])){
    $idEvenement = $_GET['idEvenement'];
    //$idUser = $_SESSION['user']['idUser'];
    $Commentaires = getCommentaires($db,$idEvenement);
    $infosEvenement = getInformationsEvenement($db,$idEvenement);
    echo"<fieldset class=\"formulaire\">
    <h2>{$infosEvenement['titre']}</h2>";

    echo "<table class=\"tab\">
  		<thead>
    		<tr>
      		<th>Createur</th>
      		<th>Commentaire</th>
    		</tr>
  		</thead>
  		<tbody>";
  	foreach ($Commentaires as $Commentaire){   
      echo"
  		<tr>
    		<td>{$Commentaire['identifiant']}</td>
    		<td>{$Commentaire['contenu']}</td>
    	</tr>";      
    	}
    	echo "</tbody></table>";
    	echo "<p class=\"centre\"><a href=\"creerCommentaire.php?idEvenement=$idEvenement\" class=\"bouton\">Commenter</a></p>
      </fieldset>";
}
}

?>

<?php include 'views/footer.php' ?>

