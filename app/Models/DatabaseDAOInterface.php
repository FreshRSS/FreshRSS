<?php

interface DatabaseDAOInterface
{
	/**
	 * @return bool
	 */
	public function tablesAreCorrect(): bool;

	/**
	 * @param string $table
	 * @return array
	 */
	public function getSchema(string $table): array;

	/**
	 * @param array $dao
	 * @return array
	 */
	public function daoToSchema(array $dao): array;

	/**
	 * @param bool $all
	 * @return mixed
	 */
	public function size($all = false);

	/**
	 * @return bool
	 */
	public function optimize(): bool;
}
