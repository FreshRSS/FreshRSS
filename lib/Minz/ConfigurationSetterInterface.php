<?php
declare(strict_types=1);

interface Minz_ConfigurationSetterInterface {

	/**
	 * Return whether the given key is supported by this setter.
	 * @param string $key the key to test.
	 * @return bool true if the key is supported, false otherwise.
	 */
	public function support(string $key): bool;

	/**
	 * Set the given key in data with the current value.
	 * @param array<string,mixed> $data an array containing the list of all configuration data.
	 * @param string $key the key to update.
	 * @param mixed $value the value to set.
	 */
	public function handle(array &$data, string $key, mixed $value): void;
}
