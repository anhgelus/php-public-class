<?php
namespace App\Rooter;

class Rooter {
    private $uri = '/';
    
    /**
     * root
     * 
     * Root vers la bonne page
     *
     * @param  string $uri get the url like /
     * @return string the page
     */
    public function root(string $uri): string
    {
        $this->uri = $uri;

        if ($uri === '/') {
            ob_start(); // init du transfère du fichier dans la variable $content
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . '/home.php';
            return $content = ob_get_clean(); // transfère dans la variable
        } else {
            if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri)) {
                ob_start();
                require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri;
                return $content = ob_get_clean();
            } else {
                ob_start();
                require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/404.php';
                return $content = ob_get_clean();
            }
            
        }
    }
    /**
     * getPageTitle -> Récupère le titre de la page
     *
     * @return string -> Titre de la page
     */
    public function getPageTitle(): string
    {
        $uri = $this->uri;

        if ($uri === '/') { // si on est dans la racine du site
            return 'Accueil';
        } else {
            if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri)) {
                return substr($uri, 1);
            } else {
                return '404';
            }
        }

    }
}