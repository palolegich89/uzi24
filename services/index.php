<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?ob_start();?>
<?$serviceId = $APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"template_service", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "services",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"PROPERTY_CODE" => array(
			0 => "TOP_TEXT",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_CANONICAL_URL" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "template_service"
	),
	false
);?>
<?$out1 = ob_get_contents();
ob_end_clean();
$APPLICATION->AddViewContent('head_block', $out1);?>
<?
/* Глобальные переменные:
$service - Информация об услуге */

CModule::IncludeModule("iblock");
$serviceChildIDs[] = $serviceId;
$serviceChildIDsForClinics = [];
$arFilter = array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "PROPERTY_PARENT" => $serviceId);
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID"));
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$serviceChildIDs[] = $arFields['ID'];
	$serviceChildIDsForClinics[] = $arFields['ID'];
}

$cat_info_g = gethlel(1, "UF_SERVICE", $serviceChildIDs);

foreach($cat_info_g as $value) {
	$clinicsIDs[] = $value['UF_CLINIC'];
}

global $FilterIdsClinics;
$FilterIdsClinics = array("ID" => $clinicsIDs);

$componentParams = array(
	"COMPONENT_TEMPLATE" => "template_clinics",
	"IBLOCK_TYPE" => "external_reference",
	"IBLOCK_ID" => "8",
	"NEWS_COUNT" => "15",
	"SORT_BY1" => "PROPERTY_ROUND_CLOCK",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "FilterIdsClinics",
	"FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "ADDRESS",
		1 => "PHONE",
		2 => "WORKTIME",
		3 => "DESCRIPTION_UZI",
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
	"PAGER_TITLE" => "Процедуры",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"PAGER_BASE_LINK_ENABLE" => "N",
	"SET_STATUS_404" => "N",
	"SHOW_404" => "N",
	"MESSAGE_404" => "",
	"ID_SERVICE" => $serviceId,
	"IDS_SERVICE_CHILD" => $serviceChildIDsForClinics
);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"template_clinics",
	$componentParams,
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>