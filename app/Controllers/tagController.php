<?php

/**
 * Controller to handle every tag actions.
 */
class FreshRSS_tag_Controller extends FreshRSS_ActionController {

	/**
	 * JavaScript request or not.
	 * @var bool|mixed
	 */
	private $ajax = false;

	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction(): void {
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
	public function tagEntryAction(): void {
		if (Minz_Request::isPost()) {
			$id_tag = Minz_Request::param('id_tag');
			$name_tag = Minz_Request::param('name_tag');
			if (is_string($name_tag)) {
				$name_tag = trim($name_tag);
			}
			$id_entry = Minz_Request::param('id_entry');
			$checked = Minz_Request::paramTernary('checked');
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
			Minz_Error::error(405);
		}
		if (!$this->ajax) {
			Minz_Request::forward(array(
				'c' => 'index',
				'a' => 'index',
			), true);
		}
	}

	public function deleteAction(): void {
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

	public function getTagsForEntryAction(): void {
		$this->view->_layout(false);
		header('Content-Type: application/json; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		$id_entry = Minz_Request::param('id_entry', 0);
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->getTagsForEntry($id_entry);
	}

	public function addAction(): void {
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$name = Minz_Request::param('name');
		$lengthOfName = 0;
		if (is_string($name)) {
			$lengthOfName = strlen($name);
		}
		$tagDAO = FreshRSS_Factory::createTagDao();
		if ($lengthOfName > 0 && null === $tagDAO->searchByName($name)) {
			$tagDAO->addTag(['name' => $name]);
			Minz_Request::good(_t('feedback.tag.created', $name), ['c' => 'tag', 'a' => 'index']);
		}

		Minz_Request::bad(_t('feedback.tag.name_exists', $name), ['c' => 'tag', 'a' => 'index']);
	}

	/**
	 * @return void|null
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException
	 */
	public function renameAction() {
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$targetName = Minz_Request::param('name');
		$sourceId = Minz_Request::param('id_tag');

		if ($targetName == '' || $sourceId == '') {
			Minz_Error::error(400);
			return;
		}

		$tagDAO = FreshRSS_Factory::createTagDao();
		$sourceTag = $tagDAO->searchById($sourceId);
		$sourceName = $sourceTag === null ? null : $sourceTag->name();
		$targetTag = $tagDAO->searchByName($targetName);
		if ($targetTag === null) {
			// There is no existing tag with the same target name
			$tagDAO->updateTag($sourceId, ['name' => $targetName]);
		} else {
			// There is an existing tag with the same target name
			$tagDAO->updateEntryTag($sourceId, $targetTag->id());
			$tagDAO->deleteTag($sourceId);
		}

		Minz_Request::good(_t('feedback.tag.renamed', $sourceName, $targetName), ['c' => 'tag', 'a' => 'index']);
	}

	public function indexAction(): void {
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags();
	}
}
