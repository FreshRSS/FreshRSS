<?php

namespace Gt\CssXPath;

class Translator {
	public const CSS_REGEX =
		'/'
		. '(?P<star>\*)'
		. '|(:(?P<pseudo>[\w-]*))'
		. '|\((?P<pseudospecifier>[^)]*)\)'
		. '|(?P<element>[\w-]*)'
		. '|(?P<child>\s*>\s*)'
		. '|(#(?P<id>[\w-]*))'
		. '|(\.(?P<class>[\w-]*))'
		. '|(?P<sibling>\s*\+\s*)'
		. '|(?P<subsequentsibling>\s*~\s*)'
		. "|(\[(?P<attribute>[\w-]*)((?P<attribute_equals>[=~$|^*]+)"
		. "(?P<attribute_value>(.+\[\]'?)|[^\]]+))*\])+"
		. '|(?P<descendant>\s+)'
		. '/';

	public const EQUALS_EXACT = "=";
	public const EQUALS_CONTAINS_WORD = "~=";
	public const EQUALS_ENDS_WITH = "$=";
	public const EQUALS_CONTAINS = "*=";
	public const EQUALS_OR_STARTS_WITH_HYPHENATED = "|=";
	public const EQUALS_STARTS_WITH = "^=";

	private SingleSelectorConverter $singleSelectorConverter;
	private SelectorListSplitter $selectorListSplitter;

	public function __construct(
		protected string $cssSelector,
		protected string $prefix = ".//",
		protected bool $htmlMode = true,
		?SingleSelectorConverter $singleSelectorConverter = null,
		?SelectorListSplitter $selectorListSplitter = null,
	) {
		$this->singleSelectorConverter = $singleSelectorConverter
			?? new SingleSelectorConverter();
		$this->selectorListSplitter = $selectorListSplitter
			?? new SelectorListSplitter();
	}

	public function __toString():string {
		return $this->convert($this->cssSelector);
	}

	// phpcs:disable Generic.NamingConventions.CamelCapsFunctionName
	public function asXPath():string {
		return $this->convert($this->cssSelector);
	}
	// phpcs:enable

	protected function convert(string $css):string {
		$cssArray = $this->selectorListSplitter->split($css);
		$xPathArray = [];

		foreach($cssArray as $input) {
			$xPathArray[] = $this->convertSingleSelector(trim($input));
		}

		return implode(" | ", $xPathArray);
	}

	protected function convertSingleSelector(string $css):string {
		return $this->singleSelectorConverter->convert(
			$css,
			$this->prefix,
			$this->htmlMode
		);
	}
}
