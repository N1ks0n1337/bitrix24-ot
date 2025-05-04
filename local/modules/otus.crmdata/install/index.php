<?php
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;

global $APPLICATION;

class otus_crmdata extends CModule
{
    public $MODULE_ID          = 'otus.crmdata';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME        = 'CRM Custom Data Tab';
    public $MODULE_DESCRIPTION = 'Добавляет вкладку с гридом из внешней таблицы в CRM';

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_VERSION      = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    public function DoInstall()
    {
        $this->InstallDB();
        $this->InstallEvents();
    }

    public function InstallDB()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $connection = Application::getConnection();
        $connection->runSqlBatch(file_get_contents(__DIR__ . '/db/mysql/install.sql'));
        return true;
    }

    public function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            'Otus\\Crmdata\\EventHandlers',
            'onEntityDetailsTabsInitialized'
        );
        return true;
    }
}
