<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div id="root"></div>

<?php
$buildPath = $_SERVER["DOCUMENT_ROOT"] . $templateFolder . "/build";
$cssFiles = glob($buildPath . "/*.css");
$jsFiles = glob($buildPath . "/*.js");
?>

<?php foreach ($cssFiles as $css): ?>
    <link rel="stylesheet" href="<?= $templateFolder ?>/build/<?= basename($css) ?>">
<?php endforeach; ?>

<?php foreach ($jsFiles as $js): ?>
    <script type="module" src="<?= $templateFolder ?>/build/<?= basename($js) ?>"></script>
<?php endforeach; ?>
