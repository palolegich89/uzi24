<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;
//pre_dump($arResult);
//Устанавливаем заголовок страницы
if(!empty($arParams["PAGE_H1"])){
    $APPLICATION->SetTitle($arParams["PAGE_H1"]);
}elseif(!empty($arParams["METRO_INFO"]) && !empty($arResult["UF_METRO_H1"])){
    $APPLICATION->SetTitle(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["UF_METRO_H1"]));
}else{
    $APPLICATION->SetTitle($arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]);
}
//Устанавливаем заголовок браузера
if(!empty($arParams["PAGE_TITLE"])){
    $APPLICATION->SetPageProperty("title", $arParams["PAGE_TITLE"]);
}elseif(!empty($arParams["METRO_INFO"]) && !empty($arResult["UF_METRO_TITLE"])){
    $APPLICATION->SetTitle(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["UF_METRO_TITLE"]));
}else{
    $APPLICATION->SetPageProperty("title", $arResult["IPROPERTY_VALUES"]["SECTION_META_TITLE"]);
}
/*//Устанавливаем ключевые слова
if(!empty($arParams["PAGE_KEYWORDS"])){
	$APPLICATION->SetPageProperty("keywords", mb_strtolower($arParams["PAGE_KEYWORDS"]));
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_KEYWORDS"]["VALUE"]){
	$APPLICATION->SetTitle(mb_strtolower(str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_KEYWORDS"]["VALUE"])));
}*/
//Устанавливаем описание страницы
if(!empty($arParams["PAGE_DESCRIPTION"])){
    $APPLICATION->SetPageProperty("description", $arParams["PAGE_DESCRIPTION"]);
}elseif(!empty($arParams["METRO_INFO"]) && !empty($arResult["UF_METRO_DESCRIPTION"])){
    $APPLICATION->SetPageProperty("description", str_replace(array("#metro#", "#count_items#", "#min_price#"), array($arParams["METRO_INFO"]["NAME"], ClinToStr(count($arResult["clinicList"]), true), $arResult["PRICE_VALUE"]." рублей"), $arResult["UF_METRO_DESCRIPTION"]));
}else{
    $APPLICATION->SetPageProperty("description", str_replace(array("#count_items#", "#min_price#"), array(ClinToStr(count($arResult["clinicList"]), true), $arResult["PRICE_VALUE"]." рублей"), $arResult["IPROPERTY_VALUES"]["SECTION_META_DESCRIPTION"]));
}
if(!empty($arParams["METRO_INFO"])){
    $APPLICATION->AddChainItem($arParams["METRO_INFO"]["NAME"], "");
}