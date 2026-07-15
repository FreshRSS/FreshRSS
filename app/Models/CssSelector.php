<?php
declare(strict_types=1);

final class FreshRSS_CssSelector {
	public static function nativeSelectorsAvailable(): bool {
		$documentClass = self::nativeDocumentClass();
		if (!class_exists($documentClass)) {
			return false;
		}
		$reflection = new ReflectionClass($documentClass);
		return $reflection->hasMethod('createFromString') && $reflection->hasMethod('querySelectorAll');
	}

	private static function nativeDocumentClass(): string {
		return 'Dom' . chr(92) . 'HTMLDocument';
	}

	/** @return object|false */
	public static function loadHtml(string $html): object|false {
		$documentClass = self::nativeDocumentClass();
		if (self::nativeSelectorsAvailable() && class_exists($documentClass)) {
			$document = (new ReflectionMethod($documentClass, 'createFromString'))->invoke(null, $html, LIBXML_NOERROR);
			return is_object($document) ? $document : false;
		}

		$document = new DOMDocument();
		return $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING) ? $document : false;
	}

	public static function isNativeDocument(object $document): bool {
		return is_a($document, self::nativeDocumentClass());
	}

	/** @return Traversable<int, mixed> */
	public static function querySelectorAll(object $document, string $selector, mixed $context = null): Traversable {
		$parent = $context ?? $document;
		if (self::isNativeDocument($document) && is_object($parent) && method_exists($parent, 'querySelectorAll')) {
			$nodes = call_user_func([$parent, 'querySelectorAll'], $selector);
			return $nodes instanceof Traversable ? $nodes : new ArrayIterator();
		}

		if (!($document instanceof DOMDocument) || ($context !== null && !($context instanceof DOMNode))) {
			return new ArrayIterator();
		}

		$xpath = new DOMXPath($document);
		$query = (new Gt\CssXPath\Translator($selector, $context === null ? '//' : 'descendant-or-self::'))->asXPath();
		$nodes = $xpath->query($query, $context);
		return $nodes instanceof Traversable ? $nodes : new ArrayIterator();
	}

	public static function querySelector(object $document, string $selector): ?object {
		foreach (self::querySelectorAll($document, $selector) as $node) {
			if (is_object($node)) {
				return $node;
			}
		}
		return null;
	}

	public static function matches(mixed $node, string $selector): bool {
		if (!is_object($node) || !method_exists($node, 'matches')) {
			return false;
		}
		return call_user_func([$node, 'matches'], $selector) === true;
	}

	public static function isElement(mixed $node): bool {
		return is_object($node) && ($node instanceof DOMElement || is_a($node, 'Dom\\Element'));
	}

	public static function getAttribute(mixed $element, string $attribute): string {
		if (!is_object($element) || !method_exists($element, 'getAttribute')) {
			return '';
		}
		$value = call_user_func([$element, 'getAttribute'], $attribute);
		return is_string($value) ? $value : '';
	}

	public static function isAttached(mixed $node, object $document): bool {
		if (!is_object($node) || !self::isElement($node)) {
			return false;
		}
		if ($node instanceof DOMElement) {
			return $node->ownerDocument === $document && $node->parentNode !== null;
		}
		if (!method_exists($node, 'getRootNode')) {
			return false;
		}
		$root = call_user_func([$node, 'getRootNode']);
		return is_object($root) && method_exists($root, 'isSameNode') && call_user_func([$root, 'isSameNode'], $document) === true;
	}

	public static function remove(mixed $node): void {
		if (is_object($node) && method_exists($node, 'remove')) {
			call_user_func([$node, 'remove']);
		}
	}

	public static function saveHtml(object $document, mixed $node = null): string|false {
		if (self::isNativeDocument($document) && method_exists($document, 'saveHtml')) {
			$html = $node === null ? call_user_func([$document, 'saveHtml']) : call_user_func([$document, 'saveHtml'], $node);
			return is_string($html) ? $html : false;
		}

		if (!($document instanceof DOMDocument) || ($node !== null && !($node instanceof DOMNode))) {
			return false;
		}

		return $document->saveHTML($node);
	}
}
