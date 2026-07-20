<?php

namespace Gt\CssXPath;

class CssSelectorLexer {
	private CssAttributeTokenBuilder $attributeTokenBuilder;

	public function __construct(
		?CssAttributeTokenBuilder $attributeTokenBuilder = null
	) {
		$this->attributeTokenBuilder = $attributeTokenBuilder
			?? new CssAttributeTokenBuilder();
	}

	/** @return array<int, array<string, mixed>> */
	public function lex(string $selector, ?callable $transform):array {
		$tokens = [];
		$length = strlen($selector);

		for($index = 0; $index < $length;) {
			$char = $selector[$index];

			if(ctype_space($char)) {
				$index = $this->consumeWhitespace(
					$selector,
					$index,
					$tokens,
					$transform
				);
				continue;
			}

			$index = $this->consumeToken(
				$selector,
				$index,
				$char,
				$tokens,
				$transform
			);
		}

		return $tokens;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeToken(
		string $selector,
		int $index,
		string $char,
		array &$tokens,
		?callable $transform
	):int {
		return match($char) {
			"*" => $this->consumeSimpleToken("star", "*", $index, $tokens, $transform),
			">" => $this->consumeSimpleToken("child", ">", $index, $tokens, $transform),
			"+" => $this->consumeSimpleToken(
				"sibling",
				"+",
				$index,
				$tokens,
				$transform
			),
			"~" => $this->consumeSimpleToken(
				"subsequentsibling",
				"~",
				$index,
				$tokens,
				$transform
			),
			"#" => $this->consumeIdentifierToken(
				"id",
				$selector,
				$index + 1,
				$tokens,
				$transform
			),
			"." => $this->consumeIdentifierToken(
				"class",
				$selector,
				$index + 1,
				$tokens,
				$transform
			),
			":" => $this->consumePseudoToken($selector, $index, $tokens, $transform),
			"[" => $this->consumeAttributeToken($selector, $index, $tokens, $transform),
			default => $this->consumeDefaultToken(
				$selector,
				$index,
				$char,
				$tokens,
				$transform
			),
		};
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeSimpleToken(
		string $type,
		string $content,
		int $index,
		array &$tokens,
		?callable $transform
	):int {
		$tokens[] = $this->buildMatchPayload($type, $content, $transform);
		return $index + 1;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeIdentifierToken(
		string $type,
		string $selector,
		int $index,
		array &$tokens,
		?callable $transform
	):int {
		[$identifier, $nextIndex] = $this->readIdentifier($selector, $index);
		$tokens[] = $this->buildMatchPayload($type, $identifier, $transform);
		return $nextIndex;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumePseudoToken(
		string $selector,
		int $index,
		array &$tokens,
		?callable $transform
	):int {
		[$pseudoTokens, $nextIndex] = $this->readPseudo(
			$selector,
			$index,
			$transform
		);
		array_push($tokens, ...$pseudoTokens);
		return $nextIndex;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeAttributeToken(
		string $selector,
		int $index,
		array &$tokens,
		?callable $transform
	):int {
		[$attributeToken, $nextIndex] = $this->readAttribute(
			$selector,
			$index,
			$transform
		);
		$tokens[] = $attributeToken;
		return $nextIndex;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeDefaultToken(
		string $selector,
		int $index,
		string $char,
		array &$tokens,
		?callable $transform
	):int {
		if(!$this->isIdentifierCharacter($char)) {
			return $index + 1;
		}

		return $this->consumeIdentifierToken(
			"element",
			$selector,
			$index,
			$tokens,
			$transform
		);
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function consumeWhitespace(
		string $selector,
		int $index,
		array &$tokens,
		?callable $transform
	):int {
		$length = strlen($selector);
		$nextIndex = $index;
		while($nextIndex < $length && ctype_space($selector[$nextIndex])) {
			$nextIndex++;
		}

		if($this->shouldEmitDescendantToken($selector, $tokens, $nextIndex)) {
			$tokens[] = $this->buildMatchPayload("descendant", " ", $transform);
		}

		return $nextIndex;
	}

	/**
	 * @param array<int, array<string, mixed>> $tokens
	 */
	private function shouldEmitDescendantToken(
		string $selector,
		array $tokens,
		int $nextIndex
	):bool {
		if(empty($tokens) || !isset($selector[$nextIndex])) {
			return false;
		}

		$nextChar = $selector[$nextIndex];
		if(in_array($nextChar, [">", "+", "~", ",", ")"], true)) {
			return false;
		}

		$previousType = (string)$tokens[array_key_last($tokens)]["type"];
		return !in_array($previousType, [
			"child",
			"sibling",
			"subsequentsibling",
			"descendant",
		], true);
	}

	/** @return array{0: string, 1: int} */
	private function readIdentifier(string $selector, int $index):array {
		$length = strlen($selector);
		$identifier = "";

		while($index < $length && $this->isIdentifierCharacter($selector[$index])) {
			$identifier .= $selector[$index];
			$index++;
		}

		return [$identifier, $index];
	}

	/**
	 * @return array{0: array<int, array<string, mixed>>, 1: int}
	 */
	private function readPseudo(
		string $selector,
		int $index,
		?callable $transform
	):array {
		$tokens = [];
		$isPseudoElement = isset($selector[$index + 1])
			&& $selector[$index + 1] === ":";
		$nameStart = $index + ($isPseudoElement ? 2 : 1);
		[$name, $nextIndex] = $this->readIdentifier($selector, $nameStart);

		$tokens[] = $this->buildMatchPayload(
			$isPseudoElement ? "pseudo-element" : "pseudo",
			$name,
			$transform
		);

		if(isset($selector[$nextIndex]) && $selector[$nextIndex] === "(") {
			[$content, $nextIndex] = $this->readBalancedContent(
				$selector,
				$nextIndex,
				"(",
				")"
			);
			$tokens[] = $this->buildMatchPayload(
				"pseudospecifier",
				$content,
				$transform
			);
		}

		return [$tokens, $nextIndex];
	}

	/**
	 * @return array{0: array<string, mixed>, 1: int}
	 */
	private function readAttribute(
		string $selector,
		int $index,
		?callable $transform
	):array {
		[$content, $nextIndex] = $this->readBalancedContent(
			$selector,
			$index,
			"[",
			"]"
		);
		return [
			$this->attributeTokenBuilder->build($content, $transform),
			$nextIndex,
		];
	}

	/** @return array{0: string, 1: int} */
	private function readBalancedContent(
		string $selector,
		int $startIndex,
		string $open,
		string $close
	):array {
		$length = strlen($selector);
		$depth = 1;
		$content = "";
		$quote = null;

		for($index = $startIndex + 1; $index < $length; $index++) {
			$char = $selector[$index];

			if($quote !== null) {
				$content .= $char;
				if($char === $quote) {
					$quote = null;
				}
				continue;
			}

			if($char === "'" || $char === '"') {
				$quote = $char;
				$content .= $char;
				continue;
			}

			if($char === $open) {
				$depth++;
				$content .= $char;
				continue;
			}

			if($char === $close) {
				$depth--;
				if($depth === 0) {
					return [$content, $index + 1];
				}

				$content .= $char;
				continue;
			}

			$content .= $char;
		}

		return [$content, $length];
	}

	private function isIdentifierCharacter(string $char):bool {
		return preg_match('/[\w-]/', $char) === 1;
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
