<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/*CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog"); 
CModule::IncludeModule("highloadblock");
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */


foreach($arResult["ITEMS"] as $key => $value) {
	$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter"=>array("TABLE_NAME"=>"b_uzi")));
	if(!($hldata = $rsData->fetch())){
		echo "Инфоблок не найден";
	}else{
		$hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
		$hlDataClass = $hldata["NAME"]."Table";
		$res = $hlDataClass::getList(array(
				"filter" => array(
					"UF_CLINIC" => $value["ID"],
				)
			)
		);
		while ($arItem = $res->Fetch()) {
			$arResult["ITEMS"][$key]["SERVICES"][] = $arItem;
		}
	}
}

foreach($arResult["ITEMS"] as $key => $value) {
	foreach($value["SERVICES"] as $k => $v) {
		$arFilter1 = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y", "ID"=>$v["UF_SERVICE"]);
		$res1 = CIBlockElement::GetList(Array(), $arFilter1, false, false, Array("ID", "NAME", "PROPERTY_PRIORITET"));
		while($ob1 = $res1->GetNextElement())
		{
			$arFields1 = $ob1->GetFields();
			if(!empty($arFields1["PROPERTY_PRIORITET_VALUE"])){
				$arResult["ITEMS"][$key]["SERVICES"][$k]["NAME"] = $arFields1["NAME"];
			}else{
				unset($arResult["ITEMS"][$key]["SERVICES"][$k]);
			}
		}
		
	}
}

foreach($arResult["ITEMS"] as $cell => $arItem){
	foreach($arItem["DISPLAY_PROPERTIES"]["METRO"]["VALUE"] as $key => $metro){
		$distans_metro = !empty($arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key])?" (".$arItem["DISPLAY_PROPERTIES"]["METRO"]["DESCRIPTION"][$key].")":false;
		$arResult["ITEMS"][$cell]["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][$key] = $arItem["DISPLAY_PROPERTIES"]["METRO"]["LINK_ELEMENT_VALUE"][$metro]["NAME"].$distans_metro;
	}
}

/*
$cat_info = gethlel(1, "UF_SERVICE", $arParams["ID_SERVICE"]);

foreach($cat_info as $clin){
	$arResult["CLIN_PRICE"][$clin["UF_CLINIC"]] = $clin;
}
$arResult["sort_price"] = record_sort($cat_info, "UF_PRICE");*/