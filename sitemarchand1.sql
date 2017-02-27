-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 11 Mai 2016 à 22:47
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sitemarchand`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(6) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `role` enum('CLIENT','ADMIN') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `login`, `mdp`, `nom`, `prenom`, `role`) VALUES
(1, 'jonham', 'c87f62a9e949058a8142c71c93fc0ef2', 'Hamoudi', 'Jonathan', 'ADMIN'),
(2, 'mardup', 'f6c9839d6ebdad84b619994a18391383', 'Dupont', 'Martin', 'CLIENT');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idClient` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `prixTotal` float(4,2) NOT NULL,
  `quantiteTotale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idClient` (`idClient`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `commandes`
--

INSERT INTO `commandes` (`id`, `idClient`, `date`, `prixTotal`, `quantiteTotale`) VALUES
(13, 1, '2016-05-07 21:02:36', 99.99, 15),
(14, 1, '2016-05-08 16:13:23', 97.20, 20),
(15, 1, '2016-05-08 16:40:03', 90.52, 19),
(16, 1, '2016-05-08 20:08:47', 99.99, 47),
(17, 1, '2016-05-08 20:32:13', 84.95, 5),
(18, 1, '2016-05-09 15:08:56', 16.99, 1),
(19, 1, '2016-05-09 15:09:08', 16.99, 1),
(20, 1, '2016-05-09 15:40:17', 99.99, 26),
(21, 1, '2016-05-09 17:21:53', 99.99, 19),
(22, 1, '2016-05-09 19:20:39', 99.99, 31),
(23, 1, '2016-05-09 19:30:09', 26.07, 1),
(24, 1, '2016-05-09 19:30:17', 52.14, 2),
(25, 1, '2016-05-09 19:31:28', 99.99, 6),
(26, 1, '2016-05-09 19:31:40', 52.14, 2),
(27, 1, '2016-05-09 19:36:40', 99.99, 51),
(28, 1, '2016-05-11 22:34:39', 99.99, 8),
(29, 1, '2016-05-11 22:35:03', 99.99, 8),
(30, 1, '2016-05-11 22:35:32', 99.99, 12),
(31, 1, '2016-05-11 22:45:24', 99.99, 25);

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

CREATE TABLE IF NOT EXISTS `familles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `familles`
--

INSERT INTO `familles` (`id`, `code`, `nom`) VALUES
(1, 'jaz', 'Jazz'),
(2, 'blu', 'Blues'),
(3, 'fol', 'Folk'),
(4, 'cla', 'Classique'),
(5, 'pop', 'Pop'),
(6, 'vfr', 'Vari&eacute;t&eacute; fran&ccedil;aise');

-- --------------------------------------------------------

--
-- Structure de la table `lignecommande`
--

CREATE TABLE IF NOT EXISTS `lignecommande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCommande` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixUnitaire` float(4,2) NOT NULL,
  `sousTotal` float(4,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idCommande` (`idCommande`,`idProduit`),
  KEY `idProduit` (`idProduit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Contenu de la table `lignecommande`
--

INSERT INTO `lignecommande` (`id`, `idCommande`, `idProduit`, `quantite`, `prixUnitaire`, `sousTotal`) VALUES
(12, 14, 13, 20, 4.86, 97.20),
(13, 15, 10, 7, 4.60, 32.20),
(14, 15, 13, 12, 4.86, 58.32),
(15, 16, 3, 20, 16.99, 99.99),
(16, 16, 6, 18, 20.15, 99.99),
(17, 16, 9, 5, 19.99, 99.95),
(18, 16, 13, 4, 4.86, 19.44),
(19, 17, 3, 5, 16.99, 84.95),
(20, 18, 3, 1, 16.99, 16.99),
(21, 19, 3, 1, 16.99, 16.99),
(22, 20, 5, 13, 33.43, 99.99),
(23, 20, 3, 3, 16.99, 50.97),
(24, 20, 9, 4, 19.99, 79.96),
(25, 20, 10, 6, 4.60, 27.60),
(26, 21, 4, 4, 26.60, 99.99),
(27, 21, 10, 6, 4.60, 27.60),
(28, 21, 12, 9, 35.28, 99.99),
(29, 22, 4, 21, 26.60, 99.99),
(30, 22, 13, 4, 4.86, 19.44),
(31, 22, 6, 6, 20.15, 99.99),
(32, 23, 11, 1, 26.07, 26.07),
(33, 24, 11, 2, 26.07, 52.14),
(34, 25, 11, 6, 26.07, 99.99),
(35, 26, 11, 2, 26.07, 52.14),
(36, 27, 12, 51, 35.28, 99.99),
(37, 29, 3, 8, 16.99, 99.99),
(38, 30, 8, 12, 99.99, 99.99),
(39, 31, 6, 25, 20.15, 99.99);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFamille` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `prix` float(4,2) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idFamille` (`idFamille`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `idFamille`, `nom`, `description`, `image`, `prix`, `stock`) VALUES
(3, 1, 'Kind of Blue', 'Miles Davis', 'kindofblue', 16.99, 4),
(4, 4, 'Mahler: Symphonie No.5', 'Léonard Bernstein - Wiener Philharmoniker', 'mahlersym5', 26.60, 15),
(5, 1, 'Genius Loves Company', 'Ray Charles', 'genlovescomp', 33.43, 4),
(6, 3, 'Pete Remembers Woody - Volume One', 'Pete Seeger', 'peterememwoo', 20.15, 0),
(8, 2, 'Live At The Regal', 'B.B. King', 'liveatregal', 99.99, 3),
(9, 5, 'Hafanana', 'Afric Simone', 'hafanana', 19.99, 5),
(10, 6, 'Magnolias For Ever', 'Claude François', 'magforever', 4.60, 35),
(11, 5, 'Let It Be', 'The Beatles', 'letitbe', 26.07, 14),
(12, 5, 'Aerial Ballet', 'Harry Nilsson', 'aerialballet', 35.28, 10),
(13, 6, 'Ella, ella', 'France Gall', 'ellaella', 4.86, 3);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `lignecommande`
--
ALTER TABLE `lignecommande`
  ADD CONSTRAINT `lignecommande_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `commandes` (`id`),
  ADD CONSTRAINT `lignecommande_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`idFamille`) REFERENCES `familles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
