<?php
declare(strict_types=1);

/**
 * Manage the sharing options in FreshRSS.
 */
class FreshRSS_Share {
	/**
	 * The list of available sharing options.
	 * @var array<string,FreshRSS_Share>
	 */
	private static array $list_sharing = [];

	/**
	 * Register a new sharing option.
	 * @param array{'type':string,'url':string,'transform'?:array<callable>|array<string,array<callable>>,'field'?:string,'help'?:string,'form'?:'simple'|'advanced',
	 *	'method'?:'GET'|'POST','HTMLtag'?:'button','deprecated'?:bool} $share_options is an array defining the share option.
	 */
	public static function register(array $share_options): void {
		$type = $share_options['type'];
		if (isset(self::$list_sharing[$type])) {
			return;
		}

		self::$list_sharing[$type] = new FreshRSS_Share(
			$type,
			$share_options['url'],
			$share_options['transform'] ?? [],
			$share_options['form'] ?? 'simple',
			$share_options['help'] ?? '',
			$share_options['method'] ?? 'GET',
			$share_options['field'] ?? null,
			$share_options['HTMLtag'] ?? null,
			$share_options['deprecated'] ?? false
		);
	}

	/**
	 * Register sharing options in a file.
	 * @param string $filename the name of the file to load.
	 */
	public static function load(string $filename): void {
		$shares_from_file = @include($filename);
		if (!is_array($shares_from_file)) {
			$shares_from_file = [];
		}

		foreach ($shares_from_file as $share_type => $share_options) {
			$share_options['type'] = $share_type;
			self::register($share_options);
		}

		uasort(self::$list_sharing, static fn(FreshRSS_Share $a, FreshRSS_Share $b) => strcasecmp($a->name() ?? '', $b->name() ?? ''));
	}

	/**
	 * Return the list of sharing options.
	 * @return array<string,FreshRSS_Share>
	 */
	public static function enum(): array {
		return self::$list_sharing;
	}

	/**
	 * @param string $type the share type, null if $type is not registered.
	 * @return FreshRSS_Share|null object related to the given type.
	 */
	public static function get(string $type): ?FreshRSS_Share {
		return self::$list_sharing[$type] ?? null;
	}


	private string $type;
	private string $name;
	private string $url_transform;
	/** @var array<callable>|array<string,array<callable>> */
	private array $transforms;
	/**
	 * @phpstan-var 'simple'|'advanced'
	 */
	private string $form_type;
	private string $help_url;
	private ?string $custom_name = null;
	private ?string $base_url = null;
	private ?string $id = null;
	private ?string $title = null;
	private ?string $link = null;
	private bool $isDeprecated;
	/**
	 * @phpstan-var 'GET'|'POST'
	 */
	private string $method;
	private ?string $field;
	/**
	 * @phpstan-var 'button'|null
	 */
	private ?string $HTMLtag;

	/**
	 * Create a FreshRSS_Share object.
	 * @param string $type is a unique string defining the kind of share option.
	 * @param string $url_transform defines the url format to use in order to share.
	 * @param array<callable>|array<string,array<callable>> $transforms is an array of transformations to apply on link and title.
	 * @param 'simple'|'advanced' $form_type defines which form we have to use to complete. "simple"
	 *        is typically for a centralized service while "advanced" is for
	 *        decentralized ones.
	 * @param string $help_url is an optional url to give help on this option.
	 * @param 'GET'|'POST' $method defines the sharing method (GET or POST)
	 * @param string|null $field
	 * @param 'button'|null $HTMLtag
	 * @param bool $isDeprecated
	 */
	private function __construct(string $type, string $url_transform, array $transforms, string $form_type,
		string $help_url, string $method, ?string $field, ?string $HTMLtag, bool $isDeprecated = false) {
		$this->type = $type;
		$this->name = _t('gen.share.' . $type);
		$this->url_transform = $url_transform;
		$this->help_url = $help_url;
		$this->HTMLtag = $HTMLtag;
		$this->isDeprecated = $isDeprecated;
		$this->transforms = $transforms;

		if (!in_array($form_type, ['simple', 'advanced'], true)) {
			$form_type = 'simple';
		}
		$this->form_type = $form_type;
		if (!in_array($method, ['GET', 'POST'], true)) {
			$method = 'GET';
		}
		$this->method = $method;
		$this->field = $field;
	}

