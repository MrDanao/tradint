-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 17 Février 2018 à 19:38
-- Version du serveur :  5.7.21-0ubuntu0.16.04.1
-- Version de PHP :  7.0.25-0ubuntu0.16.04.1

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
  MODIFY `reference` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
