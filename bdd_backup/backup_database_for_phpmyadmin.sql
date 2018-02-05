-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 05 Février 2018 à 00:41
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
(1, 'Annonce 1', 'Ceci est la description de l\'annonce 1.', 11, '2018-02-04 19:35:05', '1_p1.jpg', NULL, NULL, 'dan_tran', 1, 3),
(2, 'Annonce 2', 'Ceci est la description de l\'annonce 2.', 9, '2018-02-04 19:35:05', '2_p1.jpg', NULL, NULL, 'yassine_farouq', 1, 1),
(3, 'Annonce 3', 'Ceci est le descriptif de l\'annonce 3.', NULL, '2018-02-04 19:37:53', '3_p1.jpg', NULL, NULL, 'yassine_farouq', 3, 4),
(4, 'Annonce 4', 'DESCRIPTION ANNONCE 4.', 100, '2018-02-04 19:48:13', '4_p1.jpg', NULL, NULL, 'lamine_traore', 1, 3),
(5, 'f', 'f', 10, '2018-02-04 22:39:38', 'z', NULL, NULL, 'lamine_traore', 2, 3),
(7, 'fegrer', 'ffdsfsdfd', NULL, '2018-02-04 23:11:11', 'lisez moi.txt', 'NULL', 'NULL', 'dan_tran', 3, 1),
(8, 'vfdfvfd', 'vdfvfdvdf', NULL, '2018-02-04 23:12:35', 'leboncoin_campus_tmsp', NULL, NULL, 'dan_tran', 2, 2),
(9, 'greeger', 'gregreer', 10000, '2018-02-04 23:13:21', 'localisation.sql', NULL, NULL, 'dan_tran', 1, 3),
(10, 'gregrger', 'fezfez', 7686, '2018-02-04 23:14:09', 'localisation.sql', NULL, NULL, 'dan_tran', 1, 2),
(11, 'trrt', 'gregre', NULL, '2018-02-04 23:17:51', 'leboncoin_campus_tmsp', NULL, NULL, 'dan_tran', 3, 2),
(12, 'gfgdfgfd', 'gfdg', NULL, '2018-02-04 23:39:35', 'photo.jpg', 'Capture dâ€™Ã©cran de 2018-02-01 23-42-54.png', NULL, 'dan_tran', 3, 2),
(13, 'gfgdfgfd', 'gfdg', NULL, '2018-02-04 23:40:47', 'photo.jpg', 'Capture dâ€™Ã©cran de 2018-02-01 23-42-54.png', NULL, 'dan_tran', 3, 2),
(14, 'gfdgfdfÃ©Ã©Ã©Ã©', 'vdfd', NULL, '2018-02-04 23:41:18', 'photo.jpg', 'Capture dâ€™Ã©cran de 2018-02-01 23-42-54.png', NULL, 'dan_tran', 2, 5),
(15, 'gfdgfdfÃ©Ã©Ã©Ã©', 'vdfd', NULL, '2018-02-04 23:50:42', 'photo.jpg', 'Capture dâ€™Ã©cran de 2018-02-01 23-42-54.png', NULL, 'dan_tran', 2, 5),
(16, 'TEEEEST', 'TESSSSSTTT', NULL, '2018-02-05 00:21:53', 'phozzzzto.jpg', 'photo.jpg', NULL, 'dan_tran', 2, 3),
(17, 'DETFYTYTFTYFT', 'GFDGFHGHD', 67576576, '2018-02-05 00:31:17', 'photo.jpg', '_DSC9977.jpg', NULL, 'dan_tran', 1, 2),
(18, 'YGUYGGUYGUG', 'hgUYUY', NULL, '2018-02-05 00:32:26', '18_p1', '18_p2', NULL, 'dan_tran', 3, 1),
(19, 'UHIUIU', 'GGYYGUYG', NULL, '2018-02-05 00:35:31', '19_p1.jpg', '19_p2.jpg', NULL, 'dan_tran', 2, 4),
(20, 'ggggguy', 'ggggyggu', 9999, '2018-02-05 00:36:20', '20_p1.png', '20_p2.png', NULL, 'dan_tran', 1, 1);

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
  `salt` char(128) COLLATE utf8_bin NOT NULL,
  `idLocal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`pseudo`, `passwd`, `email`, `numeroTel`, `salt`, `idLocal`) VALUES
('dan_tran', '$2y$10$ZXzd2s37e77RJerLvcCKMudZq.rbOJvJy3bf/.QDNY/pizciOpH1a', 'dan_tran@gmail.com', '0123456789', 'e|ÝÚÍû{¾Ñ%êË½ÀŠ3]!—„ýÆ-¤‰T2w“Å©z—µH‚BØ¤S“øUž××†y=”þ®cŽ%2Ç½¼)¤ñÜÖ$ =·dÉ£=pðLlf›!ÄOëºœÇì‡`ì÷ô[ÙBÙ:ÚÓcýà´\nBà¸', 3),
('lamine_traore', '$2y$10$CX.qNkX8cnqcsBYwKNj7BullvgTd7ZlUt3n5cAOiqtanxuTI002he', 'lamine_traore@gmail.com', '0123456789', '	ª6Eürzœ°0(Øû§k—©.ŽhdgúhWÃƒ–{,•$r_ž‰Ém¹õð”„kÿgñ"VíXY½;v35ªq´ZŒ¬ºr[¡øWYRzçå#tò§Bwú\0s¬a@ž;ó5öTÇ‡y&Ý­‰Èû-ÛV\n‰4§Œ¦\Z', 7),
('yassine_farouq', '$2y$10$fXNu9LuwCw2iSfUjcn6eCeqAIbgFDMBkPS1qoAYMjGP/VVEJcxwJC', 'yassine_farouq@gmail.com', '0123456789', '}snô»°\r¢Iõ#r~ž\n@ˆb!o_ðkŒÓŠ›‡c"™]ÛÁ²Ý·©Ò—^‡‹§ƒx&ú?ö­Š~Xü‘öƒKSÞ$õýÅ¤cŽºÑ¡Ø]ÝV\Zmq@ÍÓ‹BÎIòeÖQÍj¡<ô\nGWLi Thþ¸ÿÚTksIÑ©¶	', 3);

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
  MODIFY `reference` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
