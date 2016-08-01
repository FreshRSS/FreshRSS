<?php
define('SQL_CREATE_TABLES', '
CREATE TABLE IF NOT EXISTS `%1$scategory` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`name` varchar(191) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `%1$sfeed` (
	`id` SMALLINT NOT NULL AUTO_INCREMENT,	-- v0.7
	`url` varchar(511) CHARACTER SET latin1 NOT NULL,
	`category` SMALLINT DEFAULT 0,	-- v0.7
	`name` varchar(191) NOT NULL,
	`website` varchar(255) CHARACTER SET latin1,
	`description` text,
	`lastUpdate` int(11) DEFAULT 0,	-- Until year 2038
	`priority` tinyint(2) NOT NULL DEFAULT 10,
	`pathEntries` varchar(511) DEFAULT NULL,
	`httpAuth` varchar(511) DEFAULT NULL,
	`error` boolean DEFAULT 0,
	`keep_history` MEDIUMINT NOT NULL DEFAULT -2,	-- v0.7
	`ttl` INT NOT NULL DEFAULT -2,	-- v0.7.3
	`cache_nbEntries` int DEFAULT 0,	-- v0.7
	`cache_nbUnreads` int DEFAULT 0,	-- v0.7
	PRIMARY KEY (`id`),
	FOREIGN KEY (`category`) REFERENCES `%1$scategory`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	UNIQUE KEY (`url`),	-- v0.7
	INDEX (`name`),	-- v0.7
	INDEX (`priority`),	-- v0.7
	INDEX (`keep_history`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `%1$sentry` (
	`id` bigint NOT NULL,	-- v0.7
	`guid` varchar(760) CHARACTER SET latin1 NOT NULL,	-- Maximum for UNIQUE is 767B
	`title` varchar(255) NOT NULL,
	`author` varchar(255),
	`content_bin` blob,	-- v0.7
	`link` varchar(1023) CHARACTER SET latin1 NOT NULL,
	`date` int(11),	-- Until year 2038
	`lastSeen` INT(11) DEFAULT 0,	-- v1.1.1, Until year 2038
	`hash` BINARY(16),	-- v1.1.1
	`is_read` boolean NOT NULL DEFAULT 0,
	`is_favorite` boolean NOT NULL DEFAULT 0,
	`id_feed` SMALLINT,	-- v0.7
	`tags` varchar(1023),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `%1$sfeed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),	-- v0.7
	INDEX (`is_favorite`),	-- v0.7
	INDEX (`is_read`),	-- v0.7
	INDEX `entry_lastSeen_index` (`lastSeen`)	-- v1.1.1
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

INSERT IGNORE INTO `%1$scategory` (id, name) VALUES(1, "%2$s");
INSERT IGNORE INTO `%1$sfeed` (url, category, name, website, description, ttl) VALUES("http://freshrss.org/feeds/all.atom.xml", 1, "FreshRSS.org", "http://freshrss.org/", "FreshRSS, a free, self-hostable aggregator…", 86400);
INSERT IGNORE INTO `%1$sfeed` (url, category, name, website, description, ttl) VALUES("https://github.com/FreshRSS/FreshRSS/releases.atom", 1, "FreshRSS @ GitHub", "https://github.com/FreshRSS/FreshRSS/", "FreshRSS releases @ GitHub", 86400);
');

define('SQL_DROP_TABLES', 'DROP TABLES %1$sentry, %1$sfeed, %1$scategory');

define('SQL_UPDATE_UTF8MB4', '
ALTER DATABASE `%2$s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `%1$scategory` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
UPDATE `%1$scategory` SET name=SUBSTRING(name,1,190) WHERE LENGTH(name) > 191;
ALTER TABLE `%1$scategory` MODIFY `name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
OPTIMIZE TABLE `%1$scategory`;

ALTER TABLE `%1$sfeed` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
UPDATE `%1$sfeed` SET name=SUBSTRING(name,1,190) WHERE LENGTH(name) > 191;
ALTER TABLE `%1$sfeed` MODIFY `name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `%1$sfeed` MODIFY `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
OPTIMIZE TABLE `%1$sfeed`;

ALTER TABLE `%1$sentry` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `%1$sentry` MODIFY `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `%1$sentry` MODIFY `author` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `%1$sentry` MODIFY `tags` VARCHAR(1023) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
OPTIMIZE TABLE `%1$sentry`;
');
