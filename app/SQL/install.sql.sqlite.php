<?php
global $SQL_CREATE_TABLES;
$SQL_CREATE_TABLES = array(
'CREATE TABLE IF NOT EXISTS `category` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	UNIQUE (`name`)
);',

'CREATE TABLE IF NOT EXISTS `feed` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`url` VARCHAR(511) NOT NULL,
	`category` SMALLINT DEFAULT 0,
	`name` VARCHAR(255) NOT NULL,
	`website` VARCHAR(255),
	`description` TEXT,
	`lastUpdate` INT(11) DEFAULT 0,	-- Until year 2038
	`priority` TINYINT(2) NOT NULL DEFAULT 10,
	`pathEntries` VARCHAR(511) DEFAULT NULL,
	`httpAuth` VARCHAR(511) DEFAULT NULL,
	`error` BOOLEAN DEFAULT 0,
	`keep_history` MEDIUMINT NOT NULL DEFAULT -2,
	`ttl` INT NOT NULL DEFAULT 0,
	`attributes` TEXT,	-- v1.11.0
	`cache_nbEntries` INT DEFAULT 0,
	`cache_nbUnreads` INT DEFAULT 0,
	FOREIGN KEY (`category`) REFERENCES `category`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE (`url`)
);',
'CREATE INDEX IF NOT EXISTS feed_name_index ON `feed`(`name`);',
'CREATE INDEX IF NOT EXISTS feed_priority_index ON `feed`(`priority`);',
'CREATE INDEX IF NOT EXISTS feed_keep_history_index ON `feed`(`keep_history`);',

'CREATE TABLE IF NOT EXISTS `entry` (
	`id` BIGINT NOT NULL,
	`guid` VARCHAR(760) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content` TEXT,
	`link` VARCHAR(1023) NOT NULL,
	`date` INT(11),	-- Until year 2038
	`lastSeen` INT(11) DEFAULT 0,	-- v1.1.1, Until year 2038
	`hash` BINARY(16),	-- v1.1.1
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE (`id_feed`,`guid`)
);',
'CREATE INDEX IF NOT EXISTS entry_is_favorite_index ON `entry`(`is_favorite`);',
'CREATE INDEX IF NOT EXISTS entry_is_read_index ON `entry`(`is_read`);',
'CREATE INDEX IF NOT EXISTS entry_lastSeen_index ON `entry`(`lastSeen`);',	//v1.1.1

'INSERT OR IGNORE INTO `category` (id, name) VALUES(1, "%2$s");',
);

global $SQL_CREATE_TABLE_ENTRYTMP;
$SQL_CREATE_TABLE_ENTRYTMP = array(
'CREATE TABLE IF NOT EXISTS `entrytmp` (	-- v1.7
	`id` BIGINT NOT NULL,
	`guid` VARCHAR(760) NOT NULL,
	`title` VARCHAR(255) NOT NULL,
	`author` VARCHAR(255),
	`content` TEXT,
	`link` VARCHAR(1023) NOT NULL,
	`date` INT(11),
	`lastSeen` INT(11) DEFAULT 0,
	`hash` BINARY(16),
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,
	`tags` VARCHAR(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE (`id_feed`,`guid`)
);',
'CREATE INDEX IF NOT EXISTS entrytmp_date_index ON `entrytmp`(`date`);',

'CREATE INDEX IF NOT EXISTS `entry_feed_read_index` ON `entry`(`id_feed`,`is_read`);',	//v1.7
);

global $SQL_CREATE_TABLE_TAGS;
$SQL_CREATE_TABLE_TAGS = array(
'CREATE TABLE IF NOT EXISTS `tag` (	-- v1.12
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` VARCHAR(63) NOT NULL,
	`attributes` TEXT,
	UNIQUE (`name`)
);',
'CREATE TABLE IF NOT EXISTS `entrytag` (
	`id_tag` SMALLINT,
	`id_entry` SMALLINT,
	PRIMARY KEY (`id_tag`,`id_entry`),
	FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_entry`) REFERENCES `entry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);',
'CREATE INDEX entrytag_id_entry_index ON `entrytag` (`id_entry`);',
);

global $SQL_INSERT_FEEDS;
$SQL_INSERT_FEEDS = array(
'INSERT OR IGNORE INTO `feed` (url, category, name, website, description, ttl)
	VALUES ("https://freshrss.org/feeds/all.atom.xml", 1, "FreshRSS.org", "https://freshrss.org/", "FreshRSS, a free, self-hostable aggregator…", 86400);',
'INSERT OR IGNORE INTO `feed` (url, category, name, website, description, ttl)
	VALUES ("https://github.com/FreshRSS/FreshRSS/releases.atom", 1, "FreshRSS releases", "https://github.com/FreshRSS/FreshRSS/", "FreshRSS releases @ GitHub", 86400);',
);

define('SQL_DROP_TABLES', 'DROP TABLE IF EXISTS `entrytag`, `tag`, `entrytmp`, `entry`, `feed`, `category`');
