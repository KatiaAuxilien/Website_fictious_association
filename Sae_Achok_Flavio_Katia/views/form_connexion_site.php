<?php include 'views/header.php' ?>

 <fieldset class="formulaire">
    <table class="tab">
      <form method="POST" action="">

            <thead class="centre">
        <tr>
            <th colspan="2"><h1>Connexion</h1> </th>
        </tr>
        <tr>
          <td colspan="2"> Vous n'avez pas de compte ? <a href=./inscription.php> Créez-en un </a> </td>
        </tr>
            </thead>
        <?php
         if(isset($connexion_err['err1']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$connexion_err['err1']."</td></tr>";
         }  
        ?>
        <tr>
          <td class="centre">
            <label for="identifiant">Identifiant :</label>
          </td>
          <td>
            <input name="identifiant" value="<?php if (isset($_POST['identifiant'])) echo $_POST['identifiant']; ?>" />
          </td>
        </tr>
        <tr>
        <?php
         if(isset($connexion_err['err2']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$connexion_err['err2']."</td></tr>";
         }  
        ?>
          <td class="centre">
              <label for="motdepasse">Mot de passe :</label>
          </td>
          <td>
            <input type="password" name="motdepasse" value="<?php if (isset($_POST['motdepasse'])) echo $_POST['motdepasse']; ?>">
          </td>
        </tr>
         <?php
         if(isset($connexion_err['err3']))
         {
           echo "<tr><td class='error' colspan=\"2\">".$connexion_err['err3']."</td></tr>";
         }  
        ?>
        
      <tfoot>
         <tr>
          <td colspan="" class="centre">
            <input type="submit" value="Connecter">
          </td>
        </tr>
      </tfoot>

      </form>
    </table>
  </fieldset>

<?php include 'views/footer.php' ?>