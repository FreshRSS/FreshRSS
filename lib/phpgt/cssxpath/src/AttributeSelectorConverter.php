<?php

namespace Gt\CssXPath;

class AttributeSelectorConverter {
	/** @param array<string, mixed> $token */
	public function apply(
		array $token,
		XPathExpression $expression,
		bool $htmlMode
	):void {
		$expression->ensureElement();

		$attribute = (string)$token["content"];
		if($htmlMode) {
			$attribute = strtolower($attribute);
		}

		$detail = $token["detail"] ?? null;
		$detailType = $detail[0] ?? null;
		$detailValue = $detail[1] ?? null;

		if(!$this->hasEqualsType($detailType)) {
			$expression->appendFragment("[@{$attribute}]");
			return;
		}

		$valueString = trim((string)$detailValue["content"], " '\"");
		$equalsType = $detailType["content"];
		$expression->appendFragment(
			$this->buildExpression($attribute, $valueString, $equalsType)
		);
	}

	/** @param array<string, mixed> $token */
	public function buildConditionFromToken(array $token, bool $htmlMode):string {
		$parts = $this->extractTokenParts($token, $htmlMode);
		return $this->buildConditionFromParts(
			$parts["attribute"],
			$parts["detailType"],
			$parts["detailValue"],
		);
	}

	/**
	 * @param array<string, mixed>|null $detailType
	 * @param array<string, mixed>|null $detailValue
	 */
	private function buildConditionFromParts(
		string $attribute,
		?array $detailType,
		?array $detailValue,
	):string {
		if(!$this->hasEqualsType($detailType)) {
			return "@{$attribute}";
		}

		$valueString = trim((string)$detailValue["content"], " '\"");
		$equalsType = $detailType["content"];
		return $this->buildCondition($attribute, $valueString, $equalsType);
	}

	/**
	 * @param array<string, mixed> $token
	 * @return array{
	 *   attribute: string,
	 *   detailType: array<string, mixed>|null,
	 *   detailValue: array<string, mixed>|null
	 * }
	 */
	private function extractTokenParts(array $token, bool $htmlMode):array {
		$attribute = (string)$token["content"];
		if($htmlMode) {
			$attribute = strtolower($attribute);
		}

		$detail = $token["detail"] ?? null;
		return [
			"attribute" => $attribute,
			"detailType" => $detail[0] ?? null,
			"detailValue" => $detail[1] ?? null,
		];
	}

	/** @param array<string, mixed>|null $detailType */
	private function hasEqualsType(?array $detailType):bool {
		return isset($detailType["type"])
			&& $detailType["type"] === "attribute_equals";
	}

	private function buildCondition(
		string $attribute,
		string $value,
		string $equalsType
	):string {
		return match($equalsType) {
			Translator::EQUALS_EXACT => "@{$attribute}=\"{$value}\"",
			Translator::EQUALS_CONTAINS => "contains(@{$attribute},\"{$value}\")",
			Translator::EQUALS_CONTAINS_WORD => ""
				. "contains(concat(\" \",@{$attribute},\" \"),"
				. "concat(\" \",\"{$value}\",\" \"))"
				. "",
			Translator::EQUALS_OR_STARTS_WITH_HYPHENATED => ""
				. "@{$attribute}=\"{$value}\" or "
				. "starts-with(@{$attribute}, \"{$value}-\")"
				. "",
			Translator::EQUALS_STARTS_WITH => ""
				. "starts-with(@{$attribute}, \"{$value}\")"
				. "",
				Translator::EQUALS_ENDS_WITH => ""
				. "substring(@{$attribute},"
				. "string-length(@{$attribute}) - "
				. "string-length(\"{$value}\") + 1)"
				. "=\"{$value}\""
				. "",
			default => "@{$attribute}",
		};
	}

	private function buildExpression(
		string $attribute,
		string $value,
		string $equalsType
	):string {
		return "[" . $this->buildCondition($attribute, $value, $equalsType) . "]";
	}
}
