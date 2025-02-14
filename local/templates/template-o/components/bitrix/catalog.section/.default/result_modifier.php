<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */
// Связь услуг с услугами мск

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

use Bitrix\Main\Application as Application;

$request = Application::getInstance()->getContext()->getRequest();
$SECTION_CODE = htmlspecialchars($request->getQuery("SECTION_CODE"));
$ELEMENT_CODE = htmlspecialchars($request->getQuery("ELEMENT_CODE"));
$METRO_CODE = htmlspecialchars($request->getQuery("metro"));

$METRO_ID = getIdByCode($METRO_CODE, METRO_IB, IBLOCK_ELEMENT);
$ELEMENT_ID = getIdByCode($ELEMENT_CODE, IB_CONTENT, IBLOCK_ELEMENT);
$SECTION_ID = getIdByCode($SECTION_CODE, IB_CONTENT, IBLOCK_SECTION);

$filterseo = array(
    //"UF_METRO" => $METRO_ID,
    "UF_SERVICE_LINK" => false,
    "UF_SERVICE_SEC_LINK" => $arResult["ID"],
);

$info = gethlelarray(LocalHB, $filterseo);

$metroIDS = array();
foreach($info as $metro){
    $metroIDS[] = $metro["UF_METRO"];
}

//информация по метро
if(!empty($metroIDS)){
    $arSelect = Array("ID", "NAME", "CODE");
    $arFilter_metro = Array("IBLOCK_ID"=>IntVal(METRO_IB), "ID"=>$metroIDS, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG"=>IntVal(OKRUG));
    $rs_metro = CIBlockElement::GetList(Array(), $arFilter_metro, false, false, $arSelect);
    while($ar_metro = $rs_metro->GetNext(false, false))
    {
        $arResult["METROS"][$ar_metro["ID"]] = $ar_metro;
        $arResult["METROS"][$ar_metro["ID"]]["DETAIL_PAGE_URL"] = $arResult["SECTION_PAGE_URL"]."metro/".$ar_metro["CODE"]."/";
        if($METRO_ID == $ar_metro["ID"]){
            $arResult["METROS"][$ar_metro["ID"]]["SELECTED"] = true;
        }
    }
}

foreach ($arResult["ITEMS"] as $item)
{
	if(!empty($item["PROPERTIES"]["USLUGA"]["VALUE"]))
	{
		$USLUGA[$item["PROPERTIES"]["USLUGA"]["VALUE"]] = $item["PROPERTIES"]["USLUGA"]["VALUE"];
		$serviceName[$item["PROPERTIES"]["USLUGA"]["VALUE"]] = $item["NAME"];
	}
	if(!empty($item["PROPERTIES"]["USLUGA_MAIN"]["VALUE"]))
	{
		//pre_dump($item["NAME"]);
	}
	if($arResult["UF_SERVICE_MAIN"] == $item["ID"])
	{
		$USLUGA_main = $item["PROPERTIES"]["USLUGA"]["VALUE"];
		$serviceName_main = $item["NAME"];
	}
}

// цепляем связанные услуги и всю информацию
$arFilterS = Array("IBLOCK_ID"=>IntVal(20), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$USLUGA);
$db_listS = CIBlockSection::GetList(Array(), $arFilterS, true, Array("UF_SEC_MSK", "UF_SERVICE_LINK_MSK"));
while($ar_resultS = $db_listS->Fetch())
{
    //$xml_id_msk[$ar_resultS["UF_SEC_MSK"]] = $ar_resultS["UF_SEC_MSK"];

    $id_name[$ar_resultS["ID"]] = $ar_resultS["NAME"];
    $usluga_id[$ar_resultS["ID"]] = $ar_resultS["ID"];
	
	if(empty($serviceName[$ar_resultS["ID"]])){
		$serviceName[$ar_resultS["ID"]] = $ar_resultS["NAME"];
	}
	if(!empty($ar_resultS["UF_SERVICE_LINK_MSK"])){
		$usluga_id_v_msk[$ar_resultS["UF_SERVICE_LINK_MSK"]] = $ar_resultS["ID"];
		
		$xml_name_msk[$ar_resultS["UF_SERVICE_LINK_MSK"]] = $ar_resultS["NAME"];
		$xml_id_msk[$ar_resultS["UF_SERVICE_LINK_MSK"]] = $ar_resultS["UF_SERVICE_LINK_MSK"];
		$serviceName[$ar_resultS["UF_SERVICE_LINK_MSK"]] = $ar_resultS["NAME"];
	}

	// выбираем основную услугу раздела (айдишники и название)
	if($ar_resultS["ID"] == $USLUGA_main && !empty($arResult["UF_SERVICE_MAIN"])){
		$usluga_id_main = $ar_resultS["ID"];
		$serviceName_main2 = $ar_resultS["NAME"];
		$xml_id_msk_main = $ar_resultS["UF_SERVICE_LINK_MSK"];
	}
	
    /*if(!empty($ar_resultS["UF_SEC_MSK"])){
        $xml_name_msk[$ar_resultS["UF_SEC_MSK"]] = $ar_resultS["NAME"];
        $xml_id_msk[$array_sec[$ar_resultS["UF_SEC_MSK"]]] = $array_sec[$ar_resultS["UF_SEC_MSK"]];
        $serviceName[$array_sec[$ar_resultS["UF_SEC_MSK"]]] = $ar_resultS["NAME"];
    }*/
}

/*foreach($xml_id_msk as $xml_id_msk_item){
    $serviceName[$array_sec[$xml_id_msk_item]] = $xml_name_msk[$xml_id_msk_item];
}*/

/*// Пользовательские поля раздела
$arFilterSx = Array("IBLOCK_ID"=>IntVal(23), "GLOBAL_ACTIVE"=>"Y", "XML_ID"=>$xml_id_msk);
$db_listSx = CIBlockSection::GetList(Array(), $arFilterSx, true, Array());
while($ar_resultSx = $db_listSx->Fetch())
{
    $usluga_id_msk[$ar_resultSx["ID"]] = $ar_resultSx["ID"];
    $serviceName[$ar_resultSx["ID"]] = $xml_name_msk[$ar_resultSx["XML_ID"]];
}*/

//Запрашиваем ID всех клиник по привязанной услуге
//$priceList = gethlel(3, "UF_SERVICE_LINK", $USLUGA);
//$priceList = gethlel(15, "UF_SERVICE_LINK", $usluga_id_msk);

$filterusl = array(
    array(
        "LOGIC" => "OR",
        array("UF_SERVICE_LINK" => $xml_id_msk),
        array("UF_SERVICE_LINK2" => $usluga_id),
    ),
);

$priceList = gethlelarray(15, $filterusl, 99999);

/*//Информация об услуге
$arSelect = Array("ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>IntVal(20), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$USLUGA);
$db_list = CIBlockSection::GetList(Array(), $arFilter, false, $arSelect);
while($ar_result = $db_list->GetNext())
{
    $serviceName[$ar_result["ID"]] = $ar_result["NAME"];
}*/

//Название округа
$arSelect = Array("NAME", "PROPERTY_FULL_NAME", "PROPERTY_FULL_NAME_SKL");
$arFilter = Array("IBLOCK_ID"=>IntVal(OKRUG_IB), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>OKRUG);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext())
{
    $arResult["OKRUG_NAME"] = $arFields["NAME"];
	$arResult["OKRUG_FULL_NAME"] = $arFields["PROPERTY_FULL_NAME_VALUE"];
	$arResult["OKRUG_FULL_NAME_SKL"] = $arFields["PROPERTY_FULL_NAME_SKL_VALUE"];
}

