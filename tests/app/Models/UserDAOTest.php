<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UserDAOTest extends TestCase {

	#[DataProvider('pathTraversalPayloadsProvider')]
	public function testExistsRejectsPathTraversal(string $payload): void {
		self::assertFalse(FreshRSS_UserDAO::exists($payload));
	}

	#[DataProvider('pathTraversalPayloadsProvider')]
	public function testMtimeRejectsPathTraversal(string $payload): void {
		self::assertSame(0, FreshRSS_UserDAO::mtime($payload));
	}

	#[DataProvider('pathTraversalPayloadsProvider')]
	public function testCtimeRejectsPathTraversal(string $payload): void {
		self::assertSame(0, FreshRSS_UserDAO::ctime($payload));
	}

	/**
	 * @return array<string,array<int,string>>
	 */
	public static function pathTraversalPayloadsProvider(): array {
		return [
			'parent directory' => ['../'],
			'double parent directory' => ['../../'],
			'traversal to app' => ['../../app'],
			'traversal to etc' => ['../../../etc'],
			'traversal with null byte' => ["../\0"],
			'absolute path' => ['/etc/passwd'],
			'dot only' => ['.'],
			'double dot' => ['..'],
			'slash in name' => ['user/config'],
			'backslash traversal' => ['..\\..\\app'],
			'encoded traversal' => ['%2e%2e%2f'],
			'mixed traversal' => ['valid/../invalid'],
			'empty string' => [''],
		];
	}

	#[DataProvider('validUsernamesProvider')]
	public function testExistsAcceptsValidUsernames(string $username): void {
		$result = FreshRSS_UserDAO::exists($username);
		self::assertIsBool($result);
	}

	#[DataProvider('validUsernamesProvider')]
	public function testMtimeAcceptsValidUsernames(string $username): void {
		$result = FreshRSS_UserDAO::mtime($username);
		self::assertIsInt($result);
	}

	#[DataProvider('validUsernamesProvider')]
	public function testCtimeAcceptsValidUsernames(string $username): void {
		$result = FreshRSS_UserDAO::ctime($username);
		self::assertIsInt($result);
	}

	/**
	 * @return array<string,array<int,string>>
	 */
	public static function validUsernamesProvider(): array {
		return [
			'simple' => ['alice'],
			'with numbers' => ['user123'],
			'with underscore' => ['test_user'],
			'with dot' => ['user.name'],
			'with hyphen' => ['user-name'],
			'with at' => ['user@domain'],
			'single char' => ['a'],
			'max length' => [str_repeat('a', 39)],
		];
	}
}
