<?
/** @var array $arParams */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die();
?>
<?
global $FilterIdClinics;
if(!empty($arParams["METRO"])){
	$FilterIdClinics = array("ID" => $arParams["clinicIDS"], "PROPERTY_OKRUG" => OKRUG, "PROPERTY_METRO" => $arParams["METRO"]);
}else{
	$FilterIdClinics = array("ID" => $arParams["clinicIDS"], "PROPERTY_OKRUG" => OKRUG);
}
if(!empty($arParams["METRO_INFO"]["NAME"])){
	$h2_klin = "Клиники на м. ".$arParams["METRO_INFO"]["NAME"]." - цены";
}else{
	$h2_klin = "Клиники в ".$arParams["OKRUG_NAME"]." - цены";
}

//pre_dump($service);

$arSortFields = array(
	"SHOWS" => array(
		"ORDER"=> "DESC",
		"CODE" => "PROPERTY_ROUND_CLOCK",
		"NAME" => "Популярности"
	),
	"RATING"=> array(
		"ORDER"=> "ASC",
		"CODE" => "PROPERTY_RATING",
		"NAME" => "Рейтингу"
	),
	"NAME" => array( // параметр в url
		"ORDER"=> "ASC", //в возрастающем порядке
		"CODE" => "NAME", // Код поля для сортировки
		"NAME" => "Имени" 
	)
);

if(!empty($_REQUEST["SORT_FIELD"]) && !empty($arSortFields[$_REQUEST["SORT_FIELD"]]))
{
	setcookie("CATALOG_SORT_FIELD", $_REQUEST["SORT_FIELD"], time() + 60 * 60 * 24 * 30 * 12 * 2, "/");

	$arParams["SORT_BY1"] = $arSortFields[$_REQUEST["SORT_FIELD"]]["CODE"];
	$arParams["SORT_ORDER1"] = $arSortFields[$_REQUEST["SORT_FIELD"]]["ORDER"];

	$arSortFields[$_REQUEST["SORT_FIELD"]]["SELECTED"] = "Y";
}
elseif(!empty($_COOKIE["CATALOG_SORT_FIELD"]) && !empty($arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]])) // COOKIE
{
	$arParams["SORT_BY1"] = $arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["CODE"];
	$arParams["SORT_ORDER1"] = $arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["ORDER"];
	
	$arSortFields[$_COOKIE["CATALOG_SORT_FIELD"]]["SELECTED"] = "Y";
}

$arParams["SORT_BY1"] = !empty(trim($arParams["SORT_BY1"]))? trim($arParams["SORT_BY1"]) : $arSortFields["SHOWS"]["CODE"];
$arParams["SORT_ORDER1"] = !empty(trim($arParams["SORT_ORDER1"]))? trim($arParams["SORT_ORDER1"]) : $arSortFields["SHOWS"]["ORDER"];  
?>
<h2<?// class="page__content-title"?>><?=$h2_klin;?></h2>  
<div id="catalog_list">
	<?if(!empty($arSortFields)):?>
		<span>Портировать клиники по</span>
			<?foreach ($arSortFields as $arSortFieldCode => $arSortField):?>
			<a href="<?=$APPLICATION->GetCurPageParam("SORT_FIELD=".$arSortFieldCode, array("SORT_FIELD"))."#catalog_list";?>" class="button-sort<? if($arSortField["SELECTED"] == "Y"){$arSortFieldCodeSelected = $arSortFieldCode;?> selected<?}?>"><?=$arSortField["NAME"]?></a>
			<?endforeach;?>
	<?endif;?>
</div>
<?pre_dump($arParams["SORT_BY1"]);?>
<?pre_dump($arParams["SORT_ORDER1"]);?>
<?$clinics_list = $APPLICATION->IncludeComponent(
	"mmg:news.list", 
	"template_clinics", 
	array(
		"COMPONENT_TEMPLATE" => "template_clinics",
		"IBLOCK_TYPE" => "external_reference",
		"IBLOCK_ID" => "8",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => $arParams["SORT_BY1"],
		"SORT_ORDER1" => $arParams["SORT_ORDER1"],
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "FilterIdClinics",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "PHONE",
			1 => "ADDRESS_O",
			2 => "WORKTIME",
			3 => "DESCRIPTION_OKRUG",
			4 => "SERVICE_PRICE",
			5 => "ROUND_CLOCK",
			6 => "AVATAR",
			7 => "METRO",
			8 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => "round_new",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"ID_SERVICE" => $arParams["ID_SERVICE"],
		"clinicList" => $arParams["clinicList"],
		"CLINIC_IDS_RIGHT_ORDER" => $arParams["clinicIDS"],
		"SECTION_SECTION_PAGE_URL" => $arParams["SECTION_SECTION_PAGE_URL"]
	),
	false
);?>