<?php
require '../vendor/autoload.php';
use App\Wiki\Selector;

$uri = (string)$_SERVER['REQUEST_URI'];

$idMax = 8; //page max

if (array_key_exists("test", $_GET)) {
    $id = (int)$_GET['test'];
    $selection = new Selection($idMax);

    if ($selection->getId() != $id) {
        $selection->setId($id);
    }

    $next = $godSelection->next();
    $previously = $godSelection->previously();
}
?>
<h1>
    Hey
</h1>
<div class="wiki">
    <h2>Test</h2>
    <p>
        Bienvenue sur la page du wiki des dieux ! <br>
        Ici vous allez trouver tous les dieux ainsi que leur(s) représentation(s).
    </p>
    <article>
        <?php require 'wiki/god.php' ?>
    </article>
    <a href="?page=<?= $previously ?>" class="button">Last Page</a>
    <a href="?page=<?= $next ?>" class="button">Next Page</a>
</div>