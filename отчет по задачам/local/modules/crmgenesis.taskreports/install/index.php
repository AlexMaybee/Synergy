<?php

Class crmgenesis_taskreports extends CModule
{
    var $MODULE_ID = "crmgenesis.taskreports";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $PARTNER_NAME = 'CRM GENESIS';
    var $PARTNER_URI  = 'https://crmgenesis.com/';

    function crmgenesis_taskreports()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = "crmgenesis.taskreports – страница с отчетами по задачам";
        $this->MODULE_DESCRIPTION = "Установка модуля с отчетами по задачам";
    }

    function InstallFiles()
    {
        //созд папки если нет такой
        $dir = $_SERVER["DOCUMENT_ROOT"]."/local/components";
        if ( !file_exists ( $dir ) ) {
            mkdir ( $dir );
        }

        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/components",
            $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);

        CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/".$this->MODULE_ID."/install/custom_task_reports",  $_SERVER["DOCUMENT_ROOT"]."/custom_task_reports/", true, true);


        return true;
    }

    function UnInstallFiles()
    {
        DeleteDirFilesEx("/local/components/crmgenesis/task_reports.component");

        //удаление папки crmgenesis из компонентов, если в ней пусто после удаления своего компонента
        if(!glob($_SERVER['DOCUMENT_ROOT'].'/local/components/crmgenesis/*')) DeleteDirFilesEx("/local/components/crmgenesis");

        //удаление папки со страницей и пунктом левого меню
        DeleteDirFilesEx("/custom_task_reports/");

        return true;
    }

    function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->InstallFiles();
        RegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Установка модуля ".$this->MODULE_ID, $DOCUMENT_ROOT."/local/modules/".$this->MODULE_ID."/install/step.php");
    }

    function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        $this->UnInstallFiles();
        UnRegisterModule($this->MODULE_ID);
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля ".$this->MODULE_ID, $DOCUMENT_ROOT."/local/modules/".$this->MODULE_ID."/install/unstep.php");
    }
}