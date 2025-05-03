<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;

class CurrencyRateComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $result = array();

        // Валюта
        $result['CURRENCY'] = isset($arParams['CURRENCY'])
            ? trim($arParams['CURRENCY'])
            : '';
        if ($result['CURRENCY'] === '') {
            $result['CURRENCY'] = \Bitrix\Currency\CurrencyManager::getBaseCurrency();
        }

        $result['CACHE_TIME'] = isset($arParams['CACHE_TIME'])
            ? (int)$arParams['CACHE_TIME']
            : 3600;

        return $result;
    }

    /**
     * Точка входа в компонент
     */
    public function executeComponent()
    {
        if (!Loader::includeModule('currency')) {
            ShowError('Модуль "Валюта" не установлен');
            return;
        }

        if ($this->startResultCache(false, $this->arParams['CURRENCY'])) {
            $currencyCode = $this->arParams['CURRENCY'];

            $row = CurrencyTable::getList(array(
                'select' => array('CURRENCY', 'AMOUNT', 'AMOUNT_CNT'),
                'filter' => array('=CURRENCY' => $currencyCode),
            ))->fetch();

            if (isset($row['AMOUNT']) && isset($row['AMOUNT_CNT']) && $row['AMOUNT_CNT'] > 0) {
                $rate = (float)$row['AMOUNT'] / (int)$row['AMOUNT_CNT'];
            } else {
                $rate = 0.0;
            }

            // Подготавливаем результат для шаблона
            $this->arResult['CURRENCY'] = $currencyCode;
            $this->arResult['RATE']     = $rate;

            $this->includeComponentTemplate();
        }
    }
}
