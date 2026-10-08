<?php
declare(strict_types=1);

class FreshRSS_Migration_2026_07_03_MoveCustomFavicons {
	public static function migrate(): bool {
		require LIB_PATH . '/favicons.php';
		@mkdir(CUSTOM_FAVICONS_DIR, 0770, true);
		if (!touch(CUSTOM_FAVICONS_DIR . '/index.html')) {
			throw new Exception('Failed to create a directory for custom favicons.');
		}
		$moved_icons = 0;
		foreach (glob(FAVICONS_DIR . '*.ico', GLOB_NOSORT) ?: [] as $icon) {
			$icon = basename($icon);
			$hash = pathinfo($icon, PATHINFO_FILENAME);
			$is_custom_favicon = !file_exists(FAVICONS_DIR . $hash . '.txt');
			if ($is_custom_favicon) {
				$old_path = FAVICONS_DIR . $icon;
				$new_path = CUSTOM_FAVICONS_DIR . $icon;
				if (!@rename($old_path, $new_path)) {
					throw new Exception("Failed to move $old_path into $new_path");
				}
				$moved_icons++;
			}
		}
		Minz_Log::notice("Moved $moved_icons icons.");
		return true;
	}
}