//Достаём значения всех прайсов МЦС
$arSelect = Array("ID", "PROPERTY_ARTIKUL", "PROPERTY_PRICE");
$arFilter = Array("IBLOCK_ID"=>IntVal(5), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($arFields = $res->GetNext(false, false))
{
    $price_mcs[$arFields["PROPERTY_ARTIKUL_VALUE"]] = $arFields["PROPERTY_PRICE_VALUE"];
}

//Создаём новый массив
foreach($priceList as $priceItem){
	
	//$service_id = !empty($priceItem["UF_SERVICE_LINK"])?$priceItem["UF_SERVICE_LINK"]:$usluga_id_v_msk[$priceItem["UF_SERVICE_LINK2"]];
	$service_id = !empty($priceItem["UF_SERVICE_LINK2"])?$priceItem["UF_SERVICE_LINK2"]:$usluga_id_v_msk[$priceItem["UF_SERVICE_LINK"]];
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["INDEX"] = false;
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["ID"] = $priceItem["UF_CLINIC_LINK"];
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["UF_SERVICE_LINK"][$service_id] = $service_id;
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["SERVICE_NAME"][$service_id] = $serviceName[$service_id];
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["UF_PRICE"][$service_id] = $priceItem["UF_PRICE"];
    $clinicList[$priceItem["UF_CLINIC_LINK"]]["UF_ARTICUL_MCS"][$service_id] = $priceItem["UF_ARTICUL_MCS"];

    $arResult["clinicList_IDS"][$priceItem["UF_CLINIC_LINK"]] = $priceItem["UF_CLINIC_LINK"];
    $PriceArticul[$priceItem["UF_ARTICUL_MCS"]][$service_id] = $priceItem["UF_ARTICUL_MCS"];

    if(!empty($priceItem["UF_ARTICUL_MCS"])){
        $clinicList[$priceItem["UF_CLINIC_LINK"]]["PRICE_VALUE"][$service_id] = $price_mcs[$priceItem["UF_ARTICUL_MCS"]];
        //Если задан артикул в прайсе, то достаём цену по артикулу
        /*$arSelect = Array("ID", "PROPERTY_ARTIKUL", "PROPERTY_PRICE");
        $arFilter = Array("IBLOCK_ID"=>IntVal(5), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ARTIKUL"=>$priceItem["UF_ARTICUL_MCS"]);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($arFields = $res->GetNext(false, false))
        {
            $clinicList[$priceItem["UF_CLINIC_LINK"]]["PRICE_VALUE"][] = $arFields["PROPERTY_PRICE_VALUE"];
        }*/
    }elseif(!empty($priceItem["UF_PRICE"])){
        //если поле цена не пустое, устанавливаем цену
        $clinicList[$priceItem["UF_CLINIC_LINK"]]["PRICE_VALUE"][$service_id] = $priceItem["UF_PRICE"];
    }
	
	if($priceItem["UF_SERVICE_LINK2"] == $usluga_id_main || $priceItem["UF_SERVICE_LINK"] == $xml_id_msk_main){
		$service_id_main = !empty($priceItem["UF_SERVICE_LINK2"])?$priceItem["UF_SERVICE_LINK2"]:$usluga_id_v_msk[$priceItem["UF_SERVICE_LINK"]];
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["INDEX"] = false;
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["ID"] = $priceItem["UF_CLINIC_LINK"];
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["UF_SERVICE_LINK"][$service_id_main] = $service_id_main;
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["SERVICE_NAME"][$service_id_main] = $serviceName[$service_id_main];
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["UF_PRICE"][$service_id_main] = $priceItem["UF_PRICE"];
		$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["UF_ARTICUL_MCS"][$service_id_main] = $priceItem["UF_ARTICUL_MCS"];

		$arResult["clinicList_IDS_main"][$priceItem["UF_CLINIC_LINK"]] = $priceItem["UF_CLINIC_LINK"];
		$PriceArticul_main[$priceItem["UF_ARTICUL_MCS"]][$service_id_main] = $priceItem["UF_ARTICUL_MCS"];

		if(!empty($priceItem["UF_ARTICUL_MCS"])){
			$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["PRICE_VALUE"][$service_id_main] = $price_mcs[$priceItem["UF_ARTICUL_MCS"]];
		}elseif(!empty($priceItem["UF_PRICE"])){
			//если поле цена не пустое, устанавливаем цену
			$clinicList_main[$priceItem["UF_CLINIC_LINK"]]["PRICE_VALUE"][$service_id_main] = $priceItem["UF_PRICE"];
		}
	}
}

//pre_dump($clinicList_main);
// Запрашиваем клиники с ценами

if(!empty($arParams["METRO"])){
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "ID"=>$arResult["clinicList_IDS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG, "PROPERTY_METRO"=>$arParams["METRO"]);
}else{
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "ID"=>$arResult["clinicList_IDS"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG);
}
$rs_arSelect = array("NAME", "ID", "PROPERTY_LONG", "PROPERTY_LAT", "PROPERTY_ROUND_CLOCK", "PROPERTY_WORKTIME", "PROPERTY_SHORT_NAME", "PROPERTY_ADDRESS", "PROPERTY_LONG", "PROPERTY_LONG", "PROPERTY_ADDRESS_O");
$rs_element = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter2, false, false, $rs_arSelect);
while($ar_element = $rs_element->GetNext(false, false))
{
    $clinicIDS[$ar_element["ID"]] = $ar_element["ID"];
    $clinicList[$ar_element["ID"]]["INDEX"] = true;
	$clinicListMap[$ar_element["ID"]] = $ar_element;
}

$allClinicsList = gethlelarray(15, array(), 999999);
foreach($allClinicsList as $allClinicsItem){
	$allClinics[$allClinicsItem["UF_CLINIC_LINK"]] = $allClinicsItem["UF_CLINIC_LINK"];
}

// Айдишники всех клиник с ценами
$withPriceClinics = array_merge($allClinics,$arResult["clinicList_IDS"]);

// Запрашиваем клиники без цен
if(!empty($arParams["METRO"])){
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "!ID"=>$allClinics, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG, "PROPERTY_METRO"=>$arParams["METRO"]);
}else{
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "!ID"=>$allClinics, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG);
}
$rs_arSelect = array("NAME", "ID", "PROPERTY_LONG", "PROPERTY_LAT", "PROPERTY_ROUND_CLOCK", "PROPERTY_WORKTIME", "PROPERTY_SHORT_NAME", "PROPERTY_ADDRESS", "PROPERTY_LONG", "PROPERTY_LONG", "PROPERTY_ADDRESS_O");
$rs_element = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter2, false, false, $rs_arSelect);
while($ar_element = $rs_element->GetNext(false, false))
{
    $clinicIDS[$ar_element["ID"]] = $ar_element["ID"];
    $clinicList[$ar_element["ID"]]["INDEX"] = true;
	$clinicListMap[$ar_element["ID"]] = $ar_element;
}

