-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 28 Octobre 2012 à 10:58
-- Version du serveur: 5.5.28-log
-- Version de PHP: 5.4.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `flux_rss`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` varchar(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `entry`
--

CREATE TABLE IF NOT EXISTS `entry` (
  `id` varchar(6) NOT NULL,
  `guid` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `link` text NOT NULL,
  `date` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  `is_favorite` int(11) NOT NULL,
  `id_feed` varchar(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_feed` (`id_feed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `id` varchar(6) NOT NULL,
  `url` text NOT NULL,
  `category` varchar(6) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `website` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `entry`
--
ALTER TABLE `entry`
  ADD CONSTRAINT `entry_ibfk_1` FOREIGN KEY (`id_feed`) REFERENCES `feed` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `feed_ibfk_4` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
