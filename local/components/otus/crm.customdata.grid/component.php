<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Models\CrmDataTable;

class CrmCustomDataGridComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('crm') || !Loader::includeModule('otus.crmdata')) {
            ShowError('Не удалось подключить модули CRM или otus.crmdata');
            return;
        }

        $entityTypeId = $this->arParams['ENTITY_TYPE_ID'];
        $entityId     = (int)$this->arParams['ENTITY_ID'];
        $gridId       = $this->arParams['GRID_ID'];

        $collection = CrmDataTable::getList([
            'filter' => ['=ENTITY_ID' => $entityId],
            'order'  => ['ID' => 'DESC'],
        ])->fetchAll();

        $rows = [];
        foreach ($collection as $item) {
            $rows[] = [
                'id'   => $item['ID'],
                'data' => $item,
            ];
        }

        $headers = [
            ['id' => 'ID',        'name' => 'ID',   'sort' => 'ID',   'default' => true],
            ['id' => 'DATA',      'name' => 'Данные', 'sort' => 'DATA','default' => true],
        ];

        $this->arResult = [
            'GRID_ID' => $gridId,
            'HEADERS' => $headers,
            'ROWS'    => $rows,
            'SORT'    => ['field' => 'ID', 'order' => 'DESC'],
        ];
        $this->includeComponentTemplate();
    }
}
