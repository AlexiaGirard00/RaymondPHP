-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 18 mai 2023 à 18:29
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `raymond`
--

-- --------------------------------------------------------

--
-- Structure de la table `dbo.categories`
--

DROP TABLE IF EXISTS `dbo.categories`;
CREATE TABLE IF NOT EXISTS `dbo.categories` (
  `IdCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `NomCategorie` varchar(100) NOT NULL,
  `DescriptionCategorie` text NOT NULL,
  `ActifCategorie` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IdCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `dbo.categories`
--

INSERT INTO `dbo.categories` (`IdCategorie`, `NomCategorie`, `DescriptionCategorie`, `ActifCategorie`) VALUES
(1, 'Bols utilitaires', 'Bols utilitaires', 1),
(2, 'Bols décoratifs', 'Bols décoratifs', 1),
(3, 'Urnes funéraires', 'Urnes funéraires', 1),
(4, 'Vases décoratifs', 'Vases décoratifs', 1);

-- --------------------------------------------------------

--
-- Structure de la table `dbo.imageproduit`
--

DROP TABLE IF EXISTS `dbo.imageproduit`;
CREATE TABLE IF NOT EXISTS `dbo.imageproduit` (
  `IdImageProduit` int(11) NOT NULL AUTO_INCREMENT,
  `IdProduitFk` int(11) NOT NULL,
  `ImageChemin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`IdImageProduit`),
  KEY `IdProduitFK` (`IdImageProduit`),
  KEY `IdProduit` (`IdProduitFk`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `dbo.imageproduit`
--

INSERT INTO `dbo.imageproduit` (`IdImageProduit`, `IdProduitFk`, `ImageChemin`) VALUES
(26, 100, './uploads/thump_69123300.jpg'),
(27, 100, './uploads/thump_73279700.jpg'),
(28, 100, './uploads/thump_77455900.jpg'),
(29, 101, './uploads/thump_46450600.jpg'),
(30, 101, './uploads/thump_48458500.jpg'),
(31, 101, './uploads/thump_52424700.jpg'),
(32, 102, './uploads/thump_71396500.jpg'),
(33, 102, './uploads/thump_78265300.jpg'),
(34, 102, './uploads/thump_83983600.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `dbo.produits`
--

DROP TABLE IF EXISTS `dbo.produits`;
CREATE TABLE IF NOT EXISTS `dbo.produits` (
  `IdProduit` int(11) NOT NULL AUTO_INCREMENT,
  `NomProduit` varchar(100) NOT NULL,
  `IdCategorieFk` int(11) NOT NULL,
  `DescriptionProduit` text NOT NULL,
  `DimensionProduit` varchar(50) NOT NULL,
  `TypeDeBoisProduit` varchar(50) NOT NULL,
  `CapaciteProduit` int(11) DEFAULT NULL,
  `PrixProduit` decimal(10,0) NOT NULL,
  `DateProduit` timestamp NOT NULL,
  `ActifProduit` tinyint(1) NOT NULL,
  PRIMARY KEY (`IdProduit`),
  KEY `IdCategorieFK` (`IdCategorieFk`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `dbo.produits`
--

INSERT INTO `dbo.produits` (`IdProduit`, `NomProduit`, `IdCategorieFk`, `DescriptionProduit`, `DimensionProduit`, `TypeDeBoisProduit`, `CapaciteProduit`, `PrixProduit`, `DateProduit`, `ActifProduit`) VALUES
(100, 'Bol en bois', 1, 'Massif, respectueux de l\'environnement, fait Ã  la main pour le riz et la salade', '13 x 17', 'Acacia', 12, '12', '2023-05-18 04:00:00', 1),
(101, 'Saladier en bambou', 1, 'FabriquÃ© en bois de bambou qui est une herbe naturellement reconstituante et l\'une des ressources les plus renouvelables au monde.', '20 x 10', 'Bambou', 14, '25', '2023-05-18 04:00:00', 1),
(102, 'Urne', 3, 'Urne funÃ©raire en bouleau', '7 x 11', 'Bouleau', 70, '130', '2023-05-18 04:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `dbo.utilisateurs`
--

DROP TABLE IF EXISTS `dbo.utilisateurs`;
CREATE TABLE IF NOT EXISTS `dbo.utilisateurs` (
  `IdUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `NomUtilisateur` varchar(50) NOT NULL,
  `PrenomUtilisateur` varchar(50) NOT NULL,
  `CourrielUtilisateur` varchar(250) NOT NULL,
  `MotDePasseUtilisateur` varchar(50) NOT NULL,
  `TelephoneUtilisateur` varchar(14) NOT NULL,
  `DateChangementCourriel` datetime DEFAULT NULL,
  `GUIDLogin` varchar(250) DEFAULT NULL,
  `DateEssaisOublier` datetime DEFAULT NULL,
  `ActifUtilisateur` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IdUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `dbo.utilisateurs`
--

INSERT INTO `dbo.utilisateurs` (`IdUtilisateur`, `NomUtilisateur`, `PrenomUtilisateur`, `CourrielUtilisateur`, `MotDePasseUtilisateur`, `TelephoneUtilisateur`, `DateChangementCourriel`, `GUIDLogin`, `DateEssaisOublier`, `ActifUtilisateur`) VALUES
(1, '', '', 'yaya@yaya.com', '123', '', '2023-04-18 17:03:24', NULL, '2023-04-18 17:03:24', 1),
(2, 'Soucy', 'Jessika', 'miss_zest@hotmail.com', 'Pa$$w0rd', '450-881-5151', '2023-04-20 18:09:12', NULL, '2023-04-20 18:09:12', 1);

-- --------------------------------------------------------

--
-- Structure de la table `passwordreset`
--

DROP TABLE IF EXISTS `passwordreset`;
CREATE TABLE IF NOT EXISTS `passwordreset` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CourrielUtilisateur` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `passwordreset`
--

INSERT INTO `passwordreset` (`Id`, `CourrielUtilisateur`, `Token`) VALUES
(1, 'yaya@yaya.com', '3d433f1c5e0da794467d601bedf78c4a668e7f2ad48fae8c80378d29d9ac4422deaddbedaa7044c0f340ace4be05bb2f0acd'),
(2, 'yaya@yaya.com', '60ac8680f5898095c5719c2e36d21fc9e38c2d8a3f472ac769dcf2ce42c77f491cde34e47eb9e28f05d4382a82ac004106f1'),
(3, 'yaya@yaya.com', '61fdd91f93b0d94a6a4862092e80de3bb6bc6515a85747828d463261bee0cc83195ef473d08a2211cd0f435b214163c4aa5e'),
(4, 'yaya@yaya.com', '9f3824e3e8f63b41a88c0c34bff605ca6c38ee66b17754df17f85c30714f2f3405045707b9f9cb979576c90e5c0f540a44be'),
(5, 'yaya@yaya.com', '7bcaab5c59172e19b024a9aaff7e8e78e1cb223a5968559ffcff80e4981dc74f6663d23311f6ef25e754d91246bbdd9a0add'),
(6, 'yaya@yaya.com', '1ecdff13cccf195106cbc78053ed01c6e80609b4ed62ca245991b32186df8e4b817d555f4f4079767e4a82a9a79aafdbcd2c'),
(7, 'yaya@yaya.com', '4c105c372a00763f4b7eca3eb76c2194892df31abdeeea704e79330c4045dccf24545d374d89bb1ac05b3ea3fb56d8946784');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dbo.imageproduit`
--
ALTER TABLE `dbo.imageproduit`
  ADD CONSTRAINT `dbo.imageproduit_ibfk_1` FOREIGN KEY (`IdProduitFk`) REFERENCES `dbo.produits` (`IdProduit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dbo.produits`
--
ALTER TABLE `dbo.produits`
  ADD CONSTRAINT `dbo.produits_ibfk_1` FOREIGN KEY (`IdCategorieFk`) REFERENCES `dbo.categories` (`IdCategorie`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
