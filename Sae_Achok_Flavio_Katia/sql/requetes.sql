/*
BDD :
Inscrits au site ✅ A tester !

Evenements ✅

Inscrit à un event* ✅

Commentaires* ✅

*/

/* Ne marche pas sur mariadb :
CREATE DOMAIN SITUATION AS VARCHAR(20)  NOT NULL CONSTRAINT ContrainteSituation CHECK (VALUE IN ('handicap','valide','NSPP'));

CREATE DOMAIN HANDICAP AS VARCHAR(20) NOT NULL CONSTRAINT ContrainteTypeHandicap CHECK (VALUE IN ('moteur','sensoriel','mental','cognitif');

CREATE DOMAIN ROLESITE AS VARCHAR(20) NOT NULL CONSTRAINT ContrainteRole CHECK (VALUE IN ('utilisateur','gestionnaire','moderateur');

CREATE DOMAIN GENRE AS VARCHAR(20) NOT NULL CONSTRAINT ContrainteGenre CHECK (VALUE IN ('homme','femme','autre');

Create Table User_sae(
  idUser INT PRIMARY KEY AUTO_INCREMENT, --A chaque utilisateur ajouté, ça met tout seul le numéro de son id.
  identifiant varchar(30) UNIQUE NOT NULL, --identifiant du genre un pseudo 
  motdepasse varchar(255) NOT NULL, -- un mot de passe hashé peut faire maximum 255 caractères.
  addrmail varchar(320) UNIQUE NOT NULL, --Une adresse mail peut faire maximum 320 caractères.
  datedenaissance DATE NOT NULL, -- date de naissance enregistré au format AAAA-MM-JJ
  nom varchar(60) DEFAULT NULL, --non obligatoire
  prenom varchar(60) DEFAULT NULL, --non obligatoire
  genre GENRE NOT NULL, --peut prendre 3 valeurs possible
  situation SITUATION NOT NULL, -- peut prendre 3 valeurs possible
  handicap HANDICAP DEFAULT NULL, --Pas obligatoire, peut prendre 3 valeurs possible
  roleSite ROLESITE DEFAULT 'utilisateur' NOT NULL, --peut prendre 3 valeurs possible
  imgUrl varchar(255) DEFAULT NULL, --Pour la photo de profil Pas obligatoire
);
*/
/* CA MARHCE PAS NON PLUS
Create Table User_sae(
  idUser INT PRIMARY KEY AUTO_INCREMENT, 
  identifiant varchar(30) UNIQUE NOT NULL, 
  motdepasse varchar(255) NOT NULL,
  addrmail varchar(320) UNIQUE NOT NULL, 
  datedenaissance DATE NOT NULL, 
  nom varchar(60) DEFAULT NULL, 
  prenom varchar(60) DEFAULT NULL,
  genre  VARCHAR(20)  NOT NULL, 
  situation  VARCHAR(20)  NOT NULL,
  handicap  VARCHAR(20)  DEFAULT NULL,
  roleSite  VARCHAR(20)  DEFAULT 'utilisateur' NOT NULL,
  imgUrl varchar(255) DEFAULT NULL, 
  CONSTRAINT ContrainteGenre CHECK (genre IN ('homme','femme','autre')),
  CONSTRAINT ContrainteSituation CHECK (situation IN ('handicap','valide','NSPP')),
  CONSTRAINT ContrainteTypeHandicap CHECK (handicap IN ('moteur','sensoriel','mental','cognitif')),
  CONSTRAINT ContrainteRole CHECK (roleSite IN ('utilisateur','gestionnaire','moderateur'))
);*/

