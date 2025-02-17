<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$img = CFile::ResizeImageGet($arResult["PROPERTIES"]["AVATAR"]["VALUE"], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
$arResult["PROPERTIES"]["AVATAR"]["SRC"] = $img["src"];

$cat_info_g = gethlel(1, "UF_SERVICE", $arResult["ID"]);

global $service;
$service = $arResult;

$sort_price = record_sort($cat_info_g, 'UF_PRICE');

if (empty($sort_price)) {
	CModule::IncludeModule("iblock");
	$serviceChildIDs = [];
	$arFilter = array("IBLOCK_ID" => $arParams['IBLOCK_ID'], "ACTIVE" => "Y", "PROPERTY_PARENT" => $arResult["ID"]);
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID"));
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$serviceChildIDs[] = $arFields['ID'];
	}
	// Получаем информацию из хайлоадблока для дочерних сервисов
	$child_info = gethlel(1, "UF_SERVICE", $serviceChildIDs);

	$sort_price = record_sort($child_info, 'UF_PRICE');
}

foreach($sort_price as $key => $item){
	if(!empty($item["UF_PRICE"])){
		$arResult["sort_price"][] = $item;
	}
}
//pre_dump($arResult["sort_price"]);

