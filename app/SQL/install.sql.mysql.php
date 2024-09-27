<?php
$GLOBALS['SQL_CREATE_DB'] = <<<'SQL'
CREATE DATABASE IF NOT EXISTS `%1$s` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SQL;

$GLOBALS['SQL_CREATE_TABLES'] = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_category` (
	`id` INT NOT NULL AUTO_INCREMENT,	-- v0.7
	`name` VARCHAR(191) NOT NULL,	-- Max index length for Unicode is 191 characters (767 bytes) FreshRSS_DatabaseDAO::LENGTH_INDEX_UNICODE
	`kind` SMALLINT DEFAULT 0,	-- 1.20.0
	`lastUpdate` BIGINT DEFAULT 0,	-- 1.20.0
	`error` SMALLINT DEFAULT 0,	-- 1.20.0
	`attributes` TEXT,	-- v1.15.0
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_feed` (
	`id` INT NOT NULL AUTO_INCREMENT,	-- v0.7
	`url` VARCHAR(32768) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`kind` SMALLINT DEFAULT 0,	-- 1.20.0
	`category` INT DEFAULT 0,	-- 1.20.0
	`name` VARCHAR(191) NOT NULL,
	`website` TEXT CHARACTER SET latin1 COLLATE latin1_bin,
	`description` TEXT,
	`lastUpdate` BIGINT DEFAULT 0,
	`priority` TINYINT(2) NOT NULL DEFAULT 10,
	`pathEntries` VARCHAR(4096) DEFAULT NULL,
	`httpAuth` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
	`error` BOOLEAN DEFAULT 0,
	`ttl` INT NOT NULL DEFAULT 0,	-- v0.7.3
	`attributes` TEXT,	-- v1.11.0
	`cache_nbEntries` INT DEFAULT 0,	-- v0.7
	`cache_nbUnreads` INT DEFAULT 0,	-- v0.7
	PRIMARY KEY (`id`),
	FOREIGN KEY (`category`) REFERENCES `_category`(`id`) ON DELETE SET NULL ON UPDATE CASCADE,
	INDEX (`name`),	-- v0.7
	INDEX (`priority`)	-- v0.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_entry` (
	`id` BIGINT NOT NULL,	-- v0.7
	`guid` VARCHAR(767) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,	-- Maximum for UNIQUE is 767B
	`title` VARCHAR(8192) NOT NULL,
	`author` VARCHAR(1024),
	`content_bin` MEDIUMBLOB,	-- v0.7
	`link` VARCHAR(16383) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` BIGINT,
	`lastSeen` BIGINT DEFAULT 0,
	`hash` BINARY(16),	-- v1.1.1
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` INT,	-- 1.20.0
	`tags` VARCHAR(2048),
	`attributes` TEXT,	-- v1.20.0
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `_feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),	-- v0.7
	INDEX (`is_favorite`),	-- v0.7
	INDEX (`is_read`),	-- v0.7
	INDEX `entry_lastSeen_index` (`lastSeen`),	-- v1.1.1
	INDEX `entry_feed_read_index` (`id_feed`,`is_read`)	-- v1.7
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

INSERT IGNORE INTO `_category` (id, name) VALUES(1, 'Uncategorized');

CREATE TABLE IF NOT EXISTS `_entrytmp` (	-- v1.7
	`id` BIGINT NOT NULL,
	`guid` VARCHAR(767) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`title` VARCHAR(8192) NOT NULL,
	`author` VARCHAR(1024),
	`content_bin` MEDIUMBLOB,
	`link` VARCHAR(16383) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
	`date` BIGINT,
	`lastSeen` BIGINT DEFAULT 0,
	`hash` BINARY(16),
	`is_read` BOOLEAN NOT NULL DEFAULT 0,
	`is_favorite` BOOLEAN NOT NULL DEFAULT 0,
	`id_feed` INT,	-- 1.20.0
	`tags` VARCHAR(2048),
	`attributes` TEXT,	-- v1.20.0
	PRIMARY KEY (`id`),
	FOREIGN KEY (`id_feed`) REFERENCES `_feed`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE KEY (`id_feed`,`guid`),
	INDEX (`date`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_tag` (	-- v1.12
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(191) NOT NULL,
	`attributes` TEXT,
	PRIMARY KEY (`id`),
	UNIQUE KEY (`name`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;

CREATE TABLE IF NOT EXISTS `_entrytag` (	-- v1.12
	`id_tag` INT,	-- 1.20.0
	`id_entry` BIGINT,
	PRIMARY KEY (`id_tag`,`id_entry`),
	FOREIGN KEY (`id_tag`) REFERENCES `_tag`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (`id_entry`) REFERENCES `_entry`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	INDEX (`id_entry`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
ENGINE = INNODB;
SQL;

$GLOBALS['SQL_DROP_TABLES'] = <<<'SQL'
DROP TABLE IF EXISTS `_entrytag`, `_tag`, `_entrytmp`, `_entry`, `_feed`, `_category`;
SQL;

$GLOBALS['SQL_UPDATE_MINOR'] = <<<'SQL'
DROP PROCEDURE IF EXISTS update_minor;
CREATE PROCEDURE update_minor()
BEGIN
	DECLARE up_to_date INT;

	SELECT COUNT(*) INTO up_to_date FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = DATABASE()
		AND TABLE_NAME = REPLACE('`_tag`', '`', '')
		AND COLUMN_NAME = 'name'
		AND COLUMN_TYPE = 'VARCHAR(191)';

	IF up_to_date = 0 THEN
		ALTER TABLE `_feed`
			MODIFY COLUMN `website` TEXT CHARACTER SET latin1 COLLATE latin1_bin,
			MODIFY COLUMN `lastUpdate` BIGINT DEFAULT 0,
			MODIFY COLUMN `pathEntries` VARCHAR(4096),
			MODIFY COLUMN `httpAuth` VARCHAR(1024) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL;
		ALTER TABLE `_entry`
			MODIFY COLUMN `date` BIGINT,
			MODIFY COLUMN `lastSeen` BIGINT DEFAULT 0,
			MODIFY COLUMN `guid` VARCHAR(767) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
			MODIFY COLUMN `title` VARCHAR(8192) NOT NULL,
			MODIFY COLUMN `author` VARCHAR(1024),
			MODIFY COLUMN `link` VARCHAR(16383) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
			MODIFY COLUMN `tags` VARCHAR(2048);
		ALTER TABLE `_entrytmp`
			MODIFY COLUMN `date` BIGINT,
			MODIFY COLUMN `lastSeen` BIGINT DEFAULT 0,
			MODIFY COLUMN `guid` VARCHAR(767) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
			MODIFY COLUMN `title` VARCHAR(8192) NOT NULL,
			MODIFY COLUMN `author` VARCHAR(1024),
			MODIFY COLUMN `link` VARCHAR(16383) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
			MODIFY COLUMN `tags` VARCHAR(2048);
		ALTER TABLE `_tag`
			MODIFY COLUMN `name` VARCHAR(191) NOT NULL;
		ALTER TABLE `_feed`
			DROP INDEX IF EXISTS `url`, -- IF EXISTS works with MariaDB but not with MySQL, so needs PHP workaround
			MODIFY COLUMN `url` VARCHAR(32768) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL;
	END IF;
END;
CALL update_minor();
DROP PROCEDURE update_minor;
SQL;
