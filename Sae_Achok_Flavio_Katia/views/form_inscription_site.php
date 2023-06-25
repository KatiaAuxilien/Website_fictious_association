<?php include 'views/header.php' ?>

  <style>
    .hidden {
      display: none;
    }
  </style>
   <script>
  function toggleAdditionalField() {
    var additionalField = document.getElementById("typehandicap-row");
    var radioValue = document.querySelector('input[name="situation"]:checked').value;

    if (radioValue === "handicap") {
      additionalField.classList.remove("hidden");
    } else {
      additionalField.classList.add("hidden");
    }
  }
</script>

  <fieldset class="formulaire">
    <table class="tab">
      <form method="POST" action="">
            <thead class="centre">
        <tr>
            <th colspan="2"><h1>Inscription</h1> </th>
        </tr>
        <tr>
          <td colspan="2"> Vous avez déjà un compte ? <a href=./connexion.php> Connectez-vous </a> </td>
        </tr>
            </thead>
        <?php
         if(isset($inscription_err['err1']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err1']."</td></tr>";
         }  
        ?>
        <tr>
          <td class="centre">
            <label for="identifiant">Identifiant : *</label>
          </td>
          <td>
            <input name="identifiant" class="rose" placeholder="Votre identifiant" value="<?php if (isset($_POST['identifiant'])) echo $_POST['identifiant']; ?>">
          </td>
        </tr>
        <?php
         if(isset($inscription_err['err2']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err2']."</td></tr>";
         }  
        ?>  
        <tr>
          <td class="centre">
            <label for="motdepasse">Mot de passe : *</label>
          </td>
          <td>
            <input type="password" name="motdepasse"  class="rose" placeholder="Votre mot de passe" value=""><br/>
          </td>
        </tr>
        <?php
         if(isset($inscription_err['err3']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err3']."</td></tr>";
         } 
        ?>  
        <tr>
          <tr>
          <td class="centre">
            <label for="motdepassecheck">Retapez votre mot de passe : *</label>
          </td>
          <td>
            <input type="password" name="motdepassecheck" class="rose" placeholder="Verification" value=""><br/>
          </td>
        </tr>
        <?php
         if(isset($inscription_err['err4']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err4']."</td></tr>";
         } 
        ?>  
        <tr>
          <td class="centre">
            <label for="addrmail">Adresse mail : *</label><br/>
          </td>
          <td>
            <input id="email" name="addrmail" class="rose" placeholder="Votre email" value="<?php if (isset($_POST['addrmail'])) echo $_POST['addrmail']; ?>">
          </td>
        </tr>
        <?php 
           if(isset($inscription_err['err5']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err5']."</td></tr>";
         } 
        ?>
        <tr>
          <td class="centre">
            <label for="fname">Nom :</label>
          </td>
          <td>
            <input type="text" id="fname" name="nom" class="rose" placeholder="Votre nom" value="<?php if (isset($_POST['nom'])) echo $_POST['nom']; ?>"><br>
          </td>
        </tr>
        <?php 
           if(isset($inscription_err['err6']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err6']."</td></tr>";
         } 
        ?>
        <tr>
          <td class="centre">
            <label for="lname">Prénom :</label>
          </td>
          <td>
            <input type="text" id="lname" name="prenom" class="rose" placeholder="Votre prénom" value="<?php if (isset($_POST['prenom'])) echo $_POST['prenom']; ?>"><br>
          </td>
        </tr>
                <?php 
           if(isset($inscription_err['err7']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err7']."</td></tr>";
         } 
        ?>
        <tr>
          <td class="centre">
            <label for="dname">Date de naissance : *</label>
          </td>
          <td>
            <input type="date" id="dname" class="rose" name="datedenaissance" max="2007-01-01" value="<?php if (isset($_POST['datedenaissancce'])) echo $_POST['datedenaissancce']; ?>"><br>
          </td>
        </tr>
       <?php 
           if(isset($inscription_err['err8']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err8']."</td></tr>";
         } 
        ?>
        <tr>
          <td class="centre">
            <label for="genre">Genre : *</label>
          </td>
          <td>
            <input name="genre" type="radio" value="homme" />Homme
            <input name="genre" type="radio" value="femme" />Femme
            <input name="genre" type="radio" value="autre" />Autre 
          </td>
        </tr>
        <?php 
           if(isset($inscription_err['err9']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err9']."</td></tr>";
         } 
        ?>
        <tr>
        <td class="centre">
          <label for="situation">Situation : *</label>
        </td>
        <td>
          <input name="situation" type="radio" value="handicap" onclick="toggleAdditionalField()" <?php if (isset($_POST['situation']) && $_POST['situation'] === 'handicap') echo 'checked'; ?> required/> Handicap
          <input name="situation" type="radio" value="valide" onclick="toggleAdditionalField()" <?php if (isset($_POST['situation']) && $_POST['situation'] === 'valide') echo 'checked'; ?> required/> Valide
          <input name="situation" type="radio" value="NSPP" onclick="toggleAdditionalField()" <?php if (isset($_POST['situation']) && $_POST['situation'] === 'NSPP') echo 'checked'; ?> required/> Ne se prononce pas
        </td>
      </tr>

      <tr id="typehandicap-row" <?php if (!isset($_POST['situation']) || $_POST['situation'] !== 'handicap') echo 'class="hidden"'; ?>>
        <td class="centre">
          <label for="typehandicap">Handicap :</label>
        </td>
        <td>
          <select name="typehandicap">
            <option value="moteur">Handicap moteur</option>
            <option value="sensoriel">Handicap sensoriel</option>
            <option value="mental">Handicap mental</option>
            <option value="cognitif">Handicap cognitif</option>
          </select>
        </td>
      </tr>

        <?php
         if(isset($inscription_err['err10']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$inscription_err['err10']."</td></tr>";
         } 
        ?> 
      <tfoot>
        <tr>
         <td colspan="2" class="centre"><input type="checkbox" id="cgu" required>
    <label for="cgu">J'ai lu et j'accepte les <a href=./cgu.php> condition générale d'utilisation.</a></label></td> 
        </tr>
        <tr>
         <td colspan="2">* champs obligatoires</td> 
        </tr>
         <tr>
          <td colspan="2" class="centre">
            <input  class="centre" type="submit" value="S'inscrire">
          </td>
        </tr>
      </tfoot>
      </form>
    </table>
  </fieldset>

<?php include 'views/footer.php' ?>