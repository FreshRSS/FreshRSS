<?php

class TitleRewritingHandlerTest extends PHPUnit\Framework\TestCase {
	/**
	 * @dataProvider provideValidTemplate
	 */
	public function test__construct_whenValidTemplate_storeRule($template, $rule) {
		$handler = new FreshRSS_TitleRewriting_Handler($template);
		$reflectionClass = new ReflectionClass($handler);
		$property = $reflectionClass->getProperty('rule');
		$property->setAccessible(true);
		$this->assertEquals($rule, $property->getValue($handler));
	}

	public function provideValidTemplate() {
		yield 'no rule' => [
			'',
			[],
		];
		yield 'simple string' => [
			'hello',
			[
				'hello',
			],
		];
		yield 'string containing pipe' => [
			'hello | world',
			[
				'hello | world',
			],
		];
		yield 'string containing opening parenthesis' => [
			'hello ( world',
			[
				'hello ( world',
			],
		];
		yield 'string containing closing parenthesis' => [
			'hello ) world',
			[
				'hello ) world',
			],
		];
		yield 'string containing comma' => [
			'hello , world',
			[
				'hello , world',
			],
		];
		yield 'string containing quote' => [
			'hello " world',
			[
				'hello " world',
			],
		];
		yield 'string containing single curly braces' => [
			'hello {} world',
			[
				'hello {} world',
			],
		];
		yield 'simple variable' => [
			'{{ title }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'variable with simple filter' => [
			'{{ title | trim }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'trim',
						],
					],
				],
			],
		];
		yield 'variable with filter and parameters' => [
			'{{ title | replace("0", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'0',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with filter and empty parameter' => [
			'{{ title | replace("o", "") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'o',
								'',
							],
						],
					],
				],
			],
		];
		yield 'variable with filter and parameters with pipe' => [
			'{{ title | ireplace("|", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'ireplace',
							'parameters' => [
								'|',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with filter and parameters with opening parenthesis' => [
			'{{ title | replace("(", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'(',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with filter and parameters with closing parenthesis' => [
			'{{ title | replace(")", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								')',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with filter and parameters with comma' => [
			'{{ title | replace(",", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								',',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with filter and parameters with space' => [
			'{{ title | replace(" ", "o") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								' ',
								'o',
							],
						],
					],
				]
			],
		];
		yield 'variable with multiple filters and the last one has no parameter' => [
			'{{ title | replace("0", "o") | replace("1", "i") | trim }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'0',
								'o',
							],
						],
						[
							'name' => 'replace',
							'parameters' => [
								'1',
								'i',
							],
						],
						[
							'name' => 'trim',
						],
					],
				]
			],
		];
		yield 'variable with multiple filters and the last one has parameters' => [
			'{{ title | trim | replace("0", "o") | replace("1", "i") }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'trim',
						],
						[
							'name' => 'replace',
							'parameters' => [
								'0',
								'o',
							],
						],
						[
							'name' => 'replace',
							'parameters' => [
								'1',
								'i',
							],
						],
					],
				]
			],
		];
		yield 'multiple strings with multiple variables with multiple filters with multiple parameters with multiple special characters' => [
			'hello "()|{}," world {{ title | replace("()|{},", "{}|(),") | trim("-_") }} hello "()|{}," world {{ title | replace("()|{},", "{}|(),")' .
			' | trim("-_") }} hello "()|{}," world',
			[
				'hello "()|{}," world ',
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'()|{},',
								'{}|(),',
							],
						],
						[
							'name' => 'trim',
							'parameters' => [
								'-_',
							],
						],
					],
				],
				' hello "()|{}," world ',
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'replace',
							'parameters' => [
								'()|{},',
								'{}|(),',
							],
						],
						[
							'name' => 'trim',
							'parameters' => [
								'-_',
							],
						],
					],
				],
				' hello "()|{}," world',
			]
		];
		yield 'unknown variable' => [
			'{{ unknown }}',
			[],
		];
		yield 'unknown filter' => [
			'{{ title | unknown }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'unknown and known filter' => [
			'{{ title | unknown | trim }}',
			[
				[
					'variable' => 'title',
					'filters' => [
						[
							'name' => 'trim',
						],
					],
				],
			],
		];
		yield 'trim filter with extra parameter' => [
			'{{ title | trim("1", "2") }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'replace filter with no parameter' => [
			'{{ title | replace }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'replace filter with one parameter missing' => [
			'{{ title | replace("1") }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'replace filter with extra parameter' => [
			'{{ title | replace("1", "2", "3") }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'ireplace filter with no parameter' => [
			'{{ title | ireplace }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'ireplace filter with one parameter missing' => [
			'{{ title | ireplace("1") }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
		yield 'ireplace filter with extra parameter' => [
			'{{ title | ireplace("1", "2", "3") }}',
			[
				[
					'variable' => 'title',
				],
			],
		];
	}

	/**
	 * @dataProvider provideInvalidTemplate
	 */
	public function test__construct_whenInvalidTemplate_throwsException($template, $exceptionMessage) {
		$this->expectException(FreshRSS_Parsing_Exception::class);
		$this->expectExceptionMessage($exceptionMessage);

		new FreshRSS_TitleRewriting_Handler($template);
	}

	public function provideInvalidTemplate() {
		yield 'missing variable end delimiter' => ['{{ title', 'Missing variable end delimiter'];
		yield 'missing filter end delimiter' => ['{{ title | replace( }}', 'Missing filter end delimiter'];
	}

	/**
	 * @dataProvider provideRewriteRule
	 */
	public function test_rewrite($template, $title, $feed, $expected) {
		$handler = new FreshRSS_TitleRewriting_Handler($template);
		$this->assertEquals($expected, $handler->rewrite($title, $feed));
	}

	public function provideRewriteRule() {
		yield 'no rewrite' => [
			'',
			'some article title',
			'some feed name',
			'',
		];
		yield 'single string' => [
			'hello world',
			'some article title',
			'some feed name',
			'hello world',
		];
		yield 'single variable' => [
			'{{ title }}',
			'some article title',
			'some feed name',
			'some article title',
		];
		yield 'single variable with simple trim' => [
			'{{ title | trim }}',
			'    some article title    ',
			'some feed name',
			'some article title',
		];
		yield 'single variable with trim with parameter' => [
			'{{ title | trim("-") }}',
			'---some article title---',
			'some feed name',
			'some article title',
		];
		yield 'single variable with multiple trim' => [
			'{{ title | trim("-") | trim }}',
			'---   some article title   ---',
			'some feed name',
			'some article title',
		];
		yield 'single variable with replace' => [
			'{{ title | replace("---", "###") }}',
			'---some article title---',
			'some feed name',
			'###some article title###',
		];
		yield 'single variable with replace and empty parameter' => [
			'{{ title | replace("---", "") }}',
			'---some article title---',
			'some feed name',
			'some article title',
		];
		yield 'multiple variables' => [
			'{{ feed }}{{ title }}',
			'some article title',
			'some feed name',
			'some feed namesome article title',
		];
		yield 'multiple variables with multiple filters with multiple strings' => [
			'| {{ feed | replace("some", "    ") | ireplace("Feed", "    ") | trim }} | {{ title | replace("some", "-") | replace("title", "-") |' .
			' trim("-") | trim }} |',
			'some article title',
			'some feed name',
			'| name | article |',
		];
	}
}
