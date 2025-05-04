<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    'bitrix:crm.interface.grid',
    '',
    [
        'GRID_ID'  => $arResult['GRID_ID'],
        'HEADERS'  => $arResult['HEADERS'],
        'ROWS'     => $arResult['ROWS'],
        'SORT'     => $arResult['SORT'],
        'AJAX_MODE'=> 'Y',
    ],
    false
);
