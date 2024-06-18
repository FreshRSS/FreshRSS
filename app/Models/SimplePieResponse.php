<?php
declare(strict_types=1);

final class FreshRSS_SimplePieResponse extends \SimplePie\File
{
	public function __construct(string $url, int $timeout = 10, int $redirects = 5, ?array $headers = null,
		?string $useragent = null, bool $force_fsockopen = false, array $curl_options = []) {
		parent::__construct($url, $timeout, $redirects, $headers, $useragent, $force_fsockopen, $curl_options);
		syslog(LOG_INFO, 'SimplePie GET ' . $this->status_code . ' ' . \SimplePie\Misc::url_remove_credentials($url));
	}
}
