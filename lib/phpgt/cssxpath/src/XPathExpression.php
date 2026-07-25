<?php

namespace Gt\CssXPath;

class XPathExpression {
	/** @var array<int, string> */
	private array $parts;
	private bool $hasElement = false;

	public function __construct(string $prefix) {
		$this->parts = [$prefix];
	}

	public function appendElement(string $element, bool $htmlMode):void {
		$this->parts[] = $htmlMode ? strtolower($element) : $element;
		$this->hasElement = true;
	}

	public function ensureElement():void {
		if($this->hasElement) {
			return;
		}

		$this->parts[] = "*";
		$this->hasElement = true;
	}

	public function appendFragment(string $fragment):void {
		$this->parts[] = $fragment;
	}

	public function markElementMissing():void {
		$this->hasElement = false;
	}

	public function prependToLast(string $prefix):void {
		$index = count($this->parts) - 1;
		$this->parts[$index] = $prefix . $this->parts[$index];
	}

	public function replaceInLast(string $search, string $replace):void {
		$index = count($this->parts) - 1;
		$this->parts[$index] = str_replace($search, $replace, $this->parts[$index]);
	}

	public function lastPartEndsWith(string $suffix):bool {
		$index = count($this->parts) - 1;
		return substr($this->parts[$index], -strlen($suffix)) === $suffix;
	}

	public function toString():string {
		return implode("", $this->parts);
	}
}
