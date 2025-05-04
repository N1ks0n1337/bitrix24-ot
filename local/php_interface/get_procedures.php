<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
header('Content-Type: application/json');

use Bitrix\Main\Loader;
Loader::includeModule('iblock');

$doctorId = isset($_POST['doctor_id']) ? intval($_POST['doctor_id']) : 0;
if ($doctorId <= 0) {
    echo json_encode([]);
    exit;
}

$doctorsIblockId = 18;

$ids = [];
$rsProp = \CIBlockElement::GetProperty(
    $doctorsIblockId,
    $doctorId,
    ['sort' => 'asc'],
    ['CODE' => 'PROCEDURE_IDS']
);
while ($p = $rsProp->Fetch()) {
    if ((int)$p['VALUE'] > 0) {
        $ids[] = (int)$p['VALUE'];
    }
}

if (empty($ids)) {
    echo json_encode([]);
    exit;
}

$rs = \CIBlockElement::GetList(
    ['NAME' => 'asc'],
    ['ID' => $ids, 'ACTIVE' => 'Y'],
    false,
    false,
    ['ID', 'NAME']
);

$out = [];
while ($pr = $rs->Fetch()) {
    $out[] = [
        'ID'   => (int)$pr['ID'],
        'NAME' => $pr['NAME'],
    ];
}

echo json_encode($out);
