<?php
declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;

final class FreshRSS_dispatcherTest_Controller extends Minz_ActionController {
	/** @var list<string> */
	public static array $executed = [];

	public function fooAction(): void {
		self::$executed[] = Minz_Request::controllerName() . '/' . Minz_Request::actionName();
		$this->view->_layout(null);
		$this->view->_path('index/index.phtml');	// Empty view
	}
}

final class DispatcherTest extends \PHPUnit\Framework\TestCase {

	private string $controllerName = '';
	private string $actionName = '';

	#[\Override]
	protected function setUp(): void {
		FreshRSS_Context::initSystem();
		$this->controllerName = Minz_Request::controllerName();
		$this->actionName = Minz_Request::actionName();
		FreshRSS_dispatcherTest_Controller::$executed = [];
	}

	#[\Override]
	protected function tearDown(): void {
		Minz_Request::_controllerName($this->controllerName);
		Minz_Request::_actionName($this->actionName);
	}

	public function testRunExecutesExactNames(): void {
		Minz_Request::_controllerName('dispatcherTest');
		Minz_Request::_actionName('foo');

		ob_start();
		try {
			Minz_Dispatcher::getInstance()->run();
		} finally {
			ob_end_clean();
		}

		self::assertSame(['dispatcherTest/foo'], FreshRSS_dispatcherTest_Controller::$executed);
	}

	/** @return list<array{string,string}> */
	public static function provideNamesInAnotherLetterCase(): array {
		return [
			['dispatcherTest', 'Foo'],
			['dispatcherTest', 'FOO'],
			['DispatcherTest', 'foo'],
			['DISPATCHERTEST', 'foo'],
		];
	}

	/**
	 * PHP resolves class and method names case-insensitively, but e.g. `Minz_Request::is()`,
	 * which extensions use in `Minz_HookType::ActionExecute` to decide about an action, does not.
	 */
	#[DataProvider('provideNamesInAnotherLetterCase')]
	public function testRunRefusesNamesInAnotherLetterCase(string $controllerName, string $actionName): void {
		Minz_Request::_controllerName($controllerName);
		Minz_Request::_actionName($actionName);

		$exception = null;
		ob_start();
		try {
			Minz_Dispatcher::getInstance()->run();
		} catch (Minz_ControllerNotExistException | Minz_ActionException $e) {
			$exception = $e;
		} finally {
			ob_end_clean();
		}

		self::assertNotNull($exception);
		self::assertSame([], FreshRSS_dispatcherTest_Controller::$executed);
	}
}
