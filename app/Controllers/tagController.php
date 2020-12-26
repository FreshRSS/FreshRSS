<?php

/**
 * Controller to handle every tag actions.
 */
class FreshRSS_tag_Controller extends Minz\ActionController {
	/**
	 * This action is called before every other action in that class. It is
	 * the common boiler plate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction() {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz\Error::error(403);
		}
		// If ajax request, we do not print layout
		$this->ajax = Minz\Request::param('ajax');
		if ($this->ajax) {
			$this->view->_layout(false);
			Minz\Request::_param('ajax');
		}
	}

	/**
	 * This action adds (checked=true) or removes (checked=false) a tag to an entry.
	 */
	public function tagEntryAction() {
		if (Minz\Request::isPost()) {
			$id_tag = Minz\Request::param('id_tag');
			$name_tag = trim(Minz\Request::param('name_tag'));
			$id_entry = Minz\Request::param('id_entry');
			$checked = Minz\Request::paramTernary('checked');
			if ($id_entry != false) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				if ($id_tag == 0 && $name_tag != '' && $checked) {
					if ($existing_tag = $tagDAO->searchByName($name_tag)) {
					    // Use existing tag
                        $tagDAO->tagEntry($existing_tag->id(), $id_entry, $checked);
                    } else {
                        //Create new tag
                        $id_tag = $tagDAO->addTag(array('name' => $name_tag));
                    }
				}
				if ($id_tag != 0) {
					$tagDAO->tagEntry($id_tag, $id_entry, $checked);
				}
			}
		} else {
			Minz\Error::error(405);
		}
		if (!$this->ajax) {
			Minz\Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	public function deleteAction() {
		if (Minz\Request::isPost()) {
			$id_tag = Minz\Request::param('id_tag');
			if ($id_tag != false) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tagDAO->deleteTag($id_tag);
			}
		} else {
			Minz\Error::error(405);
		}
		if (!$this->ajax) {
			Minz\Request::forward(array(
				'c' => 'tag',
				'a' => 'index',
			), true);
		}
	}

	public function getTagsForEntryAction() {
		$this->view->_layout(false);
		header('Content-Type: application/json; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		$id_entry = Minz\Request::param('id_entry', 0);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->getTagsForEntry($id_entry);
	}

	public function addAction() {
		if (!Minz\Request::isPost()) {
			Minz\Error::error(405);
		}

		$name = Minz\Request::param('name');
		$tagDAO = FreshRSS_Factory::createTagDao();
		if (null === $tagDAO->searchByName($name)) {
			$tagDAO->addTag(['name' => $name]);
			Minz\Request::good('feedback.tag.created', ['c' => 'tag', 'a' => 'index'], true);
		}

		Minz\Request::bad('feedback.tag.name_exists', ['c' => 'tag', 'a' => 'index'], true);
	}

	public function renameAction() {
		if (!Minz\Request::isPost()) {
			Minz\Error::error(405);
		}

		$name = Minz\Request::param('name');
		$tagDAO = FreshRSS_Factory::createTagDao();
		$newTag = $tagDAO->searchByName($name);
		if (null === $newTag) {
			$tagDAO->updateTag(Minz\Request::param('id_tag'), ['name' => $name]);
		} else {
			$tagDAO->updateEntryTag(Minz\Request::param('id_tag'), $newTag->id());
			$tagDAO->deleteTag(Minz\Request::param('id_tag'));
		}

		Minz\Request::good('feedback.tag.renamed', ['c' => 'tag', 'a' => 'index'], true);
	}

	public function indexAction() {
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags();
	}
}
