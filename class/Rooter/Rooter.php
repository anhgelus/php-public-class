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

                $position = strpos((string)$uri, "?");

                if (!$position) {
                    ob_start();
                    require dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements/404.php';
                    return $content = ob_get_clean();
                } else {
                    $sizeUri = strlen((string)$uri);

                    $uri_TEMP = ($uri - $sizeUri) + 1;
  
                    if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . substr((string)$uri, 0, $uri_TEMP))) {
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

        function createTitle(string $uri): string {
            $lenght = strlen($uri) - 5;

            $preTitle = substr($uri, 1, $lenght);
            $firstLetter = strtoupper(substr($preTitle, 0, 1));
            
            $title = $firstLetter . substr($preTitle, 1);
            return $title;
        }

        if ($uri === '/') { // si on est dans la racine du site
            return 'Accueil';
        } else {

            if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . (string)$uri)) {
                createTitle($uri);
            } else {
                $position = strpos((string)$uri, "?");

                if (!$position) {
                    return '404';
                } else {
                    $sizeUri = strlen((string)$uri);

                    $uri_TEMP = ($uri - $sizeUri) + 1;

                    if (file_exists(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'elements' . substr((string)$uri, 0, $uri_TEMP))) {
                        createTitle($uri);
                    } else {
                        return '404';
                    }
                }
            }

        }

    }
}