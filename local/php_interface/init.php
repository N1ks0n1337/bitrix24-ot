<?php
require_once __DIR__ . '/BookingProcedureProp.php';
use Bitrix\Main\EventManager;
EventManager::getInstance()->addEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    ['BookingProcedureProp', 'GetUserTypeDescription']
);

define(
    'DEBUG_FILE_NAME',
    $_SERVER['DOCUMENT_ROOT']
    . '/logs/'
    . date('Y-m-d')
    . '.log'
);

$otusAutoload = __DIR__ . '/classes/Otus/autoload.php';
if (file_exists($otusAutoload)) {
    require_once $otusAutoload;
}

$vendorAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($vendorAutoload)) {
    require_once $vendorAutoload;
}

$modelsAutoload = $_SERVER['DOCUMENT_ROOT'] . '/local/app/autoload.php';
if (file_exists($modelsAutoload)) {
    require_once $modelsAutoload;
}