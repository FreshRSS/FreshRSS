<?php

final class FreshRSS_dotpath_Util
{

	/**
	 * Get an item from an array using "dot" notation.
	 * Functions from https://stackoverflow.com/a/39118759
	 *
	 * @param  \ArrayAccess<string,mixed>|array<string,mixed>  $array
	 * @param  string|null  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public static function get($array, ?string $key, mixed $default = null) {
		if (!static::accessible($array)) {
			return static::value($default);
		}
		if ($key === null || $key === '') {
			return $array;
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
	 * @param  \ArrayAccess<string,mixed>|array<string,mixed>  $array
	 * @param  string|null  $key
	 */
	public static function getString($array, ?string $key): ?string {
		$result = self::get($array, $key, null);
		return is_string($result) ? $result : null;
	}

	/**
	 * Determine whether the given value is array accessible.
	 *
	 * @param  mixed  $value
	 * @return bool
	 */
	private static function accessible(mixed $value): bool {
		return is_array($value) || $value instanceof ArrayAccess;
	}

	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param  \ArrayAccess<string,mixed>|array<string,mixed>  $array
	 * @param  string  $key
	 * @return bool
	 */
	private static function exists($array, string $key): bool {
		if ($array instanceof ArrayAccess) {
			return $array->offsetExists($key);
		}
		return array_key_exists($key, $array);
	}

	private static function value(mixed $value): mixed {
		return $value instanceof Closure ? $value() : $value;
	}

	/**
	 * Convert a JSON object to a RSS document
	 * mapping fields from the JSON object into RSS equivalents
	 * according to the dot-separated paths
	 *
	 * @param array<string> $jf json feed
	 * @param string $feedSourceUrl the source URL for the feed
	 * @param array<string,string> $dotPaths dot paths to map JSON into RSS
	 * @param string $defaultRssTitle Default title of the RSS feed, if not already provided in dotPath `feedTitle`
	 */
	public static function convertJSONtoRSS(array $jf, string $feedSourceUrl, array $dotPaths, string $defaultRssTitle = ''): ?string {
		if (!isset($dotPaths['item']) || $dotPaths['item'] === '') {
			return null; //no definition of item path, but we can't scrape anything without knowing this
		}

		$view = new FreshRSS_View();
		$view->_path('index/rss.phtml');
		$view->internal_rendering = true;
		$view->rss_url = $feedSourceUrl;
		$view->entries = [];

		try {
			$view->rss_title = isset($dotPaths['feedTitle'])
				? (htmlspecialchars(FreshRSS_dotpath_Util::getString($jf, $dotPaths['feedTitle']) ?? '', ENT_COMPAT, 'UTF-8') ?: $defaultRssTitle)
				: $defaultRssTitle;

			$jsonItems = FreshRSS_dotpath_Util::get($jf, $dotPaths['item']);
			if (!is_array($jsonItems) || count($jsonItems) === 0) {
				return null;
			}

			foreach ($jsonItems as $jsonItem) {
				$rssItem = [];
				$rssItem['link'] = isset($dotPaths['itemUri']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemUri']) ?? '' : '';
				if (empty($rssItem['link'])) {
					continue;
				}
				$rssItem['title'] = isset($dotPaths['itemTitle']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemTitle']) ?? '' : '';
				$rssItem['author'] = isset($dotPaths['itemAuthor']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemAuthor']) ?? '' : '';
				$rssItem['timestamp'] = isset($dotPaths['itemTimestamp']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemTimestamp']) ?? '' : '';

				//get simple content, but if a path for HTML content has been provided, replace the simple content with HTML content
				$rssItem['content'] = isset($dotPaths['itemContent']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemContent']) ?? '' : '';
				$rssItem['content'] = isset($dotPaths['itemContentHTML'])
					? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemContentHTML']) ?? ''
					: $rssItem['content'];

				if (isset($dotPaths['itemTimeFormat']) && is_string($dotPaths['itemTimeFormat'])) {
					$dateTime = DateTime::createFromFormat($dotPaths['itemTimeFormat'], $rssItem['timestamp']);
					if ($dateTime != false) {
						$rssItem['timestamp'] = $dateTime->format(DateTime::ATOM);
					}
				}

				if (isset($dotPaths['itemCategories'])) {
					$jsonItemCategories = FreshRSS_dotpath_Util::get($jsonItem, $dotPaths['itemCategories']);
					if (is_string($jsonItemCategories) && $jsonItemCategories !== '') {
						$rssItem['tags'] = [$jsonItemCategories];
					} elseif (is_array($jsonItemCategories) && count($jsonItemCategories) > 0) {
						$rssItem['tags'] = $jsonItemCategories;
					}
				}

				$rssItem['thumbnail'] = isset($dotPaths['itemThumbnail']) ? FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemThumbnail']) ?? '' : '';

				//Enclosures?
				if (isset($dotPaths['itemAttachment'])) {
					$jsonItemAttachments = FreshRSS_dotpath_Util::get($jsonItem, $dotPaths['itemAttachment']);
					if (is_array($jsonItemAttachments) && count($jsonItemAttachments) > 0) {
						$rssItem['attachments'] = [];
						foreach ($jsonItemAttachments as $attachment) {
							$rssAttachment = [];
							$rssAttachment['url'] = isset($dotPaths['itemAttachmentUrl'])
								? FreshRSS_dotpath_Util::getString($attachment, $dotPaths['itemAttachmentUrl'])
								: '';
							$rssAttachment['type'] = isset($dotPaths['itemAttachmentType'])
								? FreshRSS_dotpath_Util::getString($attachment, $dotPaths['itemAttachmentType'])
								: '';
							$rssAttachment['length'] = isset($dotPaths['itemAttachmentLength'])
								? FreshRSS_dotpath_Util::get($attachment, $dotPaths['itemAttachmentLength'])
								: '';
							$rssItem['attachments'][] = $rssAttachment;
						}
					}
				}

				if (isset($dotPaths['itemUid'])) {
					$rssItem['guid'] = FreshRSS_dotpath_Util::getString($jsonItem, $dotPaths['itemUid']);
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
		} catch (Exception $ex) {
			Minz_Log::warning($ex->getMessage());
			return null;
		}

		return $view->renderToString();
	}
}
