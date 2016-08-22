<?php
define('SQL_CREATE_DB', 'CREATE DATABASE %1$s ENCODING \'UTF8\';');

global $SQL_CREATE_TABLES;
$SQL_CREATE_TABLES = array(
'CREATE TABLE IF NOT EXISTS "%1$scategory" (
	"id" SERIAL PRIMARY KEY,
	"name" varchar(255) UNIQUE NOT NULL
);',

'CREATE TABLE IF NOT EXISTS "%1$sfeed" (
	"id" SERIAL PRIMARY KEY,
	"url" varchar(511) UNIQUE NOT NULL,
	"category" SMALLINT DEFAULT 0,
	"name" varchar(255) NOT NULL,
	"website" varchar(255),
	"description" text,
	"lastUpdate" int DEFAULT 0,
	"priority" smallint NOT NULL DEFAULT 10,
	"pathEntries" varchar(511) DEFAULT NULL,
	"httpAuth" varchar(511) DEFAULT NULL,
	"error" smallint DEFAULT 0,
	"keep_history" INT NOT NULL DEFAULT -2,
	"ttl" INT NOT NULL DEFAULT -2,
	"cache_nbEntries" int DEFAULT 0,
	"cache_nbUnreads" int DEFAULT 0,
	FOREIGN KEY (category) REFERENCES "%1$scategory" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);',
'CREATE INDEX name_index ON "%1$sfeed" ("name");',
'CREATE INDEX priority_index ON "%1$sfeed" ("priority");',
'CREATE INDEX keep_history_index ON "%1$sfeed" ("keep_history");',

'CREATE TABLE IF NOT EXISTS "%1$sentry" (
	"id" bigint NOT NULL PRIMARY KEY,
	"guid" varchar(760) UNIQUE NOT NULL,
	"title" varchar(255) NOT NULL,
	"author" varchar(255),
	"content" text,
	"link" varchar(1023) NOT NULL,
	"date" INT,
	"lastSeen" INT DEFAULT 0,
	"hash" BYTEA,
	"is_read" smallint NOT NULL DEFAULT 0,
	"is_favorite" smallint NOT NULL DEFAULT 0,
	"id_feed" SMALLINT,
	"tags" varchar(1023),
	FOREIGN KEY (id_feed) REFERENCES "%1$sfeed" (id) ON DELETE CASCADE ON UPDATE CASCADE
);',
'CREATE INDEX is_favorite_index ON "%1$sentry" ("is_favorite");',
'CREATE INDEX is_read_index ON "%1$sentry" ("is_read");',
'CREATE INDEX entry_lastSeen_index ON "%1$sentry" ("lastSeen");',


'CREATE OR REPLACE RULE check_constraints_on_entry AS ON INSERT TO "%1$sentry" WHERE EXISTS(SELECT 1 FROM "%1$sentry" WHERE guid=NEW.guid) DO INSTEAD NOTHING;',
'CREATE OR REPLACE RULE check_constraints_on_feed AS ON INSERT TO "%1$sfeed" WHERE EXISTS(SELECT 1 FROM "%1$sfeed" WHERE url=NEW.url) DO INSTEAD NOTHING;',
'CREATE OR REPLACE RULE check_constraints_on_category AS ON INSERT TO "%1$scategory" WHERE EXISTS(SELECT 1 FROM "%1$scategory" WHERE name=NEW.name) DO INSTEAD NOTHING;',
'CREATE OR REPLACE RULE check_constraints_on_category as on update to "%1$scategory" WHERE EXISTS(SELECT 1 FROM "%1$scategory" WHERE name=NEW.name) DO INSTEAD NOTHING;',


'INSERT INTO "%1$scategory" (id, name) VALUES(1, \'%2$s\');',
'INSERT INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES(\'http://freshrss.org/feeds/all.atom.xml\', 1, \'FreshRSS.org\', \'http://freshrss.org/\', \'FreshRSS, a free, self-hostable aggregator…\', 86400);',
'INSERT INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES(\'https://github.com/FreshRSS/FreshRSS/releases.atom\', 1, \'FreshRSS @ GitHub\', \'https://github.com/FreshRSS/FreshRSS/\', \'FreshRSS releases @ GitHub\', 86400);',
);

define('SQL_DROP_TABLES', 'DROP TABLES "%1$sentry", "%1$sfeed", "%1$scategory"');
