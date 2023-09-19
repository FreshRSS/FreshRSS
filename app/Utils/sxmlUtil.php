<?php

//https://stackoverflow.com/a/20511976

class FreshRSS_sxml_Util extends SimpleXMLElement
{

	/**
	 * Adds a child with $value inside CDATA
	 * @param string $name
	 * @param string $value
	 */
	public function addChildWithCDATA(string $name, string $value) {
		$new_child = $this->addChild($name);

		if ($new_child !== null) {
			$node = dom_import_simplexml($new_child);
			$no   = $node->ownerDocument;
			$node->appendChild($no->createCDATASection($value));
		}

		return $new_child;
	}
}