foreach($clinicList as $key => $clinicItem){
    if($clinicItem["INDEX"] == false){
        unset($clinicList[$key]);
        unset($arResult["clinicList_IDS"][$key]);
    }
}

foreach($clinicList as $key => $clinicItem){
    $min_price_index = array_search(min($clinicItem["PRICE_VALUE"]), $clinicItem["PRICE_VALUE"]);
    $clinicList[$key]["min_price_index"] = $min_price_index;
    $clinicList[$key]["min_price_name"] = $clinicItem["SERVICE_NAME"][$min_price_index];
    $clinicList[$key]["min_price"] = min($clinicItem["PRICE_VALUE"]);
}

foreach($clinicList as $key => $clinicItem){
    if($clinicItem["min_price"] > 1){
        $clinicList_price_min[$key]["min_price"] = $clinicItem["min_price"];
    }
}




if(!empty($arParams["METRO"])){
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "ID"=>$arResult["clinicList_IDS_main"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG, "PROPERTY_METRO"=>$arParams["METRO"]);
}else{
    $arFilter2 = Array("IBLOCK_ID"=>IntVal(CLINIC_IB), "ID"=>$arResult["clinicList_IDS_main"], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_OKRUG" => OKRUG);
}
$rs_arSelect = array("NAME", "ID");
$rs_element = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter2, false, false, $rs_arSelect);
while($ar_element = $rs_element->GetNext(false, false))
{
    $clinicList_main[$ar_element["ID"]]["INDEX"] = true;
}

