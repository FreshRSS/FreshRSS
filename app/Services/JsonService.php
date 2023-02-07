<?php

if (!function_exists('array_is_list')) {
	/**
	 * Polyfill for PHP <8.1
	 * @param array<mixed> $array
	 */
	function array_is_list(array $array): bool {
		$keys = array_keys($array);
		return array_keys($keys) === $keys;
	}
}

final class FreshRSS_Json_Service {

	private static function element_to_xml(DOMNode $parent, mixed $element): bool {
		$ownerDocument = $parent instanceof DOMDocument ? $parent : $parent->ownerDocument;
		if ($ownerDocument === null) {
			return false;
		}

		if ($element === true) {
			$parent->appendChild($ownerDocument->createElement('true'));
		} elseif ($element === false) {
			$parent->appendChild($ownerDocument->createElement('false'));
		} elseif ($element === null) {
			$parent->appendChild($ownerDocument->createElement('null'));
		} elseif (is_string($element)) {
			$parent->appendChild($ownerDocument->createElement('string', $element));
		} elseif (is_int($element) || is_float($element)) {
			$parent->appendChild($ownerDocument->createElement('number', json_encode($element) ?: ''));
		} elseif (is_array($element)) {
			if (array_is_list($element)) {
				$array = $ownerDocument->createElement('array');
				$parent->appendChild($array);
				foreach ($element as $value) {
					if (!self::element_to_xml($array, $value)) {
						return false;
					}
				}
			} else {
				$object = $ownerDocument->createElement('object');
				$parent->appendChild($object);
				foreach ($element as $k => $v) {
					$value = $ownerDocument->createElement('value');
					$value->setAttribute('key', $k);
					$object->appendChild($value);
					if (!self::element_to_xml($value, $v)) {
						return false;
					}
				}
			}
		}
		return true;
	}

	/** @return string|false an XML string, or an empty string in case of empty input, or false in the case of invalid JSON input */
	public static function json_to_xml(string $json) {
		if (is_string($json) && trim($json) === '') {
			return '';
		}
		$element = json_decode($json, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			return false;
		}
		$dom = new DOMDocument('1.0', 'UTF-8');
		if (!self::element_to_xml($dom, $element)) {
			return false;
		}
		$dom->formatOutput = true;
		return $dom->saveXML();
	}
}
