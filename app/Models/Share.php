<?php

/**
 * Manage the sharing options in FreshRSS.
 */
class FreshRSS_Share {
	/**
	 * The list of available sharing options.
	 */
	private static $list_sharing = array();

	/**
	 * Register a new sharing option.
	 * @param $share_options is an array defining the share option.
	 */
	public static function register($share_options) {
		$type = $share_options['type'];

		if (isset(self::$list_sharing[$type])) {
			return;
		}

		$help_url = isset($share_options['help']) ? $share_options['help'] : '';
		self::$list_sharing[$type] = new FreshRSS_Share(
			$type, $share_options['url'], $share_options['transform'],
			$share_options['form'], $help_url
		);
	}

	/**
	 * Register sharing options in a file.
	 * @param $filename the name of the file to load.
	 */
	public static function load($filename) {
		$shares_from_file = @include($filename);
		if (!is_array($shares_from_file)) {
			$shares_from_file = array();
		}

		foreach ($shares_from_file as $share_type => $share_options) {
			$share_options['type'] = $share_type;
			self::register($share_options);
		}
	}

	/**
	 * Return the list of sharing options.
	 * @return an array of FreshRSS_Share objects.
	 */
	public static function enum() {
		return self::$list_sharing;
	}

	/**
	 * Return FreshRSS_Share object related to the given type.
	 * @param $type the share type, null if $type is not registered.
	 */
	public static function get($type) {
		if (!isset(self::$list_sharing[$type])) {
			return null;
		}

		return self::$list_sharing[$type];
	}

	/**
	 *
	 */
	private $type = '';
	private $name = '';
	private $url_transform = '';
	private $transform = array();
	private $form_type = 'simple';
	private $help_url = '';
	private $custom_name = null;
	private $base_url = null;
	private $title = null;
	private $link = null;

	/**
	 * Create a FreshRSS_Share object.
	 * @param $type is a unique string defining the kind of share option.
	 * @param $url_transform defines the url format to use in order to share.
	 * @param $transform is an array of transformations to apply on link and title.
	 * @param $form_type defines which form we have to use to complete. "simple"
	 *        is typically for a centralized service while "advanced" is for
	 *        decentralized ones.
	 * @param $help_url is an optional url to give help on this option.
	 */
	private function __construct($type, $url_transform, $transform,
	                             $form_type, $help_url = '') {
		$this->type = $type;
		$this->name = _t('gen.share.' . $type);
		$this->url_transform = $url_transform;
		$this->help_url = $help_url;

		if (!is_array($transform)) {
			$transform = array();
		}
		$this->transform = $transform;

		if (!in_array($form_type, array('simple', 'advanced'))) {
			$form_type = 'simple';
		}
		$this->form_type = $form_type;
	}

	/**
	 * Update a FreshRSS_Share object with information from an array.
	 * @param $options is a list of informations to update where keys should be
	 *        in this list: name, url, title, link.
	 */
	public function update($options) {
		$available_options = array(
			'name' => 'custom_name',
			'url' => 'base_url',
			'title' => 'title',
			'link' => 'link',
		);

		foreach ($options as $key => $value) {
			if (isset($available_options[$key])) {
				$this->{$available_options[$key]} = $value;
			}
		}
	}

	/**
	 * Return the current type of the share option.
	 */
	public function type() {
		return $this->type;
	}

	/**
	 * Return the current form type of the share option.
	 */
	public function formType() {
		return $this->form_type;
	}

	/**
	 * Return the current help url of the share option.
	 */
	public function help() {
		return $this->help_url;
	}

	/**
	 * Return the current name of the share option.
	 */
	public function name($real = false) {
		if ($real || is_null($this->custom_name) || empty($this->custom_name)) {
			return $this->name;
		} else {
			return $this->custom_name;
		}
	}

	/**
	 * Return the current base url of the share option.
	 */
	public function baseUrl() {
		return $this->base_url;
	}

	/**
	 * Return the current url by merging url_transform and base_url.
	 */
	public function url() {
		$matches = array(
			'~URL~',
			'~TITLE~',
			'~LINK~',
		);
		$replaces = array(
			$this->base_url,
			$this->title(),
			$this->link(),
		);
		return str_replace($matches, $replaces, $this->url_transform);
	}

	/**
	 * Return the title.
	 * @param $raw true if we should get the title without transformations.
	 */
	public function title($raw = false) {
		if ($raw) {
			return $this->title;
		}

		return $this->transform($this->title, $this->getTransform('title'));
	}

	/**
	 * Return the link.
	 * @param $raw true if we should get the link without transformations.
	 */
	public function link($raw = false) {
		if ($raw) {
			return $this->link;
		}

		return $this->transform($this->link, $this->getTransform('link'));
	}

	/**
	 * Transform a data with the given functions.
	 * @param $data the data to transform.
	 * @param $tranform an array containing a list of functions to apply.
	 * @return the transformed data.
	 */
	private static function transform($data, $transform) {
		if (!is_array($transform) || empty($transform)) {
			return $data;
		}

		foreach ($transform as $action) {
			$data = call_user_func($action, $data);
		}

		return $data;
	}

	/**
	 * Get the list of transformations for the given attribute.
	 * @param $attr the attribute of which we want the transformations.
	 * @return an array containing a list of transformations to apply.
	 */
	private function getTransform($attr) {
		if (array_key_exists($attr, $this->transform)) {
			return $this->transform[$attr];
		}

		return $this->transform;
	}
}
