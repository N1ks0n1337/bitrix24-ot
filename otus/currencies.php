<?php
declare(strict_types=1);

use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyLangTable;
use Bitrix\Currency\CurrencyManager;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

if (!Loader::includeModule('currency')) {
    throw new \Exception('Модуль "currency" не установлен');
}

$currencies = [];
$lang = LANGUAGE_ID;
$iterator = CurrencyLangTable::getList([
    'select' => ['CURRENCY', 'FULL_NAME'],
    'filter' => ['=LID' => $lang],
    'order'  => ['CURRENCY' => 'ASC'],
]);
while ($row = $iterator->fetch()) {
    $currencies[] = $row;
}

$selectedCurrency = isset($_GET['currency']) && $_GET['currency'] !== ''
    ? trim($_GET['currency'])
    : CurrencyManager::getBaseCurrency();

$APPLICATION->SetTitle('Курс выбранной валюты');

echo '<form method="get" action="">';
echo '<label for="currency-select">Выберите валюту:</label> ';
echo '<select id="currency-select" name="currency" onchange="this.form.submit()">';
foreach ($currencies as $cur) {
    $code = htmlspecialchars($cur['CURRENCY'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($cur['CURRENCY'] . ' — ' . $cur['FULL_NAME'], ENT_QUOTES, 'UTF-8');
    $sel  = ($cur['CURRENCY'] === $selectedCurrency) ? ' selected' : '';
    echo "<option value=\"{$code}\"{$sel}>{$name}</option>";
}
echo '</select>';
echo '</form>';

$APPLICATION->IncludeComponent(
    'otus:currency.rate',
    '',
    [
        'CURRENCY'   => $selectedCurrency,
        'CACHE_TIME' => 3600,
    ],
    false
);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
