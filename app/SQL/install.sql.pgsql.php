<?php
$SQL_CREATE_DB = <<<'SQL'
CREATE DATABASE "%1$s" ENCODING 'UTF8';
SQL;

$SQL_CREATE_TABLES = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_category` (
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(255) UNIQUE NOT NULL,
	"attributes" TEXT	-- v1.15.0
);

CREATE TABLE IF NOT EXISTS `_feed` (
	"id" SERIAL PRIMARY KEY,
	"url" VARCHAR(511) UNIQUE NOT NULL,
	"category" SMALLINT DEFAULT 0,
	"name" VARCHAR(255) NOT NULL,
	"website" VARCHAR(255),
	"description" TEXT,
	"lastUpdate" INT DEFAULT 0,
	"priority" SMALLINT NOT NULL DEFAULT 10,
	"pathEntries" VARCHAR(511) DEFAULT NULL,
	"httpAuth" VARCHAR(511) DEFAULT NULL,
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
	"guid" VARCHAR(760) NOT NULL,
	"title" VARCHAR(255) NOT NULL,
	"author" VARCHAR(255),
	"content" TEXT,
	"link" VARCHAR(1023) NOT NULL,
	"date" INT,
	"lastSeen" INT DEFAULT 0,
	"hash" BYTEA,
	"is_read" SMALLINT NOT NULL DEFAULT 0,
	"is_favorite" SMALLINT NOT NULL DEFAULT 0,
	"id_feed" SMALLINT,
	"tags" VARCHAR(1023),
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
	"guid" VARCHAR(760) NOT NULL,
	"title" VARCHAR(255) NOT NULL,
	"author" VARCHAR(255),
	"content" TEXT,
	"link" VARCHAR(1023) NOT NULL,
	"date" INT,
	"lastSeen" INT DEFAULT 0,
	"hash" BYTEA,
	"is_read" SMALLINT NOT NULL DEFAULT 0,
	"is_favorite" SMALLINT NOT NULL DEFAULT 0,
	"id_feed" SMALLINT,
	"tags" VARCHAR(1023),
	FOREIGN KEY ("id_feed") REFERENCES `_feed` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE ("id_feed","guid")
);
CREATE INDEX IF NOT EXISTS `_entrytmp_date_index` ON `_entrytmp` ("date");
SQL;

$SQL_CREATE_TABLE_TAGS = <<<'SQL'
CREATE TABLE IF NOT EXISTS `_tag` (	-- v1.12
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(63) UNIQUE NOT NULL,
	"attributes" TEXT
);
CREATE TABLE IF NOT EXISTS `_entrytag` (
	"id_tag" SMALLINT,
	"id_entry" BIGINT,
	PRIMARY KEY ("id_tag","id_entry"),
	FOREIGN KEY ("id_tag") REFERENCES `_tag` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY ("id_entry") REFERENCES `_entry` ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX IF NOT EXISTS `_entrytag_id_entry_index` ON `_entrytag` ("id_entry");
SQL;

$SQL_DROP_TABLES = <<<'SQL'
DROP TABLE IF EXISTS `_entrytag`, `_tag`, `_entrytmp`, `_entry`, `_feed`, `_category`;
SQL;
