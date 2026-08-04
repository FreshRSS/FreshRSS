<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Minz\ConfigurationNamespaceException;
use FreshRss\Minz\PDOConnectionException;

class Factory {

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createUserDao(?string $username = null): UserDAO {
		return new UserDAO($username);
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createCategoryDao(?string $username = null): CategoryDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new CategoryDAOSQLite($username),
			'pgsql' => new CategoryDAOPGSQL($username),
			default => new CategoryDAO($username),
		};
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createFeedDao(?string $username = null): FeedDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new FeedDAOSQLite($username),
			'pgsql' => new FeedDAOPGSQL($username),
			default => new FeedDAO($username),
		};
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createEntryDao(?string $username = null): EntryDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new EntryDAOSQLite($username),
			'pgsql' => new EntryDAOPGSQL($username),
			default => new EntryDAO($username),
		};
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createTagDao(?string $username = null): TagDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new TagDAOSQLite($username),
			'pgsql' => new TagDAOPGSQL($username),
			default => new TagDAO($username),
		};
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createStatsDAO(?string $username = null): StatsDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new StatsDAOSQLite($username),
			'pgsql' => new StatsDAOPGSQL($username),
			default => new StatsDAO($username),
		};
	}

	/**
	 * @throws ConfigurationNamespaceException|PDOConnectionException
	 */
	public static function createDatabaseDAO(?string $username = null): DatabaseDAO {
		return match (Context::systemConf()->db['type'] ?? '') {
			'sqlite' => new DatabaseDAOSQLite($username),
			'pgsql' => new DatabaseDAOPGSQL($username),
			default => new DatabaseDAO($username),
		};
	}
}
