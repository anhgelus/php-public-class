<?php
namespace App\Rooter;

class Rooter {

    private string $uri = '/';

    private string $siteName = '';

    /**
     * Rooter constructor.
     * @param string $uri Uri (ex: '/', '/news', '/video?id=16a', etc)
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * root
     *
     * Root vers la bonne page
     * @return string La page
     */
    public function root(): string
    {
        $uri = $this->uri;

        if ($uri === '/') {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . '/home.php';
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
     * getPageTitle Récupère le titre de la page
     *
     * @return string Titre de la page
     */
    public function getPageTitle(): string
    {
        $uri = $this->uri;

        if ($uri === '/') { // si on est dans la racine du site
            return $this->transformEnd('Accueil');
        } else if ($this->doesItExist($uri)) {
            if (strpos($uri, '?') !== false) {
                $title = strtoupper(substr($uri, 1, 1)) . substr($uri, 2, (strpos($uri, '?') - 2));
                return $this->transformEnd($title);
            } else {
                $title = strtoupper(substr($uri, 1, 1)) . substr($uri, 2, strlen($uri));
                return $this->transformEnd($title);
            }
        } else {
            return '404';
        }

    }

    /**
     * getPageDesc Récupère la description de la page
     *
     * @return string Description de la page
     */
    public function getPageDesc(): string
    {
        $uri = $this->uri;
        if ($uri === '/') {
            return 'Description';
        } else if ($this->doesItExist($uri)) {
            return '';
        } else {
            return '404 error';
        }
    }


    public function setSiteName(string $siteName): void
    {
        $this->siteName = $siteName;
    }


    /**
     * doesItExist Informe si le fichier portant ce nom existe
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
     * transformEnd Transforme la fin du fichier
     *
     * @param  mixed $base Base à transformer
     * @return string Base transformée
     */
    private function transformEnd(string $base): string
    {
        return $base . ' | ' . $this->siteName;
    }

    /**
     * detectorGetForm Détecte et renvoie le nom du fichier originel lors de l'utilisation de GET dans un formulaire
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
}