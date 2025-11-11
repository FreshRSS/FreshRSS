<?php
declare(strict_types=1);

final class FreshRSS_SimplePieResponse extends \SimplePie\File
{
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
