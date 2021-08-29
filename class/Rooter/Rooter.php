<?php
namespace App\Rooter;

class Rooter {

    private string $uri = '/';

    private string $siteName = '';

    private array $mapUri = [];

    private array $mapTitle = [];

    private array $mapDesc = [];

    /**
     * Rooter constructor.
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * Root to the right page
     * @return string La page
     */
    public function root(): string
    {
        $uri = $this->uri;
        $map = $this->mapUri;

        if ($uri === '/') {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . '/home.php';
            return $content = ob_get_clean();
        } else if (isset($map[$uri])) {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/' . $map[$uri];
            return $content = ob_get_clean();
        } else if ($this->doesItExist($uri)) {
            if (strpos($uri, '?') !== false) {
                ob_start();
                require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . $this->detectorGetForm($uri);
                return $content = ob_get_clean();
            } else {
                ob_start();
                require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri . '.php';
                return $content = ob_get_clean();
            }
        } else {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/404.php';
            return $content = ob_get_clean();
        }

    }
    /**
     * Get the page's title
     *
     * @return string Page's title
     */
    public function getPageTitle(): string
    {
        $uri = $this->uri;
        $map = $this->mapTitle;

        if ($uri === '/') { // si on est dans la racine du site
            return $this->transformEnd('Accueil');
        } else if ($this->doesItExist($uri)) {
            if (isset($map[$uri])) {
                return $this->transformEnd($map[$uri]);
            } else if (strpos($uri, '?') !== false) {
                if ($this->detectGetIntoMap($map, $uri) !== false) {
                    return $this->transformEnd($map[substr($uri, 0, (strpos($uri, '?')))]);
                } else {
                    $title = strtoupper(substr($uri, 1, 1)) . substr($uri, 2, (strpos($uri, '?') - 2));
                    return $this->transformEnd($title);
                }
            } else {
                $title = strtoupper(substr($uri, 1, 1)) . substr($uri, 2, strlen($uri));
                return $this->transformEnd($title);
            }
        } else {
            return '404';
        }

    }

    /**
     * Get the page's description
     *
     * @return string Page's description
     */
    public function getPageDesc(): string
    {
        $uri = $this->uri;
        $map = $this->mapDesc;

        if ($uri === '/') {
            return 'Description';
        } else if (isset($map[$uri])) {
            return $map[$uri];
        } else {
            return 'No Description';
        }
    }

    /**
     * Set the website name
     *
     * @param string $siteName website Name
     */
    public function setSiteName(string $siteName): void
    {
        $this->siteName = $siteName;
    }

    /**
     * Remap to the right page
     *
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $link New link to the page ('video.php', 'test/test2.php', etc)
     */
    public function map(string $uri, string $link):void
    {
        $this->mapUri[$uri] = $link;
    }

    /**
     * Modify the title of a specific page
     *
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $title New page's title ('Home Page', 'Just Video', etc)
     */
    public function mapTitle(string $uri, string $title):void
    {
        $this->mapTitle[$uri] = $title;
    }

    /**
     * Add page's description
     *
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $desc New page's description ("Video page, it's just that lmao", 'You can use the simple quote with \'it\s\' if you want')
     */
    public function mapDesc(string $uri, string $desc):void
    {
        $this->mapDesc[$uri] = $desc;
    }

    /**
     * Informs if the file with this name exists
     *
     * @param string $uri Uri (ex: '/', '/hey', etc)
     * @return bool true = file existe ; false = file doesn't existe
     */
    private function doesItExist(string $uri): bool
    {
        if ($uri === '/html') {
            return false;
        } else if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri . '.php')) {
            return true;
        } else if (strpos($uri, '?') !== false) {
            if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . $this->detectorGetForm($uri))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Transform the end to add the name of the website
     *
     * @param  mixed $base Base to be transformed
     * @return string Base transformed
     */
    private function transformEnd(string $base): string
    {
        return $base . ' | ' . $this->siteName;
    }

    /**
     * Detects and returns the original file name when using GET in a form
     *
     * @param  mixed $uri Uri (ex: '/', '/hey?lul=yes', etc)
     * @return string File's name ; False = file doesn't exist
     */
    private function detectorGetForm(string $uri): string
    {
        if (strpos($uri, '?') !== false) {
            return substr($uri, 0, strpos($uri, '?')) . '.php';
        } else {
            return false;
        }
    }

    /**
     * Detects if there is use of GET in the $uri link
     *
     * @param array $mapTitle Array defined by $this->mapTitle()
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @return bool true = use GET | false = doesn't use GET
     */
    private function detectGetIntoMap(array $mapTitle, string $uri): bool
    {
        if ($mapTitle[substr($uri, 0, (strpos($uri, '?')))] !== null) {
            return true;
        } else {
            return false;
        }
    }
}