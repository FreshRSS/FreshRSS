<?php
declare(strict_types=1);

/**
 * Contains the description of a user query
 *
 * It allows to extract the meaningful bits of the query to be manipulated in an
 * easy way.
 */
class FreshRSS_UserQuery {

	private bool $deprecated = false;
	private string $get = '';
	private string $get_name = '';
	private string $get_type = '';
	private string $name = '';
	private string $order = '';
	private FreshRSS_BooleanSearch $search;
	private int $state = 0;
	private string $url = '';
	private string $token = '';
	private bool $shareRss = false;
	private bool $shareOpml = false;
	/** @var array<int,FreshRSS_Category> $categories */
	private array $categories;
	/** @var array<int,FreshRSS_Tag> $labels */
	private array $labels;

	public static function generateToken(string $salt): string {
		if (!FreshRSS_Context::hasSystemConf()) {
			return '';
		}
		$hash = md5(FreshRSS_Context::systemConf()->salt . $salt . random_bytes(16));
		if (function_exists('gmp_init')) {
			// Shorten the hash if possible by converting from base 16 to base 62
			$hash = gmp_strval(gmp_init($hash, 16), 62);
		}
		return $hash;
	}

	/**
	 * @param array{get?:string,name?:string,order?:string,search?:string,state?:int,url?:string,token?:string,shareRss?:bool,shareOpml?:bool} $query
	 * @param array<int,FreshRSS_Category> $categories
	 * @param array<int,FreshRSS_Tag> $labels
	 */
	public function __construct(array $query, array $categories, array $labels) {
		$this->categories = $categories;
		$this->labels = $labels;
		if (isset($query['get'])) {
			$this->parseGet($query['get']);
		}
		if (isset($query['name'])) {
			$this->name = trim($query['name']);
		}
		if (isset($query['order'])) {
			$this->order = $query['order'];
		}
		if (empty($query['url'])) {
			if (!empty($query)) {
				unset($query['name']);
				$this->url = Minz_Url::display(['params' => $query]);
			}
		} else {
			$this->url = $query['url'];
		}
		if (!isset($query['search'])) {
			$query['search'] = '';
		}
		if (!empty($query['token'])) {
			$this->token = $query['token'];
		}
		if (isset($query['shareRss'])) {
			$this->shareRss = $query['shareRss'];
		}
		if (isset($query['shareOpml'])) {
			$this->shareOpml = $query['shareOpml'];
		}

		// linked too deeply with the search object, need to use dependency injection
		$this->search = new FreshRSS_BooleanSearch($query['search'], 0, 'AND', false);
		if (!empty($query['state'])) {
			$this->state = intval($query['state']);
		}
	}

	/**
	 * Convert the current object to an array.
	 *
	 * @return array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string,'token'?:string}
	 */
	public function toArray(): array {
		return array_filter([
			'get' => $this->get,
			'name' => $this->name,
			'order' => $this->order,
			'search' => $this->search->getRawInput(),
			'state' => $this->state,
			'url' => $this->url,
			'token' => $this->token,
			'shareRss' => $this->shareRss,
			'shareOpml' => $this->shareOpml,
		]);
	}

	/**
	 * Parse the get parameter in the query string to extract its name and type
	 */
	private function parseGet(string $get): void {
		$this->get = $get;
		if (preg_match('/(?P<type>[acfistT])(_(?P<id>\d+))?/', $get, $matches)) {
			$id = intval($matches['id'] ?? '0');
			switch ($matches['type']) {
				case 'a':
					$this->get_type = 'all';
					break;
				case 'c':
					$this->get_type = 'category';
					$c = $this->categories[$id] ?? null;
					$this->get_name = $c === null ? '' : $c->name();
					break;
				case 'f':
					$this->get_type = 'feed';
					$f = FreshRSS_Category::findFeed($this->categories, $id);
					$this->get_name = $f === null ? '' : $f->name();
					break;
				case 'i':
					$this->get_type = 'important';
					break;
				case 's':
					$this->get_type = 'favorite';
					break;
				case 't':
					$this->get_type = 'label';
					$l = $this->labels[$id] ?? null;
					$this->get_name = $l === null ? '' : $l->name();
					break;
				case 'T':
					$this->get_type = 'all_labels';
					break;
			}
			if ($this->get_name === '' && in_array($matches['type'], ['c', 'f', 't'], true)) {
				$this->deprecated = true;
			}
		}
	}

