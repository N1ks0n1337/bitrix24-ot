<?php
// /local/app/Models/CrmDataTable.php
namespace Models;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;

class CrmDataTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_otus_crmdata';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('ID', [
                'primary'      => true,
                'autocomplete' => true,
            ]),
            new IntegerField('ENTITY_ID', [
                'required' => true,
            ]),
            new StringField('DATA', [
                'required' => true,
            ]),
        ];
    }
}