foreach($clinicList_main as $key => $clinicItem_main){
    if($clinicItem_main["INDEX"] == false){
        unset($clinicList_main[$key]);
        unset($arResult["clinicList_IDS_main"][$key]);
    }
}

foreach($clinicList_main as $key_main => $clinicItem_main){
    $min_price_index = array_search(min($clinicItem_main["PRICE_VALUE"]), $clinicItem_main["PRICE_VALUE"]);
    $clinicList_main[$key_main]["min_price_index"] = $min_price_index;
    $clinicList_main[$key_main]["min_price_name"] = $clinicItem_main["SERVICE_NAME"][$min_price_index];
    $clinicList_main[$key_main]["min_price"] = min($clinicItem_main["PRICE_VALUE"]);
}

foreach($clinicList_main as $key_main => $clinicItem_main){
    if($clinicItem_main["min_price"] > 1){
        $clinicList_price_min_main[$key_main]["min_price"] = $clinicItem_main["min_price"];
		$clinicList_price_min_main[$key_main]["id"] = $key_main;
    }
}

//Удаляем изначальный массив с ценами
unset($priceList);

/*//Достаём информацию о клиниках
$arSelect = Array("ID", "NAME", "PROPERTY_ADDRESS", "PROPERTY_AVATAR", "PROPERTY_METRO", "PROPERTY_PHONE", "PROPERTY_WORKTIME", "PROPERTY_ROUND_CLOCK");
$arFilter = Array("IBLOCK_ID"=>IntVal(8), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$clinicList_IDS);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$clinicList[$arFields["ID"]]["INFO"] = $arFields;
}*/