	/**
	 * Check if the current user query is deprecated.
	 * It is deprecated if the category or the feed used in the query are
	 * not existing.
	 */
	public function isDeprecated(): bool {
		return $this->deprecated;
	}

	/**
	 * Check if the user query has parameters.
	 * If the type is 'all', it is considered equal to no parameters
	 */
	public function hasParameters(): bool {
		if ($this->get_type === 'all') {
			return false;
		}
		if ($this->hasSearch()) {
			return true;
		}
		if ($this->state) {
			return true;
		}
		if ($this->order) {
			return true;
		}
		if ($this->get) {
			return true;
		}
		return false;
	}

	/**
	 * Check if there is a search in the search object
	 */
	public function hasSearch(): bool {
		return $this->search->getRawInput() !== '';
	}

	public function getGet(): string {
		return $this->get;
	}

	public function getGetName(): string {
		return $this->get_name;
	}

	public function getGetType(): string {
		return $this->get_type;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getOrder(): string {
		return $this->order ?: FreshRSS_Context::userConf()->sort_order;
	}

	public function getSearch(): FreshRSS_BooleanSearch {
		return $this->search;
	}

	public function getState(): int {
		$state = $this->state;
		if (!($state & FreshRSS_Entry::STATE_READ) && !($state & FreshRSS_Entry::STATE_NOT_READ)) {
			$state |= FreshRSS_Entry::STATE_READ | FreshRSS_Entry::STATE_NOT_READ;
		}
		if (!($state & FreshRSS_Entry::STATE_FAVORITE) && !($state & FreshRSS_Entry::STATE_NOT_FAVORITE)) {
			$state |= FreshRSS_Entry::STATE_FAVORITE | FreshRSS_Entry::STATE_NOT_FAVORITE;
		}
		return $state;
	}

	public function getUrl(): string {
		return $this->url;
	}

	public function getToken(): string {
		return $this->token;
	}

	public function setToken(string $token): void {
		$this->token = $token;
	}

	public function setShareRss(bool $shareRss): void {
		$this->shareRss = $shareRss;
	}

	public function shareRss(): bool {
		return $this->shareRss;
	}

	public function setShareOpml(bool $shareOpml): void {
		$this->shareOpml = $shareOpml;
	}

	public function shareOpml(): bool {
		return $this->shareOpml;
	}

	protected function sharedUrl(bool $xmlEscaped = true): string {
		$currentUser = Minz_User::name() ?? '';
		return Minz_Url::display("/api/query.php?user={$currentUser}&t={$this->token}", $xmlEscaped ? 'html' : '', true);
	}

	public function sharedUrlRss(bool $xmlEscaped = true): string {
		if ($this->shareRss && $this->token !== '') {
			return $this->sharedUrl($xmlEscaped) . ($xmlEscaped ? '&amp;' : '&') . 'f=rss';
		}
		return '';
	}

	public function sharedUrlHtml(bool $xmlEscaped = true): string {
		if ($this->shareRss && $this->token !== '') {
			return $this->sharedUrl($xmlEscaped) . ($xmlEscaped ? '&amp;' : '&') . 'f=html';
		}
		return '';
	}

	/**
	 * OPML is only safe for some query types, otherwise it risks leaking unwanted feed information.
	 */
	public function safeForOpml(): bool {
		return in_array($this->get_type, ['all', 'category', 'feed'], true);
	}

	public function sharedUrlOpml(bool $xmlEscaped = true): string {
		if ($this->shareOpml && $this->token !== '' && $this->safeForOpml()) {
			return $this->sharedUrl($xmlEscaped) . ($xmlEscaped ? '&amp;' : '&') . 'f=opml';
		}
		return '';
	}
}
