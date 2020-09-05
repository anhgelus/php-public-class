<?php
namespace App\Rooter;

class Rooter {
    private $uri = '/';

    private $dir = "'../../../elements' . this->uri . '.php'";
    
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

        print $uri;

        /*
        réussir à débuger le code :
            - faire sauter l'erreur
            - réussir à enlever le / devant le $uri
        */
        if ($uri === '/') {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements\homes.php';
            return $content = ob_get_clean();
            exit;
        }
        ob_start();
        require $this->dir;
        return $content = ob_get_clean();

        /* if ($uri === '/') { // si on est dans la racine du site
            ob_start(); // init du transfère du fichier dans la variable $content
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/home.php';
            return $content = ob_get_clean(); // transfère dans la variable
        } else if ($uri === '/video.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/video.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros.php';
            return $content = ob_get_clean();
        } else if ($uri === '/discord.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/discord.php';
            return $content = ob_get_clean();
        } else if ($uri === '/equipe.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/equipe.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros/index.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros/home.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros/vocab.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros/vocab.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros/grammaire.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros/grammaire.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros/conjugaison.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros/conjugaison.php';
            return $content = ob_get_clean();
        } else if ($uri === '/inftaros/mythologie.php') { 
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/inftaros/mythologie.php';
            return $content = ob_get_clean();
        } else {
            ob_start();
            require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/404.php';
            return $content = ob_get_clean();
        } */
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
            return 'Accueil | HSP Web';
        } else if ($uri === '/video.php') {
            return 'Vidéo | HSP Web';
        } else if ($uri === '/inftaros.php') {
            return 'Inftaros | HSP Web';
        } else if ($uri === '/discord.php') {
            return 'Discord | HSP Web';
        } else if ($uri === '/equipe.php') {
            return 'Equipe | HSP Web';
        } else if ($uri === '/inftaros/index.php') {
            return 'Inftaros | HSP Web';
        } else if ($uri === '/inftaros/vocab.php') {
            return 'Vocabulaire | HSP Web';
        } else if ($uri === '/inftaros/grammaire.php') {
            return 'Grammaire | HSP Web';
        } else if ($uri === '/inftaros/conjugaison.php') {
            return 'Conjugaison | HSP Web';
        } else if ($uri === '/inftaros/mythologie.php') {
            return 'Mythologie | HSP Web';
        } else {
            return '404 | HSP Web';
        }

    }
}