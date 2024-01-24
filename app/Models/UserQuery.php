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
	private ?FreshRSS_FeedDAO $feed_dao;
	private ?FreshRSS_CategoryDAO $category_dao;
	private ?FreshRSS_TagDAO $tag_dao;

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
	 * @param array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string,'token'?:string} $query
	 */
	public function __construct(array $query, FreshRSS_FeedDAO $feed_dao = null, FreshRSS_CategoryDAO $category_dao = null, FreshRSS_TagDAO $tag_dao = null) {
		$this->category_dao = $category_dao;
		$this->feed_dao = $feed_dao;
		$this->tag_dao = $tag_dao;
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
		// linked too deeply with the search object, need to use dependency injection
		$this->search = new FreshRSS_BooleanSearch($query['search']);
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
			'search' => $this->search->__toString(),
			'state' => $this->state,
			'url' => $this->url,
			'token' => $this->token,
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
					$this->parseCategory($id);
					break;
				case 'f':
					$this->parseFeed($id);
					break;
				case 'i':
					$this->get_type = 'important';
					break;
				case 's':
					$this->get_type = 'favorite';
					break;
				case 't':
					$this->parseLabel($id);
					break;
				case 'T':
					$this->get_type = 'all_labels';
					break;
			}
		}
	}

	/**
	 * Parse the query string when it is a "category" query
	 */
	private function parseCategory(int $id): void {
		if ($this->category_dao === null) {
			$this->category_dao = FreshRSS_Factory::createCategoryDao();
		}
		$category = $this->category_dao->searchById($id);
		if ($category !== null) {
			$this->get_name = $category->name();
		} else {
			$this->deprecated = true;
		}
		$this->get_type = 'category';
	}

	/**
	 * Parse the query string when it is a "feed" query
	 */
	private function parseFeed(int $id): void {
		if ($this->feed_dao === null) {
			$this->feed_dao = FreshRSS_Factory::createFeedDao();
		}
		$feed = $this->feed_dao->searchById($id);
		if ($feed !== null) {
			$this->get_name = $feed->name();
		} else {
			$this->deprecated = true;
		}
		$this->get_type = 'feed';
	}

	/**
	 * Parse the query string when it is a "label" query
	 */
	private function parseLabel(int $id): void {
		if ($this->tag_dao === null) {
			$this->tag_dao = FreshRSS_Factory::createTagDao();
		}
		$tag = $this->tag_dao->searchById($id);
		if ($tag !== null) {
			$this->get_name = $tag->name();
		} else {
			$this->deprecated = true;
		}
		$this->get_type = 'label';
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
		return $this->order;
	}

	public function getSearch(): FreshRSS_BooleanSearch {
		return $this->search;
	}

	public function getState(): int {
		return $this->state;
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

	protected function sharedUrl(bool $xmlEscaped = true): string {
		$currentUser = Minz_User::name() ?? '';
		return Minz_Url::display("/api/query.php?user={$currentUser}&t={$this->token}", $xmlEscaped ? 'html' : '', true);
	}

	public function sharedUrlRss(bool $xmlEscaped = true): string {
		return $this->sharedUrl($xmlEscaped) . ($xmlEscaped ? '&amp;' : '&') . 'f=rss';
	}

	public function sharedUrlHtml(bool $xmlEscaped = true): string {
		return $this->sharedUrl($xmlEscaped) . ($xmlEscaped ? '&amp;' : '&') . 'f=html';
	}
}
