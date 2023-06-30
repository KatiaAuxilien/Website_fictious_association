<?php
require_once 'lib/modele.php';
session_start();
include 'views/header.php'; 


if (!isset($_SESSION['usr_auth']) && !$_SESSION['usr_auth']) {
    header("Location: connexion.php"); //A CHANGER
    exit();
}
if (!isset($_POST['errors'])) {
    $_POST['errors'] = array();
}

if (!isset($_POST['success'])) {
    $_POST['success']="Elements mis à jour : ";
}

if (!isset($_POST['modify'])) {
    $_POST['modify']=false;
}

?>

<style>
.image-ronde{
  width : 200px; height : 200px;
  border: solid #FFFFFF;
  -moz-border-radius : 100px;
  -webkit-border-radius : 100px;
  border-radius : 100px;
}
  
table, tr {  
  border: 1px solid black; 
  border-left: none; 
  border-right: none; 
  border-collapse: collapse; 
}

.success{
  color: limegreen;
}

</style>

      <fieldset class="formulaire">
      <form method ="POST" action="profile.php">
        <table class = "tab">
          <thead class="centre">
              <tr>
                  <th colspan="3"><h1>Profil</h1> </th>
              </tr>
                  
          </thead>
          <tr>
            <td class="centre"><label for ="pdp"><i>Photo de profil</i></label></td> 
            <td class="centre" id="pdp">
              <?php
                if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth'])
                {
                  $pdp = "";
                  if(strlen($_SESSION['user']['imgUrl']) != 0)
                  {
                    $pdp = $_SESSION['user']['imgUrl'];
                  }
                  else{
                    $pdp = "./style/images/image-de-profil.png";
                  }
                  echo "<img class=\"image-ronde\" src=\"".$pdp."\">";
                }
              ?>
            </td>
          </tr>

          <tr id="modifierpdp">
            <td class="centre">
              <label for="newimg"><i>Nouvelle photo : </i></label>
            </td>
            <td>
              <input name="newimg" id="newimg" class="rose" placeholder="Collez un lien url." type="url" value="<?php if (isset($_POST['newimg'])) echo $_POST['newimg']; ?>">
            </td>
          </tr>
      
          <tr>
            <td class="centre"><label for ="identifiant"><i>Identifiant</i></label></td> 
            <td class="centre"><label id="identifiant"><?php if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){echo $_SESSION['user']['identifiant'];} ?></label></td>
          </tr>
          <tr>
            <td class="centre"><label for="addrmail"><i>Adresse mail</i></label></td>
            <td class="centre"><label id="addrmail"><?php if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){echo $_SESSION['user']['addrmail'];} ?></label></td> 
          </tr>
          <tr>
            <td class="centre"><label for="motdepasse"><i>Mot de passe</i></label></td>
            <td class="centre"><label id="motdepasse"></label></td>   
          </tr>
             

          <tr id="modifiermdp">
            <td class="centre">
                  <label for="motdepasse"><i>Mot de passe actuel : </i></label>
                </td>
                <td>
                  <input name="motdepasse" id="motdepasse" class="rose" placeholder="Entrez votre mot de passe actuel" type="password" value="">
                </td>
          </tr>
          <tr id="modifiermdp">
            <td class="centre">
              <label for="newmotdepasse"><i>Nouveau mdp : </i></label>
            </td>
            <td>
              <input name="newmotdepasse" id="newmotdepasse" class="rose" placeholder="Nouveau mot de passe :" type="password" value="">
            </td>
            <tr>
              <td> </td>
              <td>
              <input name="newmotdepassecheck" id="newmotdepassecheck" class="rose" placeholder="Retaper nouveau mdp :" type="password" value="">
            </td>
            </
            
          </tr>
          <tr>
            <td class="centre"><label for="datedenaissance"><i>Date de baissance</i></label></td>
            <td class="centre"><label id="datedenaissance">
                <?php if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth'])
                {echo $_SESSION['user']['datedenaissance'];}
                ?></label></td> 
          </tr>
      
        <tr>
          <td class="centre"><label for="nom"><i>Nom</i></label></td>
            <td class="centre"><label id= "nom"><?php 
            if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth'])
            {
              if(strlen($_SESSION['user']['nom']) == 0){
                echo "<i>Inconnu</i>";
              }else{
                echo $_SESSION['user']['nom'];
              }
            }
              ?>
              </label></td> 
            </tr>
           

          <tr id="modifiernom">
            <td class="centre">
              <label for="newnom"><i>Nouveau nom : </i></label>
            </td>
            <td>
              <input name="newnom" id="newnom" class="rose" placeholder="Entrez votre new nom." type="text" value="">
            </td>
          </tr>
                
        <tr>
          <td class="centre"><label for="prenom"><i>Prénom</i></label></td>
            <td class="centre"><label id= "prenom">
              <?php  if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth'])
              {
                if(strlen($_SESSION['user']['prenom']) == 0){
                  echo "<i>Inconnu</i>";
                }else{
                  echo $_SESSION['user']['prenom'];
                }
              } 
            ?></label></td> 
         </tr>
         
          <tr id="modifierprenom">
            <td class="centre">
              <label for="newprenom"><i>Nouveau prénom : </i></label>
            </td>
            <td>
              <input name="newprenom" id="newprenom" class="rose" placeholder="Entrez votre new prénom." type="text" value="">
            </td>
          </tr>

        <tr>
            <td  class="centre"><label for="situation"><i>Situation</i></label></td>
            <td  class="centre"><label id= "situation"><?php 
              if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth'])
                {echo $_SESSION['user']['situation'];} 
            ?></label></td> 
          </tr>
        <tr>
          <td  class="centre"><label for= "roleSite"><i>Rôle</i></label></td>
            <td  class="centre"><label id= "roleSite"><?php if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){echo $_SESSION['user']['roleSite'];} ?></label></td> 
          </tr>
        <tr>
          <td  class="centre"><label for= "genre"><i>Genre</i></label></td>
            <td  class="centre"><label id= "genre"><?php if (isset($_SESSION['usr_auth']) && $_SESSION['usr_auth']){echo $_SESSION['user']['genre'];} ?></label></td> 
          </tr>

          <tfoot>
               <tr>
                <td colspan="2" class="centre">
                  <input type="submit" value="Appliquer"/>
                </td>
              </tr>
          </tfoot>

