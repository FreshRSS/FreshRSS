<?php
declare(strict_types=1);

final class FreshExtension_quickCollapse_Controller extends Minz_ActionController {

	/** @var QuickCollapse\View */
	protected $view;

	public function __construct() {
		parent::__construct(QuickCollapse\View::class);
	}

	public function jsVarsAction(): void {
		$extension = Minz_ExtensionManager::findExtension('Quick Collapse');
		if ($extension !== null) {
			$this->view->icon_url_in = $extension->getFileUrl('in.svg', 'svg');
			$this->view->icon_url_out = $extension->getFileUrl('out.svg', 'svg');
		}
		$this->view->i18n_toggle_collapse = _t('gen.js.toggle_collapse');
		$this->view->_layout(null);
		$this->view->_path('quickCollapse/vars.js');
		header('Content-Type: application/javascript');
	}
}
