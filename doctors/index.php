<?php
declare(strict_types=1);
// Разработческая отладка
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');

use Bitrix\Main\Loader;
use Bitrix\Iblock\ElementTable;
use Models\Lists\DoctorsTable;
use Models\Lists\ProceduresTable;

Loader::includeModule('iblock');
// Сброс D7-кэша карт свойств
DoctorsTable::clearPropertyMapCache();
ProceduresTable::clearPropertyMapCache();

/** 1) Получаем всех врачей: ID элемента + массив PROCEDURE_IDS */
$rawDoctors = DoctorsTable::getList([
    'select' => [
        'DOC_ID'        => 'IBLOCK_ELEMENT_ID',
        'PROCEDURE_IDS'             // ExpressionField
    ],
])->fetchAll();

// Строим массив врачей: ID => [NAME, PROCEDURE_IDS]
$doctors = [];
foreach ($rawDoctors as $row) {
    $id = (int)$row['DOC_ID'];
    // Имя врача берём из таблицы элементов
    $elem = ElementTable::getByPrimary($id, [
        'select' => ['NAME'],
    ])->fetch();
    $doctors[$id] = [
        'NAME'          => $elem['NAME'] ?? '–',
        'PROCEDURE_IDS' => $row['PROCEDURE_IDS'] ?: [],
    ];
}

// 2) Определяем, выбрал ли пользователь врача
$selectedId    = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : 0;
$procedureList = [];

if ($selectedId > 0 && isset($doctors[$selectedId])) {
    $procIds = $doctors[$selectedId]['PROCEDURE_IDS'];

    if (!empty($procIds)) {
        // 3) Получаем из ProceduresTable только ID, DESCRIPTION и PRICE
        $rawProcedures = ProceduresTable::getList([
            'select' => [
                'PROC_ID'     => 'IBLOCK_ELEMENT_ID',
                'DESCRIPTION',
                'PRICE',
            ],
            'filter' => [
                'IBLOCK_ELEMENT_ID' => $procIds,
            ],
        ])->fetchAll();

        // 4) Для каждого процедуры достаём имя из ElementTable
        foreach ($rawProcedures as $proc) {
            $pid = (int)$proc['PROC_ID'];
            $e = ElementTable::getByPrimary($pid, [
                'select' => ['NAME'],
            ])->fetch();

            $procedureList[] = [
                'ID'          => $pid,
                'NAME'        => $e['NAME'] ?? '–',
                'DESCRIPTION' => $proc['DESCRIPTION'],
                'PRICE'       => $proc['PRICE'],
            ];
        }
    }
}

// 5) Рендер страницы
$APPLICATION->SetTitle('Врачи и их процедуры');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');
?>
    <section class="doctors">
        <h1>Список врачей</h1>
        <div class="cards-list">
            <?php foreach ($doctors as $id => $info): ?>
                <div class="card">
                    <a href="?doctor_id=<?= $id ?>">
                        <?= htmlspecialchars($info['NAME'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($selectedId > 0): ?>
            <section class="doctor-page">
                <h2>Процедуры врача «<?= htmlspecialchars($doctors[$selectedId]['NAME'], ENT_QUOTES, 'UTF-8') ?>»</h2>

                <?php if (empty($procedureList)): ?>
                    <p>У этого врача нет назначенных процедур.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($procedureList as $pr): ?>
                            <li>
                                <strong><?= htmlspecialchars($pr['NAME'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                                <?= nl2br(htmlspecialchars($pr['DESCRIPTION'], ENT_QUOTES, 'UTF-8')) ?><br>
                                <em>Цена:</em> <?= htmlspecialchars($pr['PRICE'], ENT_QUOTES, 'UTF-8') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </section>
<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
