<?php
namespace Otus\Crmdata;

use Bitrix\Main\Event;

class EventHandlers
{
    public static function onEntityDetailsTabsInitialized(Event $event)
    {
        $params       = $event->getParameters();
        $entityTypeId = $params['ENTITY_TYPE_ID'];
        $entityId     = (int)$params['ENTITY_ID'];

        return [
            [
                'id'    => 'crm_custom_data_tab',
                'name'  => 'Доп. данные',
                'sort'  => 1000,
                'loader'=> [
                    'componentName'       => 'otus:crm.customdata.grid',
                    'componentTemplate'   => '',
                    'componentParameters' => [
                        'ENTITY_TYPE_ID'=> $entityTypeId,
                        'ENTITY_ID'     => $entityId,
                        'GRID_ID'       => 'CRM_CUSTOMDATA_' . $entityTypeId,
                    ],
                ],
            ],
        ];
    }
}
