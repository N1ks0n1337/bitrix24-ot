<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Currency\CurrencyTable;

$arCurrencies = array();

$iterator = CurrencyTable::getList(array(
    'select' => array('CURRENCY', 'FULL_NAME'),
    'order'  => array('CURRENCY' => 'ASC'),
));

while ($row = $iterator->fetch()) {
    $arCurrencies[$row['CURRENCY']] = $row['CURRENCY'] . ' — ' . $row['FULL_NAME'];
}

$arComponentParameters = array(
    'GROUPS'     => array(),
    'PARAMETERS' => array(
        'CURRENCY' => array(
            'PARENT'  => 'BASE',
            'NAME'    => 'Валюта',
            'TYPE'    => 'LIST',
            'VALUES'  => $arCurrencies,
            'DEFAULT' => key($arCurrencies),
            'REFRESH' => 'N',
        ),
        'CACHE_TIME' => array(
            'DEFAULT' => 3600,
        ),
    ),
);
