# ************************************************************
# Sequel Pro SQL dump
# Versión 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.34)
# Base de datos: media_ad
# Tiempo de Generación: 2014-09-12 16:30:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla ad_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ad_orders`;

CREATE TABLE `ad_orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla ad_units
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ad_units`;

CREATE TABLE `ad_units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tag_script` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla line_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `line_items`;

CREATE TABLE `line_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `ad_orders_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_id` (`ad_orders_id`),
  CONSTRAINT `line_items_ibfk_1` FOREIGN KEY (`ad_orders_id`) REFERENCES `ad_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla line_items_ad_units
# ------------------------------------------------------------

DROP TABLE IF EXISTS `line_items_ad_units`;

CREATE TABLE `line_items_ad_units` (
  `line_items_id` int(11) NOT NULL,
  `ad_units_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`line_items_id`,`ad_units_id`),
  KEY `line_items_id` (`line_items_id`),
  KEY `ad_units_id` (`ad_units_id`),
  CONSTRAINT `litems_adunits_ibfk_1` FOREIGN KEY (`line_items_id`) REFERENCES `line_items` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `litems_adunits_ibfk_2` FOREIGN KEY (`ad_units_id`) REFERENCES `ad_units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla sites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sites`;

CREATE TABLE `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `public_key` varchar(200) NOT NULL,
  `state` varchar(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `public_key_UNIQUE` (`public_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Volcado de tabla sites_ad_orders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sites_ad_orders`;

CREATE TABLE `sites_ad_orders` (
  `sites_id` int(11) NOT NULL,
  `ad_orders_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`sites_id`,`ad_orders_id`),
  KEY `fk_sites_id_idx` (`sites_id`),
  KEY `fk_orders_id_idx` (`ad_orders_id`),
  CONSTRAINT `fk_sites_id` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Volcado de tabla users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `first_login` tinyint(1) DEFAULT NULL,
  `can_be_deleted` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla users_sites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_sites`;

CREATE TABLE `users_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `sites_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sites_id` (`sites_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `users_sites_ibfk_2` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `users_sites_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla zonas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `zonas`;

CREATE TABLE `zonas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `id_tag_template` varchar(100) DEFAULT NULL,
  `sites_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sites_id` (`sites_id`),
  KEY `sites_id_2` (`sites_id`),
  CONSTRAINT `zonas_ibfk_1` FOREIGN KEY (`sites_id`) REFERENCES `sites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla zonas_ad_units
# ------------------------------------------------------------

DROP TABLE IF EXISTS `zonas_ad_units`;

CREATE TABLE `zonas_ad_units` (
  `zonas_id` int(11) NOT NULL,
  `ad_units_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`zonas_id`,`ad_units_id`),
  KEY `index2` (`zonas_id`),
  KEY `index3` (`ad_units_id`),
  CONSTRAINT `ad_units_id` FOREIGN KEY (`ad_units_id`) REFERENCES `ad_units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `zonas_id` FOREIGN KEY (`zonas_id`) REFERENCES `zonas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
