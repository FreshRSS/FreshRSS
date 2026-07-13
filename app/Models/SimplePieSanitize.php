<?php
declare(strict_types=1);

final class FreshRSS_SimplePieSanitize extends \SimplePie\Sanitize
{
	#[\Override]
	public function sanitize(string $data, int $type, string $base = '') {
		// `$this->base` is normally set part-way through parent::sanitize(),
		// after enforce_allowed_html_nodes has already run. Set it here so our
		// override sees the correct base when absolutising srcset URLs.
		$this->base = $base;
		return parent::sanitize($data, $type, $base);
	}

	#[\Override]
	protected function enforce_allowed_html_nodes(\DOMNode $element, bool $allow_data_attr = true, bool $allow_aria_attr = true): void {
		if ($element instanceof \DOMDocument) {
			$this->rewriteImgSrcset($element);
		}
		parent::enforce_allowed_html_nodes($element, $allow_data_attr, $allow_aria_attr);
	}

	/**
	 * Absolutise each URL in `srcset` on `<img>` and `<source>` against the
	 * document base (SimplePie's url-replacement table only handles
	 * single-URL attributes). For `<img>` only, when `src` is empty or a
	 * recognised placeholder (lazy-loading pattern), write the smallest
	 * `Nw` entry as a fallback. The browser uses `srcset` for actual
	 * selection; `src` only loads when `srcset` can't be honoured (legacy
	 * browsers, non-browser API consumers), so the smallest is the safest
	 * fallback by bandwidth and is never larger than what `srcset` would
	 * have picked.
	 */
	private function rewriteImgSrcset(\DOMDocument $doc): void {
		$xpath = new \DOMXPath($doc);
		$nodes = $xpath->query('//img[@srcset] | //source[@srcset]');
		if ($nodes === false) {
			return;
		}
		foreach ($nodes as $node) {
			if (!$node instanceof \DOMElement) {
				continue;
			}
			$entries = $this->parseSrcset($node->getAttribute('srcset'));
			if ($entries === []) {
				continue;
			}
			$absolutised = [];
			foreach ($entries as $e) {
				$abs = \SimplePie\Misc::absolutize_url($e['url'], $this->base);
				if (!is_string($abs) || $abs === '') {
					continue;
				}
				$absolutised[] = ['url' => $abs, 'descriptor' => $e['descriptor'], 'w' => $e['w']];
			}
			if ($absolutised === []) {
				continue;
			}
			$node->setAttribute('srcset', implode(', ', array_map(
				static fn(array $e): string => $e['descriptor'] === '' ? $e['url'] : $e['url'] . ' ' . $e['descriptor'],
				$absolutised
			)));

			// `<source>` (inside `<picture>`) has no `src` attribute; only `<img>`
			// needs a fallback `src` rewrite when its current value is a placeholder.
			if ($node->tagName !== 'img') {
				continue;
			}
			$current = $node->getAttribute('src');
			if (!$this->isPlaceholderSrc($current)) {
				continue;
			}
			$widthEntries = array_values(array_filter($absolutised, static fn(array $e): bool => $e['w'] > 0));
			if ($widthEntries === []) {
				continue;
			}
			usort($widthEntries, static fn(array $a, array $b): int => $a['w'] <=> $b['w']);
			$node->setAttribute('src', $widthEntries[0]['url']);
		}
	}

	/**
	 * A `src` value is treated as a lazy-load placeholder if it is empty,
	 * matches the de-facto universal 1x1 transparent GIF marker (base64
	 * encoding of the GIF89a header for a 1x1 transparent image), or is
	 * any other `data:` URI under 128 characters. The threshold sits
	 * between common placeholder sizes (~70-120 chars) and the smallest
	 * useful inline rasters (~200+ chars).
	 */
	private function isPlaceholderSrc(string $src): bool {
		if ($src === '') {
			return true;
		}
		return str_starts_with($src, 'data:') &&
			(strlen($src) < 128 || str_starts_with($src, 'data:image/gif;base64,R0lGODlh'));
	}

	/**
	 * @return list<array{url: string, descriptor: string, w: int}>
	 *         `descriptor` is `''` when the source entry has no descriptor
	 *         (browser implies `1x`); `w` is 0 for density or missing
	 *         descriptors and is used to filter entries when picking a
	 *         width-based fallback.
	 */
	private function parseSrcset(string $srcset): array {
		$out = [];
		foreach (explode(',', $srcset) as $part) {
			$part = trim($part);
			if ($part === '') {
				continue;
			}
			$bits = preg_split('/\s+/', $part, 2);
			if (!is_array($bits)) {
				continue;
			}
			$url = $bits[0];
			$descriptor = isset($bits[1]) ? trim($bits[1]) : '';
			$w = (preg_match('/^(\d+)w$/', $descriptor, $wm) === 1) ? (int)$wm[1] : 0;
			$out[] = ['url' => $url, 'descriptor' => $descriptor, 'w' => $w];
		}
		return $out;
	}
}
