<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Кастомные задачи");

$APPLICATION->IncludeComponent(
    "my_custom_code:main.tasks",
    ".default",
    array(
        "CACHE_TYPE" => "N"
    )
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
