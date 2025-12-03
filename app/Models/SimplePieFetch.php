<?php
declare(strict_types=1);

final class FreshRSS_SimplePieFetch extends \SimplePie\File
{
	public function __construct(string $url, int $timeout = 10, int $redirects = 5,
		?array $headers = null, ?string $useragent = null, bool $force_fsockopen = false, array $curl_options = []) {

		// Remove case-insensitively default HTTP headers passed by $headers if they are overridden by $curl_options[CURLOPT_HTTPHEADER]
		if (is_array($curl_options[CURLOPT_HTTPHEADER] ?? null) && is_array($headers)) {
			$existingKeys = [];
			foreach ($curl_options[CURLOPT_HTTPHEADER] as $headerLine) {
				if (!is_string($headerLine)) {
					continue;
				}
				$parts = explode(':', $headerLine, 2);
				if (count($parts) >= 2) {
					$existingKeys[strtolower(trim($parts[0]))] = true;
				}
			}
			foreach ($headers as $key => $value) {
				if (isset($existingKeys[strtolower($key)])) {
					unset($headers[$key]);
				}
			}
		}

		parent::__construct($url, $timeout, $redirects, $headers, $useragent, $force_fsockopen, $curl_options);
	}

	#[\Override]
	protected function on_http_response($response, array $curl_options = []): void {
		if (FreshRSS_Context::systemConf()->simplepie_syslog_enabled) {
			syslog(LOG_INFO, 'FreshRSS SimplePie GET ' . $this->get_status_code() . ' ' . \SimplePie\Misc::url_remove_credentials($this->get_final_requested_uri()));
		}

		if (in_array($this->get_status_code(), [429, 503], true)) {
			$parser = new \SimplePie\HTTP\Parser(is_string($response) ? $response : '');
			if ($parser->parse()) {
				$headers = $parser->headers;
			} else {
				$headers = [];
			}

			$proxy = is_string($curl_options[CURLOPT_PROXY] ?? null) ? $curl_options[CURLOPT_PROXY] : '';
			$retryAfter = FreshRSS_http_Util::setRetryAfter($this->get_final_requested_uri(), $proxy, $headers['retry-after'] ?? '');
			if ($retryAfter > 0) {
				$domain = parse_url($this->get_final_requested_uri(), PHP_URL_HOST);
				if (is_string($domain) && $domain !== '') {
					if (is_int($port = parse_url($this->get_final_requested_uri(), PHP_URL_PORT))) {
						$domain .= ':' . $port;
					}
					$errorMessage = 'Will retry after ' . date('c', $retryAfter) . ' for domain `' . $domain . '`';
					Minz_Log::notice($errorMessage);
				}
			}
		}
	}
}
