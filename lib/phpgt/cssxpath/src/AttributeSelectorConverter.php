<?php

namespace GT\CssXPath;

class AttributeSelectorConverter {
	private const UPPER_CASE = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	private const LOWER_CASE = "abcdefghijklmnopqrstuvwxyz";

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

		[$valueString, $flag] = $this->extractValueAndFlag(
			(string)$detailValue["content"]
		);
		$equalsType = $detailType["content"];
		$expression->appendFragment(
			$this->buildExpression($attribute, $valueString, $equalsType, $flag)
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

		[$valueString, $flag] = $this->extractValueAndFlag(
			(string)$detailValue["content"]
		);
		$equalsType = $detailType["content"];
		$condition = $this->buildCondition($attribute, $valueString, $equalsType);
		return $this->applyCaseFlag($condition, $attribute, $flag);
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
		string $equalsType,
		?string $flag = null
	):string {
		$condition = $this->buildCondition($attribute, $value, $equalsType);
		$condition = $this->applyCaseFlag($condition, $attribute, $flag);
		return "[{$condition}]";
	}

	/**
	 * Splits an attribute selector's value from its trailing case flag, if
	 * present, e.g. `rel~="icon" i` represents the value "icon" matched with
	 * case-insensitivity.
	 * A case flag appears either directly after the closing quote of a quoted
	 * value, or separated by whitespace after an unquoted value.
	 * @param string $rawValue
	 * @return array{string, string|null} The attribute value and its case
	 *   flag, or null if there is no case flag
	 */
	private function extractValueAndFlag(string $rawValue):array {
		$patternQuoted = "/^(?<quote>['\"])(?<value>.*)(?P=quote)\s*"
			. "(?<flag>[is])\s*$/i";
		$patternUnquoted = '/^(?<value>.+\S)\s+(?<flag>[is])\s*$/i';

		if(preg_match($patternQuoted, $rawValue, $matches) === 1
			|| preg_match($patternUnquoted, $rawValue, $matches) === 1) {
			$flag = strtolower($matches["flag"]);
			$value = trim($matches["value"], " '\"");
			if($flag === "i") {
				$value = strtolower($value);
			}

			return [$value, $flag];
		}

		return [trim($rawValue, " '\""), null];
	}

	/**
	 * Rewrites the condition's attribute-name comparison to ignore case, using
	 * the XPath translate() function.
	 * @param string $condition
	 * @param string $attribute
	 * @param string|null $flag
	 * @return string
	 */
	private function applyCaseFlag(
		string $condition,
		string $attribute,
		?string $flag
	):string {
		if($flag === null || $flag === "s") {
			return $condition;
		}

		return str_replace(
			"@" . $attribute,
			"translate(@" . $attribute
			. ",\"" . self::UPPER_CASE . "\","
			. "\"" . self::LOWER_CASE . "\")",
			$condition
		);
	}
}
