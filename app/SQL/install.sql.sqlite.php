<?php
$GLOBALS['SQL_CREATE_DB'] = <<<'SQL'
SELECT 1;	-- Do nothing for SQLite
SQL;

$GLOBALS['SQL_CREATE_TABLES'] = <<<'SQL'
CREATE TABLE IF NOT EXISTS `category` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`attributes` TEXT,	-- v1.15.0
	UNIQUE (`name`)
);

CREATE TABLE IF NOT EXISTS `feed` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`url` VARCHAR(511) NOT NULL,
	`kind` SMALLINT DEFAULT 0, -- 0.20.0
	`category` SMALLINT DEFAULT 0,
	`name` VARCHAR(255) NOT NULL,
	`website` VARCHAR(255),
	`description` TEXT,
	`lastUpdate` INT(11) DEFAULT 0,	-- Until year 2038
	`priority` TINYINT(2) NOT NULL DEFAULT 10,
	`pathEntries` VARCHAR(511) DEFAULT NULL,
	`httpAuth` VARCHAR(511) DEFAULT NULL,
	`error` BOOLEAN DEFAULT 0,
	`ttl` INT NOT NULL DEFAULT 0,
	`attributes` TEXT,	-- v1.11.0
	`cache_nbEntries` INT DEFAULT 0,
	`cache_nbUnreads` INT DEFAULT 0,
	FOREIGN KEY (`category`) REFERENCES `category`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE (`url`)
);
CREATE INDEX IF NOT EXISTS feed_name_index ON `feed`(`name`);
CREATE INDEX IF NOT EXISTS feed_priority_index ON `feed`(`priority`);

CREATE TABLE IF NOT EXISTS `entry` (
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
);
CREATE INDEX IF NOT EXISTS entry_is_favorite_index ON `entry`(`is_favorite`);
CREATE INDEX IF NOT EXISTS entry_is_read_index ON `entry`(`is_read`);
CREATE INDEX IF NOT EXISTS entry_lastSeen_index ON `entry`(`lastSeen`);	-- //v1.1.1
CREATE INDEX IF NOT EXISTS entry_feed_read_index ON `entry`(`id_feed`,`is_read`);	-- v1.7

INSERT OR IGNORE INTO `category` (id, name) VALUES(1, "Uncategorized");
SQL;

$GLOBALS['SQL_CREATE_INDEX_ENTRY_1'] = <<<'SQL'
CREATE INDEX IF NOT EXISTS entry_feed_read_index ON `entry`(`id_feed`,`is_read`);	-- v1.7
SQL;

$GLOBALS['SQL_CREATE_TABLE_ENTRYTMP'] = <<<'SQL'
CREATE TABLE IF NOT EXISTS `entrytmp` (	-- v1.7
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
);
CREATE INDEX IF NOT EXISTS entrytmp_date_index ON `entrytmp`(`date`);
SQL;

$GLOBALS['SQL_CREATE_TABLE_TAGS'] = <<<'SQL'
CREATE TABLE IF NOT EXISTS `tag` (	-- v1.12
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` VARCHAR(63) NOT NULL,
	`attributes` TEXT,
	UNIQUE (`name`)
);
CREATE TABLE IF NOT EXISTS `entrytag` (
	`id_tag` SMALLINT,
	`id_entry` BIGINT,
	PRIMARY KEY (`id_tag`,`id_entry`),
	FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_entry`) REFERENCES `entry` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX IF NOT EXISTS entrytag_id_entry_index ON `entrytag` (`id_entry`);
SQL;

$GLOBALS['SQL_DROP_TABLES'] = <<<'SQL'
DROP TABLE IF EXISTS `entrytag`;
DROP TABLE IF EXISTS `tag`;
DROP TABLE IF EXISTS `entrytmp`;
DROP TABLE IF EXISTS `entry`;
DROP TABLE IF EXISTS `feed`;
DROP TABLE IF EXISTS `category`;
SQL;
