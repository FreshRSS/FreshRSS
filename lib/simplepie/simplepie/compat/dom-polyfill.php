<?php

// SPDX-FileCopyrightText: 2026 Alexandre Alapetite
// SPDX-License-Identifier: BSD-3-Clause

// Polyfill PHP 8.4+ `Dom\` classes approximated using legacy `DOM*` classes,
// and optional CSS selector API approximated using `GT\CssXPath` library.

declare(strict_types=1);

namespace Dom;

const HTML_NO_DEFAULT_NS = 2147483648;

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses -- Polyfilled `Dom\` classes best co-exist in this file.

// Hide from PHPStan to avoid divergent signature shapes of the legacy aliases,
// and also skip when legacy `ext-dom` is unavailable
if (!defined('__PHPSTAN_RUNNING__') && class_exists(\DOMDocument::class, false)) {
    if (\PHP_VERSION_ID >= 80300) {
        // The polyfilled classes that cannot use `registerNodeClass()`
        // (aliasing internal classes requires PHP 8.3+):
        class_alias(\DOMComment::class, 'Dom\Comment', false);
        class_alias(\DOMDocument::class, 'Dom\Document', false);
        class_alias(\DOMNode::class, 'Dom\Node', false);
        class_alias(\DOMNodeList::class, 'Dom\NodeList', false);
        class_alias(\DOMText::class, 'Dom\Text', false);
    }

    /**
     * Optional PHP 8.4+ CSS selector API, requiring `GT\CssXPath` library.
     */
    trait CssSelectors
    {
        private function cssXPath(): ?XPath
        {
            /** @var \DOMDocument|null $document */
            $document = $this->ownerDocument ?? $this;
            return $document instanceof \DOMDocument ? new XPath($document) : null;
        }

        /**
         * Translates a CSS selector to an XPath expression.
         *
         * @param string $selectors CSS selector
         * @param string $prefix e.g. `.//` to search descendants of the context node
         * @throws \DOMException if the CSS selector cannot be translated
         */
        private function cssToXPath(string $selectors, string $prefix): string
        {
            if (!class_exists(\GT\CssXPath\Translator::class)) {
                // https://github.com/PhpGt/CssXPath
                throw new \DOMException('CSS selectors are not available: missing the `GT\CssXPath` package');
            }
            try {
                return (new \GT\CssXPath\Translator($selectors, $prefix))->asXPath();
            } catch (\Throwable $e) {
                throw new \DOMException('Invalid CSS selector: ' . $selectors, 0, $e);
            }
        }

        /**
         * Returns the first descendant element matching the CSS selector, or null.
         *
         * @return \Dom\Element|null
         */
        public function querySelector(string $selectors)
        {
            $result = $this->querySelectorAll($selectors);
            return $result->length === 0 ? null : $result->item(0);
        }

        /**
         * Returns the descendant elements matching the CSS selector.
         *
         * @return \Dom\NodeList<\Dom\Element>
         * @throws \DOMException if the CSS selector cannot be translated
         */
        public function querySelectorAll(string $selectors)
        {
            $xpath = $this->cssXPath();
            if ($xpath === null) {
                // No owner document (e.g. a detached node): empty result
                return $this->getElementsByTagName('_');
            }
            try {
                return $xpath->query($this->cssToXPath($selectors, './/'), $this);
            } catch (\Throwable $e) {
                throw $e instanceof \DOMException ? $e : new \DOMException('Invalid CSS selector: ' . $selectors, 0, $e);
            }
        }

        /**
         * Whether this element matches the given CSS selector.
         *
         * @throws \DOMException if the CSS selector cannot be translated
         */
        public function matches(string $selectors): bool
        {
            $xpath = $this->cssXPath();
            if ($xpath === null) {
                return false;
            }
            try {
                $result = $xpath->query($this->cssToXPath($selectors, 'descendant-or-self::'));
            } catch (\Throwable $e) {
                throw $e instanceof \DOMException ? $e : new \DOMException('Invalid CSS selector: ' . $selectors, 0, $e);
            }
            for ($i = 0; $i < $result->length; $i++) {
                $candidate = $result->item($i);
                if ($candidate !== null && $candidate->isSameNode($this)) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Equivalent of native `Dom\Element` (PHP 8.4+),
     * registered as the element class of `HTMLDocument` and `XMLDocument` below.
     */
    final class Element extends \DOMElement
    {
        use CssSelectors;

        /**
         * Native `Dom\Element::getAttribute()` return null when the attribute is missing
         * @return string|null
         */
        #[\ReturnTypeWillChange]
        public function getAttribute($qualifiedName)
        {
            return $this->hasAttribute($qualifiedName) ? parent::getAttribute($qualifiedName) : null;
        }
    }

    /**
     * Maps `\Dom\HTMLDocument::createFromString()` onto `\DOMDocument::loadHTML()`.
     */
    final class HTMLDocument extends \DOMDocument
    {
        use CssSelectors;

        public function __construct()
        {
            parent::__construct();
            $this->registerNodeClass(\DOMElement::class, Element::class);
        }

        /**
         * @return static
         */
        public static function createFromString(string $source, ?int $options = null, ?string $overrideEncoding = null)
        {
            $document = new self();
            $options = ($options ?? 0) | LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_HTML_NODEFDTD;

            // If the source itself declares an encoding, let the parser honour it, otherwise UTF-8.
            $injectEncoding = $source !== '' && strncmp($source, "\xEF\xBB\xBF", 3) !== 0
            && !preg_match('#<(?:meta|\?xml)[^>]*?(?:charset|encoding)\\s*=#i', $source);
            if ($injectEncoding) {
                $source = '<?xml encoding="UTF-8">' . $source;
            }

            try {
                // `HTML_NO_DEFAULT_NS` is unknown to the legacy `loadHTML()`
                /** @var \DOMDocument $document */
                $document->loadHTML($source, $options & ~HTML_NO_DEFAULT_NS);
            } catch (\ValueError $e) {
                // the native API silently creates an empty document.
            }

            if ($injectEncoding) {
                // Remove the injected declaration, which would otherwise be serialised
                foreach ($document->childNodes as $child) {
                    if ($child instanceof \DOMProcessingInstruction && $child->target === 'xml') {
                        $document->removeChild($child);
                        break;
                    }
                }
            }

            return $document;
        }

        /**
         * Normalise to `attr=""` for parity.
         * It also emits end tags for void elements (e.g. `</source>`).
         *
         * Returns `''` instead of `false` in case of error, for parity with the
         * native `Dom\HTMLDocument::saveHTML()`, which always returns a string.
         */
        public function saveHTML(?\DOMNode $node = null): string
        {
            if ($node === null && in_array(strtolower($this->encoding ?? 'utf-8'), ['utf-8', 'utf8'], true)) {
                // For a whole document, the legacy serialiser only knows the charset from `<meta http-equiv="Content-Type">`,
                // and otherwise writes non-ASCII characters as HTML entities, also inside `<script>`, where they are not decoded.
                // Node by node, it writes UTF-8, but skips the doctype.
                $html = '';
                foreach ($this->childNodes as $child) {
                    $html .= $child instanceof \DOMDocumentType ? '<!DOCTYPE ' . $child->name . '>' : parent::saveHTML($child);
                }
            } else {
                $html = parent::saveHTML($node);
            }
            if ($html === false) {
                return '';
            }
            // Drop void-element end tags emitted for e.g. `<source>`:
            $html = (string) preg_replace('#(<(area|base|br|col|embed|hr|img|input|link|meta|param|source|track|wbr)\b[^>]*?>)</\2>#i', '$1', $html);
            return (string) preg_replace_callback('#<[\w:-]+[^>]*?>#', static function (array $match): string {
                $bools = 'allowfullscreen|async|autofocus|autoplay|checked|controls|default|defer|disabled|formnovalidate|hidden|' .
                    'inert|ismap|itemscope|loop|multiple|muted|nomodule|novalidate|open|playsinline|readonly|required|reversed|selected';
                // Only scan outside quoted attribute values, which have no raw `"`:
                $parts = preg_split('#(="[^"]*")#', $match[0], -1, PREG_SPLIT_DELIM_CAPTURE);
                if ($parts === false) {
                    return $match[0];
                }
                foreach ($parts as $i => $part) {
                    if ($i % 2 === 0) {
                        $replaced = preg_replace('#\s(' . $bools . ')(?=[\s/>])#i', ' $1=""', $part);
                        if ($replaced !== null) {
                            $parts[$i] = $replaced;
                        }
                    }
                }
                return implode('', $parts);
            }, $html) ?: $html;
        }
    }

    final class XMLDocument extends \DOMDocument
    {
        use CssSelectors;

        public function __construct()
        {
            parent::__construct();
            $this->registerNodeClass(\DOMElement::class, Element::class);
        }

        /**
         * Maps `\Dom\XMLDocument::createFromString()` onto `\DOMDocument::loadXML()`.
         * Like the native implementation, throws upon a malformed XML document.
         *
         * @return static
         */
        public static function createFromString(string $source, ?int $options = null, ?string $overrideEncoding = null)
        {
            $document = new self();
            /** @var \DOMDocument $document */
            if (@$document->loadXML($source, ($options ?? 0) | LIBXML_NOERROR | LIBXML_NOWARNING) !== true
                || $document->documentElement === null) {
                throw new \ValueError('Argument #1 ($source) must be a valid XML');
            }
            return $document;
        }
    }

    /**
     * On the legacy path, the parser never puts elements in any namespace,
     * so rewrite queries written for the namespaced PHP 8.4 parser (e.g. `xh:body//xh:img`).
     */
    final class XPath extends \DOMXPath
    {
        /** @var array<string, true> */
        private $registeredPrefixes = [];

        /**
         * @param string $prefix
         * @param string $namespaceURI
         */
        public function registerNamespace($prefix, $namespaceURI): bool
        {
            $this->registeredPrefixes[$prefix] = true;
            return parent::registerNamespace($prefix, $namespaceURI);
        }

        private function translate(string $expression): string
        {
            if ($this->registeredPrefixes === []) {
                return $expression;
            }
            foreach (array_keys($this->registeredPrefixes) as $prefix) {
                // NCName-boundary safe:
                $translated = preg_replace('/(?<![\\w.\\-])' . preg_quote($prefix, '/') . ':/', '', $expression);
                if ($translated !== null) {
                    $expression = $translated;
                }
            }
            return $expression;
        }

        /**
         * The native API throws upon an invalid expression, rather than returning `false`.
         *
         * @param string $expression
         * @param \DOMNode|null $contextNode
         */
        public function query($expression, $contextNode = null, $registerNodeNS = true): \DOMNodeList
        {
            $translated = $this->translate($expression);
            $result = @parent::query($translated, $contextNode, $registerNodeNS);
            if ($result === false) {
                throw new \Exception('Invalid XPath expression: ' . $translated);
            }
            return $result;
        }
    }
}

// phpcs:enable PSR1.Classes.ClassDeclaration.MultipleClasses
