<?php
define('SQL_CREATE_DB', 'CREATE DATABASE "%1$s" ENCODING \'UTF8\';');

const SQL_CREATE_TABLES = [
'CREATE TABLE IF NOT EXISTS `_category` (
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(255) UNIQUE NOT NULL
);',

'CREATE TABLE IF NOT EXISTS `_feed` (
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
	"keep_history" INT NOT NULL DEFAULT -2,
	"ttl" INT NOT NULL DEFAULT 0,
	"attributes" TEXT,	-- v1.11.0
	"cache_nbEntries" INT DEFAULT 0,
	"cache_nbUnreads" INT DEFAULT 0,
	FOREIGN KEY ("category") REFERENCES `_category` ("id") ON DELETE SET NULL ON UPDATE CASCADE
);',
'CREATE INDEX `_name_index` ON `_feed` ("name");',
'CREATE INDEX `_priority_index` ON `_feed` ("priority");',
'CREATE INDEX `_keep_history_index` ON `_feed` ("keep_history");',

'CREATE TABLE IF NOT EXISTS `_entry` (
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
);',
'CREATE INDEX `_is_favorite_index` ON `_entry` ("is_favorite");',
'CREATE INDEX `_is_read_index` ON `_entry` ("is_read");',
'CREATE INDEX `_entry_lastSeen_index` ON `_entry` ("lastSeen");',

"INSERT INTO `_category` (id, name)
	SELECT 1, 'Uncategorized'
	WHERE NOT EXISTS (SELECT id FROM `_category` WHERE id = 1)
	RETURNING nextval('`_category_id_seq`');",
];

const SQL_CREATE_TABLE_ENTRYTMP = [
'CREATE TABLE IF NOT EXISTS `_entrytmp` (	-- v1.7
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
);',
'CREATE INDEX `_entrytmp_date_index` ON `_entrytmp` ("date");',

'CREATE INDEX `_entry_feed_read_index` ON `_entry` ("id_feed","is_read");',	//v1.7
];

const SQL_CREATE_TABLE_TAGS = [
'CREATE TABLE IF NOT EXISTS `_tag` (	-- v1.12
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(63) UNIQUE NOT NULL,
	"attributes" TEXT
);',
'CREATE TABLE IF NOT EXISTS `_entrytag` (
	"id_tag" SMALLINT,
	"id_entry" BIGINT,
	PRIMARY KEY ("id_tag","id_entry"),
	FOREIGN KEY ("id_tag") REFERENCES `_tag` ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY ("id_entry") REFERENCES `_entry` ("id") ON DELETE CASCADE ON UPDATE CASCADE
);',
'CREATE INDEX `_entrytag_id_entry_index` ON `_entrytag` ("id_entry");',
];

define(
	'SQL_INSERT_FEED',
	'INSERT INTO `_feed` (url, category, name, website, description, ttl)
		SELECT :url::VARCHAR, 1, :name, :website, :description, 86400
		WHERE NOT EXISTS (SELECT id FROM `_feed` WHERE url = :url);'
);

const SQL_DROP_TABLES = [
	'DROP TABLE IF EXISTS `_entrytag`, `_tag`, `_entrytmp`, `_entry`, `_feed`, `_category`',
];
