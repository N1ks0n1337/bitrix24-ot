<?php
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/** @var CMain $APPLICATION */
$APPLICATION->SetTitle(GetMessage("Отладка SQL"));

Loader::includeModule("iblock");

Bitrix\Main\Application::getConnection()->startTracker();
$queryResult = Bitrix\Iblock\ElementTable::getList([
    'filter' => [
        'IBLOCK_ID' => '1',
    ],
    'select' => [
        'ID', 'NAME'
    ],
]);
Bitrix\Main\Application::getConnection()->stopTracker();
Debug::dump($queryResult->getTrackerQuery()->getSql());


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>