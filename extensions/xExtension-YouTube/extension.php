<?php

/**
 * Class YouTubeExtension
 *
 * Latest version can be found at https://github.com/kevinpapst/freshrss-youtube
 *
 * @author Kevin Papst
 */
final class YouTubeExtension extends Minz_Extension
{
    /**
     * Video player width
     */
    private int $width = 560;
    /**
     * Video player height
     */
	private int $height = 315;
    /**
     * Whether we display the original feed content
     */
	private bool $showContent = false;
    /**
     * Switch to enable the Youtube No-Cookie domain
     */
	private bool $useNoCookie = false;

    /**
     * Initialize this extension
     */
	#[\Override]
    public function init(): void
    {
        $this->registerHook('entry_before_display', [$this, 'embedYouTubeVideo']);
        $this->registerHook('check_url_before_add', [self::class, 'convertYoutubeFeedUrl']);
        $this->registerTranslates();
    }

    public static function convertYoutubeFeedUrl(string $url): string
    {
        $matches = [];

        if (preg_match('#^https?://www\.youtube\.com/channel/([0-9a-zA-Z_-]{6,36})#', $url, $matches) === 1) {
            return 'https://www.youtube.com/feeds/videos.xml?channel_id=' . $matches[1];
        }

        if (preg_match('#^https?://www\.youtube\.com/user/([0-9a-zA-Z_-]{6,36})#', $url, $matches) === 1) {
            return 'https://www.youtube.com/feeds/videos.xml?user=' . $matches[1];
        }

        return $url;
    }

    /**
     * Initializes the extension configuration, if the user context is available.
     * Do not call that in your extensions init() method, it can't be used there.
     */
    public function loadConfigValues(): void
    {
        if (!class_exists('FreshRSS_Context', false) || !FreshRSS_Context::hasUserConf()) {
            return;
        }

		$width = FreshRSS_Context::userConf()->attributeInt('yt_player_width');
        if ($width !== null) {
            $this->width = $width;
        }

		$height = FreshRSS_Context::userConf()->attributeInt('yt_player_height');
        if ($height !== null) {
            $this->height = $height;
        }

		$showContent = FreshRSS_Context::userConf()->attributeBool('yt_show_content');
        if ($showContent !== null) {
            $this->showContent = $showContent;
        }

		$noCookie = FreshRSS_Context::userConf()->attributeBool('yt_nocookie');
        if ($noCookie !== null) {
            $this->useNoCookie = $noCookie;
        }
    }

    /**
     * Returns the width in pixel for the YouTube player iframe.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Returns the height in pixel for the YouTube player iframe.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Returns whether this extension displays the content of the YouTube feed.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     */
    public function isShowContent(): bool
    {
        return $this->showContent;
    }

    /**
     * Returns if this extension should use youtube-nocookie.com instead of youtube.com.
     * You have to call loadConfigValues() before this one, otherwise you get default values.
     */
    public function isUseNoCookieDomain(): bool
    {
        return $this->useNoCookie;
    }

    /**
     * Inserts the YouTube video iframe into the content of an entry, if the entries link points to a YouTube watch URL.
     */
    public function embedYouTubeVideo(FreshRSS_Entry $entry): FreshRSS_Entry
    {
        $link = $entry->link();

        if (preg_match('#^https?://www\.youtube\.com/watch\?v=|/videos/watch/[0-9a-f-]{36}$#', $link) !== 1) {
            return $entry;
        }

        $this->loadConfigValues();

        if (stripos($entry->content(), '<iframe class="youtube-plugin-video"') !== false) {
            return $entry;
        }
        if (stripos($link, 'www.youtube.com/watch?v=') !== false) {
            $html = $this->getHtmlContentForLink($entry, $link);
        }
        else { //peertube
            $html = $this->getHtmlPeerTubeContentForLink($entry, $link);
        }

        $entry->_content($html);

        return $entry;
    }

