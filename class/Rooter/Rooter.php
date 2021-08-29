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
     * Root vers la bonne page
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
     * Récupère le titre de la page
     *
     * @return string Titre de la page
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
     * Récupère la description de la page
     *
     * @return string Description de la page
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
     * @param string $siteName Nom du site
     */
    public function setSiteName(string $siteName): void
    {
        $this->siteName = $siteName;
    }

    /**
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $link Lien vers la page ('video.php', 'test/test2.php', etc)
     */
    public function map(string $uri, string $link):void
    {
        $this->mapUri[$uri] = $link;
    }

    /**
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $title Titre de la page ('Home Page', 'Just Video', etc)
     */
    public function mapTitle(string $uri, string $title):void
    {
        $this->mapTitle[$uri] = $title;
    }

    /**
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @param string $desc Description de la page ("Video page, it's just that lmao", 'You can use the simple quote with \'it\s\' if you want')
     */
    public function mapDesc(string $uri, string $desc):void
    {
        $this->mapDesc[$uri] = $desc;
    }

    /**
     * Informe si le fichier portant ce nom existe
     *
     * @param  mixed $uri Uri (ex: '/', '/hey', etc)
     * @return bool True = fichier existe ; False = n'existe pas
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
     * Transforme la fin du fichier
     *
     * @param  mixed $base Base à transformer
     * @return string Base transformée
     */
    private function transformEnd(string $base): string
    {
        return $base . ' | ' . $this->siteName;
    }

    /**
     * Détecte et renvoie le nom du fichier originel lors de l'utilisation de GET dans un formulaire
     *
     * @param  mixed $uri Uri (ex: '/', '/hey?lul=yes', etc)
     * @return string Nom du fichier ; False = fichier inexistant
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
     * Détecte s'il y a l'utilisation de GET dans le lien $uri
     *
     * @param array $mapTitle Array défini par $this->mapTitle()
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     * @return bool true = utilise GET | false = n'utilise pas GET
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