<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

foreach($arResult["SECTIONS"] as $key_sec => $section){
	if($section["DEPTH_LEVEL"] > 1){
		$arResult["SECTIONS_NEW"][$section["IBLOCK_SECTION_ID"]]["CILDREN"][$section["ID"]] = $section;
	}else{
		$arResult["SECTIONS_NEW"][$section["ID"]] = $section;
	}
}

?>