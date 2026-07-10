<?php
declare(strict_types=1);

namespace FreshRss\Minz;

/**
 * MINZ - Copyright 2011 Marien Fressinaud
 * Licensed under AGPL3 <https://www.gnu.org/licenses/>
*/

/**
 * The ModelArray class is the model to interact with text files containing a PHP array
 */
class ModelArray {
	/**
	 * File name
	 */
	protected string $filename;

	/**
	 * Opens the specified file and loads the array into $array
	 * @param string $filename the name of the file containing the array
	 * Note: $array is always an array
	 */
	public function __construct(string $filename) {
		$this->filename = $filename;
	}

	/**
	 * @return array<string,mixed>
	 * @throws FileNotExistException
	 * @throws PermissionDeniedException
	 */
	protected function loadArray(): array {
		if (!file_exists($this->filename)) {
			throw new FileNotExistException($this->filename, Exception::WARNING);
		} elseif (($handle = $this->getLock()) === false) {
			throw new PermissionDeniedException($this->filename);
		} else {
			$data = include $this->filename;
			$this->releaseLock($handle);

			if ($data === false) {
				throw new PermissionDeniedException($this->filename);
			} elseif (!is_array($data) || !is_array_keys_string($data)) {
				$data = [];
			}
			return $data;
		}
	}

	/**
	 * Saves $array to $filename
	 * @param array<string,mixed> $array
	 * @throws PermissionDeniedException
	 */
	protected function writeArray(array $array): bool {
		if (file_put_contents($this->filename, "<?php\n return " . var_export($array, true) . ';', LOCK_EX) === false) {
			throw new PermissionDeniedException($this->filename);
		}
		if (function_exists('opcache_invalidate')) {
			opcache_invalidate($this->filename);	//Clear PHP cache for include
		}
		return true;
	}

	/** @return resource|false */
	private function getLock() {
		$handle = fopen($this->filename, 'r');
		if ($handle === false) {
			return false;
		}

		$count = 50;
		while (!flock($handle, LOCK_SH) && $count > 0) {
			$count--;
			usleep(1000);
		}

		if ($count > 0) {
			return $handle;
		} else {
			fclose($handle);
			return false;
		}
	}

	/** @param resource $handle */
	private function releaseLock($handle): void {
		flock($handle, LOCK_UN);
		fclose($handle);
	}
}
