<?php

declare(strict_types=1);

final class ImageCacheExtension extends Minz_Extension
{
    // Defaults
    private const CACHE_URL = 'https://wsrv.nl/?url=';
    private const CACHE_POST_URL = 'https://example.com/prepare';
    private const CACHE_ACCESS_TOKEN = '';
    private const URL_ENCODE = '1';
    private const CACHE_POST_ENABLED = '';

    #[\Override]
    public function init(): void
    {
        if (!FreshRSS_Context::hasSystemConf()) {
            throw new FreshRSS_Context_Exception('System configuration not initialised!');
        }
        $this->registerHook('entry_before_display', [self::class, 'content_modification_hook']);
        $this->registerHook('entry_before_insert', [self::class, 'image_upload_hook']);
        // Defaults
        $save = false;
        if (is_null(FreshRSS_Context::userConf()->image_cache_url)) {
            FreshRSS_Context::userConf()->image_cache_url = self::CACHE_URL;
            $save = true;
        }
        if (is_null(FreshRSS_Context::userConf()->image_cache_post_url)) {
            FreshRSS_Context::userConf()->image_cache_post_url = self::CACHE_POST_URL;
            $save = true;
        }
        if (is_null(FreshRSS_Context::userConf()->image_cache_post_url)) {
            FreshRSS_Context::userConf()->image_cache_access_token = self::CACHE_ACCESS_TOKEN;
            $save = true;
        }
        if (is_null(FreshRSS_Context::userConf()->image_cache_post_enabled)) {
            FreshRSS_Context::userConf()->image_cache_post_enabled = self::CACHE_POST_ENABLED;
            $save = true;
        }
        if ($save) {
            FreshRSS_Context::userConf()->save();
        }
    }

    #[\Override]
    public function handleConfigureAction(): void
    {
        $this->registerTranslates();

        if (Minz_Request::isPost()) {
            FreshRSS_Context::userConf()->image_cache_url = Minz_Request::paramString('image_cache_url');
            FreshRSS_Context::userConf()->image_cache_post_url = Minz_Request::paramString('image_cache_post_url');
            FreshRSS_Context::userConf()->image_cache_access_token = Minz_Request::paramString('image_cache_access_token');
            FreshRSS_Context::userConf()->image_cache_post_enabled = Minz_Request::paramString('image_cache_post_enabled');
            FreshRSS_Context::userConf()->save();
        }
    }

    public static function curlPostRequest(string $url, array $data): mixed
    {
        $data = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json;charset='utf-8'",
                'Content-Length: ' . strlen($data),
                "Accept: application/json")
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output, true);
    }

    public static function send_proactive_cache_request(string $url): mixed
    {
        if (FreshRSS_Context::userConf()->image_cache_post_enabled) {
            $post_url = FreshRSS_Context::userConf()->image_cache_post_url;
            return self::curlPostRequest($post_url, array("access_token" => FreshRSS_Context::userConf()->image_cache_access_token, "url" => $url));
        }
        return false;
    }

    public static function getCacheImageUri(string $url): string
    {
        $url = rawurlencode($url);
        return FreshRSS_Context::userConf()->image_cache_url . $url;
    }

    public static function small($string)
{
    return substr($string, 0, 20);
}

    public static function cache_images(string $content): string
    {
        if (empty($content)) {
            return $content;
        }
        $doc = new DOMDocument();
        libxml_use_internal_errors(true); // prevent tag soup errors from showing
        $encoding = mb_detect_encoding($content);
        $doc->loadHTML('<!DOCTYPE html><meta charset="'.$encoding.'">'.$content);
        $imgs = $doc->getElementsByTagName('img');
        foreach ($imgs as $img) {
            if ($img->hasAttribute('src')) {
                self::send_proactive_cache_request($img->getAttribute('src'));
            }
            if ($img->hasAttribute('srcset')) {
                preg_replace_callback('/(?:([^\s,]+)(\s*(?:\s+\d+[wx])(?:,\s*)?))/',
                    function (array $matches): string {
                        self::send_proactive_cache_request($matches[1]);
                        return '';
                    },
                    $img->getAttribute('srcset'));
            }
        }
        return $content;
    }

    public static function swapUris(string $content): string
    {
        if (empty($content)) {
            return $content;
        }
        $doc = new DOMDocument();
        libxml_use_internal_errors(true); // prevent tag soup errors from showing
        $encoding = mb_detect_encoding($content);
        $doc->loadHTML('<!DOCTYPE html><meta charset="'.$encoding.'">'.$content);
        $imgs = $doc->getElementsByTagName('img');
        foreach ($imgs as $img) {
            if ($img->hasAttribute('src')) {
                $newSrc = self::getCacheImageUri($img->getAttribute('src'));
                $img->setAttribute('src', $newSrc);
            }
            if ($img->hasAttribute('srcset')) {
                $newSrcSet = preg_replace_callback('/(?:([^\s,]+)(\s*(?:\s+\d+[wx])(?:,\s*)?))/',
                    function (array $matches): string {
                        return str_replace($matches[1], self::getCacheImageUri($matches[1]), $matches[0]);
                    }
                    , $img->getAttribute('srcset'));
                $img->setAttribute('srcset', $newSrcSet);
            }
        }
        return $doc->saveHTML();
    }

    public static function content_modification_hook($entry)
    {
        $entry->_content(
            self::swapUris($entry->content())
        );

        return $entry;
    }

    public static function image_upload_hook($entry)
    {
        self::cache_images($entry->content());
        return $entry;
    }
}
