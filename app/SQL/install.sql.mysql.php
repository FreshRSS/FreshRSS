<?php
const SQL_CREATE_DB = <<<'SQL'
CREATE DATABASE IF NOT EXISTS `%1$s` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SQL;

const SQL_CREATE_TABLES = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_category` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`name` VARCHAR(191) NOT NULL,	-- Max index length for Unicode is 191 characters (767 bytes) FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_feed` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`url` VARCHAR(511) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`category` SMALLINT DEFAULT 0,	-- v0.7
	`name` VARCHAR(191) NOT NULL,
	`website` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_bin,
	`description` TEXT,
	`lastUpdate` INT(11) DEFAULT 0,	-- Until year 2038
	`priority` TINYINT(2) NOT NULL DEFAULT 10,
	`pathEntries` VARCHAR(511) DEFAULT NULL,
	`httpAuth` VARCHAR(511) DEFAULT NULL,
	`error` BOOLEAN DEFAULT 0,
	`keep_history` MEDIUMINT NOT NULL DEFAULT -2,	-- v0.7
	`ttl` INT NOT NULL DEFAULT 0,	-- v0.7.3
	`attributes` TEXT,	-- v1.11.0
	`cache_nbEntries` INT DEFAULT 0,	-- v0.7
	`cache_nbUnreads` INT DEFAULT 0,	-- v0.7
	PRIMARY KEY (`id`),
	FOREIGN KEY (`category`) REFERENCES `_category`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE KEY (`url`),	-- v0.7
	INDEX (`name`),	-- v0.7
	INDEX (`priority`),	-- v0.7
	INDEX (`keep_history`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_entry` (
	`id` BIGINT NOT NULL,	-- v0.7
	`guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,	-- Maximum for UNIQUE is 767B
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content_bin` MEDIUMBLOB,	-- v0.7
	`link` VARCHAR(1023) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` INT(11),	-- Until year 2038
	`lastSeen` INT(11) DEFAULT 0,	-- v1.1.1, Until year 2038
	`hash` BINARY(16),	-- v1.1.1
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,	-- v0.7
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `_feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),	-- v0.7
	INDEX (`is_favorite`),	-- v0.7
	INDEX (`is_read`),	-- v0.7
	INDEX `entry_lastSeen_index` (`lastSeen`),	-- v1.1.1
	INDEX `entry_feed_read_index` (`id_feed`,`is_read`)	-- v1.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

INSERT IGNORE INTO `_category` (id, name) VALUES(1, "Uncategorized");
SQL;

const SQL_CREATE_INDEX_ENTRY_1 = <<<'SQL'
CREATE INDEX `entry_feed_read_index` ON `_entry` (`id_feed`,`is_read`);	-- v1.7
SQL;

const SQL_CREATE_TABLE_ENTRYTMP = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_entrytmp` (	-- v1.7
	`id` BIGINT NOT NULL,
	`guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content_bin` MEDIUMBLOB,
	`link` VARCHAR(1023) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` INT(11),
	`lastSeen` INT(11) DEFAULT 0,
	`hash` BINARY(16),
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `_feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),
	INDEX (`date`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;
SQL;

const SQL_CREATE_TABLE_TAGS = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_tag` (	-- v1.12
	`id` SMALLINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(63) NOT NULL,
	`attributes` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_entrytag` (	-- v1.12
	`id_tag` SMALLINT,
	`id_entry` BIGINT,
	PRIMARY KEY (`id_tag`,`id_entry`),
	FOREIGN KEY (`id_tag`) REFERENCES `_tag`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_entry`) REFERENCES `_entry`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	INDEX (`id_entry`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;
SQL;

const SQL_INSERT_FEED = <<<'SQL'
INSERT IGNORE INTO `_feed` (url, category, name, website, description, ttl)
	VALUES(:url, 1, :name, :website, :description, 86400);
SQL;

const SQL_DROP_TABLES = <<<'SQL'
DROP TABLE IF EXISTS `_entrytag`, `_tag`, `_entrytmp`, `_entry`, `_feed`, `_category`;
SQL;

const SQL_UPDATE_GUID_LATIN1_BIN = <<<'SQL'
ALTER TABLE `_entrytmp` MODIFY `guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;	-- v1.12
ALTER TABLE `_entry` MODIFY `guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;
SQL;
