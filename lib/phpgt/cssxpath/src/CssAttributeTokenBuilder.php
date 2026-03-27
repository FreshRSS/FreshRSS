<?php

namespace Gt\CssXPath;

class CssAttributeTokenBuilder {
	/**
	 * @return array<string, mixed>
	 */
	public function build(string $content, ?callable $transform):array {
		$operatorData = $this->extractOperator($content);
		$token = $this->buildMatchPayload(
			"attribute",
			$operatorData["name"],
			$transform
		);

		if($operatorData["operator"] === null) {
			return $token;
		}

		$token["detail"] = [
			$this->buildMatchPayload(
				"attribute_equals",
				$operatorData["operator"],
				$transform
			),
			$this->buildMatchPayload(
				"attribute_value",
				$operatorData["value"],
				$transform
			),
		];
		return $token;
	}

	/**
	 * @return array{name: string, operator: string|null, value: string}
	 */
	private function extractOperator(string $content):array {
		$operators = ["~=", "$=", "|=", "^=", "*=", "="];
		$quote = null;
		$length = strlen($content);

		for($index = 0; $index < $length; $index++) {
			$char = $content[$index];
			if($quote !== null) {
				if($char === $quote) {
					$quote = null;
				}

				continue;
			}

			if($char === "'" || $char === '"') {
				$quote = $char;
				continue;
			}

			$matchedOperator = $this->matchOperator(
				$content,
				$index,
				$operators
			);
			if($matchedOperator === null) {
				continue;
			}

			return [
				"name" => trim(substr($content, 0, $index)),
				"operator" => $matchedOperator,
				"value" => trim(
					substr($content, $index + strlen($matchedOperator))
				),
			];
		}

		return [
			"name" => trim($content),
			"operator" => null,
			"value" => "",
		];
	}

	/**
	 * @param array<int, string> $operators
	 */
	private function matchOperator(
		string $content,
		int $index,
		array $operators
	):?string {
		foreach($operators as $operator) {
			if(substr($content, $index, strlen($operator)) === $operator) {
				return $operator;
			}
		}

		return null;
	}

	/** @return array<string, string> */
	private function buildMatchPayload(
		string $groupKey,
		string $match,
		?callable $transform
	):array {
		if($transform) {
			return $transform($groupKey, $match);
		}

		return ["type" => $groupKey, "content" => $match];
	}
}
