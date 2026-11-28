<?php
declare(strict_types=1);

/**
 * Remote MCP endpoint for read-only FreshRSS access.
 *
 * Configure either:
 * - FRESHRSS_MCP_USER and FRESHRSS_MCP_TOKEN environment variables; or
 * - data/config.php:
 *   'mcp_server' => [
 *     'tokens' => [
 *       'alice' => 'long-random-token',
 *     ],
 *   ],
 */

require dirname(__DIR__, 2) . '/constants.php';
require LIB_PATH . '/lib_rss.php';

header("Content-Security-Policy: default-src 'none'; frame-ancestors 'none'; sandbox");
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Headers: Authorization, Content-Type, MCP-Protocol-Version, MCP-Session-Id');
header('Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 600');

const FRESHRSS_MCP_JSON = JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
const FRESHRSS_MCP_PROTOCOL_VERSION = '2025-11-25';

/**
 * @param array<string,mixed>|list<mixed> $payload
 */
function freshrss_mcp_json(array $payload, int $status = 200): never {
	http_response_code($status);
	header('Content-Type: application/json; charset=UTF-8');
	echo json_encode($payload, FRESHRSS_MCP_JSON), "\n";
	exit();
}

function freshrss_mcp_no_content(int $status): never {
	http_response_code($status);
	exit();
}

/**
 * @param string|int|null $id
 * @param array<string,mixed> $result
 */
function freshrss_mcp_result(string|int|null $id, array $result): never {
	freshrss_mcp_json([
		'jsonrpc' => '2.0',
		'id' => $id,
		'result' => $result,
	]);
}

/**
 * @param string|int|null $id
 * @param mixed $data
 */
function freshrss_mcp_error(string|int|null $id, int $code, string $message, mixed $data = null, int $status = 200): never {
	$error = [
		'code' => $code,
		'message' => $message,
	];
	if ($data !== null) {
		$error['data'] = $data;
	}
	freshrss_mcp_json([
		'jsonrpc' => '2.0',
		'id' => $id,
		'error' => $error,
	], $status);
}

function freshrss_mcp_header(string $headerName): string {
	$upName = 'HTTP_' . strtoupper(str_replace('-', '_', $headerName));
	if (is_string($_SERVER[$upName] ?? null)) {
		return trim($_SERVER[$upName]);
	}
	if (function_exists('getallheaders')) {
		$headers = getallheaders();
		foreach ($headers as $key => $value) {
			if (is_string($key) && strcasecmp($key, $headerName) === 0 && is_string($value)) {
				return trim($value);
			}
		}
	}
	return '';
}

function freshrss_mcp_request_token(): string {
	$authorization = freshrss_mcp_header('Authorization');
	if (preg_match('/^Bearer\s+(?<token>.+)$/i', $authorization, $matches) === 1) {
		return trim($matches['token']);
	}
	if (is_string($_GET['token'] ?? null)) {
		return trim($_GET['token']);
	}
	return '';
}

/**
 * @return array<string,string>
 */
function freshrss_mcp_configured_tokens(): array {
	$tokens = [];
	$envUser = getenv('FRESHRSS_MCP_USER');
	$envToken = getenv('FRESHRSS_MCP_TOKEN');
	if (is_string($envUser) && $envUser !== '' && is_string($envToken) && $envToken !== '') {
		$tokens[$envUser] = $envToken;
	}

	$config = FreshRSS_Context::systemConf()->attributeArray('mcp_server') ?? [];
	if (($config['enabled'] ?? true) === false) {
		return [];
	}

	$configTokens = $config['tokens'] ?? [];
	if (is_array($configTokens)) {
		foreach ($configTokens as $user => $token) {
			if (is_string($user) && $user !== '' && is_string($token) && $token !== '') {
				$tokens[$user] = $token;
			}
		}
	}
	return $tokens;
}

