<?php
declare(strict_types=1);

final class FreshRSS_dotNotation_Util
{

	/**
	 * Get an item from an array using "dot" notation.
	 * Functions adapted from https://stackoverflow.com/a/39118759
	 * https://github.com/illuminate/support/blob/52e8f314b8043860b1c09e5c2c7e8cca94aafc7d/Arr.php#L270-L305
	 * Newer version in
	 * https://github.com/laravel/framework/blob/10.x/src/Illuminate/Collections/Arr.php#L302-L337
	 *
	 * @param \ArrayAccess<string,mixed>|array<string,mixed>|mixed $array
	 * @param string|null $key
	 * @param mixed $default
	 * @return mixed
	 */
	public static function get($array, ?string $key, mixed $default = null) {
		if (!static::accessible($array)) {
			return static::value($default);
		}
		/** @var \ArrayAccess<string,mixed>|array<string,mixed> $array */
		if (in_array($key, [null, '', '.', '$'], true)) {
			return $array;
		}

		// Compatibility with brackets path such as `items[0].value`
		$key = preg_replace('/\[(\d+)\]/', '.$1', $key);
		if ($key === null) {
			return null;
		}

		if (static::exists($array, $key)) {
			return $array[$key];
		}
		if (strpos($key, '.') === false) {
			return $array[$key] ?? static::value($default);
		}
		foreach (explode('.', $key) as $segment) {
			if (static::accessible($array) && static::exists($array, $segment)) {
				$array = $array[$segment];
			} else {
				return static::value($default);
			}
		}
		return $array;
	}

	/**
	 * Get a string from an array using "dot" notation.
	 *
	 * @param \ArrayAccess<string,mixed>|array<string,mixed>|mixed $array
	 * @param string|null $key
	 */
	public static function getString($array, ?string $key): ?string {
		$result = self::get($array, $key, null);
		return is_string($result) || is_bool($result) || is_float($result) || is_int($result) ? (string)$result : null;
	}

	/**
	 * Determine whether the given value is array accessible.
	 *
	 * @param mixed $value
	 * @return bool
	 */
	private static function accessible($value): bool {
		return is_array($value) || $value instanceof \ArrayAccess;
	}

	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param \ArrayAccess<string,mixed>|array<string,mixed>|mixed $array
	 * @param string $key
	 * @return bool
	 */
	private static function exists($array, string $key): bool {
		if ($array instanceof \ArrayAccess) {
			return $array->offsetExists($key);
		}
		if (is_array($array)) {
			return array_key_exists($key, $array);
		}
		return false;
	}

	/** @param mixed $value */
	private static function value($value): mixed {
		return $value instanceof Closure ? $value() : $value;
	}

