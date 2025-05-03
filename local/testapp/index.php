<?php
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

// Добавление новой новости в инфоблок
$newsFields = [
    'TITLE' => 'Новая новость',
    'DATE_CREATE' => new \Bitrix\Main\Type\DateTime(), // Устанавливаем текущую дату
];

$result = NewsTable::add($newsFields); // Добавляем запись

if ($result->isSuccess()) {
    echo "Новость добавлена с ID: " . $result->getId(); // Выводим ID добавленной новости
} else {
    echo "Ошибка: " . implode(", ", $result->getErrorMessages()); // Вывод ошибок
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
