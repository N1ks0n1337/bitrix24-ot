<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div class="otus-currency-rate">
    <p>Курс валюты
        <strong><?= htmlspecialchars($arResult['CURRENCY'], ENT_QUOTES, 'UTF-8') ?></strong>:
        <span><?= number_format($arResult['RATE'], 4, ',', ' ') ?></span>
    </p>
</div>
