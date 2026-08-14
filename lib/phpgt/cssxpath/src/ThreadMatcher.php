<?php

namespace Gt\CssXPath;

class ThreadMatcher {
	private CssSelectorLexer $cssSelectorLexer;

	public function __construct(
		?CssSelectorLexer $cssSelectorLexer = null
	) {
		$this->cssSelectorLexer = $cssSelectorLexer
			?? new CssSelectorLexer();
	}

	/** @return array<int, array<string, mixed>> */
	public function collate(
		string $regex,
		string $string,
		?callable $transform = null
	):array {
		if($regex === Translator::CSS_REGEX) {
			return $this->collateCssSelector($string, $transform);
		}

		preg_match_all(
			$regex,
			$string,
			$matches,
			PREG_PATTERN_ORDER
		);

		$set = $this->initialiseSet($matches[0]);

		foreach($matches as $key => $matchedGroup) {
			if(is_numeric($key)) {
				continue;
			}

			$this->collateGroup($set, $key, $matchedGroup, $transform);
		}

		return $set;
	}

	/** @return array<int, array<string, mixed>> */
	private function collateCssSelector(
		string $selector,
		?callable $transform
	):array {
		return $this->cssSelectorLexer->lex($selector, $transform);
	}

	/**
	 * @param array<int, string> $matches
	 * @return array<int, array<string, mixed>|null>
	 */
	private function initialiseSet(array $matches):array {
		$set = [];

		foreach($matches as $index => $value) {
			if($value !== "") {
				$set[$index] = null;
			}
		}

		return $set;
	}

	/**
	 * @param array<int, array<string, mixed>|null> $set
	 * @param array<int, string> $matchedGroup
	 */
	private function collateGroup(
		array &$set,
		string $groupKey,
		array $matchedGroup,
		?callable $transform
	):void {
		foreach($matchedGroup as $index => $match) {
			if($match === "") {
				continue;
			}

			$toSet = $this->buildMatchPayload($groupKey, $match, $transform);
			$this->appendMatch($set, $index, $toSet);
		}
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

	/**
	 * @param array<int, array<string, mixed>|null> $set
	 * @param array<string, string> $toSet
	 */
	private function appendMatch(array &$set, int $index, array $toSet):void {
		if(!isset($set[$index])) {
			$set[$index] = $toSet;
			return;
		}

		if(!isset($set[$index]["detail"])) {
			$set[$index]["detail"] = [];
		}

		$set[$index]["detail"][] = $toSet;
	}
}