    /**
     * Returns an HTML <iframe> for a given Youtube watch URL (www.youtube.com/watch?v=)
     */
    public function getHtmlContentForLink(FreshRSS_Entry $entry, string $link): string
    {
        $domain = 'www.youtube.com';
        if ($this->useNoCookie) {
            $domain = 'www.youtube-nocookie.com';
        }
        $url = str_replace('//www.youtube.com/watch?v=', '//'.$domain.'/embed/', $link);
        $url = str_replace('http://', 'https://', $url);

        return $this->getHtml($entry, $url);
    }

    /**
    * Returns an HTML <iframe> for a given PeerTube watch URL
    */
    public function getHtmlPeerTubeContentForLink(FreshRSS_Entry $entry, string $link): string
    {
        $url = str_replace('/watch', '/embed', $link);

		return $this->getHtml($entry, $url);
    }

    /**
     * Returns an HTML <iframe> for a given URL for the configured width and height, with content ignored, appended or formatted.
     */
    public function getHtml(FreshRSS_Entry $entry, string $url): string
    {
        $content = '';

        $iframe = '<iframe class="youtube-plugin-video"
                style="height: ' . $this->height . 'px; width: ' . $this->width . 'px;"
                width="' . $this->width . '"
                height="' . $this->height . '"
                src="' . $url . '"
                frameborder="0"
                allowFullScreen></iframe>';

        if ($this->showContent) {
            $doc = new DOMDocument();
            $doc->encoding = 'UTF-8';
            $doc->recover = true;
            $doc->strictErrorChecking = false;

            if ($doc->loadHTML('<?xml encoding="utf-8" ?>' . $entry->content()))
            {
                $xpath = new DOMXPath($doc);

				/** @var DOMNodeList<DOMElement> $titles */
                $titles = $xpath->evaluate("//*[@class='enclosure-title']");
				/** @var DOMNodeList<DOMElement> $thumbnails */
                $thumbnails = $xpath->evaluate("//*[@class='enclosure-thumbnail']/@src");
				/** @var DOMNodeList<DOMElement> $descriptions */
                $descriptions = $xpath->evaluate("//*[@class='enclosure-description']");

                $content = '<div class="enclosure">';

                // We hide the title so it doesn't appear in the final article, which would be redundant with the RSS article title,
                // but we keep it in the content anyway, so RSS clients can extract it if needed.
                if ($titles->length > 0) {
                    $content .= '<p class="enclosure-title" hidden>' . $titles[0]->nodeValue . '</p>';
                }

                // We hide the thumbnail so it doesn't appear in the final article, which would be redundant with the YouTube player preview,
                // but we keep it in the content anyway, so RSS clients can extract it to display a preview where it wants (in article listing,
                // by example, like with Reeder).
                if ($thumbnails->length > 0) {
                    $content .= '<p hidden><img class="enclosure-thumbnail" src="' . $thumbnails[0]->nodeValue . '" alt=""/></p>';
                }

                $content .= $iframe;

                if ($descriptions->length > 0) {
                    $content .= '<p class="enclosure-description">' . nl2br(htmlentities($descriptions[0]->nodeValue)) . '</p>';
                }

                $content .= "</div>\n";
            }
            else {
                $content = $iframe . $entry->content();
            }
        }
        else {
            $content = $iframe;
        }

        return $content;
    }

    /**
     * This function is called by FreshRSS when the configuration page is loaded, and when configuration is saved.
     *  - We save configuration in case of a post.
     *  - We (re)load configuration in all case, so they are in-sync after a save and before a page load.
     */
	#[\Override]
    public function handleConfigureAction(): void
    {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            FreshRSS_Context::userConf()->_attribute('yt_player_height', Minz_Request::paramInt('yt_height'));
            FreshRSS_Context::userConf()->_attribute('yt_player_width', Minz_Request::paramInt('yt_width'));
            FreshRSS_Context::userConf()->_attribute('yt_show_content', Minz_Request::paramBoolean('yt_show_content'));
            FreshRSS_Context::userConf()->_attribute('yt_nocookie', Minz_Request::paramInt('yt_nocookie'));
            FreshRSS_Context::userConf()->save();
        }

        $this->loadConfigValues();
    }
}
