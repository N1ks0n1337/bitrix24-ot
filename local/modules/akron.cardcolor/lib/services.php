<?php
use Bitrix\Main\Loader;

Loader::registerNamespace('Akron\CardColor\Api', '/local/modules/akron.cardcolor/lib/api/');

return [
    'controllers' => [
        'value' => [
            'defaultNamespace' => '\\Akron\\CardColor\\Api\\',
        ],
        'readonly' => true,
    ]
];
