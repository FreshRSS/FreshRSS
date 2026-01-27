<?php
declare(strict_types=1);

final class FreshRSS_SimplePieCustom extends \SimplePie\SimplePie
{
	/**
	 * @param array<string,mixed> $attributes
	 * @param array<int,mixed> $curl_options
	 * @throws FreshRSS_Context_Exception
	 */
	public function __construct(array $attributes = [], array $curl_options = []) {
		parent::__construct();
		$limits = FreshRSS_Context::systemConf()->limits;
		$this->get_registry()->register(\SimplePie\File::class, FreshRSS_SimplePieFetch::class);
		$this->set_useragent(FRESHRSS_USERAGENT);
		$this->set_cache_name_function('sha1');	// @phpstan-ignore method.deprecated
		$this->set_cache_location(CACHE_PATH);	// @phpstan-ignore method.deprecated
		$this->set_cache_duration($limits['cache_duration'], $limits['cache_duration_min'], $limits['cache_duration_max']);
		$this->enable_order_by_date(false);

		$feed_timeout = empty($attributes['timeout']) || !is_numeric($attributes['timeout']) ? 0 : (int)$attributes['timeout'];
		$this->set_timeout($feed_timeout > 0 ? $feed_timeout : $limits['timeout']);

		$curl_options = array_replace(FreshRSS_Context::systemConf()->curl_options, $curl_options);
		if (isset($attributes['ssl_verify'])) {
			$curl_options[CURLOPT_SSL_VERIFYHOST] = empty($attributes['ssl_verify']) ? 0 : 2;
			$curl_options[CURLOPT_SSL_VERIFYPEER] = (bool)$attributes['ssl_verify'];
			if (empty($attributes['ssl_verify'])) {
				$curl_options[CURLOPT_SSL_CIPHER_LIST] = 'DEFAULT@SECLEVEL=1';
			}
		}
		$attributes['curl_params'] = FreshRSS_http_Util::sanitizeCurlParams(is_array($attributes['curl_params'] ?? null) ? $attributes['curl_params'] : []);
		if (!empty($attributes['curl_params']) && is_array($attributes['curl_params'])) {
			foreach ($attributes['curl_params'] as $co => $v) {
				if (is_int($co)) {
					$curl_options[$co] = $v;
				}
			}
		}
		if (!empty($curl_options[CURLOPT_PROXYTYPE]) && ($curl_options[CURLOPT_PROXYTYPE] < 0 || $curl_options[CURLOPT_PROXYTYPE] === 3)) {
			// 3 is legacy for NONE
			unset($curl_options[CURLOPT_PROXYTYPE]);
			if (isset($curl_options[CURLOPT_PROXY])) {
				unset($curl_options[CURLOPT_PROXY]);
			}
		}
		$this->set_curl_options($curl_options);

		$this->strip_comments(true);
		$this->rename_attributes(['id', 'class']);
		$this->allow_aria_attr(true);
		$this->allow_data_attr(true);
		$this->allowed_html_attributes([
			// HTML
			'dir',
			'draggable',
			'hidden',
			'lang',
			'role',
			'title',
			// MathML
			'displaystyle',
			'mathsize',
			'scriptlevel',
		]);
		$this->allowed_html_elements_with_attributes([
			// HTML
			'a' => ['href', 'hreflang', 'type'],
			'abbr' => [],
			'acronym' => [],
			'address' => [],
			// 'area' => [], // TODO: support <area> after rewriting ids with a format like #ugc-<insert original id here> (maybe)
			'article' => [],
			'aside' => [],
			'audio' => ['controlslist', 'loop', 'muted', 'src'],
			'b' => [],
			'bdi' => [],
			'bdo' => [],
			'big' => [],
			'blink' => [],
			'blockquote' => ['cite'],
			'br' => ['clear'],
			'button' => ['disabled'],
			'canvas' => ['width', 'height'],
			'caption' => ['align'],
			'center' => [],
			'cite' => [],
			'code' => [],
			'col' => ['span', 'align', 'valign', 'width'],
			'colgroup' => ['span', 'align', 'valign', 'width'],
			'data' => ['value'],
			'datalist' => [],
			'dd' => [],
			'del' => ['cite', 'datetime'],
			'details' => ['open'],
			'dfn' => [],
			'dialog' => [],
			'dir' => [],
			'div' => ['align'],
			'dl' => [],
			'dt' => [],
			'em' => [],
			'fieldset' => ['disabled'],
			'figcaption' => [],
			'figure' => [],
			'footer' => [],
			'h1' => [],
			'h2' => [],
			'h3' => [],
			'h4' => [],
			'h5' => [],
			'h6' => [],
			'header' => [],
			'hgroup' => [],
			'hr' => ['align', 'noshade', 'size', 'width'],
			'i' => [],
			'iframe' => ['src', 'align', 'frameborder', 'longdesc', 'marginheight', 'marginwidth', 'scrolling', 'allowfullscreen'],
			'image' => ['src', 'alt', 'width', 'height', 'align', 'border', 'hspace', 'longdesc', 'vspace'],
			'img' => ['src', 'alt', 'width', 'height', 'align', 'border', 'hspace', 'longdesc', 'vspace'],
			'ins' => ['cite', 'datetime'],
			'kbd' => [],
			'label' => [],
			'legend' => [],
			'li' => ['value', 'type'],
			'main' => [],
			// 'map' => [], // TODO: support <map> after rewriting ids with a format like #ugc-<insert original id here> (maybe)
			'mark' => [],
			'marquee' => ['behavior', 'direction', 'height', 'hspace', 'loop', 'scrollamount', 'scrolldelay', 'truespeed', 'vspace', 'width'],
			'menu' => [],
			'meter' => ['value', 'min', 'max', 'low', 'high', 'optimum'],
			'nav' => [],
			'nobr' => [],
			// 'noembed' => [], // <embed> is not allowed, so we want to display the contents of <noembed>
			'noframes' => [],
			// 'noscript' => [], // From the perspective of the feed content, JS isn't allowed so we want to display the contents of <noscript>
			'ol' => ['reversed', 'start', 'type'],
			'optgroup' => ['disabled', 'label'],
			'option' => ['disabled', 'label', 'selected', 'value'],
			'output' => [],
			'p' => ['align'],
			'picture' => [],
			// 'plaintext' => [], // Can't be closed. See: https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/plaintext
			'pre' => ['width', 'wrap'],
			'progress' => ['max', 'value'],
			'q' => ['cite'],
			'rb' => [],
			'rp' => [],
			'rt' => [],
			'rtc' => [],
			'ruby' => [],
			's' => [],
			'samp' => [],
			'search' => [],
			'section' => [],
			'select' => ['disabled', 'multiple', 'size'],
			'small' => [],
			'source' => ['type', 'src', 'media', 'height', 'width'],
			'span' => [],
			'strike' => [],
			'strong' => [],
			'sub' => [],
			'summary' => [],
			'sup' => [],
			'table' => ['align', 'border', 'cellpadding', 'cellspacing', 'rules', 'summary', 'width'],
			'tbody' => ['align', 'char', 'charoff', 'valign'],
			'td' => ['colspan', 'headers', 'rowspan', 'abbr', 'align', 'height', 'scope', 'valign', 'width'],
			'textarea' => ['cols', 'disabled', 'maxlength', 'minlength', 'placeholder', 'readonly', 'rows', 'wrap'],
			'tfoot' => ['align', 'valign'],
			'th' => ['abbr', 'colspan', 'rowspan', 'scope', 'align', 'height', 'valign', 'width'],
			'thead' => ['align', 'valign'],
			'time' => ['datetime'],
			'tr' => ['align', 'valign'],
			'track' => ['default', 'kind', 'srclang', 'label', 'src'],
			'tt' => [],
			'u' => [],
			'ul' => ['type'],
			'var' => [],
			'video' => ['src', 'poster', 'controlslist', 'height', 'loop', 'muted', 'playsinline', 'width'],
			'wbr' => [],
			'xmp' => [],
			// MathML
			'maction' => ['actiontype', 'selection'],
			'math' => ['display'],
			'menclose' => ['notation'],
			'merror' => [],
			'mfenced' => ['close', 'open', 'separators'],
			'mfrac' => ['denomalign', 'linethickness', 'numalign'],
			'mi' => ['mathvariant'],
			'mmultiscripts' => ['subscriptshift', 'superscriptshift'],
			'mn' => [],
			'mo' => ['accent', 'fence', 'form', 'largeop', 'lspace', 'maxsize', 'minsize', 'movablelimits', 'rspace', 'separator', 'stretchy', 'symmetric'],
			'mover' => ['accent'],
			'mpadded' => ['depth', 'height', 'lspace', 'voffset', 'width'],
			'mphantom' => [],
			'mprescripts' => [],
			'mroot' => [],
			'mrow' => [],
			'ms' => [],
			'mspace' => ['depth', 'height', 'width'],
			'msqrt' => [],
			'msub' => [],
			'msubsup' => ['subscriptshift', 'superscriptshift'],
			'msup' => ['superscriptshift'],
			'mtable' => ['align', 'columnalign', 'columnlines', 'columnspacing', 'frame', 'framespacing', 'rowalign', 'rowlines', 'rowspacing', 'width'],
			'mtd' => ['columnspan', 'rowspan', 'columnalign', 'rowalign'],
			'mtext' => [],
			'mtr' => ['columnalign', 'rowalign'],
			'munder' => ['accentunder'],
			'munderover' => ['accent', 'accentunder'],
			// TODO: Support SVG after sanitizing and URL rewriting of xlink:href
		]);
		$this->strip_attributes([
			'data-auto-leave-validation',
			'data-leave-validation',
			'data-no-leave-validation',
			'data-original',
		]);
		$this->add_attributes([
			'audio' => ['controls' => 'controls', 'preload' => 'none'],
			'iframe' => [
				'allow' => 'accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share',
				'sandbox' => 'allow-scripts allow-same-origin',
				'allowfullscreen' => 'allowfullscreen',
			],
			'video' => ['controls' => 'controls', 'preload' => 'none'],
		]);
		$this->set_url_replacements([
			'a' => 'href',
			'area' => 'href',
			'audio' => 'src',
			'blockquote' => 'cite',
			'del' => 'cite',
			'form' => 'action',
			'iframe' => 'src',
			'img' => [
				'longdesc',
				'src',
			],
			'image' => [
				'longdesc',
				'src',
			],
			'input' => 'src',
			'ins' => 'cite',
			'q' => 'cite',
			'source' => 'src',
			'track' => 'src',
			'video' => [
				'poster',
				'src',
			],
		]);
		$https_domains = [];
		$force = @file(FRESHRSS_PATH . '/force-https.default.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (is_array($force)) {
			$https_domains = array_merge($https_domains, $force);
		}
		$force = @file(DATA_PATH . '/force-https.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (is_array($force)) {
			$https_domains = array_merge($https_domains, $force);
		}

		// Remove whitespace and comments starting with # / ;
		$https_domains = preg_replace('%\\s+|[\/#;].*$%', '', $https_domains) ?? $https_domains;
		$https_domains = array_filter($https_domains, fn(string $v) => $v !== '');

		$this->set_https_domains($https_domains);
	}

	public static function sanitizeHTML(string $data, string $base = '', ?int $maxLength = null): string {
		if ($data === '' || ($maxLength !== null && $maxLength <= 0)) {
			return '';
		}
		if ($maxLength !== null) {
			$data = mb_strcut($data, 0, $maxLength, 'UTF-8');
		}
		/** @var FreshRSS_SimplePieCustom|null $simplePie */
		static $simplePie = null;
		if ($simplePie === null) {
			$simplePie = new static();
			$simplePie->enable_cache(false);
			$simplePie->init();
		}
		$sanitized = $simplePie->sanitize->sanitize($data, \SimplePie\SimplePie::CONSTRUCT_HTML, $base);
		if (!is_string($sanitized)) {
			return '';
		}
		$result = html_only_entity_decode($sanitized);
		if ($maxLength !== null && strlen($result) > $maxLength) {
			//Sanitizing has made the result too long so try again shorter
			$data = mb_strcut($result, 0, (2 * $maxLength) - strlen($result) - 2, 'UTF-8');
			return self::sanitizeHTML($data, $base, $maxLength);
		}
		return $result;
	}
}
