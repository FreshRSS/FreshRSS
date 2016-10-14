<?php
define('SQL_CREATE_DB', 'CREATE DATABASE %1$s ENCODING \'UTF8\';');

global $SQL_CREATE_TABLES;
$SQL_CREATE_TABLES = array(
'CREATE TABLE IF NOT EXISTS "%1$scategory" (
	"id" SERIAL PRIMARY KEY,
	"name" VARCHAR(255) UNIQUE NOT NULL
);',

'CREATE TABLE IF NOT EXISTS "%1$sfeed" (
	"id" SERIAL PRIMARY KEY,
	"url" varchar(511) UNIQUE NOT NULL,
	"category" SMALLINT DEFAULT 0,
	"name" VARCHAR(255) NOT NULL,
	"website" VARCHAR(255),
	"description" text,
	"lastUpdate" INT DEFAULT 0,
	"priority" SMALLINT NOT NULL DEFAULT 10,
	"pathEntries" VARCHAR(511) DEFAULT NULL,
	"httpAuth" VARCHAR(511) DEFAULT NULL,
	"error" smallint DEFAULT 0,
	"keep_history" INT NOT NULL DEFAULT -2,
	"ttl" INT NOT NULL DEFAULT -2,
	"cache_nbEntries" INT DEFAULT 0,
	"cache_nbUnreads" INT DEFAULT 0,
	FOREIGN KEY ("category") REFERENCES "%1$scategory" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);',
'CREATE INDEX %1$sname_index ON "%1$sfeed" ("name");',
'CREATE INDEX %1$spriority_index ON "%1$sfeed" ("priority");',
'CREATE INDEX %1$skeep_history_index ON "%1$sfeed" ("keep_history");',

'CREATE TABLE IF NOT EXISTS "%1$sentry" (
	"id" BIGINT NOT NULL PRIMARY KEY,
	"guid" VARCHAR(760) UNIQUE NOT NULL,
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
'CREATE INDEX %1$sis_favorite_index ON "%1$sentry" ("is_favorite");',
'CREATE INDEX %1$sis_read_index ON "%1$sentry" ("is_read");',
'CREATE INDEX %1$sentry_lastSeen_index ON "%1$sentry" ("lastSeen");',

'INSERT INTO "%1$scategory" (id, name) SELECT 1, \'%2$s\' WHERE NOT EXISTS (SELECT id FROM "%1$scategory" WHERE id = 1);',
'INSERT INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES(\'http://freshrss.org/feeds/all.atom.xml\', 1, \'FreshRSS.org\', \'http://freshrss.org/\', \'FreshRSS, a free, self-hostable aggregator…\', 86400);',
'INSERT INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES(\'https://github.com/FreshRSS/FreshRSS/releases.atom\', 1, \'FreshRSS @ GitHub\', \'https://github.com/FreshRSS/FreshRSS/\', \'FreshRSS releases @ GitHub\', 86400);',
);

define('SQL_DROP_TABLES', 'DROP TABLES "%1$sentry", "%1$sfeed", "%1$scategory"');
