<?php
declare(strict_types=1);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

\Bitrix\Main\Loader::includeModule('iblock');

$visitsRaw = \Models\VisitsTable::getList([
    'select' => [
        'ID',
        'VISIT_DATE',
        'NOTES',
        'DOCTOR_NAME'    => 'DOCTOR.NAME',
        'PROCEDURE_NAME' => 'PROCEDURE.NAME',
    ],
    'order' => [
        'VISIT_DATE' => 'DESC',
    ],
])->fetchAll();

$APPLICATION->SetTitle('Журнал визитов');
$APPLICATION->SetAdditionalCSS('/visits/style.css');

echo '<section class="visits">';
echo '<h1>Журнал визитов</h1>';
echo '<table border="1" cellpadding="6" cellspacing="0">';
echo '<thead><tr>'
    . '<th>ID</th>'
    . '<th>Дата визита</th>'
    . '<th>Врач</th>'
    . '<th>Процедура</th>'
    . '<th>Заметки</th>'
    . '</tr></thead>';
echo '<tbody>';
foreach ($visitsRaw as $visit) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars((string)$visit['ID'],           ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars((string)$visit['VISIT_DATE'],   ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($visit['DOCTOR_NAME'],          ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . htmlspecialchars($visit['PROCEDURE_NAME'],       ENT_QUOTES, 'UTF-8') . '</td>';
    echo '<td>' . nl2br(htmlspecialchars($visit['NOTES'],         ENT_QUOTES, 'UTF-8')) . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</section>';

// 6) Подключаем подвал Bitrix
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');

