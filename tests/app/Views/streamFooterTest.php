<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class streamFooterTest extends \PHPUnit\Framework\TestCase {

	/** @return Traversable<string,array{array<string,string>,int,string}> */
	public static function providePaginationStates(): Traversable {
		yield 'automatic first page' => [[], 2, '0'];
		yield 'explicit unread first page' => [['state' => '2'], 2, '2'];
		yield 'explicit favourite first page' => [['state' => '4'], 4, '4'];
		yield 'automatic unread next page' => [['state' => '2', 'stateForRedirect' => '0'], 2, '0'];
		yield 'automatic all next page' => [['state' => '3', 'stateForRedirect' => '0'], 3, '0'];
		yield 'explicit favourite next page' => [['state' => '4', 'stateForRedirect' => '4'], 4, '4'];
	}

	/** @param array<string,string> $request */
	#[DataProvider('providePaginationStates')]
	public function testPaginationKeepsTheRequestedState(array $request, int $resolvedState, string $requestedState): void {
		FreshRSS_Context::initSystem();
		Minz_Translate::init('en');
		FreshRSS_Context::$state = $resolvedState;
		FreshRSS_Context::$continuation_id = '123';
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch('needle');
		Minz_Request::_params($request + ['search' => 'needle']);

		$view = new FreshRSS_View();
		$view->_path('helpers/stream-footer.phtml');
		$html = new DOMDocument();
		self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET));
		$button = $html->getElementById('load_more');
		self::assertInstanceOf(DOMElement::class, $button);
		$query = parse_url($button->getAttribute('formaction'), PHP_URL_QUERY);
		self::assertIsString($query);
		parse_str($query, $params);
		self::assertSame((string)$resolvedState, $params['state'] ?? null);
		self::assertSame($requestedState, $params['stateForRedirect'] ?? null);
		self::assertSame('needle', $params['search'] ?? null);
		self::assertSame('123', $params['cid'] ?? null);
		self::assertSame('1', $params['ajax'] ?? null);
	}
}