function freshrss_mcp_validate_origin(): void {
	$origin = freshrss_mcp_header('Origin');
	if ($origin === '') {
		return;
	}

	$config = FreshRSS_Context::systemConf()->attributeArray('mcp_server') ?? [];
	$allowedOrigins = $config['allowed_origins'] ?? [
		'https://claude.ai',
		'https://www.claude.ai',
		'https://claude.com',
		'https://www.claude.com',
	];
	if (!is_array($allowedOrigins)) {
		$allowedOrigins = [];
	}
	foreach ($allowedOrigins as $allowedOrigin) {
		if (is_string($allowedOrigin) && strcasecmp($origin, $allowedOrigin) === 0) {
			return;
		}
	}
	freshrss_mcp_error(null, -32000, 'Forbidden origin.', null, 403);
}

function freshrss_mcp_init_context(): void {
	FreshRSS_Context::initSystem();
	freshrss_mcp_validate_origin();

	$token = freshrss_mcp_request_token();
	if ($token === '') {
		freshrss_mcp_error(null, -32001, 'Missing MCP token.', null, 401);
	}

	$matchedUser = '';
	foreach (freshrss_mcp_configured_tokens() as $user => $validToken) {
		if (hash_equals($validToken, $token)) {
			$matchedUser = $user;
			break;
		}
	}
	if ($matchedUser === '') {
		freshrss_mcp_error(null, -32001, 'Invalid MCP token.', null, 401);
	}
	if (!FreshRSS_user_Controller::checkUsername($matchedUser)) {
		freshrss_mcp_error(null, -32001, 'Invalid MCP user.', null, 401);
	}

	Minz_Session::init('FreshRSS', true);
	FreshRSS_Context::initUser($matchedUser);
	if (!FreshRSS_Context::hasUserConf() || !FreshRSS_Context::userConf()->enabled) {
		freshrss_mcp_error(null, -32001, 'MCP user is not available.', null, 401);
	}
	Minz_Translate::init(FreshRSS_Context::userConf()->language);
}

/**
 * @return list<array<string,mixed>>
 */
function freshrss_mcp_tools(): array {
	return [
		[
			'name' => 'freshrss.account_summary',
			'title' => 'FreshRSS account summary',
			'description' => 'Return a summary of the connected FreshRSS user, including feed and unread counts.',
			'inputSchema' => [
				'type' => 'object',
				'additionalProperties' => false,
			],
			'annotations' => [
				'readOnlyHint' => true,
			],
		],
		[
			'name' => 'freshrss.list_feeds',
			'title' => 'List FreshRSS feeds',
			'description' => 'List the FreshRSS feeds visible to the connected user.',
			'inputSchema' => [
				'type' => 'object',
				'properties' => [
					'include_hidden' => [
						'type' => 'boolean',
						'description' => 'Whether to include hidden or archived feeds.',
						'default' => false,
					],
				],
				'additionalProperties' => false,
			],
			'annotations' => [
				'readOnlyHint' => true,
			],
		],
		[
			'name' => 'freshrss.list_articles',
			'title' => 'List FreshRSS articles',
			'description' => 'List recent FreshRSS articles with optional FreshRSS search syntax, feed/category filtering, and read/starred state.',
			'inputSchema' => [
				'type' => 'object',
				'properties' => [
					'search' => [
						'type' => 'string',
						'description' => 'FreshRSS search expression, such as author:alice or quoted terms.',
					],
					'feed_id' => [
						'type' => 'integer',
						'description' => 'Restrict results to one FreshRSS feed id.',
						'minimum' => 1,
					],
					'category_id' => [
						'type' => 'integer',
						'description' => 'Restrict results to one FreshRSS category id.',
						'minimum' => 1,
					],
					'state' => [
						'type' => 'string',
						'enum' => ['all', 'read', 'unread', 'starred'],
						'default' => 'all',
					],
					'limit' => [
						'type' => 'integer',
						'minimum' => 1,
						'maximum' => 50,
						'default' => 10,
					],
					'include_content' => [
						'type' => 'boolean',
						'description' => 'Whether to include a plain-text excerpt of each article body.',
						'default' => true,
					],
				],
				'additionalProperties' => false,
			],
			'annotations' => [
				'readOnlyHint' => true,
			],
		],
		[
			'name' => 'freshrss.get_article',
			'title' => 'Get FreshRSS article',
			'description' => 'Fetch one FreshRSS article by id, including content.',
			'inputSchema' => [
				'type' => 'object',
				'properties' => [
					'id' => [
						'type' => 'string',
						'description' => 'FreshRSS article id.',
					],
				],
				'required' => ['id'],
				'additionalProperties' => false,
			],
			'annotations' => [
				'readOnlyHint' => true,
			],
		],
	];
}

