<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'PARAMETERS' => [
        'ENTITY_TYPE_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Тип сущности CRM',
            'TYPE'    => 'STRING',
        ],
        'ENTITY_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'ID сущности CRM',
            'TYPE'    => 'STRING',
        ],
        'GRID_ID' => [
            'PARENT'  => 'BASE',
            'NAME'    => 'Идентификатор грида',
            'TYPE'    => 'STRING',
            'DEFAULT' => 'CRM_CUSTOMDATA_GRID',
        ],
    ],
];
