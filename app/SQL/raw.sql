CREATE TABLE IF NOT EXISTS `YnoUser_category` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)	-- v0.7
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `YnoUser_feed` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`url` varchar(511) CHARACTER SET latin1 NOT NULL,
	`category` SMALLINT DEFAULT 0,	-- v0.7
	`name` varchar(255) NOT NULL,
	`website` varchar(255) CHARACTER SET latin1,
	`description` text,
	`lastUpdate` int(11) DEFAULT 0,
	`priority` tinyint(2) NOT NULL DEFAULT 10,
	`pathEntries` varchar(511) DEFAULT NULL,
	`httpAuth` varchar(511) DEFAULT NULL,
	`error` boolean DEFAULT 0,
	`keep_history` MEDIUMINT NOT NULL DEFAULT -2,	-- v0.7
	`ttl` INT NOT NULL DEFAULT -2,	-- v0.7.3
	`cache_nbEntries` int DEFAULT 0,	-- v0.7
	`cache_nbUnreads` int DEFAULT 0,	-- v0.7
	PRIMARY KEY (`id`),
	FOREIGN KEY (`category`) REFERENCES `YnoUser_category`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE KEY (`url`),	-- v0.7
	INDEX (`name`),	-- v0.7
	INDEX (`priority`),	-- v0.7
	INDEX (`keep_history`)	-- v0.7
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `YnoUser_entry` (
	`id` bigint NOT NULL,	-- v0.7
	`guid` varchar(760) CHARACTER SET latin1 NOT NULL,	-- Maximum for UNIQUE is 767B
	`title` varchar(255) NOT NULL,
	`author` varchar(255),
	`content_bin` blob,	-- v0.7
	`link` varchar(1023) CHARACTER SET latin1 NOT NULL,
	`date` int(11),
	`is_read` boolean NOT NULL DEFAULT 0,
	`is_favorite` boolean NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,	-- v0.7
	`tags` varchar(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `YnoUser_feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),	-- v0.7
	INDEX (`is_favorite`),	-- v0.7
	INDEX (`is_read`)	-- v0.7
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci
ENGINE = INNODB;

INSERT IGNORE INTO `YnoUser_category` (id, name) VALUES(1, "Uncategorized");
