<?php
declare(strict_types=1);

use FreshRss\Minz\Request;
use FreshRss\Minz\Translate;
use FreshRss\Minz\User;
use FreshRss\Models\BooleanSearch;
use FreshRss\Models\Context;
use FreshRss\Models\UserConfiguration;
use FreshRss\Models\View;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
final class headerTest extends \PHPUnit\Framework\TestCase {

	/** @return Traversable<string,array{?string,?string}> */
	public static function provideSearchSorts(): Traversable {
		foreach (['id', 'c.name', 'date', 'f.name', 'lastUserModified', 'length', 'link', 'title', 'rand'] as $sort) {
			yield $sort => [$sort, $sort];
		}
		yield 'no override' => [null, null];
		yield 'empty override' => ['', null];
		yield 'invalid override' => ['" onfocus="alert(1)', null];
	}

	#[DataProvider('provideSearchSorts')]
	public function testSearchPreservesSort(?string $requestedSort, ?string $expectedSort): void {
		Context::initSystem();
		Context::systemConf()->allow_anonymous = true;
		User::change(Context::systemConf()->default_user);
		Context::setUserConf(clone UserConfiguration::default());
		Translate::init('en');
		Request::_params($requestedSort === null ? [] : ['sort' => $requestedSort]);
		// The context has already validated the requested sort before rendering the header.
		Context::$sort = match ($expectedSort) {
			'c.name', 'date', 'f.name', 'lastUserModified', 'length', 'link', 'title', 'rand' => $expectedSort,
			default => 'id',
		};
		Context::$search = new BooleanSearch('needle');

		$view = new View();
		$view->_path('../layout/header.phtml');
		$view->html_url = 'https://example.net/';
		// Fragment of a page, so prefix with `<!DOCTYPE html>`
		$doc = Dom\HTMLDocument::createFromString('<!DOCTYPE html>' . $view->renderToString(), Dom\HTML_NO_DEFAULT_NS);
		$inputs = (new Dom\XPath($doc))->query('//form[.//input[@name="search"]]/input[@name="sort"]');
		self::assertSame($expectedSort === null ? 0 : 1, $inputs->length);
		if ($expectedSort !== null) {
			$input = $inputs->item(0);
			self::assertInstanceOf(Dom\Element::class, $input);
			self::assertSame('hidden', $input->getAttribute('type'));
			self::assertSame($expectedSort, $input->getAttribute('value'));
		}
	}
}
