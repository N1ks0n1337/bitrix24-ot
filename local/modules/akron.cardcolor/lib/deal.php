<?php
namespace Akron\CardColor\Api;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Loader;
use Bitrix\Crm\DealTable;

class Deal extends Controller
{
    public function getColorsAction($dealIds)
    {
        Loader::includeModule('crm');

        $result = [];
        $deals = DealTable::getList([
            'filter' => ['@ID' => $dealIds],
            'select' => ['ID', 'UF_CRM_1732699662']
        ]);

        while ($deal = $deals->fetch()) {
            $result[$deal['ID']] = $deal['UF_CRM_1732699662'];
        }

        return [
            'colors' => $result
        ];
    }
}
