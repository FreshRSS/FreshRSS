<?php

namespace Freshrss\Controllers;

/**
 * Controller to handle every tag actions.
 */
class tag_Controller extends ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!Auth::hasAccess()) {
			Error::error(403);
		}
		// If ajax request, we do not print layout
		$this->ajax = Request::param('ajax');
		if ($this->ajax) {
			$this->view->_layout(false);
			Request::_param('ajax');
		}
	}

	/**
	 * This action adds (checked=true) or removes (checked=false) a tag to an entry.
	 */
	public function tagEntryAction() {
		if (Request::isPost()) {
			$id_tag = Request::param('id_tag');
			$name_tag = trim(Request::param('name_tag'));
			$id_entry = Request::param('id_entry');
			$checked = Request::paramTernary('checked');
			if ($id_entry != false) {
				$tagDAO = Factory::createTagDao();
				if ($id_tag == 0 && $name_tag != '' && $checked) {
					//Create new tag
					$id_tag = $tagDAO->addTag(array('name' => $name_tag));
				}
				if ($id_tag != 0) {
					$tagDAO->tagEntry($id_tag, $id_entry, $checked);
				}
			}
		} else {
			Error::error(405);
		}
		if (!$this->ajax) {
			Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	public function deleteAction() {
		if (Request::isPost()) {
			$id_tag = Request::param('id_tag');
			if ($id_tag != false) {
				$tagDAO = Factory::createTagDao();
				$tagDAO->deleteTag($id_tag);
			}
		} else {
			Error::error(405);
		}
		if (!$this->ajax) {
			Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	public function getTagsForEntryAction() {
		$this->view->_layout(false);
		header('Content-Type: application/json; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		$id_entry = Request::param('id_entry', 0);
		$tagDAO = Factory::createTagDao();
		$this->view->tags = $tagDAO->getTagsForEntry($id_entry);
	}
}
