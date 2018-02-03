#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: utilisateur
#------------------------------------------------------------

CREATE TABLE utilisateur(
        pseudo    Varchar (50) NOT NULL ,
        passwd    Varchar (255) NOT NULL ,
        email     Varchar (100) NOT NULL ,
        numeroTel Char (10) NOT NULL ,
        salt      Char (128) NOT NULL ,
        idLocal   Int NOT NULL ,
        PRIMARY KEY (pseudo )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: annonce
#------------------------------------------------------------

CREATE TABLE annonce(
        reference     Char (10) NOT NULL ,
        nom           Varchar (255) NOT NULL ,
        descriptif    Varchar (2000) NOT NULL ,
        prix          Int ,
        photo1        Varchar (1000) NOT NULL ,
        photo2        Varchar (1000) ,
        photo3        Varchar (1000) ,
        pseudo        Varchar (50) NOT NULL ,
        idTypeAnnonce Int NOT NULL ,
        idCat         Int NOT NULL ,
        PRIMARY KEY (reference )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: localisation
#------------------------------------------------------------

CREATE TABLE localisation(
        idLocal   int (11) Auto_increment  NOT NULL ,
        descLocal Varchar (100) NOT NULL ,
        PRIMARY KEY (idLocal )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: type_annonce
#------------------------------------------------------------

CREATE TABLE type_annonce(
        idTypeAnnonce   int (11) Auto_increment  NOT NULL ,
        descTypeAnnonce Varchar (100) NOT NULL ,
        PRIMARY KEY (idTypeAnnonce )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: categorie
#------------------------------------------------------------

CREATE TABLE categorie(
        idCat   int (11) Auto_increment  NOT NULL ,
        descCat Varchar (100) NOT NULL ,
        PRIMARY KEY (idCat )
)ENGINE=InnoDB;

ALTER TABLE utilisateur ADD CONSTRAINT FK_utilisateur_idLocal FOREIGN KEY (idLocal) REFERENCES localisation(idLocal);
ALTER TABLE annonce ADD CONSTRAINT FK_annonce_pseudo FOREIGN KEY (pseudo) REFERENCES utilisateur(pseudo);
ALTER TABLE annonce ADD CONSTRAINT FK_annonce_idTypeAnnonce FOREIGN KEY (idTypeAnnonce) REFERENCES type_annonce(idTypeAnnonce);
ALTER TABLE annonce ADD CONSTRAINT FK_annonce_idCat FOREIGN KEY (idCat) REFERENCES categorie(idCat);

# ajout de quelques données dans la base

INSERT INTO `type_annonce` (`idTypeAnnonce`, `descTypeAnnonce`) VALUES
(1, 'Vente'),
(2, 'Échange'),
(3, 'Prêt'),
(4, 'Don');

INSERT INTO `localisation` (`idLocal`, `descLocal`) VALUES
(1, 'U1'),
(2, 'U2'),
(3, 'U3'),
(4, 'U4'),
(5, 'U5'),
(6, 'U6'),
(7, 'U7'),
(8, 'Externe');

INSERT INTO `categorie` (`idCat`, `descCat`) VALUES
(1, 'Meubles'),
(2, 'Fournitures'),
(3, 'Cuisine'),
(4, 'Vêtements'),
(5, 'Nourriture');
