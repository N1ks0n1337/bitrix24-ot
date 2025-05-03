<?php
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;

Loader::registerAutoloadClasses('akron.cardcolor', [
    'Akron\CardColor\EventHandler' => 'lib/eventhandler.php',
    'Akron\CardColor\Api\Deal' => 'lib/api/deal.php',
]);

EventManager::getInstance()->addEventHandler(
    'main',
    'OnPageStart',
    ['Akron\CardColor\EventHandler', 'onPageStart']
);

if (file_exists(__DIR__ . '/lib/services.php')) {
    Loader::includeModule('akron.cardcolor');
    require_once(__DIR__ . '/lib/services.php');
}