-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Sam 24 Février 2018 à 23:27
-- Version du serveur :  10.1.26-MariaDB-0+deb9u1
-- Version de PHP :  7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tradint`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `reference` int(10) NOT NULL,
  `nom` varchar(255) COLLATE utf8_bin NOT NULL,
  `descriptif` varchar(2000) COLLATE utf8_bin NOT NULL,
  `prix` int(11) DEFAULT NULL,
  `dateAjout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `photo1` varchar(1000) COLLATE utf8_bin NOT NULL,
  `photo2` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `photo3` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL,
  `idTypeAnnonce` int(11) NOT NULL,
  `idCat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `idCat` int(11) NOT NULL,
  `descCat` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `dataAnnonce`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `dataAnnonce` (
`reference` int(10)
,`nom` varchar(255)
,`descriptif` varchar(2000)
,`prix` int(11)
,`photo1` varchar(1000)
,`photo2` varchar(1000)
,`photo3` varchar(1000)
,`descTypeAnnonce` varchar(100)
,`idTypeAnnonce` int(11)
,`descCat` varchar(100)
,`idCat` int(11)
,`dateAjout` datetime
,`pseudo` varchar(50)
,`idLocal` int(11)
,`descLocal` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure de la table `localisation`
--

CREATE TABLE `localisation` (
  `idLocal` int(11) NOT NULL,
  `descLocal` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `type_annonce`
--

CREATE TABLE `type_annonce` (
  `idTypeAnnonce` int(11) NOT NULL,
  `descTypeAnnonce` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL,
  `passwd` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `numeroTel` char(10) COLLATE utf8_bin NOT NULL,
  `salt` binary(128) NOT NULL,
  `idLocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la vue `dataAnnonce`
--
DROP TABLE IF EXISTS `dataAnnonce`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admintradint`@`localhost` SQL SECURITY DEFINER VIEW `dataAnnonce`  AS  select `ann`.`reference` AS `reference`,`ann`.`nom` AS `nom`,`ann`.`descriptif` AS `descriptif`,`ann`.`prix` AS `prix`,`ann`.`photo1` AS `photo1`,`ann`.`photo2` AS `photo2`,`ann`.`photo3` AS `photo3`,`typ`.`descTypeAnnonce` AS `descTypeAnnonce`,`ann`.`idTypeAnnonce` AS `idTypeAnnonce`,`cat`.`descCat` AS `descCat`,`ann`.`idCat` AS `idCat`,`ann`.`dateAjout` AS `dateAjout`,`ann`.`pseudo` AS `pseudo`,`user`.`idLocal` AS `idLocal`,`local`.`descLocal` AS `descLocal` from ((((`annonce` `ann` join `type_annonce` `typ`) join `categorie` `cat`) join `utilisateur` `user`) join `localisation` `local`) where ((`ann`.`idTypeAnnonce` = `typ`.`idTypeAnnonce`) and (`ann`.`idCat` = `cat`.`idCat`) and (`ann`.`pseudo` = `user`.`pseudo`) and (`user`.`idLocal` = `local`.`idLocal`)) order by `ann`.`reference` desc ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`reference`),
  ADD KEY `FK_annonce_pseudo` (`pseudo`),
  ADD KEY `FK_annonce_idTypeAnnonce` (`idTypeAnnonce`),
  ADD KEY `FK_annonce_idCat` (`idCat`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCat`);

--
-- Index pour la table `localisation`
--
ALTER TABLE `localisation`
  ADD PRIMARY KEY (`idLocal`);

--
-- Index pour la table `type_annonce`
--
ALTER TABLE `type_annonce`
  ADD PRIMARY KEY (`idTypeAnnonce`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`pseudo`),
  ADD KEY `FK_utilisateur_idLocal` (`idLocal`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `reference` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `localisation`
--
ALTER TABLE `localisation`
  MODIFY `idLocal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `type_annonce`
--
ALTER TABLE `type_annonce`
  MODIFY `idTypeAnnonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `FK_annonce_idCat` FOREIGN KEY (`idCat`) REFERENCES `categorie` (`idCat`),
  ADD CONSTRAINT `FK_annonce_idTypeAnnonce` FOREIGN KEY (`idTypeAnnonce`) REFERENCES `type_annonce` (`idTypeAnnonce`),
  ADD CONSTRAINT `FK_annonce_pseudo` FOREIGN KEY (`pseudo`) REFERENCES `utilisateur` (`pseudo`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_utilisateur_idLocal` FOREIGN KEY (`idLocal`) REFERENCES `localisation` (`idLocal`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