/**
 * @return array<string,mixed>
 */
function freshrss_mcp_feed_to_array(FreshRSS_Feed $feed, string $category): array {
	return [
		'id' => $feed->id(),
		'title' => html_entity_decode($feed->name(), ENT_QUOTES, 'UTF-8'),
		'category' => html_entity_decode($category, ENT_QUOTES, 'UTF-8'),
		'url' => html_entity_decode($feed->url(), ENT_QUOTES, 'UTF-8'),
		'html_url' => html_entity_decode($feed->website(), ENT_QUOTES, 'UTF-8'),
		'unread_count' => $feed->nbNotRead(),
		'total_count' => $feed->nbEntries(),
		'last_update' => $feed->lastUpdate() > 0 ? date(DATE_ATOM, $feed->lastUpdate()) : null,
		'priority' => $feed->priority(),
	];
}

function freshrss_mcp_text_from_html(string $html, int $maxLength = 4000): string {
	$text = html_entity_decode(trim(strip_tags($html)), ENT_QUOTES, 'UTF-8');
	$text = preg_replace('/[ \t\r\n]+/', ' ', $text) ?? $text;
	if (mb_strlen($text, 'UTF-8') > $maxLength) {
		return mb_substr($text, 0, $maxLength, 'UTF-8') . '...';
	}
	return $text;
}

/**
 * @return array<string,mixed>
 */
function freshrss_mcp_entry_to_array(FreshRSS_Entry $entry, bool $includeContent): array {
	$feed = $entry->feed();
	$article = [
		'id' => $entry->id(),
		'title' => html_entity_decode($entry->title(), ENT_QUOTES, 'UTF-8'),
		'url' => html_entity_decode($entry->link(), ENT_QUOTES, 'UTF-8'),
		'author' => html_entity_decode(ltrim($entry->authors(true), ';'), ENT_QUOTES, 'UTF-8'),
		'published_at' => $entry->machineReadableDate(),
		'is_read' => $entry->isRead(),
		'is_favorite' => $entry->isFavorite(),
		'feed_id' => $entry->feedId(),
		'feed_title' => $feed === null ? '' : html_entity_decode($feed->name(), ENT_QUOTES, 'UTF-8'),
		'tags' => array_map(static fn (string $tag): string => html_entity_decode($tag, ENT_QUOTES, 'UTF-8'), $entry->tags()),
	];
	if ($includeContent) {
		$article['content_text'] = freshrss_mcp_text_from_html($entry->content(false));
	}
	return $article;
}

/**
 * @return array<string,mixed>
 */
function freshrss_mcp_account_summary(): array {
	$categoryDAO = FreshRSS_Factory::createCategoryDao();
	$categories = $categoryDAO->listCategories(prePopulateFeeds: true, details: true);
	$feeds = 0;
	$visibleFeeds = 0;
	foreach ($categories as $category) {
		foreach ($category->feeds() as $feed) {
			$feeds++;
			if ($feed->priority() > FreshRSS_Feed::PRIORITY_HIDDEN) {
				$visibleFeeds++;
			}
		}
	}

	$entryDAO = FreshRSS_Factory::createEntryDao();
	$states = $entryDAO->countAsStates(FreshRSS_Feed::PRIORITY_HIDDEN);

	return [
		'user' => Minz_User::name(),
		'instance_title' => FreshRSS_Context::systemConf()->title,
		'base_url' => FreshRSS_Context::systemConf()->base_url,
		'categories_count' => count($categories),
		'feeds_count' => $feeds,
		'visible_feeds_count' => $visibleFeeds,
		'unread_count' => $states['unread'] ?? 0,
		'read_count' => $states['read'] ?? 0,
		'starred_count' => $states['favorites'] ?? 0,
	];
}

