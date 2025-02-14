<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */
global $APPLICATION;

//Устанавливаем заголовок страницы
if(!empty($arParams["PAGE_H1"])){
	$APPLICATION->SetTitle($arParams["PAGE_H1"]);
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_H1"]["VALUE"]){
	$APPLICATION->SetTitle(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_H1"]["VALUE"]));
}
//Устанавливаем заголовок браузера
if(!empty($arParams["PAGE_TITLE"])){
	$APPLICATION->SetPageProperty("title", $arParams["PAGE_TITLE"]);
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_TITLE"]["VALUE"]){
	$APPLICATION->SetTitle(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_TITLE"]["VALUE"]));
}
//Устанавливаем ключевые слова
if(!empty($arParams["PAGE_KEYWORDS"])){
	$APPLICATION->SetPageProperty("keywords", mb_strtolower($arParams["PAGE_KEYWORDS"]));
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_KEYWORDS"]["VALUE"]){
	$APPLICATION->SetTitle(mb_strtolower(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_KEYWORDS"]["VALUE"])));
}
//Устанавливаем описание страницы
if(!empty($arParams["PAGE_DESCRIPTION"])){
	$APPLICATION->SetPageProperty("description", $arParams["PAGE_DESCRIPTION"]);
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_DESCRIPTION"]["VALUE"]){
	$APPLICATION->SetTitle(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_DESCRIPTION"]["VALUE"]));
}
if(!empty($arParams["METRO_INFO"])){
    $APPLICATION->AddChainItem($arParams["METRO_INFO"]["NAME"], "");
}