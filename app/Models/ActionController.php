<?php
declare(strict_types=1);

namespace FreshRss\Models;

use FreshRss\Minz\ActionController as MinzActionController;

abstract class ActionController extends MinzActionController {

	/**
	 * @var View
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct(string $viewType = '') {
		parent::__construct($viewType === '' ? View::class : $viewType);
	}
}