/**
 * @param array<string,mixed> $arguments
 * @return array<string,mixed>
 */
function freshrss_mcp_list_feeds(array $arguments): array {
	$includeHidden = ($arguments['include_hidden'] ?? false) === true;
	$categoryDAO = FreshRSS_Factory::createCategoryDao();
	$feeds = [];
	foreach ($categoryDAO->listCategories(prePopulateFeeds: true, details: true) as $category) {
		foreach ($category->feeds() as $feed) {
			if (!$includeHidden && $feed->priority() <= FreshRSS_Feed::PRIORITY_HIDDEN) {
				continue;
			}
			$feeds[] = freshrss_mcp_feed_to_array($feed, $category->name());
		}
	}
	return [
		'feeds' => $feeds,
		'count' => count($feeds),
	];
}

/**
 * @param array<string,mixed> $arguments
 * @return array<string,mixed>
 */
function freshrss_mcp_list_articles(array $arguments): array {
	$limit = is_numeric($arguments['limit'] ?? null) ? (int)$arguments['limit'] : 10;
	$limit = max(1, min(50, $limit));
	$includeContent = ($arguments['include_content'] ?? true) !== false;
	$searchText = is_string($arguments['search'] ?? null) ? $arguments['search'] : '';
	$stateName = is_string($arguments['state'] ?? null) ? $arguments['state'] : 'all';

	$type = 'A';
	$id = 0;
	if (is_numeric($arguments['feed_id'] ?? null) && (int)$arguments['feed_id'] > 0) {
		$type = 'f';
		$id = (int)$arguments['feed_id'];
	} elseif (is_numeric($arguments['category_id'] ?? null) && (int)$arguments['category_id'] > 0) {
		$type = 'c';
		$id = (int)$arguments['category_id'];
	}

	$state = match ($stateName) {
		'read' => FreshRSS_Entry::STATE_READ,
		'unread' => FreshRSS_Entry::STATE_NOT_READ,
		'starred' => FreshRSS_Entry::STATE_FAVORITE,
		default => FreshRSS_Entry::STATE_ALL,
	};

	$search = new FreshRSS_BooleanSearch($searchText);
	$entryDAO = FreshRSS_Factory::createEntryDao();
	$articles = [];
	foreach ($entryDAO->listWhere($type, $id, $state, $search, limit: $limit) as $entry) {
		$articles[] = freshrss_mcp_entry_to_array($entry, $includeContent);
	}

	return [
		'articles' => $articles,
		'count' => count($articles),
	];
}

/**
 * @param array<string,mixed> $arguments
 * @return array<string,mixed>
 */
function freshrss_mcp_get_article(array $arguments): array {
	$id = is_string($arguments['id'] ?? null) ? trim($arguments['id']) : '';
	if ($id === '' || !ctype_digit($id)) {
		throw new InvalidArgumentException('id must be a FreshRSS numeric article id.');
	}
	$entryDAO = FreshRSS_Factory::createEntryDao();
	$entry = $entryDAO->searchById($id);
	if ($entry === null) {
		throw new OutOfBoundsException('Article not found.');
	}
	return [
		'article' => freshrss_mcp_entry_to_array($entry, true),
	];
}

/**
 * @param array<string,mixed> $arguments
 * @return array<string,mixed>
 */
function freshrss_mcp_call_tool(string $name, array $arguments): array {
	return match ($name) {
		'freshrss.account_summary' => freshrss_mcp_account_summary(),
		'freshrss.list_feeds' => freshrss_mcp_list_feeds($arguments),
		'freshrss.list_articles' => freshrss_mcp_list_articles($arguments),
		'freshrss.get_article' => freshrss_mcp_get_article($arguments),
		default => throw new InvalidArgumentException('Unknown tool: ' . $name),
	};
}

/**
 * @param array<string,mixed> $payload
 * @return string|int|null
 */
function freshrss_mcp_request_id(array $payload): string|int|null {
	$id = $payload['id'] ?? null;
	return is_string($id) || is_int($id) || $id === null ? $id : null;
}

