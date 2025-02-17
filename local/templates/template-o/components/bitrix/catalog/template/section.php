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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");?>

<?/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component,
	array("HIDE_ICONS" => "Y")
);*/?>
<?$intSectionID = $APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "",
    array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
        "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
		"INCLUDE_SUBSECTIONS" => "N",//$arParams["INCLUDE_SUBSECTIONS"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "SET_META_DESCRIPTION" => "N",
        "SET_META_KEYWORDS" => "N",
        "MESSAGE_404" => $arParams["~MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
        "PRICE_CODE" => $arParams["~PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
        "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
        "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
        "LAZY_LOAD" => $arParams["LAZY_LOAD"],
        "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
        "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
        "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
        'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

        'LABEL_PROP' => $arParams['LABEL_PROP'],
        'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
        'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
        'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
        'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
        'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
        'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
        'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
        'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
        'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
        'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
        'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
        'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
        'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
        'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
        'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
        'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
        'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
        'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
        'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

        'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
        'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
        'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

        'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
        "ADD_SECTIONS_CHAIN" => "N",
        'ADD_TO_BASKET_ACTION' => $basketAction,
        'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
        'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],
        'USE_COMPARE_LIST' => 'Y',
        'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
        'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
        'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
		'SECTION_USER_FIELDS' => array("UF_SERVICE_MAIN")
    ),
    $component
);?>
<?$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;?>
<?
//Информация о разделе
/*$arSelect = Array("*");
$arFilter = Array("IBLOCK_ID"=>IntVal(IB_CONTENT), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$intSectionID);
$db_list = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
while($ar_result = $db_list->GetNext())
{
	pre_dump($ar_result);
}*/

//***********
// * Разделы *
// ***********

$arFilter_section = Array("IBLOCK_ID"=>IntVal(IB_CONTENT), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$rs_section = CIBlockSection::GetList(Array("LEFT_MARGIN" => "ASC"), $arFilter_section, true, Array("UF_*"));
while($ar_section = $rs_section->GetNext())
{
	if($ar_section["DEPTH_LEVEL"] == 1){
		$arResult["SECTIONS"][$ar_section["ID"]] = $ar_section;
		if($arResult["VARIABLES"]["SECTION_CODE"] == $ar_section["CODE"]){
			$arResult["SECTIONS"][$ar_section["ID"]]["SELECTED"] = true;
		}
	}
	if($ar_section["DEPTH_LEVEL"] == 2){
		$arResult["SECTIONS"][$ar_section["IBLOCK_SECTION_ID"]]["ITEMS"][$ar_section["ID"]] = $ar_section;
		if($arResult["VARIABLES"]["SECTION_CODE"] == $ar_section["CODE"]){
			$arResult["SECTIONS"][$ar_section["IBLOCK_SECTION_ID"]]["ITEMS"][$ar_section["ID"]]["SELECTED"] = true;
			$arResult["SECTIONS"][$ar_section["IBLOCK_SECTION_ID"]]["SELECTED"] = true;
		}
	}
}

//************
// * Элементы *
// ************

/*$arFilter = Array("IBLOCK_ID"=>IntVal(IB_CONTENT), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "SECTION_CODE"=>$arResult["VARIABLES"]["SECTION_CODE"]);
$rs_element = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ar_element = $rs_element->GetNext(false, false))
{
	$arResult["SECTIONS"][$ar_element["IBLOCK_SECTION_ID"]]["ITEMS"][$ar_element["ID"]] = $ar_element;
	if($elementId == $ar_element["ID"]){
		$arResult["SECTIONS"][$ar_element["IBLOCK_SECTION_ID"]]["ITEMS"][$ar_element["ID"]]["SELECTED"] = true;
		$arResult["ITEMS"][$ar_element["ID"]]["SELECTED"] = true;
		$arResult["ITEMS"][$ar_element["ID"]] = $ar_element;
	}
}
pre_dump($arResult["ITEMS"]);*/
/*********************
 * Построение дерева *
 *********************/
/*
$previousLevel = 0;
$arStack = Array();
foreach($arResult["SECTIONS"] as $arSection)
{
   if($previousLevel && $arSection["DEPTH_LEVEL"] <= $previousLevel)
   {
      $delta = $previousLevel - $arSection["DEPTH_LEVEL"];
      for($i = 0; $i < ($delta + 1); $i++)
      {
         $section_id = array_pop($arStack);
         if(array_key_exists($section_id, $arResult["ELEMENTS"]))
         {
            foreach($arResult["ELEMENTS"][$section_id] as $arElement)
            {
               $arResult["ITEMS"][] = $arElement;
            }
         }
      }
   }

   $arResult["ITEMS"][] = $arSection;

   $arStack[] = $arSection["ID"];
   $previousLevel = $arSection["DEPTH_LEVEL"];
}*/

?>
<?$this->SetViewTarget('aside_sidebar');?>
    <div class="page__sidebar">
        <h4 class="page__sidebar-title">Услуги</h4>
        <nav class="page__sidebar-nav">
            <ul>
                <?foreach($arResult["SECTIONS"] as $key => $value):?>
                    <li <?if($value['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$value['SECTION_PAGE_URL'];?>"><?=$value['NAME'];?></a>
                        <?if(!empty($value['ITEMS']) && $value['SELECTED'] == true):?>
                            <ul>
                                <?foreach($value['ITEMS'] as $k => $v):?>
                                    <li <?if($v['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$v['SECTION_PAGE_URL'];?>"><?=$v['NAME'];?></a></li>
                                <?endforeach;?>
                            </ul>
                        <?endif?>
                    </li>
                <?endforeach?>
                <?/*foreach($arResult["ITEMS"] as $k => $v):?>
                <li <?if($v['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$v['DETAIL_PAGE_URL'];?>"><?=$v['NAME'];?></a></li>
                <?endforeach*/?>
            </ul>
        </nav>
    </div>
<?$this->EndViewTarget();?>

<?$APPLICATION->ShowViewContent('metro_sidebar');?>
<?if(
	Bitrix\Main\Loader::includeModule('api.uncachedarea')
	&& Bitrix\Main\Loader::includeModule('iblock')
) {
	CAPIUncachedArea::includeFile(
		"/local/include/list_reviews.php",
		array(
			"IBLOCK_ID" => $IBLOCK_ID_REV,
			"SECTION_ID" => $SECTION_ID_REV,
			"ELEMENT_ID" => $ELEMENT_ID_REV,
			"SECTION_SECTION_PAGE_URL" => $SECTION_SECTION_PAGE_URL_REV,
		)
	);
}?>