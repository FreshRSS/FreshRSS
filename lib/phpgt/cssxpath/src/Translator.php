<?php /** @noinspection HtmlDeprecatedTag */
namespace Gt\CssXPath;

class Translator {
	const cssRegex =
		'/'
		. '(?P<star>\*)'
		. '|(:(?P<pseudo>[\w-]*))'
		. '|\(*(?P<pseudospecifier>["\']*[\w\h-]*["\']*)\)'
		. '|(?P<element>[\w-]*)'
		. '|(?P<child>\s*>\s*)'
		. '|(#(?P<id>[\w-]*))'
		. '|(\.(?P<class>[\w-]*))'
		. '|(?P<sibling>\s*\+\s*)'
		. '|(?P<subsequentsibling>\s*~\s*)'
		. "|(\[(?P<attribute>[\w-]*)((?P<attribute_equals>[=~$|^*]+)(?P<attribute_value>(.+\[\]'?)|[^\]]+))*\])+"
		. '|(?P<descendant>\s+)'
		. '/';

	const EQUALS_EXACT = "=";
	const EQUALS_CONTAINS_WORD = "~=";
	const EQUALS_ENDS_WITH = "$=";
	const EQUALS_CONTAINS = "*=";
	const EQUALS_OR_STARTS_WITH_HYPHENATED = "|=";
	const EQUALS_STARTS_WITH = "^=";

	public function __construct(
			protected string $cssSelector,
			protected string $prefix = ".//",
			protected bool $htmlMode = true
		) {
	}

	public function __toString():string {
		return $this->asXPath();
	}

	public function asXPath():string {
		return $this->convert($this->cssSelector);
	}

	protected function convert(string $css):string {
		$cssArray = preg_split(
			'/(["\']).*?\1(*SKIP)(*F)|,/',
			$css
		);
		$xPathArray = [];

		foreach($cssArray as $input) {
			$output = $this->convertSingleSelector(trim($input));
			$xPathArray []= $output;
		}

		return implode(" | ", $xPathArray);
	}

