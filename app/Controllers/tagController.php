<?php

/**
 * Controller to handle every tag actions.
 */
class FreshRSS_tag_Controller extends FreshRSS_ActionController {

	/**
	 * JavaScript request or not.
	 */
	private bool $ajax = false;

	/**
	 * This action is called before every other action in that class. It is
	 * the common boilerplate for every action. It is triggered by the
	 * underlying framework.
	 */
	public function firstAction(): void {
		// If ajax request, we do not print layout
		$this->ajax = Minz_Request::paramBoolean('ajax');
		if ($this->ajax) {
			$this->view->_layout(null);
			Minz_Request::_param('ajax');
		}
	}

	/**
	 * This action adds (checked=true) or removes (checked=false) a tag to an entry.
	 */
	public function tagEntryAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		if (Minz_Request::isPost()) {
			$id_tag = Minz_Request::paramInt('id_tag');
			$name_tag = Minz_Request::paramString('name_tag');
			$id_entry = Minz_Request::paramString('id_entry');
			$checked = Minz_Request::paramTernary('checked');
			if ($id_entry != '') {
				$tagDAO = FreshRSS_Factory::createTagDao();
				if ($id_tag == 0 && $name_tag !== '' && $checked) {
					if ($existing_tag = $tagDAO->searchByName($name_tag)) {
						// Use existing tag
						$tagDAO->tagEntry($existing_tag->id(), $id_entry, $checked);
					} else {
						//Create new tag
						$id_tag = $tagDAO->addTag(['name' => $name_tag]);
					}
				}
				if ($id_tag != false) {
					$tagDAO->tagEntry($id_tag, $id_entry, $checked);
				}
			}
		} else {
			Minz_Error::error(405);
		}
		if (!$this->ajax) {
			Minz_Request::forward([
				'c' => 'index',
				'a' => 'index',
			], true);
		}
	}

	public function deleteAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		if (Minz_Request::isPost()) {
			$id_tag = Minz_Request::paramInt('id_tag');
			if ($id_tag !== 0) {
				$tagDAO = FreshRSS_Factory::createTagDao();
				$tagDAO->deleteTag($id_tag);
			}
		} else {
			Minz_Error::error(405);
		}
		if (!$this->ajax) {
			Minz_Request::forward([
				'c' => 'tag',
				'a' => 'index',
			], true);
		}
	}

	public function getTagsForEntryAction(): void {
		if (!FreshRSS_Auth::hasAccess() && !FreshRSS_Context::$system_conf->allow_anonymous) {
			Minz_Error::error(403);
		}
		$this->view->_layout(null);
		header('Content-Type: application/json; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
		$id_entry = Minz_Request::paramString('id_entry');
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tagsForEntry = $tagDAO->getTagsForEntry($id_entry) ?: [];
	}

	public function addAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$name = Minz_Request::paramString('name');
		$tagDAO = FreshRSS_Factory::createTagDao();
		if (strlen($name) > 0 && null === $tagDAO->searchByName($name)) {
			$tagDAO->addTag(['name' => $name]);
			Minz_Request::good(_t('feedback.tag.created', $name), ['c' => 'tag', 'a' => 'index']);
		}

		Minz_Request::bad(_t('feedback.tag.name_exists', $name), ['c' => 'tag', 'a' => 'index']);
	}

	/**
	 * @throws Minz_ConfigurationNamespaceException
	 * @throws Minz_PDOConnectionException|JsonException
	 */
	public function renameAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		if (!Minz_Request::isPost()) {
			Minz_Error::error(405);
		}

		$targetName = Minz_Request::paramString('name');
		$sourceId = Minz_Request::paramInt('id_tag');

		if ($targetName == '' || $sourceId == 0) {
			Minz_Error::error(400);
			return;
		}

		$tagDAO = FreshRSS_Factory::createTagDao();
		$sourceTag = $tagDAO->searchById($sourceId);
		$sourceName = $sourceTag === null ? null : $sourceTag->name();
		$targetTag = $tagDAO->searchByName($targetName);
		if ($targetTag === null) {
			// There is no existing tag with the same target name
			$tagDAO->updateTagName($sourceId, $targetName);
		} else {
			// There is an existing tag with the same target name
			$tagDAO->updateEntryTag($sourceId, $targetTag->id());
			$tagDAO->deleteTag($sourceId);
		}

		Minz_Request::good(_t('feedback.tag.renamed', $sourceName, $targetName), ['c' => 'tag', 'a' => 'index']);
	}

	public function indexAction(): void {
		if (!FreshRSS_Auth::hasAccess()) {
			Minz_Error::error(403);
		}
		$tagDAO = FreshRSS_Factory::createTagDao();
		$this->view->tags = $tagDAO->listTags() ?: [];
	}
}
