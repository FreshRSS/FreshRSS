<?php

namespace Gt\CssXPath;

class PseudoSelectorConverter {
	/** @var array<int, string> */
	private const BOOLEAN_ATTRIBUTES = ["disabled", "checked", "selected"];
	private SelectorListSplitter $selectorListSplitter;
	private NotSelectorConditionBuilder $notSelectorConditionBuilder;
	private ?HasSelectorConditionBuilder $hasSelectorConditionBuilder;

	public function __construct(
		?SelectorListSplitter $selectorListSplitter = null,
		?NotSelectorConditionBuilder $notSelectorConditionBuilder = null,
		?HasSelectorConditionBuilder $hasSelectorConditionBuilder = null,
	) {
		$this->selectorListSplitter = $selectorListSplitter
			?? new SelectorListSplitter();
		$this->notSelectorConditionBuilder = $notSelectorConditionBuilder
			?? new NotSelectorConditionBuilder();
		$this->hasSelectorConditionBuilder = $hasSelectorConditionBuilder;
	}

	/**
	 * @param array<string, mixed> $token
	 * @param array<string, mixed>|null $next
	 */
	public function apply(
		array $token,
		?array $next,
		XPathExpression $expression,
		bool $htmlMode
	):void {
		$pseudo = $token["content"];
		$specifier = $this->extractSpecifier($next);

		if(in_array($pseudo, self::BOOLEAN_ATTRIBUTES, true)) {
			$expression->appendFragment("[@{$pseudo}]");
			return;
		}

		$handlers = [
			"text" => fn() => $this->applyText($expression),
			"contains" => fn() => $this->applyContains($expression, $specifier),
			"not" => fn() => $this->applyNot($expression, $specifier, $htmlMode),
			"has" => fn() => $this->applyHas($expression, $specifier, $htmlMode),
			"first-child" => fn() => $expression->prependToLast("*[1]/self::"),
			"nth-child" => fn() => $this->applyNthChild($expression, $specifier),
			"last-child" => fn() => $expression->prependToLast("*[last()]/self::"),
			"first-of-type" => fn() => $expression->appendFragment("[1]"),
			"nth-of-type" => fn() => $this->applyNthOfType($expression, $specifier),
			"last-of-type" => fn() => $expression->appendFragment("[last()]"),
		];

		$handler = $handlers[$pseudo] ?? null;
		if($handler !== null) {
			$handler();
		}
	}

	private function applyText(XPathExpression $expression):void {
		$expression->appendFragment('[@type="text"]');
	}

	private function applyContains(
		XPathExpression $expression,
		string $specifier
	):void {
		if($specifier === "") {
			return;
		}

		$expression->appendFragment("[contains(text(),{$specifier})]");
	}

	private function applyNthChild(
		XPathExpression $expression,
		string $specifier
	):void {
		if($specifier === "") {
			return;
		}

		if($expression->lastPartEndsWith("]")) {
			$replacement = " and position() = {$specifier}]";
			$expression->replaceInLast("]", $replacement);
			return;
		}

		$expression->appendFragment("[{$specifier}]");
	}

	private function applyNthOfType(
		XPathExpression $expression,
		string $specifier
	):void {
		if($specifier === "") {
			return;
		}

		$expression->appendFragment("[{$specifier}]");
	}

	private function applyNot(
		XPathExpression $expression,
		string $specifier,
		bool $htmlMode
	):void {
		$selectorList = $this->selectorListSplitter->split($specifier);
		if(empty($selectorList)) {
			return;
		}

		$conditions = [];
		foreach($selectorList as $selector) {
			$condition = $this->notSelectorConditionBuilder
				->build($selector, $htmlMode);
			if($condition === null) {
				return;
			}

			$conditions[] = $condition;
		}

		$combined = count($conditions) === 1
			? $conditions[0]
			: "(" . implode(" or ", $conditions) . ")";
		$expression->ensureElement();
		$expression->appendFragment("[not({$combined})]");
	}

	private function applyHas(
		XPathExpression $expression,
		string $specifier,
		bool $htmlMode
	):void {
		$condition = $this->getHasSelectorConditionBuilder()
			->build($specifier, $htmlMode);
		if($condition === null) {
			return;
		}

		$expression->ensureElement();
		$expression->appendFragment("[{$condition}]");
	}

	private function getHasSelectorConditionBuilder():HasSelectorConditionBuilder {
		return $this->hasSelectorConditionBuilder
			??= new HasSelectorConditionBuilder();
	}

	/** @param array<string, mixed>|null $next */
	private function extractSpecifier(?array $next):string {
		if(!$next || $next["type"] !== "pseudospecifier") {
			return "";
		}

		return (string)$next["content"];
	}
}
