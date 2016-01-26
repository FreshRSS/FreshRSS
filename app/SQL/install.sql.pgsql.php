<?php
define('SQL_CREATE_TABLES', '
CREATE TABLE IF NOT EXISTS "%1$scategory" (
	"id" SERIAL PRIMARY KEY,
	"name" varchar(255) UNIQUE NOT NULL
)

CREATE TABLE IF NOT EXISTS "%1$sfeed" (
	"id" SERIAL PRIMARY KEY,
	"url" varchar(511) UNIQUE NOT NULL,
	"category" SMALLINT DEFAULT 0,
	"name" varchar(255) NOT NULL,
	"website" varchar(255),
	"description" text,
	"lastupdate" int DEFAULT 0,
	"priority" smallint NOT NULL DEFAULT 10,
	"pathEntries" varchar(511) DEFAULT NULL,
	"httpAuth" varchar(511) DEFAULT NULL,
	"error" boolean DEFAULT FALSE,
	"keep_history" INT NOT NULL DEFAULT -2,
	"ttl" INT NOT NULL DEFAULT -2,
	"cache_nbentries" int DEFAULT 0,
	"cache_nbunreads" int DEFAULT 0,
	FOREIGN KEY (category) REFERENCES "%1$scategory" (id) ON DELETE SET NULL ON UPDATE CASCADE
)
CREATE INDEX name_index ON "%1$sfeed" (name)
CREATE INDEX priority_index ON "%1$sfeed" (priority)
CREATE INDEX keep_history_index ON "%1$sfeed" (keep_history)

CREATE TABLE IF NOT EXISTS "%1$sentry" (
	"id" bigint NOT NULL PRIMARY KEY,
	"guid" varchar(760) UNIQUE NOT NULL,
	"title" varchar(255) NOT NULL,
	"author" varchar(255),
	"content_bin" text,
	"link" varchar(1023) NOT NULL,
	"date" INT,
	"lastseen" INT DEFAULT 0,
	"hash" BYTEA,
	"is_read" boolean NOT NULL DEFAULT false,
	"is_favorite" boolean NOT NULL DEFAULT false,
	"id_feed" SMALLINT,
	"tags" varchar(1023),
	FOREIGN KEY (id_feed) REFERENCES "%1$sfeed" (id) ON DELETE CASCADE ON UPDATE CASCADE
)
CREATE INDEX is_favorite_index ON "%1$sentry" (is_favorite)
CREATE INDEX is_read_index ON "%1$sentry" (is_read)
CREATE INDEX entry_lastSeen_index ON "%1$sentry" (lastSeen)

CREATE OR REPLACE FUNCTION update_unread_feed() RETURNS TRIGGER AS $$
	BEGIN
		UPDATE "%1$sfeed" 
			SET cache_nbunreads=(SELECT COUNT(*) FROM "%1$sentry" WHERE id_feed=OLD.id_feed AND NOT is_read)
			WHERE id=OLD.id_feed;
		return NULL;
	end;
	$$ LANGUAGE PLPGSQL;

CREATE TRIGGER update_unread_feed
	AFTER UPDATE OF is_read OR DELETE OR INSERT ON "%1$sentry"
	FOR EACH ROW
	EXECUTE PROCEDURE update_unread_feed();

CREATE OR REPLACE FUNCTION reset_feed_seq() RETURNS TRIGGER AS $$
	BEGIN
		PERFORM 1 FROM "%1$sfeed";
		IF NOT FOUND THEN
			ALTER SEQUENCE IF EXISTS "%1$sfeed_id_seq" RESTART;
		END IF;
		return NULL;
	end;
	$$ LANGUAGE PLPGSQL;

CREATE TRIGGER reset_feed_seq
	AFTER DELETE ON "%1$sfeed"
	FOR EACH STATEMENT
	EXECUTE PROCEDURE reset_feed_seq();



CREATE OR REPLACE RULE check_constraints_on_entry as on insert to "%1$sentry" where exists(select 1 FROM "%1$sentry" WHERE guid=NEW.guid) do instead nothing;
CREATE OR REPLACE RULE check_constraints_on_feed as on insert to "%1$sfeed" where exists(select 1 FROM "%1$sfeed" WHERE url=NEW.url) do instead nothing;
CREATE OR REPLACE RULE check_constraints_on_category as on insert to "%1$scategory" where exists(select 1 FROM "%1$scategory" WHERE name=NEW.name) do instead nothing;
CREATE OR REPLACE RULE check_constraints_on_category as on update to "%1$scategory" where exists(select 1 FROM "%1$scategory" WHERE name=NEW.name) do instead nothing;


INSERT IGNORE INTO "%1$scategory" (id, name) VALUES(1, "%2$s");
INSERT IGNORE INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES("http://freshrss.org/feeds/all.atom.xml", 1, "FreshRSS.org", "http://freshrss.org/", "FreshRSS, a free, self-hostable aggregator…", 86400);
INSERT IGNORE INTO "%1$sfeed" (url, category, name, website, description, ttl) VALUES("https://github.com/FreshRSS/FreshRSS/releases.atom", 1, "FreshRSS @ GitHub", "https://github.com/FreshRSS/FreshRSS/", "FreshRSS releases @ GitHub", 86400);
');

define('SQL_DROP_TABLES', 'DROP TABLES "%1$sentry", "%1$sfeed", "%1$scategory"');
