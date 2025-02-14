<?/***********
 * Разделы *
 ***********/
//CModule::IncludeModule('iblock');
$arFilter = Array("IBLOCK_ID"=>IntVal($arParams["IBLOCK_ID"]), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "DEPTH_LEVEL"=>1);
$rs_section = CIBlockSection::GetList(Array("LEFT_MARGIN" => "ASC"), $arFilter, true, array("SECTION_PAGE_URL", "NAME", "CODE"));
while($ar_section = $rs_section->Fetch())
{
	$arResult["SECTIONS"][$ar_section["ID"]] = $ar_section;
	if($SECTION_ID == $ar_section["ID"]){
		$arResult["SECTIONS"][$ar_section["ID"]]["SELECTED"] = true;
	}
}
?>