<?php
$GLOBALS['SQL_CREATE_DB'] = <<<'SQL'
CREATE DATABASE "%1$s" ENCODING 'UTF8';
SQL;

$GLOBALS['SQL_CREATE_TABLES'] = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_category` (
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(191) UNIQUE NOT NULL,
	"kind" SMALLINT DEFAULT 0,	-- 1.20.0
	"lastUpdate" BIGINT DEFAULT 0,	-- 1.20.0
	"error" SMALLINT DEFAULT 0,	-- 1.20.0
	"attributes" TEXT	-- v1.15.0
);

CREATE TABLE IF NOT EXISTS `_feed` (
	"id" SERIAL PRIMARY KEY,
	"url" VARCHAR(32768) NOT NULL,
	"kind" SMALLINT DEFAULT 0, -- 1.20.0
	"category" INT DEFAULT 0,	-- 1.20.0
	"name" VARCHAR(191) NOT NULL,
	"website" VARCHAR(32768),
	"description" TEXT,
	"lastUpdate" BIGINT DEFAULT 0,
	"priority" SMALLINT NOT NULL DEFAULT 10,
	"pathEntries" VARCHAR(4096) DEFAULT NULL,
	"httpAuth" VARCHAR(1024) DEFAULT NULL,
	"error" SMALLINT DEFAULT 0,
	"ttl" INT NOT NULL DEFAULT 0,
	"attributes" TEXT,	-- v1.11.0
	"cache_nbEntries" INT DEFAULT 0,
	"cache_nbUnreads" INT DEFAULT 0,
	FOREIGN KEY ("category") REFERENCES `_category` ("id") ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE INDEX IF NOT EXISTS `_name_index` ON `_feed` ("name");
CREATE INDEX IF NOT EXISTS `_priority_index` ON `_feed` ("priority");

CREATE TABLE IF NOT EXISTS `_entry` (
	"id" BIGINT NOT NULL PRIMARY KEY,
	"guid" VARCHAR(767) NOT NULL,
	"title" VARCHAR(8192) NOT NULL,
	"author" VARCHAR(1024),
	"content" TEXT,
	"link" VARCHAR(16383) NOT NULL,
	"date" BIGINT,
	"lastSeen" BIGINT DEFAULT 0,
	"hash" BYTEA,
	"is_read" SMALLINT NOT NULL DEFAULT 0,
	"is_favorite" SMALLINT NOT NULL DEFAULT 0,
	"id_feed" INT,	-- 1.20.0
	"tags" VARCHAR(2048),
	"attributes" TEXT,	-- v1.20.0
	FOREIGN KEY ("id_feed") REFERENCES `_feed` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE ("id_feed","guid")
);
CREATE INDEX IF NOT EXISTS `_is_favorite_index` ON `_entry` ("is_favorite");
CREATE INDEX IF NOT EXISTS `_is_read_index` ON `_entry` ("is_read");
CREATE INDEX IF NOT EXISTS `_entry_lastSeen_index` ON `_entry` ("lastSeen");
CREATE INDEX IF NOT EXISTS `_entry_feed_read_index` ON `_entry` ("id_feed","is_read");	-- v1.7

INSERT INTO `_category` (id, name)
	SELECT 1, 'Uncategorized'
	WHERE NOT EXISTS (SELECT id FROM `_category` WHERE id = 1)
	RETURNING nextval('`_category_id_seq`');

CREATE TABLE IF NOT EXISTS `_entrytmp` (	-- v1.7
	"id" BIGINT NOT NULL PRIMARY KEY,
	"guid" VARCHAR(767) NOT NULL,
	"title" VARCHAR(8192) NOT NULL,
	"author" VARCHAR(1024),
	"content" TEXT,
	"link" VARCHAR(16383) NOT NULL,
	"date" BIGINT,
	"lastSeen" BIGINT DEFAULT 0,
	"hash" BYTEA,
	"is_read" SMALLINT NOT NULL DEFAULT 0,
	"is_favorite" SMALLINT NOT NULL DEFAULT 0,
	"id_feed" INT,	-- 1.20.0
	"tags" VARCHAR(2048),
	"attributes" TEXT,	-- v1.20.0
	FOREIGN KEY ("id_feed") REFERENCES `_feed` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE ("id_feed","guid")
);
CREATE INDEX IF NOT EXISTS `_entrytmp_date_index` ON `_entrytmp` ("date");

CREATE TABLE IF NOT EXISTS `_tag` (	-- v1.12
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(191) UNIQUE NOT NULL,
	"attributes" TEXT
);
CREATE TABLE IF NOT EXISTS `_entrytag` (
	"id_tag" INT,	-- 1.20.0
	"id_entry" BIGINT,
	PRIMARY KEY ("id_tag","id_entry"),
	FOREIGN KEY ("id_tag") REFERENCES `_tag` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY ("id_entry") REFERENCES `_entry` ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX IF NOT EXISTS `_entrytag_id_entry_index` ON `_entrytag` ("id_entry");
SQL;

$GLOBALS['SQL_DROP_TABLES'] = <<<'SQL'
DROP TABLE IF EXISTS `_entrytag`, `_tag`, `_entrytmp`, `_entry`, `_feed`, `_category`;
SQL;

$GLOBALS['SQL_UPDATE_MINOR'] = <<<'SQL'
DO $$
BEGIN
	IF NOT EXISTS (
		SELECT 1 FROM information_schema.columns
		WHERE table_schema = 'public'
			AND table_name = REPLACE('`_tag`', '"', '')
			AND column_name = 'name'
			AND character_maximum_length = 191
	) THEN
		ALTER TABLE `_category`
			ALTER COLUMN "name" SET DATA TYPE VARCHAR(191);
		ALTER TABLE `_feed`
			DROP CONSTRAINT IF EXISTS `_feed_url_key`,
			ALTER COLUMN "url" SET DATA TYPE VARCHAR(32768),
			ALTER COLUMN "name" SET DATA TYPE VARCHAR(191),
			ALTER COLUMN "website" SET DATA TYPE VARCHAR(32768),
			ALTER COLUMN "lastUpdate" SET DATA TYPE BIGINT,
			ALTER COLUMN "pathEntries" SET DATA TYPE VARCHAR(4096),
			ALTER COLUMN "httpAuth" SET DATA TYPE VARCHAR(1024);
		ALTER TABLE `_entry`
			ALTER COLUMN "date" SET DATA TYPE BIGINT,
			ALTER COLUMN "lastSeen" SET DATA TYPE BIGINT,
			ALTER COLUMN "guid" SET DATA TYPE VARCHAR(767),
			ALTER COLUMN "title" SET DATA TYPE VARCHAR(8192),
			ALTER COLUMN "author" SET DATA TYPE VARCHAR(1024),
			ALTER COLUMN "link" SET DATA TYPE VARCHAR(16383),
			ALTER COLUMN "tags" SET DATA TYPE VARCHAR(2048);
		ALTER TABLE `_entrytmp`
			ALTER COLUMN "date" SET DATA TYPE BIGINT,
			ALTER COLUMN "lastSeen" SET DATA TYPE BIGINT,
			ALTER COLUMN "guid" SET DATA TYPE VARCHAR(767),
			ALTER COLUMN "title" SET DATA TYPE VARCHAR(8192),
			ALTER COLUMN "author" SET DATA TYPE VARCHAR(1024),
			ALTER COLUMN "link" SET DATA TYPE VARCHAR(16383),
			ALTER COLUMN "tags" SET DATA TYPE VARCHAR(2048);
		ALTER TABLE `_tag`
			ALTER COLUMN "name" SET DATA TYPE VARCHAR(191);
	END IF;
END $$;
SQL;
