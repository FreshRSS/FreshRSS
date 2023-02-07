<?php
declare(strict_types=1);

class JsonServiceTest extends PHPUnit\Framework\TestCase {

	/**
	 * @dataProvider provideJsonToXml
	 * @param string|false $xmlOutput
	 */
	public function test__json_to_xml(string $jsonInput, $xmlOutput): void {
		$xml = FreshRSS_Json_Service::json_to_xml($jsonInput);
		$this->assertEquals($xmlOutput, $xml);
	}

	/**
	 * @return array<array<string|false>>
	 */
	public function provideJsonToXml() {

		yield [ '', '' ];

		yield [ 'invalid', false ];

		$json = <<<'JSON'
{
	"a": [2, 3],
	"b": 4.5,
	"c": true,
	"d": "test",
	"e": {
		"e1": false,
		"e2": null
	}
}
JSON;

		$xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<object>
  <value key="a">
    <array>
      <number>2</number>
      <number>3</number>
    </array>
  </value>
  <value key="b">
    <number>4.5</number>
  </value>
  <value key="c">
    <true/>
  </value>
  <value key="d">
    <string>test</string>
  </value>
  <value key="e">
    <object>
      <value key="e1">
        <false/>
      </value>
      <value key="e2">
        <null/>
      </value>
    </object>
  </value>
</object>

XML;

		yield [ $json, $xml];

		$json = <<<'JSON'
[
	{
		"title": "Item1",
		"body": "Hello"
	},
	{
		"title": "Item2",
		"body": "World"
	}
]
JSON;

		$xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<array>
  <object>
    <value key="title">
      <string>Item1</string>
    </value>
    <value key="body">
      <string>Hello</string>
    </value>
  </object>
  <object>
    <value key="title">
      <string>Item2</string>
    </value>
    <value key="body">
      <string>World</string>
    </value>
  </object>
</array>

XML;

		yield [ $json, $xml ];

		$xml = <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<null/>

XML;

		yield [ 'null', $xml ];

	}

}