Create Table User_sae(
  idUser INT PRIMARY KEY AUTO_INCREMENT, 
  identifiant varchar(30) UNIQUE NOT NULL, 
  motdepasse varchar(255) NOT NULL,
  addrmail varchar(320) UNIQUE NOT NULL, 
  datedenaissance DATE NOT NULL, 
  nom varchar(60) DEFAULT NULL, 
  prenom varchar(60) DEFAULT NULL,
  genre  VARCHAR(20)  NOT NULL CHECK (genre IN ('homme','femme','autre')), 
  situation  VARCHAR(20)  NOT NULL CHECK (situation IN ('handicap','valide','NSPP')),
  handicap  VARCHAR(20)  DEFAULT NULL CHECK (handicap IN ('moteur','sensoriel','mental','cognitif')),
  roleSite  VARCHAR(20)  DEFAULT 'utilisateur' NOT NULL CHECK (roleSite IN ('utilisateur','gestionnaire','moderateur')),
  imgUrl varchar(255) DEFAULT NULL
);

-- Exemples d'insertion utilisateur
-- INSERT INTO User_sae (identifiant,motdepasse,addrmail,datedenaissance,genre,situation,handicap,roleSite) VALUES ('ninou29','MDPHASHED','louli@gmail.com','19990514','handicap','sensoriel','utilisateur','autre');

-- UPDATE User_sae SET imgUrl='https://upload.wikimedia.org/wikipedia/commons/thumb/6/69/SMirC-smile.svg/2048px-SMirC-smile.svg.png' WHERE identifiant = 'ninou29'; -- pour ajouter une photo de profil par exemple.

Create Table Evenements_sae(
  idEvent INT PRIMARY KEY AUTO_INCREMENT,
  idCreateur INT NOT NULL,
  FOREIGN KEY (idCreateur) REFERENCES User_sae(idUser),
  dateEvenement Date NOT NULL,
  titre VARCHAR(30) NOT NULL,
  description VARCHAR(2500) NOT NULL,
  type VARCHAR(30) NOT NULL check (type IN ('LAN','convention','competition','stream'))
);

Exemple insertion :
INSERT INTO Evenements_sae (idCreateur,dateEvenement,titre,description,type) VALUES (9,'2023-06-24','Partie minecraft modée','Salut ! Jorganise du lourd le samedi 24 Juin, une giga LAN sur minecraft avec des bonbons et des mod fantasy, venez nombreux.','LAN');
  

-- CREATE TABLE Participants(
--   idEvent INT,
--   idUser INT,
--   FOREIGN KEY (idEvent) REFERENCES Evenements_sae(idEvent),
--   FOREIGN KEY (idUser) REFERENCES User_sae(idUser),
--   UNIQUE(idEvent,idUser), -- Un utilisateur ne va pas participer 2 fois au même événement, donc la paire est unique.
--   role VARCHAR(20) NOT NULL DEFAULT 'participant' CHECK (role IN ('organisateur','regulateur','gestionnaire','participant'))
-- );

  CREATE TABLE Participants(
  idEvenement int(11),
  idParticipant int(11),
  FOREIGN KEY (idEvenement) REFERENCES Evenements_sae(idEvent),
  FOREIGN KEY (idParticipant) REFERENCES User_sae(idUser),
  role VARCHAR(20) NOT NULL DEFAULT 'participant' CHECK (role IN ('organisateur','regulateur','gestionnaire','participant'))
);
  
Exemple insertion :
INSERT INTO Participants (idEvenement,idParticipant) VALUES (1,4);

CREATE TABLE Commentaire_sae (
  idCommentaire INT PRIMARY KEY AUTO_INCREMENT,
  idEvenement INT NOT NULL,
  FOREIGN KEY (idEvenement) REFERENCES Evenements_sae(idEvent),
  idUser INT NOT NULL,
  FOREIGN KEY (idUser) REFERENCES User_sae(idUser),
  contenu varchar(2000)
);


Exemple insertion :
INSERT INTO Commentaire_sae (idEvenement,idUser,contenu) VALUES (1,4,"J'aime pas minecraft !");

Select * from Evenements_sae; --Requête sans Filtre
Where $filtre=$type_filtre,...;--S'il faut filter un créateur, un type d'évent précis
Order by $ordre,...;--Trier par ordre alphabétique et/ou date



--CREATE VIEW VueCreateur AS SELECT identifiant FROM User_sae JOIN Evenements_sae ON idUser=idCreateur WHERE idUser = 4;
