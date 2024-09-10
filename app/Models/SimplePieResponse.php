<?php
declare(strict_types=1);

final class FreshRSS_SimplePieResponse extends \SimplePie\File
{
	#[\Override]
	protected function on_http_response(): void {
		syslog(LOG_INFO, 'FreshRSS SimplePie GET ' . $this->get_status_code() . ' ' . \SimplePie\Misc::url_remove_credentials($this->get_final_requested_uri()));
	}
}
