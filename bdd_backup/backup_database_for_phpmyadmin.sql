-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 08 Février 2018 à 16:06
-- Version du serveur :  5.7.21-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

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

--
-- Contenu de la table `annonce`
--

INSERT INTO `annonce` (`reference`, `nom`, `descriptif`, `prix`, `dateAjout`, `photo1`, `photo2`, `photo3`, `pseudo`, `idTypeAnnonce`, `idCat`) VALUES
(36, 'Annonce 1 par dan_tran Ã©', 'Description de l\'annonce 1 up par dan_tran. Ã©', 99, '2018-02-06 21:59:24', '36_p1.jpg', '36_p2.png', NULL, 'dan_tran', 1, 2),
(37, 'Annonce 2 par dan_tran', 'Description annonce 2.', NULL, '2018-02-06 22:00:10', '37_p1.png', NULL, NULL, 'dan_tran', 3, 2),
(40, 'Annonce 5', 'Description annonce 5.', NULL, '2018-02-06 22:13:12', '40_p1.jpg', NULL, NULL, 'lamine_traore', 4, 3),
(41, 'Annonce 6', 'description', 1, '2018-02-06 22:14:04', '41_p1.png', NULL, NULL, 'lamine_traore', 1, 2),
(42, 'Annonce 7', 'descr', NULL, '2018-02-07 00:53:53', '42_p1.png', NULL, NULL, 'lamine_traore', 2, 3),
(43, 'Annonce 8', 'desc', NULL, '2018-02-07 00:55:18', '43_p1.jpg', NULL, NULL, 'dan_tran', 2, 4),
(44, 'cdcdz', 'ceceze', NULL, '2018-02-08 15:37:17', '44_p1.jpg', NULL, NULL, 'test', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `idCat` int(11) NOT NULL,
  `descCat` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idCat`, `descCat`) VALUES
(1, 'Meubles'),
(2, 'Fournitures'),
(3, 'Cuisine'),
(4, 'Vêtements'),
(5, 'Nourriture');

-- --------------------------------------------------------

--
-- Structure de la table `localisation`
--

CREATE TABLE `localisation` (
  `idLocal` int(11) NOT NULL,
  `descLocal` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `localisation`
--

INSERT INTO `localisation` (`idLocal`, `descLocal`) VALUES
(1, 'U1\r\n'),
(2, 'U2'),
(3, 'U3'),
(4, 'U4'),
(5, 'U5'),
(6, 'U6'),
(7, 'U7'),
(8, 'Externe');

-- --------------------------------------------------------

--
-- Structure de la table `type_annonce`
--

CREATE TABLE `type_annonce` (
  `idTypeAnnonce` int(11) NOT NULL,
  `descTypeAnnonce` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `type_annonce`
--

INSERT INTO `type_annonce` (`idTypeAnnonce`, `descTypeAnnonce`) VALUES
(1, 'Vente'),
(2, '&Eacute;change'),
(3, 'Pr&ecirc;t'),
(4, 'Don');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `pseudo` varchar(50) COLLATE utf8_bin NOT NULL,
  `passwd` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `numeroTel` char(10) COLLATE utf8_bin NOT NULL,
  `salt` char(128) CHARACTER SET utf16 COLLATE utf16_bin NOT NULL,
  `idLocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`pseudo`, `passwd`, `email`, `numeroTel`, `salt`, `idLocal`) VALUES
('dan_tran', '$2y$10$gvU5H12PQoKAd0m5VsyaD.R7nZEmC/k5zR/lNlSRy.mO0JclC4eYO', 'dan_tran@hotmail.fr', '0123456789', '‚õ9]B‚€wI¹VÌš1>(iéÂæŸ”ãÙµ>Å*ÍPÌÉ–ò)áIL¸ƒiÛ, DlïÇ½íàüícÐãg­aO@ë£<¹+Åp«Žzw.˜îÝO?¥˜kJ‰ói"ØÆT’ÐÕŽ	£÷²(‹¢%âñýö\0­¤P¸', 3),
('lamine_traore', '$2y$10$67bIW/GaUUzhSsa8iHcAWOx7gkEfbZZi4s1iLkBig5glqcKeuFiGO', 'lamine_traore@hotmail.fr', '0123456789', 'ë¶È[ñšQLáJÆ¼ˆw\0YCƒ—@;(.ùÙ=9Ôc-™yyÑ )Dugæ¨\n•dw[úê»F1^d]|Foòúž8N´¾ë£s€¾Í%còòHîî\nÀøóÞžÕ¸’ÝÙÆ·$èÆü!¿W ·þàrøÞx xÄ÷G}f$ƒ¾,Ë×÷', 4),
('test', '$2y$10$BNYe.e1ZdX6KuXc0U.oKtOo8bAydRXPxMyWMRKczUAdRUEK75CZZK', 'test', '0123456789', 'ÖùíYu~Š¹w4Sê\nµtd¤9“ïÞ˜o³#UF¹àX;>òilˆ}¢ÃfBÓQ~(Ä“‹®ô¢Ñ÷ Ó5n‘°„<ZÕñè1£‰ø¸oP‡?a¶Ré`Ë(1ðÚ§¤šÜß8Y?½\Z¨ÃíRð£àÅOÇž', 3),
('yassine_farouq', '$2y$10$nzWfBTWeoQnQIozPCHPXce0H.F61U4VoDfwDgjnh61A6HZ1lmkz0y', 'yassine_farouq@hotmail.fr', '0123456789', 'Ÿ5Ÿ5ž¡	Ð"ŒÏs×rË˜€áñ: æw7e·x–õº¦3)1´MÆ¿øÍ÷ùíD(kÑQ3ûy©â;{üÃ„¿Õ\Z¤Ðå|ÉDÉc?²Ì÷žfˆe«f¶¼z¯Æ®¾Åë¶êHòM*eøZ…Flf0mÈœJ½Ù†', 7);

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
  MODIFY `reference` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
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