try {
	FreshRSS_Context::initSystem();
	if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') {
		freshrss_mcp_no_content(204);
	}
	if (($_SERVER['REQUEST_METHOD'] ?? '') === 'HEAD') {
		freshrss_mcp_no_content(200);
	}
	if (($_SERVER['REQUEST_METHOD'] ?? '') === 'GET') {
		header('Allow: HEAD, OPTIONS, POST');
		freshrss_mcp_no_content(405);
	}
	if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
		header('Allow: HEAD, OPTIONS, POST');
		freshrss_mcp_error(null, -32600, 'Only POST is supported for MCP JSON-RPC requests.', null, 405);
	}

	freshrss_mcp_init_context();

	$raw = file_get_contents('php://input', false, null, 0, 2097152);
	$payload = json_decode(is_string($raw) ? $raw : '', true, flags: JSON_THROW_ON_ERROR);
	if (!is_array($payload) || !is_array_keys_string($payload)) {
		freshrss_mcp_error(null, -32600, 'Invalid JSON-RPC request.', null, 400);
	}

	$id = freshrss_mcp_request_id($payload);
	$method = $payload['method'] ?? null;
	if (!is_string($method) || ($payload['jsonrpc'] ?? null) !== '2.0') {
		freshrss_mcp_error($id, -32600, 'Invalid JSON-RPC request.', null, 400);
	}
	if (!array_key_exists('id', $payload)) {
		freshrss_mcp_no_content(202);
	}

	switch ($method) {
		case 'initialize':
			$params = is_array($payload['params'] ?? null) ? $payload['params'] : [];
			$requestedVersion = is_string($params['protocolVersion'] ?? null) ? $params['protocolVersion'] : FRESHRSS_MCP_PROTOCOL_VERSION;
			$protocolVersion = in_array($requestedVersion, ['2025-11-25', '2025-06-18', '2025-03-26'], true) ?
				$requestedVersion :
				FRESHRSS_MCP_PROTOCOL_VERSION;
			freshrss_mcp_result($id, [
				'protocolVersion' => $protocolVersion,
				'capabilities' => [
					'tools' => [
						'listChanged' => false,
					],
				],
				'serverInfo' => [
					'name' => 'freshrss',
					'title' => 'FreshRSS',
					'version' => FRESHRSS_VERSION,
					'websiteUrl' => FRESHRSS_WEBSITE,
				],
				'instructions' => 'Read-only access to FreshRSS feeds and articles for the authenticated user.',
			]);

		case 'ping':
			freshrss_mcp_result($id, []);

		case 'tools/list':
			freshrss_mcp_result($id, [
				'tools' => freshrss_mcp_tools(),
			]);

		case 'tools/call':
			$params = is_array($payload['params'] ?? null) ? $payload['params'] : [];
			$name = $params['name'] ?? '';
			$arguments = $params['arguments'] ?? [];
			if (!is_string($name) || !is_array($arguments) || !is_array_keys_string($arguments)) {
				freshrss_mcp_error($id, -32602, 'Invalid tools/call parameters.');
			}
			try {
				$result = freshrss_mcp_call_tool($name, $arguments);
				freshrss_mcp_result($id, [
					'content' => [
						[
							'type' => 'text',
							'text' => json_encode($result, FRESHRSS_MCP_JSON),
						],
					],
					'structuredContent' => $result,
					'isError' => false,
				]);
			} catch (InvalidArgumentException | OutOfBoundsException $e) {
				freshrss_mcp_result($id, [
					'content' => [
						[
							'type' => 'text',
							'text' => $e->getMessage(),
						],
					],
					'isError' => true,
				]);
			}

		default:
			freshrss_mcp_error($id, -32601, 'Method not found: ' . $method);
	}
} catch (JsonException $e) {
	freshrss_mcp_error(null, -32700, 'Parse error.', $e->getMessage(), 400);
} catch (Throwable $e) {
	Minz_Log::error('FreshRSS MCP error: ' . $e->getMessage());
	freshrss_mcp_error(null, -32603, 'Internal error.', null, 500);
}
