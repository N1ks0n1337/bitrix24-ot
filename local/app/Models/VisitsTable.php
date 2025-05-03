<?php
namespace Models;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Iblock\ElementTable;

class VisitsTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_visits';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField('ID', ['primary' => true, 'autocomplete' => true]),

            new IntegerField('DOCTOR_ID', ['required' => true]),

            new IntegerField('PROCEDURE_ID', ['required' => true]),

            new DatetimeField('VISIT_DATE', ['required' => true]),

            new StringField('NOTES'),

            new Reference(
                'DOCTOR',
                ElementTable::class,
                ['=this.DOCTOR_ID'    => 'ref.ID']
            ),

            new Reference(
                'PROCEDURE',
                ElementTable::class,
                ['=this.PROCEDURE_ID' => 'ref.ID']
            ),
        ];
    }
}
