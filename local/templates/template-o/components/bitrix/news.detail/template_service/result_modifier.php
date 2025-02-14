<?
$img = CFile::ResizeImageGet($arResult["PROPERTIES"]["AVATAR"]["VALUE"], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true);                
$arResult["PROPERTIES"]["AVATAR"]["SRC"] = $img["src"];

$cat_info_g = gethlel(1, "UF_SERVICE", $arResult["ID"]);

global $service;
$service = $arResult;

$sort_price = record_sort($cat_info_g, 'UF_PRICE');

foreach($sort_price as $key => $item){
	if(!empty($item["UF_PRICE"])){
		$arResult["sort_price"][] = $item;
	}
}
//pre_dump($arResult["sort_price"]);

