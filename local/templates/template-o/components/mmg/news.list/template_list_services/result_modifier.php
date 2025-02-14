<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach($arResult["ITEMS"] as $key => $value) {
	if(!empty($value["PROPERTIES"]["PARENT"]["VALUE"])) {
		foreach($arResult["ITEMS"] as $k => $v) {
			if($v["ID"] == $value["PROPERTIES"]["PARENT"]["VALUE"]) {
				$arResult["ITEMS"][$k]["CHILDREN"][] = $value;
				unset($arResult["ITEMS"][$key]);
			}
		}
	}
}

