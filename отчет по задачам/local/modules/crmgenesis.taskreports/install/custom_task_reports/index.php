<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use \Bitrix\Main;
use \Bitrix\Main\Loader;
use Bitrix\Main\UserTable;

$APPLICATION->SetTitle("Звіт по завданнях");
CJSCore::Init();
?>

<section class="module-container">
<?
$APPLICATION->IncludeComponent(
    "crmgenesis:task_reports.component",
    "first",
    Array(
    ),
    false
);
?>
</section>
