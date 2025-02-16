<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/*CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog"); 
CModule::IncludeModule('highloadblock');
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */

$arFilter = [
	"IBLOCK_ID" => 4,
	"ACTIVE"    => "Y",
	"ID"        => $arParams['ID_SERVICE']
];
$res = CIBlockElement::GetList(
	[],
	$arFilter,
	false,
	["nTopCount" => 1],
	[
		"ID",
		"NAME",
		"CODE",
		"DETAIL_TEXT",
		"PROPERTY_AVATAR",
		"PROPERTY_TOP_TEXT"
	]
);
if ($ob = $res->GetNextElement()) {
	$arResult["SERVICE"] = $ob->GetFields();
}

// Формируем массив имен для элементов IBLOCK_ID=4
$child_info_name_array = [];
$arFilter1 = [
	"IBLOCK_ID" => 4,
	"ACTIVE"    => "Y"
];
$res1 = CIBlockElement::GetList([], $arFilter1, false, false, ["ID", "NAME"]);
while ($ob1 = $res1->GetNextElement()) {
	$fields = $ob1->GetFields();
	$child_info_name_array[$fields["ID"]] = $fields["NAME"];
}

// Обрабатываем свойство "METRO" в каждом элементе ITEMS
if (!empty($arResult["ITEMS"])) {
	foreach ($arResult["ITEMS"] as $cell => $arItem) {
		if (
			isset(
				$arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"],
				$arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"],
				$arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"]
			) && is_array($arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"])
		) {
			foreach ($arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"] as $key => $metro) {
				$distance = !empty($arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key])
					? " (" . $arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key] . ")"
					: "";
				$metroName = isset($arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"][$metro]["NAME"])
					? $arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"][$metro]["NAME"]
					: "";
				$arResult["ITEMS"][$cell]["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][$key] = $metroName . $distance;
			}
		}
	}
}

// Получаем информацию из хайлоадблока (функция gethlel)
// Для основного сервиса
$cat_info = gethlel(1, "UF_SERVICE", $arParams['ID_SERVICE']);
if (!empty($cat_info)) {
	foreach ($cat_info as $clin) {
		$arResult["CLIN_PRICE"][$clin["UF_CLINIC"]] = $clin;
	}
}

// Сортируем по цене (используется ваша функция record_sort)
$arResult["sort_price"] = record_sort($cat_info, 'UF_PRICE');

// Получаем информацию из хайлоадблока для дочерних сервисов
$child_info = gethlel(1, "UF_SERVICE", $arParams['IDS_SERVICE_CHILD']);
if (!empty($child_info)) {
	// Группируем по UF_CLINIC и сразу добавляем поле NAME из $child_info_name_array
	foreach ($child_info as $clinic) {
		if (isset($child_info_name_array[$clinic["UF_SERVICE"]])) {
			$clinic['NAME'] = $child_info_name_array[$clinic["UF_SERVICE"]];
		}
		$arResult["CLINIC_PRICE"][$clinic["UF_CLINIC"]][] = $clinic;
	}
}

// Ограничиваем количество элементов в каждой группе до 3 случайных значений
if (!empty($arResult["CLINIC_PRICE"])) {
	foreach ($arResult["CLINIC_PRICE"] as &$clinicGroup) {
		if (count($clinicGroup) > 3) {
			shuffle($clinicGroup);
			$clinicGroup = array_slice($clinicGroup, 0, 3);
		}
	}
	unset($clinicGroup);
}

// Если отсортированный массив по цене пуст или содержит менее одного элемента,
// выполняем сортировку для дочерних сервисов
if (empty($arResult["sort_price"]) || $arResult["sort_price"] < 1) {
	$arResult["sort_price"] = record_sort($child_info, 'UF_PRICE');
}
