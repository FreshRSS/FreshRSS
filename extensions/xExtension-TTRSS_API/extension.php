<?php
declare(strict_types=1);

final class TTRSS_APIExtension extends Minz_Extension {

	#[\Override]
	public function init(): void {
		$this->registerHook('post_update', [$this, 'postUpdateHook']);
	}

	#[\Override]
	public function install() {
		$filename = 'ttrss.php';
		$file_source = join_path($this->getPath(), $filename);
		$path_destination = join_path(PUBLIC_PATH, 'api');
		$file_destination = join_path($path_destination, $filename);

		if (!is_writable($path_destination)) {
			return 'server cannot write in ' . $path_destination;
		}

		if (file_exists($file_destination)) {
			if (!unlink($file_destination)) {
				return 'API file seems already existing but cannot be removed';
			}
		}

		if (!file_exists($file_source)) {
			return 'API file seems not existing in this extension. Try to download it again.';
		}

		if (!copy($file_source, $file_destination)) {
			return 'the API file has failed during installation.';
		}

		return true;
	}

	#[\Override]
	public function uninstall() {
		$filename = 'ttrss.php';
		$file_destination = join_path(PUBLIC_PATH, 'api', $filename);

		if (file_exists($file_destination) && !unlink($file_destination)) {
			return 'API file cannot be removed';
		}

		return true;
	}

	public function postUpdateHook(): void {
		$res = $this->install();

		if ($res !== true) {
			Minz_Log::warning('Problem during TTRSS API extension post update: ' . $res);
		}
	}
}
