<?php

namespace Gt\CssXPath;

class HasSelectorConditionBuilder {
	private SelectorListSplitter $selectorListSplitter;
	private SingleSelectorConverter $singleSelectorConverter;

	public function __construct(
		?SelectorListSplitter $selectorListSplitter = null,
		?SingleSelectorConverter $singleSelectorConverter = null,
	) {
		$this->selectorListSplitter = $selectorListSplitter
			?? new SelectorListSplitter();
		$this->singleSelectorConverter = $singleSelectorConverter
			?? new SingleSelectorConverter();
	}

	public function build(string $selectorList, bool $htmlMode):?string {
		$selectorList = trim($selectorList);
		if($selectorList === "") {
			return null;
		}

		$this->assertSupported($selectorList);

		$selectors = $this->selectorListSplitter->split($selectorList);
		if(empty($selectors)) {
			return null;
		}

		$conditions = [];
		foreach($selectors as $selector) {
			$conditions[] = $this->buildCondition(trim($selector), $htmlMode);
		}

		if(count($conditions) === 1) {
			return $conditions[0];
		}

		$wrappedConditions = array_map(
			fn(string $condition):string => "({$condition})",
			$conditions
		);
		return implode(" or ", $wrappedConditions);
	}

	private function buildCondition(string $selector, bool $htmlMode):string {
		$prefix = str_starts_with($selector, ">")
			|| str_starts_with($selector, "+")
			|| str_starts_with($selector, "~")
			? "."
			: ".//";

		return $this->singleSelectorConverter->convert(
			$selector,
			$prefix,
			$htmlMode
		);
	}

	private function assertSupported(string $selectorList):void {
		if(preg_match('/(^|[^[:alnum:]_-]):has\s*\(/', $selectorList) === 1) {
			throw new NotYetImplementedException(
				"Nested :has selector functionality is deferred"
			);
		}

		if(str_contains($selectorList, "::")) {
			throw new NotYetImplementedException(
				"Pseudo-element :has selector functionality is deferred"
			);
		}

		if(preg_match('/:nth-child\([^)]*\bof\b/', $selectorList) === 1) {
			throw new NotYetImplementedException(
				"':nth-child(of S)' in :has selector functionality is deferred"
			);
		}
	}
}
