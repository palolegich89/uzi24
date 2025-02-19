<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Все станции метро, где можно круглосуточно сделать УЗИ. Изучайте цены и выбирайте лучший вариант. Актуальные адреса и номера телефонов для записи на УЗИ. Доступна онлайн-запись.");
$APPLICATION->SetPageProperty("title", "Клиники с услугами круглосуточного УЗИ по метро и районам");
$APPLICATION->SetTitle("Круглосуточное УЗИ по станциям метро Москвы");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");

$curPage = $APPLICATION->GetCurPage();
$curDir = $APPLICATION->GetCurDir(true);

// Страница со списком метро, районов и округов

$block_id = 2;
$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();
$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$limit = 999;
$rsData = $entity_data_class::getList(array(
	'select' => array('*'),
	'order' => array(),
	'limit' => $limit,
	'filter' => array("UF_ACTIVE" => true)
));
while ($el = $rsData->fetch()) {
	if (!empty($el["UF_METRO"])) {
		$seo_metro[$el["UF_METRO"]] = $el["UF_METRO"];
	}
	if (!empty($el["UF_RAYON"])) {
		//$seo_rayon[$el["UF_RAYON"]] = true;
	}
	if (!empty($el["UF_OKRUG"])) {
		//$seo_okrug[$el["UF_OKRUG"]] = true;
	}
}

$res2 = CIBlockElement::GetList(array(), array(
	"IBLOCK_ID" => 1,
	"ACTIVE" => "Y"
), false, false, array(
	"ID",
	"NAME",
	"CODE",
	"DETAIL_PAGE_URL"
));
while ($ob2 = $res2->GetNextElement()) {
	$arFields2 = $ob2->GetFields();

	if ($seo_metro[$arFields2["ID"]]) {
		$metro_tmp[$arFields2["ID"]] = $arFields2;
		$metro_tmp[$arFields2["ID"]]["URL"] = $arFields2["DETAIL_PAGE_URL"];
	} 
}

sort($metro_tmp);
foreach ($metro_tmp as $key => $value) {
	$first_char = substr($value["NAME"], 0, 1);
	$prev_char = substr($metro_tmp[$key - 1]["NAME"], 0, 1);
	$metro[$first_char][$key] = $value;
}

global $arFilterMetrosIDs;
$arFilterMetrosIDs = ["ID" => $seo_metro];
?>
<h1><? $APPLICATION->ShowTitle(false) ?></h1>
<? $APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"template_metro",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"FILTER_NAME" => "arFilterMetrosIDs",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "external_reference",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "999",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Станции метро",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "NAME",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "template_metro"
	),
	false
); ?>

<?/*<div class="metro-stations__list">
		<div class="metro-stations__part">
			<div class="metro-stations__columns">
				<? foreach ($metro as $key => $value): ?>
					<div class="metro-stations__one">
						<h3 class="metro-stations__one-title"><? echo $key; ?></h3>
						<ul>
							<? foreach ($value as $k => $v): ?>
								<li><a href="<? echo $v["URL"]; ?>"><? echo $v["NAME"]; ?></a></li>
							<? endforeach; ?>
						</ul>
					</div>
				<? endforeach; ?>
			</div>
		</div>
		<div class="metro-stations__part">
			<h2 class="metro-stations__part-title">Клиники по районам и округам</h2>
			<div class="metro-stations__columns">
				<? foreach ($locations as $key => $value): ?>
					<div class="metro-stations__one">
						<h3 class="metro-stations__one-title"><a href="<? echo $value["URL"]; ?>"><? echo $value["NAME"]; ?></a></h3>
						<ul>
							<? foreach ($value["RAYON"] as $k => $v): ?>
								<li><a href="<? echo $v["URL"]; ?>"><? echo $v["NAME"]; ?></a></li>
							<? endforeach; ?>
						</ul>
					</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>*/ ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>