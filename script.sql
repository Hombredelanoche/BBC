DROP TABLE IF EXISTS "Rôle";
CREATE TABLE IF NOT EXISTS"Rôle"(
   id_role INT,
   modérateur VARCHAR(50) NOT NULL,
   utilisateur VARCHAR(50) NOT NULL,
   visiteur VARCHAR(50),
   PRIMARY KEY(id_role)
);

DROP TABLE IF EXISTS "Utilisateur";
CREATE TABLE IF NOT EXISTS"Utilisateur"(
   id_utilisateur INT,
   surname VARCHAR(100) NOT NULL,
   email VARCHAR(150) NOT NULL,
   password VARCHAR(100) NOT NULL,
   adress VARCHAR(200) NOT NULL,
   phone_number INT,
   birthday DATE NOT NULL,
   name VARCHAR(100) NOT NULL,
   profil_picture VARCHAR(255),
   id_role INT NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(email),
   UNIQUE(phone_number),
   FOREIGN KEY(id_role) REFERENCES Rôle(id_role)
);

DROP TABLE IF EXISTS "Planning";
CREATE TABLE IF NOT EXISTS"Planning"(
   Id_Planning INT,
   title VARCHAR(100) NOT NULL,
   debut_training DATETIME NOT NULL,
   fin_training DATETIME NOT NULL,
   background_color VARCHAR(15) NOT NULL,
   boder_color VARCHAR(15) NOT NULL,
   text_color VARCHAR(15) NOT NULL,
   description TEXT NOT NULL,
   all_day LOGICAL,
   PRIMARY KEY(Id_Planning)
);

DROP TABLE IF EXISTS "Categorie";
CREATE TABLE IF NOT EXISTS"Categorie"(
   Id_catégorie INT,
   nom_catégorie VARCHAR(50) NOT NULL,
   PRIMARY KEY(Id_catégorie)
);

DROP TABLE IF EXISTS "TodoArticles";
CREATE TABLE IF NOT EXISTS"TodoArticles"(
   Id_TodoArticles INT,
   title_article VARCHAR(100) NOT NULL,
   content TEXT NOT NULL,
   creation_date DATE NOT NULL,
   pictures VARCHAR(255),
   video VARCHAR(255),
   Id_catégorie INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(Id_TodoArticles),
   FOREIGN KEY(Id_catégorie) REFERENCES catégories(Id_catégorie),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

DROP TABLE IF EXISTS "Inscription_training";
CREATE TABLE IF NOT EXISTS"Inscription_training"(
   id_utilisateur INT,
   Id_Planning INT,
   PRIMARY KEY(id_utilisateur, Id_Planning),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(Id_Planning) REFERENCES Planning(Id_Planning)
);
