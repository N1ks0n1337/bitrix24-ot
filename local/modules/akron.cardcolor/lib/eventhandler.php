<?php
namespace Akron\CardColor;

use Bitrix\Main\Context;
use Bitrix\Main\Page\Asset;

class EventHandler
{
    public static function onPageStart()
    {
        $request = Context::getCurrent()->getRequest();
        $page = $request->getRequestedPage();

        // Проверяем, что находимся на странице канбана сделок
        if (strpos($page, '/crm/deal/kanban/') !== false)
        {
            // Подключаем наш JavaScript файл
            Asset::getInstance()->addJs('/local/js/akron.cardcolor/kanban_color.js');
        }
    }
}
