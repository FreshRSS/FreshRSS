<?php

class FreshRSS_Share {

	static public function generateUrl($options, $selected, $link, $title) {
		$share = $options[$selected['type']];
		$matches = array(
			'~URL~',
			'~TITLE~',
			'~LINK~',
		);
		$replaces = array(
			$selected['url'],
			self::transformData($title, self::getTransform($share, 'title')),
			self::transformData($link, self::getTransform($share, 'link')),
		);
		$url = str_replace($matches, $replaces, $share['url']);
		return $url;
	}

	static private function transformData($data, $transform) {
		if (!is_array($transform)) {
			return $data;
		}
		if (count($transform) === 0) {
			return $data;
		}
		foreach ($transform as $action) {
			$data = call_user_func($action, $data);
		}
		return $data;
	}

	static private function getTransform($options, $type) {
		$transform = $options['transform'];

		if (array_key_exists($type, $transform)) {
			return $transform[$type];
		}

		return $transform;
	}

}
