<?php

namespace Favicon;

class Favicon
{
    protected $url = '';
    protected $cacheDir;
    protected $cacheTimeout;
    protected $dataAccess;

    public function __construct($args = array())
    {
        if (isset($args['url'])) {
            $this->url = $args['url'];
        }
        
        $this->cacheDir = __DIR__ . '/../../resources/cache';
        $this->dataAccess = new DataAccess();
    }

    public function cache($args = array()) {
        if (isset($args['dir'])) {
            $this->cacheDir = $args['dir'];
        }

        if (!empty($args['timeout'])) {
                $this->cacheTimeout = $args['timeout'];
        } else {
                $this->cacheTimeout = 0;
        }
    }

    public static function baseUrl($url, $path = false)
    {
        $return = '';

        if (!$url = parse_url($url)) {
            return FALSE;
        }

        // Scheme
        $scheme = isset($url['scheme']) ? strtolower($url['scheme']) : null;
        if ($scheme != 'http' && $scheme != 'https') {

            return FALSE;
        }
        $return .= "{$scheme}://";

        // Username and password
        if (isset($url['user'])) {
            $return .= $url['user'];
            if (isset($url['pass'])) {
                $return .= ":{$url['pass']}";
            }
            $return .= '@';
        }

        // Hostname
        if( !isset($url['host']) ) {
            return FALSE;
        }
        
        $return .= $url['host'];

        // Port
        if (isset($url['port'])) {
            $return .= ":{$url['port']}";
        }

        // Path
        if( $path && isset($url['path']) ) {
            $return .= $url['path'];
        }
        $return .= '/';

        return $return;    
    }

    public function info($url)
    {
        if(empty($url) || $url === false) {
            return false;
        }
        
        $max_loop = 5;
        
        // Discover real status by following redirects. 
        $loop = TRUE;
        while ($loop && $max_loop-- > 0) {
            $headers = $this->dataAccess->retrieveHeader($url);
            $exploded = explode(' ', $headers[0]);
            
            if( !isset($exploded[1]) ) { 
                return false;
            }
            list(,$status) = $exploded;
            
            switch ($status) {
                case '301':
                case '302':
                    $url = $headers['Location'];
                    break;
                default:
                    $loop = FALSE;
                    break;
            }
        }

        return array('status' => $status, 'url' => $url);
    }
    
    public function endRedirect($url) {
        $out = $this->info($url);
        return !empty($out['url']) ? $out['url'] : false;
    }

    /**
     * Find remote (or cached) favicon
     * @return favicon URL, false if nothing was found
     **/
    public function get($url = '')
    {
        // URLs passed to this method take precedence.
        if (!empty($url)) {
            $this->url = $url;
        }

        // Get the base URL without the path for clearer concatenations.
        $original = rtrim($this->baseUrl($this->url, true), '/');
        $url = rtrim($this->endRedirect($this->baseUrl($this->url, false)), '/');

        if(($favicon = $this->checkCache($url)) || ($favicon = $this->getFavicon($url))) {
            $base = true;
        }
        elseif(($favicon = $this->checkCache($original)) || ($favicon = $this->getFavicon($original, false))) {
            $base = false;    
        }
        else
            return false;
            
        // Save cache if necessary
        $cache = $this->cacheDir . '/' . md5($base ? $url : $original);
        if ($this->cacheTimeout && !file_exists($cache) || (is_writable($cache) && time() - filemtime($cache) > $this->cacheTimeout)) {
            $this->dataAccess->saveCache($cache, $favicon);
        }
        
        return $favicon;
    }
    
    private function getFavicon($url, $checkDefault = true) {
        $favicon = false;
        
        if(empty($url)) {
            return false;
        }
        
        // Try /favicon.ico first.
        if( $checkDefault ) {
            $info = $this->info("{$url}/favicon.ico");
            if ($info['status'] == '200') {
                $favicon = $info['url'];
            }
        }

        // See if it's specified in a link tag in domain url.
        if (!$favicon) {
            $favicon = $this->getInPage($url);
        }
        
        // Make sure the favicon is an absolute URL.
        if( $favicon && filter_var($favicon, FILTER_VALIDATE_URL) === false ) {
            $favicon = $url . '/' . $favicon;
        }

        // Sometimes people lie, so check the status.
        // And sometimes, it's not even an image. Sneaky bastards!
        // If cacheDir isn't writable, that's not our problem
        if ($favicon && is_writable($this->cacheDir) && !$this->checkImageMType($favicon)) {
            $favicon = false;
        }

        return $favicon;
    }
    
    private function getInPage($url) {
        $html = $this->dataAccess->retrieveUrl("{$url}/");
        preg_match('!<head.*?>.*</head>!ims', $html, $match);
        
        if(empty($match) || count($match) == 0) {
            return false;
        }
        
        $head = $match[0];
        
        $dom = new \DOMDocument();
        // Use error supression, because the HTML might be too malformed.
        if (@$dom->loadHTML($head)) {
            $links = $dom->getElementsByTagName('link');
            foreach ($links as $link) {
                if ($link->hasAttribute('rel') && strtolower($link->getAttribute('rel')) == 'shortcut icon') {
                    return $link->getAttribute('href');
                } elseif ($link->hasAttribute('rel') && strtolower($link->getAttribute('rel')) == 'icon') {
                    return $link->getAttribute('href');
                } elseif ($link->hasAttribute('href') && strpos($link->getAttribute('href'), 'favicon') !== FALSE) {
                    return $link->getAttribute('href');
                }
            }
        }
        return false;
    }
    
    private function checkCache($url) {
        if ($this->cacheTimeout) {
            $cache = $this->cacheDir . '/' . md5($url);
            if (file_exists($cache) && is_readable($cache) && (time() - filemtime($cache) < $this->cacheTimeout)) {
                return $this->dataAccess->readCache($cache);
            }
        } 
        return false;
    }
    
    private function checkImageMType($url) {
        $tmpFile = $this->cacheDir . '/tmp.ico';
        
        $fileContent = $this->dataAccess->retrieveUrl($url);
        $this->dataAccess->saveCache($tmpFile, $fileContent);
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $isImage = strpos(finfo_file($finfo, $tmpFile), 'image') !== false;
        finfo_close($finfo);
        
        unlink($tmpFile);
        
        return $isImage;
    }
    
    /**
     * @return mixed
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param mixed $cacheDir
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return mixed
     */
    public function getCacheTimeout()
    {
        return $this->cacheTimeout;
    }

    /**
     * @param mixed $cacheTimeout
     */
    public function setCacheTimeout($cacheTimeout)
    {
        $this->cacheTimeout = $cacheTimeout;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param DataAccess $dataAccess
     */
    public function setDataAccess($dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }
}