$arResult["clinicIDS"] = $clinicIDS;
$arResult["clinicList"] = $clinicList;
$arResult["clinicListMap"] = $clinicListMap;

$arResult["sort_price"] = record_sort($clinicList_price_min, 'min_price');
$arResult["sort_price_main"] = record_sort($clinicList_price_min_main, 'min_price');

//pre_dump($arResult["sort_price_main"]);

$arSelect = Array("ID", "NAME", "PROPERTY_IZBR", "PROPERTY_SHORT_NAME", "PROPERTY_ALTERNATIVE_NAME", "PROPERTY_WORKTIME", "PROPERTY_ROUND_CLOCK");
$arFilter = Array("IBLOCK_ID"=>IntVal(8), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$arResult["clinicList_IDS_main"], "PROPERTY_IZBR_VALUE" => "Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	//$clinicEl_main["INFO"] = $arFields;

	$clinicEl_main["NAME"] = !empty($arFields["PROPERTY_SHORT_NAME_VALUE"])?$arFields["PROPERTY_SHORT_NAME_VALUE"]:$arFields["NAME"];
	$clinicEl_main["WORKTIME"] = !empty($arFields["PROPERTY_ROUND_CLOCK_VALUE"])?"24 часа":$arFields["PROPERTY_WORKTIME_VALUE"];
}
$clinicEl_main["PRICE"] = number_format($arResult["sort_price_main"][0]["min_price"], 0, ',', ' ').' руб.';
$clinicEl_main["PRICE_VALUE"] = $arResult["sort_price_main"][0]["min_price"];
$clinicEl_main["OKRUG"] = $arResult["OKRUG_FULL_NAME_SKL"];
$clinicEl_main["NAME_SERVICE"] = $serviceName_main;

$arResult["TEXT_INFO"] = $clinicEl_main;
$arResult["PRICE"] = 'от '.number_format($arResult["sort_price"][0]["min_price"], 0, ',', ' ').' руб.';
$arResult["PRICE_VALUE"] = $arResult["sort_price"][0]["min_price"];

//pre_dump($arResult["clinicList"]);

$this->__component->arResultCacheKeys = array_merge($this->__component->arResultCacheKeys, array('UF_METRO_TITLE', 'UF_METRO_DESCRIPTION', 'UF_METRO_H1', 'PRICE', 'PRICE_VALUE', 'clinicList', 'TEXT_INFO'));