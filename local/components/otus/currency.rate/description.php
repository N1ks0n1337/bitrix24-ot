<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = array(
    'NAME'        => 'Курс валюты',
    'DESCRIPTION' => 'Выводит курс выбранной валюты из справочника валют',
    'CACHE_PATH'  => 'Y',
    'PATH'        => array(
        'ID'   => 'otus',
        'NAME' => 'OTUS'
    ),
);