<?php 

/*Erreur 1 : Photo de profil.
Erreur 2 : Mot de passe (...)
Erreur 3 : Nom
Erreur 4 : Prénom
...
*/
if(isset($_POST['newimg']))
{
 $_POST['errors'] = array();

 //Verification du lien.
  $newimg = "";
  if (isset($_POST['newimg']) && !empty($_POST['newimg'])) 
  {
    $newimg = filter_input(INPUT_POST, 'newimg', FILTER_SANITIZE_URL); 
    if(!$newimg){
      // Le lien est invalide ou inaccessible
      $_POST['errors']['err1'] = 'Lien invalide.';
    }
  }
  
  //Verification du mdp :
  $newmotdepasse = "";
if ( (isset($_POST['motdepasse']) && !empty($_POST['motdepasse'])) || (isset($_POST['newmotdepasse']) && !empty($_POST['newmotdepasse'])) || (isset($_POST['newmotdepassecheck']) && !empty($_POST['newmotdepassecheck'])) ) 
{ 
  if((isset($_POST['motdepasse']) && empty($_POST['motdepasse'])) || (isset($_POST['newmotdepasse']) && empty($_POST['newmotdepasse'])) || (isset($_POST['newmotdepassecheck']) && empty($_POST['newmotdepassecheck'])) )
  { 
    $_POST['errors']['err2'] = 'Les champs mot de passe sont obligatoires !';
  }

 if (!empty($_POST['newmotdepassecheck']) && !empty($_POST['newmotdepasse']) && ($_POST['newmotdepasse'] !=$_POST['newmotdepassecheck']) ) {
  $_POST['errors']['err2'] = 'Mots de passe non identiques';
 }
}
  
  //Verification du nom.
  $newnom = "";
  if (isset($_POST['newnom']) && !empty($_POST['newnom']) ) {
    $newnom = filter_input(INPUT_POST, 'newnom', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!$newnom){
      $_POST['errors']['err3'] = 'Nom invalide.';
    }
    if (preg_match('/^[\p{L}\p{M}\']+$/u', $newnom)) {
        
    } else {
        $_POST['errors']['err3'] = 'Nom invalide.';
    }
  }

    //Verification du prénom.
 $newprenom = "";
  if (isset($_POST['newprenom']) && !empty($_POST['newprenom']) ) {
    $newprenom = filter_input(INPUT_POST, 'newprenom', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!$newprenom){
      $_POST['errors']['err4'] = 'Prénom invalide.';
    }
    if (preg_match('/^[\p{L}\p{M}\']+$/u', $newprenom)) {
        
    } else {
        $_POST['errors']['err4'] = 'Prénom invalide.';
    }
  }



  if(empty($_POST['errors'])){
      $db = connectDB();
      $identifiant = $_SESSION['user']['identifiant'];
      
      if(!empty($_POST['newimg']) && !isset($_POST['errors']['err1']))
      {
        [$success,$error] = setInfoUser($db,'imgUrl',$newimg,$identifiant);
          if($success)
        {
          $_POST['modify'] = true;
          $_POST['success'] = "".$_POST['success']." photo de profil";
          $_POST['imgUrl'] = $newimg;
        }
          else
        {
          $_POST['errors']['err1'] =$error;
        }
      }

      if(!empty($_POST['newmotdepasse'])&& !empty($_POST['motdepasse']) && !empty($_POST['newmotdepassecheck']) && !isset($_POST['errors']['err2']))
      {
        [$success,$error] = setMotdepasse($db,$identifiant,$_POST['motdepasse'],$_POST['newmotdepasse'],$_POST['newmotdepassecheck']);
        echo "<script>alert('setmdp')</script>";
          if($success)
        {
          $_POST['modify'] = true;
          $_POST['success'] = "".$_POST['success']." mot de passe";
        }
          else
        {
          $_POST['errors']['err2'] =$error;
        }
      }

      if(!empty($_POST['newnom']) && !isset($_POST['errors']['err3']))
      {
        [$success,$error] = setInfoUser($db,'nom',$newnom,$identifiant);
          if($success)
        {
          $_POST['success'] = "".$_POST['success']." nom";
          $_POST['modify'] = true;
          $_POST['nom'] = $newnom;
        }
          else
        {
          $_POST['errors']['err3'] = $error;
        }
      }
      if(!empty($_POST['newprenom']) && !isset($_POST['errors']['err4']))
      {
        [$success,$error] = setInfoUser($db,'prenom',$newprenom,$identifiant);
          if($success)
        {
          $_POST['success'] = "".$_POST['success']." prénom";
            $_POST['modify'] = true;
            $_POST['prenom'] = $newprenom;
        }
          else
        {
          $_POST['errors']['err4'] =$error;
        }
      }

        $tableuser= majInfosUser($db, $identifiant);
        $_SESSION['user'] = $tableuser;
        $_POST['success'] = "".$_POST['success'].".";
        mysqli_close($db);
  }
}
?>

        <?php 
           if($_POST['modify'])
           {
             echo "<tr class=\"centre\"><td class=\"success\" colspan=\"2\">".$_POST['success']."</td></tr>";
             echo "<script>alert('Modifications effectuées : Veuillez rafraichir la page pour voir vos modifications !')</script>";
           }  
        ?>

        <?php if (!empty($_POST['errors']['err1'])): ?>
          <tr class="centre"><td class="error"><?php echo $_POST['errors']['err1']; ?></td></tr>
        <?php endif; ?>
       <?php if (!empty($_POST['errors']['err2'])): ?>
          <tr class="centre"><td class="error"><?php echo $_POST['errors']['err2']; ?></td></tr>
        <?php endif; ?>
        <?php if (!empty($_POST['errors']['err3'])): ?>
          <tr class="centre"><td class="error"><?php echo $_POST['errors']['err3']; ?></td></tr>
        <?php endif; ?>
        <?php if (!empty($_POST['errors']['err4'])): ?>
          <tr class="centre"><td class="error"><?php echo $_POST['errors']['err4']; ?></td></tr>
        <?php endif; ?>
      </table>
        </form>
        </fieldset>

<?php include 'views/footer.php' ?>