	/**
	 * Update a FreshRSS_Share object with information from an array.
	 * @param array<string,string> $options is a list of information to update where keys should be
	 *        in this list: name, url, id, title, link.
	 */
	public function update(array $options): void {
		foreach ($options as $key => $value) {
			switch ($key) {
				case 'name':
					$this->custom_name = $value;
					break;
				case 'url':
					$this->base_url = $value;
					break;
				case 'id':
					$this->id = $value;
					break;
				case 'title':
					$this->title = $value;
					break;
				case 'link':
					$this->link = $value;
					break;
				case 'method':
					$this->method = strcasecmp($value, 'POST') === 0 ? 'POST' : 'GET';
					break;
				case 'field':
					$this->field = $value;
					break;
			}
		}
	}

	/**
	 * Return the current type of the share option.
	 */
	public function type(): string {
		return $this->type;
	}

	/**
	 * Return the current method of the share option.
	 * @return 'GET'|'POST'
	 */
	public function method(): string {
		return $this->method;
	}

	/**
	 * Return the current field of the share option. It’s null for shares
	 * using the GET method.
	 */
	public function field(): ?string {
		return $this->field;
	}

	/**
	 * Return the current form type of the share option.
	 * @return 'simple'|'advanced'
	 */
	public function formType(): string {
		return $this->form_type;
	}

	/**
	 * Return the current help url of the share option.
	 */
	public function help(): string {
		return $this->help_url;
	}

	/**
	 * Return the custom type of HTML tag of the share option, null for default.
	 * @return 'button'|null
	 */
	public function HTMLtag(): ?string {
		return $this->HTMLtag;
	}

	/**
	 * Return the current name of the share option.
	 */
	public function name(bool $real = false): ?string {
		if ($real || empty($this->custom_name)) {
			return $this->name;
		} else {
			return $this->custom_name;
		}
	}

	/**
	 * Return the current base url of the share option.
	 */
	public function baseUrl(): string {
		return $this->base_url ?? '';
	}

	/**
	 * Return the deprecated status of the share option.
	 */
	public function isDeprecated(): bool {
		return $this->isDeprecated;
	}

	/**
	 * Return the current url by merging url_transform and base_url.
	 */
	public function url(): string {
		$matches = [
			'~ID~',
			'~URL~',
			'~TITLE~',
			'~LINK~',
		];
		$replaces = [
			$this->id(),
			$this->base_url,
			$this->title(),
			$this->link(),
		];
		return str_replace($matches, $replaces, $this->url_transform);
	}

	/**
	 * Return the id.
	 * @param bool $raw true if we should get the id without transformations.
	 */
	public function id(bool $raw = false): ?string {
		if ($raw) {
			return $this->id;
		}

		if ($this->id === null) {
			return null;
		}
		return self::transform($this->id, $this->getTransform('id'));
	}

	/**
	 * Return the title.
	 * @param bool $raw true if we should get the title without transformations.
	 */
	public function title(bool $raw = false): string {
		if ($raw) {
			return $this->title ?? '';
		}

		if ($this->title === null) {
			return '';
		}
		return self::transform($this->title, $this->getTransform('title'));
	}

	/**
	 * Return the link.
	 * @param bool $raw true if we should get the link without transformations.
	 */
	public function link(bool $raw = false): string {
		if ($raw) {
			return $this->link ?? '';
		}
		if ($this->link === null) {
			return '';
		}

		return self::transform($this->link, $this->getTransform('link'));
	}

	/**
	 * Transform a data with the given functions.
	 * @param string $data the data to transform.
	 * @param array<callable> $transform an array containing a list of functions to apply.
	 * @return string the transformed data.
	 */
	private static function transform(string $data, array $transform): string {
		if (empty($transform)) {
			return $data;
		}

		foreach ($transform as $action) {
			$data = call_user_func($action, $data);
		}

		return $data;
	}

	/**
	 * Get the list of transformations for the given attribute.
	 * @param string $attr the attribute of which we want the transformations.
	 * @return array<callable> containing a list of transformations to apply.
	 */
	private function getTransform(string $attr): array {
		if (array_key_exists($attr, $this->transforms)) {
			$candidates = is_array($this->transforms[$attr]) ? $this->transforms[$attr] : [];
		} else {
			$candidates = $this->transforms;
		}

		$transforms = [];
		foreach ($candidates as $transform) {
			if (is_callable($transform)) {
				$transforms[] = $transform;
			}
		}
		return $transforms;
	}
}
