<?php
use Bitrix\Main\ModuleManager;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;

class otus_crmdata extends CModule
{
    public $MODULE_ID = 'otus.crmdata';

    public function DoUninstall()
    {
        $this->UninstallEvents();
        $this->UninstallDB();
    }

    public function UninstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(
            'crm',
            'onEntityDetailsTabsInitialized',
            $this->MODULE_ID,
            'Otus\\Crmdata\\EventHandlers',
            'onEntityDetailsTabsInitialized'
        );
        return true;
    }

    public function UninstallDB()
    {
        $connection = Application::getConnection();
        $connection->runSqlBatch(file_get_contents(__DIR__ . '/../install/db/mysql/uninstall.sql'));
        ModuleManager::unRegisterModule($this->MODULE_ID);
        return true;
    }
}
