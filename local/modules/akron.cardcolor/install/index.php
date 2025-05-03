<?php
namespace Akron\CardColor;

use Bitrix\Main\ModuleManager;

class akron_cardcolor extends \CModule
{
    public function __construct()
    {
        $this->MODULE_ID = 'akron.cardcolor';
        $this->MODULE_NAME = 'Окрашивание карточек сделок';
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '2024-11-27';
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}