	/**
	 * Convert a JSON object to a RSS document
	 * mapping fields from the JSON object into RSS equivalents
	 * according to the dot-separated paths
	 *
	 * @param array<string> $jf json feed
	 * @param string $feedSourceUrl the source URL for the feed
	 * @param array<string,string> $dotNotation dot notation to map JSON into RSS
	 * @param string $defaultRssTitle Default title of the RSS feed, if not already provided in dotNotation `feedTitle`
	 */
	public static function convertJsonToRss(array $jf, string $feedSourceUrl, array $dotNotation, string $defaultRssTitle = ''): ?string {
		if (!isset($dotNotation['item']) || $dotNotation['item'] === '') {
			return null; //no definition of item path, but we can't scrape anything without knowing this
		}

		$view = new FreshRSS_View();
		$view->_path('index/rss.phtml');
		$view->internal_rendering = true;
		$view->rss_url = htmlspecialchars($feedSourceUrl, ENT_COMPAT, 'UTF-8');
		$view->html_url = $view->rss_url;
		$view->entries = [];

		$view->rss_title = isset($dotNotation['feedTitle'])
			? (htmlspecialchars(FreshRSS_dotNotation_Util::getString($jf, $dotNotation['feedTitle']) ?? '', ENT_COMPAT, 'UTF-8') ?: $defaultRssTitle)
			: $defaultRssTitle;

		$jsonItems = FreshRSS_dotNotation_Util::get($jf, $dotNotation['item']);
		if (!is_array($jsonItems) || count($jsonItems) === 0) {
			return null;
		}

		foreach ($jsonItems as $jsonItem) {
			$rssItem = [];
			$rssItem['link'] = isset($dotNotation['itemUri']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemUri']) ?? '' : '';
			if (empty($rssItem['link'])) {
				continue;
			}
			$rssItem['title'] = isset($dotNotation['itemTitle']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemTitle']) ?? '' : '';
			$rssItem['author'] = isset($dotNotation['itemAuthor']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemAuthor']) ?? '' : '';
			$rssItem['timestamp'] = isset($dotNotation['itemTimestamp']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemTimestamp']) ?? '' : '';

			//get simple content, but if a path for HTML content has been provided, replace the simple content with HTML content
			$rssItem['content'] = isset($dotNotation['itemContent']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemContent']) ?? '' : '';
			$rssItem['content'] = isset($dotNotation['itemContentHTML'])
				? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemContentHTML']) ?? ''
				: $rssItem['content'];

			if (isset($dotNotation['itemTimeFormat']) && is_string($dotNotation['itemTimeFormat'])) {
				$dateTime = DateTime::createFromFormat($dotNotation['itemTimeFormat'], $rssItem['timestamp']);
				if ($dateTime != false) {
					$rssItem['timestamp'] = $dateTime->format(DateTime::ATOM);
				}
			}

			if (isset($dotNotation['itemCategories'])) {
				$jsonItemCategories = FreshRSS_dotNotation_Util::get($jsonItem, $dotNotation['itemCategories']);
				if (is_string($jsonItemCategories) && $jsonItemCategories !== '') {
					$rssItem['tags'] = [$jsonItemCategories];
				} elseif (is_array($jsonItemCategories) && count($jsonItemCategories) > 0) {
					$rssItem['tags'] = [];
					foreach ($jsonItemCategories as $jsonItemCategory) {
						if (is_string($jsonItemCategory)) {
							$rssItem['tags'][] = $jsonItemCategory;
						}
					}
				}
			}

			$rssItem['thumbnail'] = isset($dotNotation['itemThumbnail']) ? FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemThumbnail']) ?? '' : '';

			//Enclosures?
			if (isset($dotNotation['itemAttachment'])) {
				$jsonItemAttachments = FreshRSS_dotNotation_Util::get($jsonItem, $dotNotation['itemAttachment']);
				if (is_array($jsonItemAttachments) && count($jsonItemAttachments) > 0) {
					$rssItem['attachments'] = [];
					foreach ($jsonItemAttachments as $attachment) {
						$rssAttachment = [];
						$rssAttachment['url'] = isset($dotNotation['itemAttachmentUrl'])
							? FreshRSS_dotNotation_Util::getString($attachment, $dotNotation['itemAttachmentUrl'])
							: '';
						$rssAttachment['type'] = isset($dotNotation['itemAttachmentType'])
							? FreshRSS_dotNotation_Util::getString($attachment, $dotNotation['itemAttachmentType'])
							: '';
						$rssAttachment['length'] = isset($dotNotation['itemAttachmentLength'])
							? FreshRSS_dotNotation_Util::get($attachment, $dotNotation['itemAttachmentLength'])
							: '';
						$rssItem['attachments'][] = $rssAttachment;
					}
				}
			}

			if (isset($dotNotation['itemUid'])) {
				$rssItem['guid'] = FreshRSS_dotNotation_Util::getString($jsonItem, $dotNotation['itemUid']);
			}

			if (empty($rssItem['guid'])) {
				$rssItem['guid'] = 'urn:sha1:' . sha1($rssItem['title'] . $rssItem['content'] . $rssItem['link']);
			}

			if ($rssItem['title'] != '' || $rssItem['content'] != '' || $rssItem['link'] != '') {
				// HTML-encoding/escaping of the relevant fields (all except 'content')
				foreach (['author', 'guid', 'link', 'thumbnail', 'timestamp', 'tags', 'title'] as $key) {
					if (!empty($rssItem[$key]) && is_string($rssItem[$key])) {
						$rssItem[$key] = Minz_Helper::htmlspecialchars_utf8($rssItem[$key]);
					}
				}
				$view->entries[] = FreshRSS_Entry::fromArray($rssItem);
			}
		}

		return $view->renderToString();
	}
}
