ALTER TABLE `account` ADD `type` ENUM('customer','supplier','commons')  NOT NULL  DEFAULT 'commons'  AFTER `password`;
