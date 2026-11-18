<?php
declare(strict_types=1);

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
		FreshRSS_Context::initSystem();
		FreshRSS_Context::systemConf()->allow_anonymous = true;
		Minz_User::change(FreshRSS_Context::systemConf()->default_user);
		FreshRSS_Context::setUserConf(clone FreshRSS_UserConfiguration::default());
		Minz_Translate::init('en');
		Minz_Request::_params($requestedSort === null ? [] : ['sort' => $requestedSort]);
		// The context has already validated the requested sort before rendering the header.
		FreshRSS_Context::$sort = match ($expectedSort) {
			'c.name', 'date', 'f.name', 'lastUserModified', 'length', 'link', 'title', 'rand' => $expectedSort,
			default => 'id',
		};
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch('needle');

		$view = new FreshRSS_View();
		$view->_path('../layout/header.phtml');
		$view->html_url = 'https://example.net/';
		$html = new DOMDocument();
		self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING));
		$inputs = (new DOMXPath($html))->query('//form[.//input[@name="search"]]/input[@name="sort"]');
		self::assertNotFalse($inputs);
		self::assertSame($expectedSort === null ? 0 : 1, $inputs->length);
		if ($expectedSort !== null) {
			$input = $inputs->item(0);
			self::assertInstanceOf(DOMElement::class, $input);
			self::assertSame('hidden', $input->getAttribute('type'));
			self::assertSame($expectedSort, $input->getAttribute('value'));
		}
	}

	/** @return Traversable<string,array{'form'|'http_auth',?string,?string}> */
	public static function provideLogouts(): Traversable {
		yield 'form' => ['form', null, './?c=auth&a=logout'];
		yield 'OIDC' => ['http_auth', 'openid-connect', './oidc/?logout=' . urlencode('http://example.net/i') . '/'];
		yield 'other HTTP authentication' => ['http_auth', 'Basic', null];
	}

	/** @param 'form'|'http_auth' $authType */
	#[DataProvider('provideLogouts')]
	public function testLogoutInConfigureMenu(string $authType, ?string $serverAuthType, ?string $expectedAction): void {
		$_SERVER['HTTP_HOST'] = 'example.net';
		$_SERVER['REQUEST_URI'] = '/i/';
		if ($serverAuthType !== null) {
			$_SERVER['AUTH_TYPE'] = $serverAuthType;
		}
		FreshRSS_Context::initSystem();
		FreshRSS_Context::systemConf()->auth_type = $authType;
		Minz_User::change(FreshRSS_Context::systemConf()->default_user);
		FreshRSS_Context::setUserConf(clone FreshRSS_UserConfiguration::default());
		Minz_Translate::init('en');
		FreshRSS_Context::$search = new FreshRSS_BooleanSearch('');
		(new ReflectionProperty(FreshRSS_Auth::class, 'login_ok'))->setValue(null, true);

		$view = new FreshRSS_View();
		$view->_path('../layout/header.phtml');
		$view->html_url = 'https://example.net/';
		$html = new DOMDocument();
		self::assertTrue($html->loadHTML($view->renderToString(), LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING));
		$buttons = (new DOMXPath($html))->query('//nav[contains(@class, "configure")]//button[contains(@class, "signout")]');
		self::assertNotFalse($buttons);
		self::assertSame($expectedAction === null ? 0 : 1, $buttons->length);
		if ($expectedAction !== null) {
			$button = $buttons->item(0);
			self::assertInstanceOf(DOMElement::class, $button);
			self::assertSame($expectedAction, $button->getAttribute('formaction'));
		}
	}
}
