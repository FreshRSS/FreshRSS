<?php
declare(strict_types=1);

/**
 * @property string $apiPasswordHash
 * @property array{'keep_period':string|false,'keep_max':int|false,'keep_min':int|false,'keep_favourites':bool,'keep_labels':bool,'keep_unreads':bool} $archiving
 * @property bool $auto_load_more
 * @property bool $auto_remove_article
 * @property bool $bottomline_date
 * @property bool $bottomline_favorite
 * @property bool $bottomline_link
 * @property bool $bottomline_read
 * @property bool $bottomline_sharing
 * @property bool $bottomline_tags
 * @property bool $bottomline_myLabels
 * @property string $content_width
 * @property-read int $default_state
 * @property string $default_view
 * @property string|bool $display_categories
 * @property string $show_tags
 * @property int $show_tags_max
 * @property string $show_author_date
 * @property string $show_feed_name
 * @property bool $display_posts
 * @property string $email_validation_token
 * @property-read bool $enabled
 * @property string $feverKey
 * @property bool $hide_read_feeds
 * @property int $html5_notif_timeout
 * @property-read bool $is_admin
 * @property int|null $keep_history_default
 * @property string $language
 * @property string $timezone
 * @property bool $lazyload
 * @property string $mail_login
 * @property bool $mark_updated_article_unread
 * @property array<string,bool|int> $mark_when
 * @property int $max_posts_per_rss
 * @property-read array<string,int> $limits
 * @property int|null $old_entries
 * @property bool $onread_jump_next
 * @property string $passwordHash
 * @property int $posts_per_page
 * @property array<array{'get'?:string,'name'?:string,'order'?:string,'search'?:string,'state'?:int,'url'?:string,'token'?:string}> $queries
 * @property bool $reading_confirm
 * @property int $since_hours_posts_per_rss
 * @property bool $show_fav_unread
 * @property bool $show_favicons
 * @property bool $icons_as_emojis
 * @property int $simplify_over_n_feeds
 * @property bool $show_nav_buttons
 * @property 'ASC'|'DESC' $sort_order
 * @property array<string,array<string>> $sharing
 * @property array<string,string> $shortcuts
 * @property bool $sides_close_article
 * @property bool $sticky_post
 * @property string $theme
 * @property string $darkMode
 * @property string $token
 * @property bool $topline_date
 * @property bool $topline_display_authors
 * @property bool $topline_favorite
 * @property bool $topline_link
 * @property bool $topline_read
 * @property bool $topline_summary
 * @property string $topline_website
 * @property string $topline_thumbnail
 * @property int $ttl_default
 * @property int $dynamic_opml_ttl_default
 * @property-read bool $unsafe_autologin_enabled
 * @property string $view_mode
 * @property array<string,mixed> $volatile
 * @property array<string,array<string,mixed>> $extensions
 */
final class FreshRSS_UserConfiguration extends Minz_Configuration {
	use FreshRSS_FilterActionsTrait;

	/** @throws Minz_ConfigurationNamespaceException */
	public static function init(string $config_filename, ?string $default_filename = null): FreshRSS_UserConfiguration {
		parent::register('user', $config_filename, $default_filename);
		return parent::get('user');
	}

	/**
	 * Access the default configuration for users.
	 * @throws Minz_FileNotExistException
	 */
	public static function default(): FreshRSS_UserConfiguration {
		static $default_user_conf = null;
		if ($default_user_conf == null) {
			$namespace = 'user_default';
			FreshRSS_UserConfiguration::register($namespace, '_', FRESHRSS_PATH . '/config-user.default.php');
			$default_user_conf = FreshRSS_UserConfiguration::get($namespace);
		}
		return $default_user_conf;
	}

	/**
	 * @param non-empty-string $key
	 * @return array<int|string,mixed>|null
	 */
	public function attributeArray(string $key): ?array {
		$a = parent::param($key, null);
		return is_array($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeBool(string $key): ?bool {
		$a = parent::param($key, null);
		return is_bool($a) ? $a : null;
	}

	/** @param non-empty-string $key */
	public function attributeInt(string $key): ?int {
		$a = parent::param($key, null);
		return is_numeric($a) ? (int)$a : null;
	}

	/** @param non-empty-string $key */
	public function attributeString(string $key): ?string {
		$a = parent::param($key, null);
		return is_string($a) ? $a : null;
	}

	/**
	 * @param non-empty-string $key
	 * @param array<string,mixed>|mixed|null $value Value, not HTML-encoded
	 */
	public function _attribute(string $key, $value = null): void {
		parent::_param($key, $value);
	}
}
