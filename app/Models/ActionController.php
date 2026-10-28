<?php
declare(strict_types=1);

abstract class FreshRSS_ActionController extends Minz_ActionController {

	/**
	 * @var FreshRSS_View
	 * @phpstan-ignore property.phpDocType
	 */
	protected $view;

	public function __construct(string $viewType = '') {
		parent::__construct($viewType === '' ? FreshRSS_View::class : $viewType);
	}
}
