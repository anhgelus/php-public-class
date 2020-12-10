<?php
$selector = substr($uri, 0, 8);

function getSelector(int $n) {
    return "/?page=" . $n;
}
?>
<?php if ($selector === getSelector(1)): //Anhgelus Morhtuuzh?>
    <h2>
        Page 1
    </h2>
<?php endif ?>
<?php if ($selector === getSelector(2)): //Dieu du Ui?>
    <h2>
        Page 2
    </h2>
<?php endif ?>
<?php if ($selector === getSelector(3)): //Vinhd Gud?>
    <h2>
        Page 3
    </h2>
<?php endif ?>
<?php if ($selector  === getSelector(4)): //Inftarosh Buhmestra?>
    <h2>
        Page 4
    </h2>
<?php endif ?>
<?php if ($selector === getSelector(5)): //Lonhmordh Gud?>
    <h2>
        Page 5
    </h2>
<?php endif?>