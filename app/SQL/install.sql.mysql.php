<?php
define('SQL_CREATE_DB', 'CREATE DATABASE IF NOT EXISTS `%1$s` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

define('SQL_CREATE_TABLES', '
CREATE TABLE IF NOT EXISTS `%1$scategory` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`name` VARCHAR(' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') NOT NULL,	-- Max index length for Unicode is 191 characters (767 bytes)
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `%1$sfeed` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`url` VARCHAR(511) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`category` SMALLINT DEFAULT 0,	-- v0.7
	`name` VARCHAR(' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') NOT NULL,
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
	FOREIGN KEY (`category`) REFERENCES `%1$scategory`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE KEY (`url`),	-- v0.7
	INDEX (`name`),	-- v0.7
	INDEX (`priority`),	-- v0.7
	INDEX (`keep_history`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `%1$sentry` (
	`id` BIGINT NOT NULL,	-- v0.7
	`guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,	-- Maximum for UNIQUE is 767B
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content_bin` BLOB,	-- v0.7
	`link` VARCHAR(1023) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` INT(11),	-- Until year 2038
	`lastSeen` INT(11) DEFAULT 0,	-- v1.1.1, Until year 2038
	`hash` BINARY(16),	-- v1.1.1
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,	-- v0.7
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `%1$sfeed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),	-- v0.7
	INDEX (`is_favorite`),	-- v0.7
	INDEX (`is_read`),	-- v0.7
	INDEX `entry_lastSeen_index` (`lastSeen`)	-- v1.1.1
	-- INDEX `entry_feed_read_index` (`id_feed`,`is_read`)	-- v1.7 Located futher down
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

INSERT IGNORE INTO `%1$scategory` (id, name) VALUES(1, "%2$s");
');

define('SQL_CREATE_TABLE_ENTRYTMP', '
CREATE TABLE IF NOT EXISTS `%1$sentrytmp` (	-- v1.7
	`id` BIGINT NOT NULL,
	`guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content_bin` BLOB,
	`link` VARCHAR(1023) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` INT(11),
	`lastSeen` INT(11) DEFAULT 0,
	`hash` BINARY(16),
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `%1$sfeed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),
	INDEX (`date`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE INDEX `entry_feed_read_index` ON `%1$sentry`(`id_feed`,`is_read`);	-- v1.7 Located here to be auto-added
');

define('SQL_CREATE_TABLE_TAGS', '
CREATE TABLE IF NOT EXISTS `%1$stag` (	-- v1.12
	`id` SMALLINT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(63) NOT NULL,
	`attributes` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `%1$sentrytag` (	-- v1.12
	`id_tag` SMALLINT,
	`id_entry` BIGINT,
	PRIMARY KEY (`id_tag`,`id_entry`),
	FOREIGN KEY (`id_tag`) REFERENCES `%1$stag`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_entry`) REFERENCES `%1$sentry`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	INDEX (`id_entry`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;
');

global $SQL_INSERT_FEEDS;
$SQL_INSERT_FEEDS = array(
'INSERT IGNORE INTO `%1$sfeed` (url, category, name, website, description, ttl) VALUES("https://freshrss.org/feeds/all.atom.xml", 1, "FreshRSS.org", "https://freshrss.org/", "FreshRSS, a free, self-hostable aggregator…", 86400);',
'INSERT IGNORE INTO `%1$sfeed` (url, category, name, website, description, ttl) VALUES("https://github.com/FreshRSS/FreshRSS/releases.atom", 1, "FreshRSS @ GitHub", "https://github.com/FreshRSS/FreshRSS/", "FreshRSS releases @ GitHub", 86400);',
);

define('SQL_DROP_TABLES', 'DROP TABLE IF EXISTS `%1$sentrytag`, `%1$stag`, `%1$sentrytmp`, `%1$sentry`, `%1$sfeed`, `%1$scategory`');

define('SQL_UPDATE_UTF8MB4', '
ALTER DATABASE `%2$s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;	-- v1.5.0

ALTER TABLE `%1$scategory` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
UPDATE `%1$scategory` SET name=SUBSTRING(name,1,' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') WHERE LENGTH(name) > ' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ';
ALTER TABLE `%1$scategory` MODIFY `name` VARCHAR(' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
OPTIMIZE TABLE `%1$scategory`;

ALTER TABLE `%1$sfeed` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
UPDATE `%1$sfeed` SET name=SUBSTRING(name,1,' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') WHERE LENGTH(name) > ' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ';
ALTER TABLE `%1$sfeed` MODIFY `name` VARCHAR(' . FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE . ') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `%1$sfeed` MODIFY `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
OPTIMIZE TABLE `%1$sfeed`;

ALTER TABLE `%1$sentry` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `%1$sentry` MODIFY `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `%1$sentry` MODIFY `author` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `%1$sentry` MODIFY `tags` VARCHAR(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
OPTIMIZE TABLE `%1$sentry`;
');

define('SQL_UPDATE_GUID_LATIN1_BIN', '	-- v1.12
ALTER TABLE `%1$sentrytmp` MODIFY `guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;
ALTER TABLE `%1$sentry` MODIFY `guid` VARCHAR(760) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;
');
