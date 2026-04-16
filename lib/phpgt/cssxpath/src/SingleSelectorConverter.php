<?php

namespace Gt\CssXPath;

class SingleSelectorConverter {
	private ThreadMatcher $threadMatcher;
	private PseudoSelectorConverter $pseudoSelectorConverter;
	private AttributeSelectorConverter $attributeSelectorConverter;

	public function __construct(
		?ThreadMatcher $threadMatcher = null,
		?PseudoSelectorConverter $pseudoSelectorConverter = null,
		?AttributeSelectorConverter $attributeSelectorConverter = null,
	) {
		$this->threadMatcher = $threadMatcher ?? new ThreadMatcher();
		$this->pseudoSelectorConverter = $pseudoSelectorConverter
			?? new PseudoSelectorConverter();
		$this->attributeSelectorConverter = $attributeSelectorConverter
			?? new AttributeSelectorConverter();
	}

	public function convert(
		string $css,
		string $prefix,
		bool $htmlMode
	):string {
		$thread = array_values(
			array_filter(
				$this->threadMatcher->collate(Translator::CSS_REGEX, $css)
			)
		);
		$expression = new XPathExpression($prefix);

		foreach($thread as $index => $token) {
			$next = $thread[$index + 1] ?? null;
			$this->applyToken($token, $next, $expression, $htmlMode);
		}

		return $expression->toString();
	}

	/**
	 * @param array<string, mixed> $token
	 * @param array<string, mixed>|null $next
	 */
	private function applyToken(
		array $token,
		?array $next,
		XPathExpression $expression,
		bool $htmlMode
	):void {
		$handlers = [
			"star" => fn() => $expression
				->appendElement((string)$token["content"], $htmlMode),
				"element" => fn() => $expression
					->appendElement((string)$token["content"], $htmlMode),
				"pseudo" => fn() => $this->pseudoSelectorConverter
					->apply($token, $next, $expression, $htmlMode),
				"child" => fn() => $this->appendAxis($expression, "/"),
			"id" => fn() => $this->appendId($expression, (string)$token["content"]),
			"class" => fn() => $this
				->appendClass($expression, (string)$token["content"]),
			"sibling" => fn() => $this->appendAxis(
				$expression,
				"/following-sibling::*[1]/self::"
			),
			"subsequentsibling" => fn() => $this->appendAxis(
				$expression,
				"/following-sibling::"
			),
			"attribute" => fn() => $this->attributeSelectorConverter
				->apply($token, $expression, $htmlMode),
			"descendant" => fn() => $this->appendAxis($expression, "//"),
		];

		$handler = $handlers[$token["type"]] ?? null;
		if($handler !== null) {
			$handler();
		}
	}

	private function appendAxis(XPathExpression $expression, string $axis):void {
		$expression->appendFragment($axis);
		$expression->markElementMissing();
	}

	private function appendId(
		XPathExpression $expression,
		string $identifier
	):void {
		$expression->ensureElement();
		$expression->appendFragment("[@id='{$identifier}']");
	}

	private function appendClass(
		XPathExpression $expression,
		string $className
	):void {
		$expression->ensureElement();
		$expression->appendFragment(
			"[contains(concat(' ',normalize-space(@class),' '),' {$className} ')]"
		);
	}
}
