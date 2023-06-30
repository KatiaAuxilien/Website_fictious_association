<?php
// Les erreurs de mysqli ne lanceront pas d'exception
// Il faut tester le retour des fonctions
mysqli_report(MYSQLI_REPORT_OFF);

function connectDB()
{
   $db = mysqli_connect("dwarves.iut-fbleau.fr","daveigasf","daveigasf","daveigasf");
   if (!$db) {
      die("Connexion Impossible: " . mysqli_connect_error());
   }
   return $db;
}


//Katia : Fonction pour filtrer les entrées utilisateurs du html et sql :
function assainir_filtrer($db,$input)
{
  $content_without_html = htmlentities($input);
  $content_without_html_sql = mysqli_real_escape_string($db,$content_without_html); //Erreur à régler.

  return $content_without_html_sql;
}

function verifier_connexion($db, $identifiant, $motdepasse)
{
    $identifiant_secure = assainir_filtrer($db,$identifiant);
    $mdp_secure = assainir_filtrer($db,$motdepasse);

        if(!$db){
        die("Connexion BD impossible");
        }

        $req="SELECT * FROM User_sae WHERE identifiant='".$identifiant_secure."';";
        $res=mysqli_query($db,$req);
        $donneesUser=mysqli_fetch_assoc($res);
  
    if(empty($donneesUser['identifiant']))
    {
       return [false, "Identifiant incorrect."];
    }
        if(!password_verify($mdp_secure,$donneesUser['motdepasse'])){
            return [false, "Mot de passe incorrect.",""];
    }
   return [true, "",$donneesUser];
}

