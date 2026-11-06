<?php
// PHPStan symbol stubs for the PHP 8.4+ \Dom HTML5 parser (phpVersion min < 8.4 hides the real ones).
// Never executed; registered via scanFiles in phpstan.dist.neon.

namespace Dom;

class Node {}

const HTML_NO_DEFAULT_NS = 2147483648;

class HTMLDocument {
	public static function createFromString(string $source, int $options = 0, ?string $overrideEncoding = null): HTMLDocument {}
}

class Element extends Node {
	public function getAttribute(string $qualifiedName): ?string {}
}

class XPath {
	public function __construct(HTMLDocument $document) {}
	/** @return \Dom\NodeList<\Dom\Node> */
	public function query(string $expression, ?Node $contextNode = null, bool $registerNodeNS = true): NodeList {}
}

/**
 * @template-covariant TNode of Node
 * @implements \IteratorAggregate<int, TNode>
 */
class NodeList implements \IteratorAggregate, \Countable {
	public function count(): int {}
	/** @return \Iterator<int, TNode> */
	public function getIterator(): \Iterator {}
	/** @return TNode|null */
	public function item(int $index): ?Node {}
}