	protected function convertSingleSelector(string $css):string {
		$thread = $this->preg_match_collated(self::cssRegex, $css);
		$thread = array_values($thread);

		$xpath = [$this->prefix];
		$hasElement = false;
		foreach($thread as $threadKey => $currentThreadItem) {
			$next = isset($thread[$threadKey + 1])
				? $thread[$threadKey + 1]
				: false;

			switch ($currentThreadItem["type"]) {
			case "star":
			case "element":
				if($this->htmlMode) {
					$xpath []= strtolower($currentThreadItem['content']);
				} else {
					$xpath []= $currentThreadItem['content'];
				}
				$hasElement = true;
				break;

			case "pseudo":
				$specifier = "";
				if ($next && $next["type"] == "pseudospecifier") {
					$specifier = "{$next['content']}";
				}

				switch ($currentThreadItem["content"]) {
				case "disabled":
				case "checked":
				case "selected":
					array_push(
						$xpath,
						"[@{$currentThreadItem['content']}]"
					);
					break;

				case "text":
					array_push(
						$xpath,
						'[@type="text"]'
					);
					break;

				case "contains":
					if(empty($specifier)) {
						continue 3;
					}

					array_push(
						$xpath,
						"[contains(text(),$specifier)]"
					);
					break;

				case "first-child":
					$prev = count($xpath) - 1;
					$xpath[$prev] = '*[1]/self::' . $xpath[$prev];
					break;

				case "nth-child":
					if (empty($specifier)) {
						continue 3;
					}

					$prev = count($xpath) - 1;
					$previous = $xpath[$prev];

					if (substr($previous, -1, 1) === "]") {
						$xpath[$prev] = str_replace(
							"]",
							" and position() = $specifier]",
							$xpath[$prev]
						);
					}
					else {
						array_push(
							$xpath,
							"[$specifier]"
						);
					}
					break;

				case "last-child":
					$prev = count($xpath) - 1;
					$xpath[$prev] = '*[last()]/self::' . $xpath[$prev];
					break;

				case 'first-of-type':
					$prev = count($xpath) - 1;
					$previous = $xpath[$prev];

					if(substr($previous, -1, 1) === "]") {
						array_push(
							$xpath,
							"[1]"
						);
					}
					else {
						array_push(
							$xpath,
							"[1]"
						);
					}
					break;

				case "nth-of-type":
					if (empty($specifier)) {
						continue 3;
					}

					$prev = count($xpath) - 1;
					$previous = $xpath[$prev];

					if(substr($previous, -1, 1) === "]") {
						array_push(
							$xpath,
							"[$specifier]"
						);
					}
					else {
						array_push(
							$xpath,
							"[$specifier]"
						);
					}
					break;

				case "last-of-type":
					$prev = count($xpath) - 1;
					$previous = $xpath[$prev];

					if(substr($previous, -1, 1) === "]") {
						array_push(
							$xpath,
							"[last()]"
						);
					}
					else {
						array_push(
							$xpath,
							"[last()]"
						);
					}
					break;

				}
				break;

			case "child":
				array_push($xpath, "/");
				$hasElement = false;
				break;

			case "id":
				array_push(
					$xpath,
					($hasElement ? '' : '*')
					. "[@id='{$currentThreadItem['content']}']"
				);
				$hasElement = true;
				break;

			case "class":
				// https://devhints.io/xpath#class-check
				array_push(
					$xpath,
					($hasElement ? '' : '*')
					. "[contains(concat(' ',normalize-space(@class),' '),' {$currentThreadItem['content']} ')]"
				);
				$hasElement = true;
				break;

			case "sibling":
				array_push(
					$xpath,
					"/following-sibling::*[1]/self::"
				);
				$hasElement = false;
				break;

			case "subsequentsibling":
				array_push(
					$xpath,
					"/following-sibling::"
				);
				$hasElement = false;
				break;

			case "attribute":
				if(!$hasElement) {
					array_push($xpath, "*");
					$hasElement = true;
				}

				if($this->htmlMode) {
					$currentThreadItem['content'] = strtolower($currentThreadItem['content']);
				}

				/** @var null|array<int, array<string, string>> $detail */
				$detail = $currentThreadItem["detail"] ?? null;
				$detailType = $detail[0] ?? null;
				$detailValue = $detail[1] ?? null;

				if(!$detailType
				|| $detailType["type"] !== "attribute_equals") {
					array_push(
						$xpath,
						"[@{$currentThreadItem['content']}]"
					);
					continue 2;
				}

				$valueString = trim(
					$detailValue["content"],
					" '\""
				);

				$equalsType = $detailType["content"];
				switch ($equalsType) {
				case self::EQUALS_EXACT:
					array_push(
						$xpath,
						"[@{$currentThreadItem['content']}=\"{$valueString}\"]"
					);
					break;

				case self::EQUALS_CONTAINS:
					array_push(
						$xpath,
						"[contains(@{$currentThreadItem['content']},\"{$valueString}\")]"
					);
					break;

				case self::EQUALS_CONTAINS_WORD:
					array_push(
						$xpath,
						"["
						. "contains("
						. "concat(\" \",@{$currentThreadItem['content']},\" \"),"
						. "concat(\" \",\"{$valueString}\",\" \")"
						. ")"
						. "]"
					);
					break;

				case self::EQUALS_OR_STARTS_WITH_HYPHENATED:
					array_push(
						$xpath,
						"["
						. "@{$currentThreadItem['content']}=\"{$valueString}\" or "
						. "starts-with(@{$currentThreadItem['content']}, \"{$valueString}-\")"
						. "]"
					);
					break;

				case self::EQUALS_STARTS_WITH:
					array_push(
						$xpath,
						"[starts-with("
						. "@{$currentThreadItem['content']}, \"{$valueString}\""
						. ")]"
					);
					break;

				case self::EQUALS_ENDS_WITH:
					array_push(
						$xpath,
						"["
						. "substring("
						. "@{$currentThreadItem['content']},"
						. "string-length(@{$currentThreadItem['content']}) - "
						. "string-length(\"{$valueString}\") + 1)"
						. "=\"{$valueString}\""
						. "]"
					);
					break;
				}
				break;

			case "descendant":
				array_push($xpath, "//");
				$hasElement = false;
				break;
			}
		}

		return implode("", $xpath);
	}

	/** @return array<int, array<string, string>> */
	protected function preg_match_collated(
		string $regex,
		string $string,
		?callable $transform = null
	):array {
		preg_match_all(
			$regex,
			$string,
			$matches,
			PREG_PATTERN_ORDER
		);

		$set = [];
		foreach($matches[0] as $k => $v) {
			if(!empty($v)) {
				$set[$k] = null;
			}
		}

		foreach($matches as $k => $m) {
			if(is_numeric($k)) {
				continue;
			}

			foreach($m as $i => $match) {
				if($match === "") {
					continue;
				}

				$toSet = null;

				if($transform) {
					$toSet = $transform($k, $match);
				}
				else {
					$toSet = ["type" => $k, "content" => $match];
				}

				if(!isset($set[$i])) {
					$set[$i] = $toSet;
				}
				else {
					if(!isset($set[$i]["detail"])) {
						$set[$i]["detail"] = [];
					}

					array_push($set[$i]["detail"], $toSet);
				}
			}
		}

		return $set;
	}
}