function inscrire($db, $identifiant, $motdepasse, $addrmail,$datedenaissance,$genre,$situation)
{

  $datedenaissancecorrect =str_replace("-", "", $datedenaissance);
  //PREREQUIS !!! connectDB() dans le code !
  //On filtre nos données avant insertion.
  $identifiant_secure = assainir_filtrer($db,$identifiant);
  $motdepasse_secure  = assainir_filtrer($db,$motdepasse);
  $addrmail_secure  = assainir_filtrer($db,$addrmail);
  $datedenaissance_secure  = assainir_filtrer($db,$datedenaissancecorrect);

  //Verif du login
        $req2="SELECT identifiant FROM User_sae WHERE identifiant='$identifiant_secure';";
        $res2=mysqli_query($db,$req2);
  //Verif de l'email
        $req3="SELECT addrmail FROM User_sae WHERE addrmail='$addrmail_secure';";
        $res3=mysqli_query($db,$req3);
        if(mysqli_num_rows($res3)!=0 || mysqli_num_rows($res2)!=0){
            return [false, "Email ou identifiant déjà pris."]; //Pas de précisions pour éviter de donner + d'informations sur la bdd.
        }
  
        $mdp_hashed = password_hash($motdepasse_secure, PASSWORD_DEFAULT);

        $req="INSERT INTO User_sae (identifiant,motdepasse,addrmail,datedenaissance,genre,situation,roleSite) VALUES ('".$identifiant_secure."','".$mdp_hashed."','".$addrmail_secure."','".$datedenaissance_secure."','".$genre."','".$situation."','utilisateur')";
  
        $resultat=mysqli_query($db,$req);
        if($resultat){
        return [true, ""]; //La connexion est réussie.
        }else{
          return[false,"Erreur sql !  ddn :".$datedenaissance_secure.""];
      }
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

//CES FONCTIONS SETTERS SERVIRONT POUR LA PAGE INSCRIPTION ET MODIFIER LE PROFIL !

//setter des informations [genre,handicap,Nom, prenom, image]


//Attention ! Pour utiliser setInfoUser il faut faire attention lors de l'utilisation à ce que l'attribution situation soi handicap si on veut modifier l'handicap.
function setInfoUser($db,$attribut,$information,$identifiant){
  //PREREQUIS !!! connectDB() dans le code !
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
  
  if($attribut == 'genre' || $attribut == 'handicap' || $attribut == 'nom' || $attribut == 'prenom' || $attribut == 'imgUrl')
  {
    $information_secure = assainir_filtrer($db,$information);

      $req="UPDATE User_sae SET ".$attribut." ='".$information."' WHERE identifiant = '".$identifiant."';";
  
        $resultat=mysqli_query($db,$req);
        if($resultat){
      return [true, ""];
        }else{
      return[false,"Erreur de mise à jour de ".$attribut."!"];
    }
  }
  else
  {
    return [false,"Attribut non modifiable avec cette fonction."]; //On peut pas modifier la date de naissance, l'identifiant, le mot de passe et l'adresse mail
  }
}

//Pour modifier le mdp :
function setMotdepasse($db,$identifiant,$motdepasse,$nouvmdp)
{  //PREREQUIS !!! connectDB() dans le code !

    $mdp_secure = assainir_filtrer($db,$motdepasse);
    $nouvmdp_secure = assainir_filtrer($db,$nouvmdp);

    if(!$db){
    die("Connexion BD impossible");
    }

    $req="SELECT motdepasse FROM User_sae WHERE identifiant='".$identifiant."';";
    $res=mysqli_query($db,$req);
    $donneesUser=mysqli_fetch_assoc($res);
  
    if(!password_verify($mdp_secure,$donneesUser['motdepasse'])){
        return [false, "Mot de passe incorrect."];
    }
        $mdp_hashed = password_hash($nouvmdp_secure, PASSWORD_DEFAULT);
        
    $req2="UPDATE User_sae SET motdepasse ='".$mdp_hashed."' WHERE identifiant = '".$identifiant."';";
    $resultat=mysqli_query($db,$req2);

   return [true, ""];

  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

function getInfosUser($db,$identifiant)
{
    //PREREQUIS !!! connectDB() dans le code !
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
   $result = mysqli_query(
      $db,
      "select * From User_sae
     where identifiant='".$identifiant."';");
   return $result;
}

function majInfosUser($db,$identifiant)
{
    //PREREQUIS !!! connectDB() dans le code !
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
        $req="SELECT * FROM User_sae WHERE identifiant='".$identifiant."';";
        $res=mysqli_query($db,$req);
        $donneesUser=mysqli_fetch_assoc($res);
   return $donneesUser;
}

function getRequete_Filtre($filtrage,$typesSelectionnes){
  $conditionTypes = '';
if (!empty($typesSelectionnes)) {
  $typesFiltre = implode("', '", $typesSelectionnes);
  $conditionTypes = "AND type IN ('$typesFiltre')";
}
  if ($filtrage === 'titre') {
    $evenementsFiltres = "SELECT idEvent,dateEvenement,titre,description,type,User_sae.identifiant  FROM User_sae JOIN Evenements_sae ON User_sae.idUser = Evenements_sae.idCreateur where 1 $conditionTypes ORDER BY titre ASC"; // $evenements est votre liste d'événements à filtrer
} elseif ($filtrage === 'date') {
    $evenementsFiltres = "SELECT idEvent,dateEvenement,titre,description,type,User_sae.identifiant  FROM User_sae JOIN Evenements_sae ON User_sae.idUser = Evenements_sae.idCreateur where 1 $conditionTypes  ORDER BY dateEvenement DESC";
} elseif ($filtrage === 'createur') {
    $evenementsFiltres = "SELECT idEvent,dateEvenement,titre,description,type,User_sae.identifiant  FROM User_sae JOIN Evenements_sae ON User_sae.idUser = Evenements_sae.idCreateur where 1 $conditionTypes  ORDER BY User_sae.nom ASC";
} else {
    $evenementsFiltres ="select idEvent,dateEvenement,titre,description,type,User_sae.identifiant FROM User_sae JOIN Evenements_sae ON User_sae.idUser = Evenements_sae.idCreateur where 1 $conditionTypes  ;"; // Pas de filtrage, afficher tous les événements
}
  return $evenementsFiltres;
}

function getEvenements_Filtre($db,$filtre,$typesSelectionnes)
 {
     //PREREQUIS !!! connectDB() dans le code !
   //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
  
   if(!$db){
     die("Connexion BD impossible");
   }
    $req =getRequete_Filtre($filtre,$typesSelectionnes);
    $res = mysqli_query($db,$req);
    return $res;
}

function setInscriptionEvenement($db,$idUser,$idEvent){
    $req= "INSERT INTO Participants (idEvenement,idParticipant) VALUES ('$idEvent','$idUser');";
  
        $resultat=mysqli_query($db,$req);
        if($resultat){
      return [true, ""];
        }else{
      return[false,"Erreur de mise à jour de la table".mysqli_error($db)];
    }
  }

function insertCommentaire($db,$idUser,$idEvent,$contenu){
     $req= "INSERT INTO Commentaire_sae(idEvenement,idUser,contenu) VALUES ('$idEvent','$idUser','$contenu');";
     $resultat=mysqli_query($db,$req);
        if($resultat){
      return [true, ""];
        }else{
      return[false,"Erreur de mise à jour de la table".mysqli_error($db)];
}
}

function getCommentaires($db,$idEvent){
    $req = "SELECT User_sae.imgUrl, User_sae.identifiant, Evenements_sae.titre, Commentaire_sae.contenu 
FROM User_sae
JOIN Commentaire_sae ON User_sae.idUser = Commentaire_sae.idUser
JOIN Evenements_sae ON Evenements_sae.idEvent = Commentaire_sae.idEvenement
WHERE idEvenement=".$idEvent.";";




    $result = mysqli_query($db,$req);
   return $result;
}

function creer_event($db,$id,$titre, $type, $dateevenement,$description)
{

  $datecorrect =str_replace("-", "", $dateevenement);
  //PREREQUIS !!! connectDB() dans le code !
  //On filtre nos données avant insertion.
  $titre_secure = assainir_filtrer($db,$titre);
  $type_secure  = assainir_filtrer($db,$type);
  $description_secure  = assainir_filtrer($db,$description);
  $datecorrect_secure  = assainir_filtrer($db,$datecorrect);

        $req = "INSERT INTO Evenements_sae (idCreateur, dateEvenement, titre, description, type) VALUES ('".$id."', '".$datecorrect_secure."', '".$titre_secure."', '".$description_secure."', '".$type_secure."')";

  
        $resultat=mysqli_query($db,$req);
        if($resultat){
        return [true, ""]; //La connexion est réussie.
        }else{
          return[false,"Erreur sql !  ddn :".$datecorrect_secure.""];
      }
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

function getInformationsEvenement($db,$id)
{
  //PREREQUIS !!! connectDB() dans le code !
   $req ="SELECT * FROM Evenements_sae WHERE idEvent = '".$id."';";
   $res = mysqli_query($db,$req);
   $donneesEvent=mysqli_fetch_assoc($res);
   return $donneesEvent;
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

function getIdentifiantById($db,$id)
{
    //PREREQUIS !!! connectDB() dans le code !
   $req ="SELECT identifiant FROM User_sae WHERE idUser = '".$id."';";
   $res = mysqli_query($db,$req);
   $table=mysqli_fetch_array($res);
    if(!$res){
        return "Erreur"; 
    }
   return $table;
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

function getParticipantEvenement($db,$idEvent)
{
    //PREREQUIS !!! connectDB() dans le code !
   $req ="SELECT identifiant,imgUrl FROM User_sae JOIN Participants ON idUser = idParticipant WHERE idEvenement = ( SELECT idEvent FROM Evenements_sae WHERE idEvent = ".$idEvent.");";
   $res = mysqli_query($db,$req);
    if(!$res){
        return "Erreur"; //La connexion est réussie.
    }
   return $res;
  //!! penser à ajouter mysqli_close($db); après l'appel de la fonction !!
}

?>

