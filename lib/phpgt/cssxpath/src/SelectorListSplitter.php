<?php

namespace Gt\CssXPath;

class SelectorListSplitter {
	/** @return array<int, string> */
	public function split(string $selectorList):array {
		$selectorList = trim($selectorList);
		if($selectorList === "") {
			return [];
		}

		$parts = [];
		$current = "";
		$quote = null;
		$bracketDepth = 0;
		$parenDepth = 0;
		$length = strlen($selectorList);

		for($i = 0; $i < $length; $i++) {
			$char = $selectorList[$i];

			if($this->handleQuotedState($char, $current, $quote)) {
				continue;
			}

			if($this->openQuoteIfNeeded($char, $current, $quote)) {
				continue;
			}

			$this->trackDepth($char, $bracketDepth, $parenDepth);
			if($this->isTopLevelComma($char, $bracketDepth, $parenDepth)) {
				$this->appendCurrentPart($parts, $current);
				$current = "";
				continue;
			}

			$current .= $char;
		}

		$this->appendCurrentPart($parts, $current);
		return $parts;
	}

	private function handleQuotedState(
		string $char,
		string &$current,
		?string &$quote
	):bool {
		if($quote === null) {
			return false;
		}

		$current .= $char;
		if($char === $quote) {
			$quote = null;
		}

		return true;
	}

	private function openQuoteIfNeeded(
		string $char,
		string &$current,
		?string &$quote
	):bool {
		if($char !== "'" && $char !== '"') {
			return false;
		}

		$quote = $char;
		$current .= $char;
		return true;
	}

	private function trackDepth(
		string $char,
		int &$bracketDepth,
		int &$parenDepth
	):void {
		match($char) {
			"[" => $bracketDepth++,
			"]" => $bracketDepth = max(0, $bracketDepth - 1),
			"(" => $parenDepth++,
			")" => $parenDepth = max(0, $parenDepth - 1),
			default => null,
		};
	}

	private function isTopLevelComma(
		string $char,
		int $bracketDepth,
		int $parenDepth
	):bool {
		return $char === ","
			&& $bracketDepth === 0
			&& $parenDepth === 0;
	}

	/** @param array<int, string> $parts */
	private function appendCurrentPart(array &$parts, string $current):void {
		$trimmed = trim($current);
		if($trimmed !== "") {
			$parts[] = $trimmed;
		}
	}
}
