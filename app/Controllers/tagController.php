<?php

/**
 * Controller to handle every tag actions.
 */
class FreshRSS_tag_Controller extends Minz_ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		// If ajax request, we do not print layout
		$this->ajax = Minz_Request::param('ajax');
		if ($this->ajax) {
			$this->view->_layout(false);
			Minz_Request::_param('ajax');
		}
	}

	/**
	 * This action adds (checked=true) or removes (checked=false) a tag to an entry.
	 */
	public function tagEntryAction() {
		if (Minz_Request::isPost()) {
			$id_tag = Minz_Request::param('id_tag');
			$name_tag = trim(Minz_Request::param('name_tag'));
			$id_entry = Minz_Request::param('id_entry');
			$checked = Minz_Request::paramTernary('checked');
			if ($id_entry != false) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				if ($id_tag == 0 && $name_tag != '' && $checked) {
					//Create new tag
					$id_tag = $tagDAO->addTag(array('name' => $name_tag));
				}
				if ($id_tag != 0) {
					$tagDAO->tagEntry($id_tag, $id_entry, $checked);
				}
			}
		} else {
			Minz_Error::error(405);
		}
		if (!$this->ajax) {
			Minz_Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	public function deleteAction() {
		if (Minz_Request::isPost()) {
			$id_tag = Minz_Request::param('id_tag');
			if ($id_tag != false) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tagDAO->deleteTag($id_tag);
			}
		} else {
			Minz_Error::error(405);
		}
		if (!$this->ajax) {
			Minz_Request::forward(array(
				'c' => 'tag',
				'a' => 'index',
			), true);
		}
	}

	public function getTagsForEntryAction() {
		$this->view->_layout(false);
		header('Content-Type: application/json; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		$id_entry = Minz_Request::param('id_entry', 0);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->getTagsForEntry($id_entry);
	}

	public function addAction() {
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$name = Minz_Request::param('name');
		$tagDAO = FreshRSS_Factory::createTagDao();
		if (null === $tagDAO->searchByName($name)) {
			$tagDAO->addTag(['name' => $name]);
			Minz_Request::good('feedback.tag.created', ['c' => 'tag', 'a' => 'index'], true);
		}

		Minz_Request::bad('feedback.tag.name_exists', ['c' => 'tag', 'a' => 'index'], true);
	}

	public function renameAction() {
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$name = Minz_Request::param('name');
		$tagDAO = FreshRSS_Factory::createTagDao();
		$newTag = $tagDAO->searchByName($name);
		if (null === $newTag) {
			$tagDAO->updateTag(Minz_Request::param('id_tag'), ['name' => $name]);
		} else {
			$tagDAO->updateEntryTag(Minz_Request::param('id_tag'), $newTag->id());
			$tagDAO->deleteTag(Minz_Request::param('id_tag'));
		}

		Minz_Request::good('feedback.tag.renamed', ['c' => 'tag', 'a' => 'index'], true);
	}

	public function indexAction() {
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags();
	}
}
