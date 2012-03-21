ALTER TABLE `account` ADD `type` ENUM('customer','supplier','commons')  NOT NULL  DEFAULT 'commons'  AFTER `password`;

CREATE TABLE `delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipient` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `filename` varchar(128) NOT NULL DEFAULT '',
  `expire_date` datetime NOT NULL,
  `password` char(40) NOT NULL DEFAULT '',
  `comment` text,
  `account_id` smallint(5) unsigned NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `account` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;