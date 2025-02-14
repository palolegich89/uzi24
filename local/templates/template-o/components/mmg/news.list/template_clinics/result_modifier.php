<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/*CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog"); 
CModule::IncludeModule('highloadblock');
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

/*$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID"=>$arParams['ID_SERVICE']);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_AVATAR", "PROPERTY_TOP_TEXT"));
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arResult["SERVICE"] = $arFields;
}

foreach($arResult["ITEMS"] as $cell => $arItem){
	foreach($arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"] as $key => $metro){
		$distans_metro = !empty($arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key])?" (".$arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key].")":false;
		$arResult["ITEMS"][$cell]["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][$key] = $arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"][$metro]["NAME"].$distans_metro;
	}
}

$cat_info = gethlel(1, "UF_SERVICE", $arParams['ID_SERVICE']);

foreach($cat_info as $clin){
	$arResult["CLIN_PRICE"][$clin["UF_CLINIC"]] = $clin;
}
$arResult["sort_price"] = record_sort($cat_info, 'UF_PRICE');*/
foreach($arResult["ITEMS"] as $cell => $arItem){
	foreach($arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"] as $key => $metro){
		$distans_metro = !empty($arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key])?" (".$arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key].")":false;
		$arResult["ITEMS"][$cell]["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][$key] = $arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"][$metro]["NAME"].$distans_metro;
	}
}


$arResult['NAV_RESULT_NAV_NUM'] = $arResult['NAV_RESULT']->NavNum;
 
$arResult['NAV_RESULT_NAV_PAGE_NOMER'] = $arResult['NAV_RESULT']->NavPageNomer;
 
$arResult['NAV_RESULT_NAV_PAGE_COUNT'] = $arResult['NAV_RESULT']->NavPageCount;
 
$arResult['SECTION_SECTION_PAGE_URL'] = !empty($arParams['SECTION_SECTION_PAGE_URL']) ? $arParams['SECTION_SECTION_PAGE_URL'] : null;
 
$this->__component->SetResultCacheKeys([
    'NAV_RESULT_NAV_NUM',
    'NAV_RESULT_NAV_PAGE_NOMER',
    'NAV_RESULT_NAV_PAGE_COUNT',
    'SECTION_SECTION_PAGE_URL',
]);
