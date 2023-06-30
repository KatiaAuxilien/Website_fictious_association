

 <h2 class="centre">Evenements</h2>


 <form class="centre" method="get" action="">
  <select name="filtre">
     <option value="aucun">Aucun</option>
    <option value="createur">Créateur</option>
    <option value="date">Date</option>
    <option value="titre">Titre</option>
  </select>
   <label>
  <input type="checkbox" name="types[]" value="LAN"> LAN
</label>
<label>
  <input type="checkbox" name="types[]" value="convention"> Convention
</label>
<label>
  <input type="checkbox" name="types[]" value="competition"> Compétition
</label>
<label>
  <input type="checkbox" name="types[]" value="stream"> Stream
</label>
  <input type="submit" value="Filtrer">
 </form>


<?php 

if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']) {
    foreach ($users as $user){
      if ($user['identifiant'] == $_SESSION['user']['identifiant'] && $user['roleSite']=='gestionnaire') {
         echo "<table >
        <tr>
          <td colspan=\"2\"><a href=\"create_event.php\" class=\"bouton\">Créer évènement</a></td>
        </tr>
        </table>";
      }
      }
}
?>
  
 <table class="tab">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Créateur</th>
      <th>Date</th>
      <th>Description</th>
      <th>Type</th>
    </tr>
  </thead>
  <tbody>
    <?php
  if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){
    foreach ($Evenements as $event) { 
      echo "
  <tr>
    <td> <a href =\"./fiche.php?idEvenement={$event['idEvent']}\">{$event['titre']}</a></td>
    <td>{$event['identifiant']}</td>
    <td>{$event['dateEvenement']}</td>
    <td>{$event['description']}</td>
    <td>{$event['type']}</td>    
    <td><a href=\"evenements.php?action=inscrire&idEvenement={$event['idEvent']}\">S'inscrire</a></td>
  </tr>
  </tr>
  <td><a href=\"Commentaires.php?action=voirComm&idEvenement={$event['idEvent']}\">Commentaires</a></td>
  </tr>";   
      
    } 
    echo "</table>";
  }else{
    foreach ($Evenements as $event) {   
      echo"
  <tr>
    <td> <a href =\"./fiche.php?idEvenement={$event['idEvent']}\">{$event['titre']}</a></td>
    <td>{$event['identifiant']}</td>
    <td>{$event['dateEvenement']}</td>
    <td>{$event['description']}</td>
    <td>{$event['type']}</td>
    </tr>";      
    }
    echo "</table>";
  }
   
    ?>
  </tbody>
 </table>

 <?php
 include 'footer.php'; 
 ?>
