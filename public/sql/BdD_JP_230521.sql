-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour travailgroupe
CREATE DATABASE IF NOT EXISTS `travailgroupe` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `travailgroupe`;

-- Listage de la structure de la table travailgroupe. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.categorie : ~4 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Bureautique'),
	(2, 'Dev Web'),
	(3, 'Dev App');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Listage des données de la table travailgroupe.doctrine_migration_versions : ~2 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20210515081706', '2021-05-15 10:17:28', 6087),
	('DoctrineMigrations\\Version20210515082038', '2021-05-15 08:21:10', 256);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptif` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.formation : ~5 rows (environ)
/*!40000 ALTER TABLE `formation` DISABLE KEYS */;
INSERT INTO `formation` (`id`, `nom`, `descriptif`) VALUES
	(1, 'Initiation Comptabilité', NULL),
	(2, 'Initiation à Word et Excel', NULL),
	(3, 'Initiation Bureautique et Infographie', NULL),
	(4, 'RAN métiers du numérique', 'Remise à niveau dans les métiers du numérique.'),
	(6, 'RAN métiers de la bureautique', 'Remise à niveau dans les métiers de la bureautique.'),
	(7, 'Spécialisation bureautique', 'Niveau 22 de la formation de secrétaire de direction'),
	(8, 'Developpement web', 'Titre III dev web web mobile');
/*!40000 ALTER TABLE `formation` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `libelle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptif` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.module : ~7 rows (environ)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `categorie_id`, `libelle`, `descriptif`) VALUES
	(1, 1, 'Word', 'Durant ce module vous apprendrez les bases de l\'utilisation du logiciel de traitement de texte de la suite bureautique Microsoft.'),
	(2, 1, 'Excel', 'Durant ce module vous apprendrez les bases de l\'utilisation du tableur de la suite bureautique Microsoft.'),
	(3, 1, 'PowerPoint', 'Ce module vous permettra d\'effectuer des présentations en suivant un plan défini dans un cadre contraint.'),
	(4, 2, 'PHP', 'Au lieu d\'utiliser des tonnes de commandes afin d\'afficher du HTML (comme en C ou en Perl), les pages PHP contiennent des fragments HTML dont du code qui fait "quelque chose" (dans ce cas, il va afficher "Bonjour, je suis un script PHP !").'),
	(5, 2, 'SQL', 'Le SQL (Structured Query Language) est un langage permettant de communiquer avec une base de données. Ce langage informatique est notamment très utilisé par les développeurs web pour communiquer avec les données d’un site web. SQL.sh recense des cours de SQL et des explications sur les principales commandes pour lire, insérer, modifier et supprimer des données dans une base.'),
	(6, 2, 'Javascript', 'JavaScript (souvent abrégé en « JS ») est un langage de script léger, orienté objet, principalement connu comme le langage de script des pages web. Mais il est aussi utilisé dans de nombreux environnements extérieurs aux navigateurs web tels que Node.js, Apache CouchDB voire Adobe Acrobat. Le code JavaScript est interprété ou compilé à la volée (JIT). C\'est un langage à objets utilisant le concept de prototype, disposant d\'un typage faible et dynamique qui permet de programmer suivant plusieurs paradigmes de programmation : fonctionnelle, impérative et orientée objet. Apprenez-en plus sur JavaScript.'),
	(7, 3, 'Swift', 'Logiciel de programmation mobile');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. programmer
CREATE TABLE IF NOT EXISTS `programmer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `duree` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4136CCA9613FECDF` (`session_id`),
  KEY `IDX_4136CCA9AFC2B591` (`module_id`),
  CONSTRAINT `FK_4136CCA9613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_4136CCA9AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.programmer : ~5 rows (environ)
/*!40000 ALTER TABLE `programmer` DISABLE KEYS */;
INSERT INTO `programmer` (`id`, `session_id`, `module_id`, `duree`) VALUES
	(1, 2, 1, 3),
	(2, 1, 1, 5),
	(3, 1, 2, 4),
	(4, 3, 5, 2),
	(5, 3, 4, 2),
	(6, 3, 6, 2);
/*!40000 ALTER TABLE `programmer` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `nb_places` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.session : ~3 rows (environ)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `formation_id`, `date_debut`, `date_fin`, `nb_places`) VALUES
	(1, 2, '2021-03-03', '2021-11-11', 16),
	(2, 3, '2021-02-02', '2021-10-10', 12),
	(3, 4, '2021-06-01', '2021-06-30', 10);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. session_stagiaire
CREATE TABLE IF NOT EXISTS `session_stagiaire` (
  `session_id` int(11) NOT NULL,
  `stagiaire_id` int(11) NOT NULL,
  PRIMARY KEY (`session_id`,`stagiaire_id`),
  KEY `IDX_C80B23B613FECDF` (`session_id`),
  KEY `IDX_C80B23BBBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_C80B23B613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C80B23BBBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.session_stagiaire : ~3 rows (environ)
/*!40000 ALTER TABLE `session_stagiaire` DISABLE KEYS */;
INSERT INTO `session_stagiaire` (`session_id`, `stagiaire_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(3, 4);
/*!40000 ALTER TABLE `session_stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table travailgroupe. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `courriel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table travailgroupe.stagiaire : ~4 rows (environ)
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_naissance`, `adresse`, `code_postal`, `ville`, `courriel`, `telephone`, `sexe`) VALUES
	(1, 'Dupont', 'Michel', '1989-05-15', '33 boulevard de Lyon', '67000', 'STRASBOURG', 'michel-dupont@gmel.com', '0336549678', 'M'),
	(2, 'Tamarin', 'Micheline', '1985-03-29', '5 rue Michel Polnareff', '45000', 'NANTES', 'micheline.tamarin@hotmel.fr', '0346544678', 'F'),
	(3, 'GURAK', 'Jean-Philippe', '1975-06-16', '6A rue du Rhin', '68490', 'Hombourg', 'gu@gu.fr', '0102030405', 'M'),
	(4, 'boum', 'boum', '1985-05-10', '12 boum boum', '75000', 'Ca va peter', 'boum@boum.fr', '0102030506', 'F'),
	(5, 'Bidule', 'bidule', '1968-02-01', '68 chemin de l\'ile aux ours', '68680', 'Oursland', 'bidule@bidule.fr', '9887766554', 'F');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
