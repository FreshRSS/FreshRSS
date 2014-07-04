<?php
$SQL_CREATE_TABLES = array(
'CREATE TABLE IF NOT EXISTS `%1$scategory` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`name` varchar(255) NOT NULL,
	UNIQUE (`name`)
);',

'CREATE TABLE IF NOT EXISTS `%1$sfeed` (
	`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	`url` varchar(511) NOT NULL,
	`%1$scategory` SMALLINT DEFAULT 0,
	`name` varchar(255) NOT NULL,
	`website` varchar(255),
	`description` text,
	`lastUpdate` int(11) DEFAULT 0,
	`priority` tinyint(2) NOT NULL DEFAULT 10,
	`pathEntries` varchar(511) DEFAULT NULL,
	`httpAuth` varchar(511) DEFAULT NULL,
	`error` boolean DEFAULT 0,
	`keep_history` MEDIUMINT NOT NULL DEFAULT -2,
	`ttl` INT NOT NULL DEFAULT -2,
	`cache_nbEntries` int DEFAULT 0,
	`cache_nbUnreads` int DEFAULT 0,
	FOREIGN KEY (`%1$scategory`) REFERENCES `%1$scategory`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE (`url`)
);',

'CREATE INDEX IF NOT EXISTS feed_name_index ON `%1$sfeed`(`name`);',
'CREATE INDEX IF NOT EXISTS feed_priority_index ON `%1$sfeed`(`priority`);',
'CREATE INDEX IF NOT EXISTS feed_keep_history_index ON `%1$sfeed`(`keep_history`);',

'CREATE TABLE IF NOT EXISTS `%1$sentry` (
	`id` bigint NOT NULL,
	`guid` varchar(760) NOT NULL,
	`title` varchar(255) NOT NULL,
	`author` varchar(255),
	`content` text,
	`link` varchar(1023) NOT NULL,
	`date` int(11),
	`is_read` boolean NOT NULL DEFAULT 0,
	`is_favorite` boolean NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,
	`tags` varchar(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `%1$sfeed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE (`id_feed`,`guid`)
);',

'CREATE INDEX IF NOT EXISTS entry_is_favorite_index ON `%1$sentry`(`is_favorite`);',
'CREATE INDEX IF NOT EXISTS entry_is_read_index ON `%1$sentry`(`is_read`);',

'INSERT OR IGNORE INTO `%1$scategory` (id, name) VALUES(1, "%2$s");',
);

define('SQL_DROP_TABLES', 'DROP TABLES %1$sentry, %1$sfeed, %1$scategory');

define('SQL_SHOW_TABLES', 'SELECT name FROM sqlite_master WHERE type="table"');
