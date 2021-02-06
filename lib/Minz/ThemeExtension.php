<?php

abstract class Minz_ThemeExtension extends Minz_Extension {
	protected $icons = []; // Override this to reflect the redefined icons
	protected $iconFolder = 'icons'; // Override this to reflect the extension folder tree
	protected $thumbnailFolder = 'thumbs'; // Override this to reflect the extension folder tree

	/**
	 * Get the list of CSS files used by the theme.
	 *
	 * Those files needs to be either in the static folder or
	 * be part of the base theme. Base theme files must be
	 * prefixed by an underscore (_).
	 *
	 * @return array
	 */
	abstract protected function getCssFiles();

	/**
	 * Get the list of CSS files for left-to-right languages.
	 *
	 * @return array
	 */
	final public function getLtrCssFiles() {
		return array_reverse($this->getCssFiles());
	}

	/**
	 * Get the list of CSS files for right-to-left languages.
	 *
	 * @return array
	 */
	final public function getRtlCssFiles() {
		return array_map(function ($file) {
			return str_replace('.css', '.rtl.css', $file);
		}, $this->getLtrThemeFiles());
	}

	/**
	 * Get the thumbnail URL
	 *
	 * The thumbnail needs to be a PNG image named 'original.png'.
	 *
	 * @return string
	 */
	final public function getThumbnailUrl() {
		return $this->getFileUrl("{$this->thumbnailFolder}/original.png", 'png');
	}

	/**
	 * Get the list of CSS files used by the theme.
	 *
	 * Icons need to be SVG images.
	 *
	 * @return array
	 */
	final public function getIconFiles() {
		return array_combine($this->icons, array_map(function ($icon) {
			return $this->getFileUrl("{$this->iconFolder}/{$icon}.svg", 'svg');
		}, $this->icons));
	}

	public function init() {
	}
}
