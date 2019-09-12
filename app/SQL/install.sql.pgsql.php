<?php
define('SQL_CREATE_DB', 'CREATE DATABASE "%1$s" ENCODING \'UTF8\';');

global $SQL_CREATE_TABLES;
$SQL_CREATE_TABLES = array(
'CREATE TABLE IF NOT EXISTS "%1$scategory" (
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(255) UNIQUE NOT NULL
);',

'CREATE TABLE IF NOT EXISTS "%1$sfeed" (
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
	FOREIGN KEY ("category") REFERENCES "%1$scategory" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);',
'CREATE INDEX "%1$sname_index" ON "%1$sfeed" ("name");',
'CREATE INDEX "%1$spriority_index" ON "%1$sfeed" ("priority");',
'CREATE INDEX "%1$skeep_history_index" ON "%1$sfeed" ("keep_history");',

'CREATE TABLE IF NOT EXISTS "%1$sentry" (
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
	FOREIGN KEY ("id_feed") REFERENCES "%1$sfeed" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE ("id_feed","guid")
);',
'CREATE INDEX "%1$sis_favorite_index" ON "%1$sentry" ("is_favorite");',
'CREATE INDEX "%1$sis_read_index" ON "%1$sentry" ("is_read");',
'CREATE INDEX "%1$sentry_lastSeen_index" ON "%1$sentry" ("lastSeen");',

'INSERT INTO "%1$scategory" (id, name)
	SELECT 1, \'%2$s\'
	WHERE NOT EXISTS (SELECT id FROM "%1$scategory" WHERE id = 1)
	RETURNING nextval(\'"%1$scategory_id_seq"\');',
);

global $SQL_CREATE_TABLE_ENTRYTMP;
$SQL_CREATE_TABLE_ENTRYTMP = array(
'CREATE TABLE IF NOT EXISTS "%1$sentrytmp" (	-- v1.7
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
	FOREIGN KEY ("id_feed") REFERENCES "%1$sfeed" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	UNIQUE ("id_feed","guid")
);',
'CREATE INDEX "%1$sentrytmp_date_index" ON "%1$sentrytmp" ("date");',

'CREATE INDEX "%1$sentry_feed_read_index" ON "%1$sentry" ("id_feed","is_read");',	//v1.7
);

global $SQL_CREATE_TABLE_TAGS;
$SQL_CREATE_TABLE_TAGS = array(
'CREATE TABLE IF NOT EXISTS "%1$stag" (	-- v1.12
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(63) UNIQUE NOT NULL,
	"attributes" TEXT
);',
'CREATE TABLE IF NOT EXISTS "%1$sentrytag" (
	"id_tag" SMALLINT,
	"id_entry" BIGINT,
	PRIMARY KEY ("id_tag","id_entry"),
	FOREIGN KEY ("id_tag") REFERENCES "%1$stag" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY ("id_entry") REFERENCES "%1$sentry" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);',
'CREATE INDEX "%1$sentrytag_id_entry_index" ON "%1$sentrytag" ("id_entry");',
);

define(
	'SQL_INSERT_FEED',
	'INSERT INTO "%1$sfeed" (url, category, name, website, description, ttl)
		SELECT :url::VARCHAR, 1, :name, :website, :description, 86400
		WHERE NOT EXISTS (SELECT id FROM "%1$sfeed" WHERE url = :url);'
);

global $SQL_DROP_TABLES;
$SQL_DROP_TABLES = [
	'DROP TABLE IF EXISTS "%1$sentrytag", "%1$stag", "%1$sentrytmp", "%1$sentry", "%1$sfeed", "%1$scategory"',
	'DROP INDEX IF EXISTS "%1$sentrytag_id_entry_index", "%1$sentry_feed_read_index", "%1$sentrytmp_date_index", "%1$sentry_lastSeen_index", "%1$sis_read_index", "%1$sis_favorite_index", "%1$skeep_history_index", "%1$spriority_index", "%1$sname_index"',
];
