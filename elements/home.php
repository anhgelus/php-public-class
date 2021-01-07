<?php
require '../class/Wiki/Selector.php';
use App\Wiki\Selector;

$uri = (string)$_SERVER['REQUEST_URI'];

$idMax = 8; //page max

if (array_key_exists("test", $_GET)) {
    $id = (int)$_GET['test'];
    $selection = new Selector($idMax);

    if ($selection->getId() != $id) {
        $selection->setId($id);
    }

    $next = $selection->next();
    $previously = $selection->previously();
} else {
    $id = 0;
    $selection = new Selector($idMax);

    if ($selection->getId() != $id) {
        $selection->setId($id);
    }

    $next = $selection->next();
    $previously = $selection->previously();

    print 'im here';
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
        <?php require 'wiki/test.php' ?>
    </article>
    <a href="?page=<?= $previously ?>" class="button">Last Page</a>
    <a href="?page=<?= $next ?>" class="button">Next Page</a>
</div>