<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Все станции метро, где можно круглосуточно сделать УЗИ. Изучайте цены и выбирайте лучший вариант. Актуальные адреса и номера телефонов для записи на УЗИ. Доступна онлайн-запись.");
$APPLICATION->SetPageProperty("title", "Клиники с услугами круглосуточного УЗИ по метро и районам");
$APPLICATION->SetTitle("Круглосуточное УЗИ по станциям метро Москвы");

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("highloadblock");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$get_location = $_REQUEST["location"];
$curPage = $APPLICATION->GetCurPage();
$curDir = $APPLICATION->GetCurDir(true);

if (!empty($get_location)) {
	$H1_B = "";
	$loc_seo_text = "";

	$rayon_confirm = false;
	$metro_confirm = false;
	$okrug_confirm = false;

	$PAGER_TEMPLATE = "round";

	$TITLE_LIST_MAIN = false;
	$TITLE_LIST_SEC = false;

	if (strstr($get_location, "_metro")) {
		$location_get = "";
		$location_sef = "";

		$get_location = str_replace("_metro", "", $get_location);
		$metro_confirm = true;
		$location = array();
		$arFilter = array(
			"IBLOCK_ID" => 1,
			"ACTIVE" => "Y",
			"CODE" => $get_location
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME",
			"CODE",
			"PROPERTY_RAYON",
			"PROPERTY_OKRUG",
			"PROPERTY_SOSED_METRO",
			"PROPERTY_NAME_ALT"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$location = $arFields;
			$metros_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["PROPERTY_SOSED_METRO_VALUE"]] = $arFields["PROPERTY_SOSED_METRO_VALUE"];

			$location_get = "/location/?location=" . $arFields["CODE"] . "_metro";
			$location_sef = "/location/metro/" . $arFields["CODE"] . "/";
		}

		$metro[] = $location;
		$metro_info = $location;

		$res = CIBlockElement::GetByID($location["PROPERTY_RAYON_VALUE"]);
		if ($ar_res = $res->GetNext()) {
			$rayon["NAME"] = $ar_res["NAME"];
			$rayon["CODE"] = $ar_res["CODE"];
		}

		$res = CIBlockElement::GetByID($location["PROPERTY_OKRUG_VALUE"]);
		if ($ar_res = $res->GetNext()) {
			$okrug["NAME"] = $ar_res["NAME"];
			$okrug["CODE"] = $ar_res["CODE"];
		}

		$loc = $location["NAME"];

		$metro_seo = array();
		$block_id = 2;
		$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();
		$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();

		$rsData = $entity_data_class::getList(array(
			'select' => array('*'),
			'order' => array(),
			'limit' => $limit,
			'filter' => array("UF_METRO" => $metro_info["ID"], "UF_ACTIVE" => true)
		));
		while ($el = $rsData->fetch()) {
			$metro_seo = $el;
		}

		/*if(!empty($metro_seo) && !empty($location))
		{
			//$APPLICATION->AddChainItem( , "");
			//$APPLICATION->SetTitle($metro_seo["UF_H1"]);
			if(!empty($metro_seo["UF_H1"]))
			{
				$H1_B = $metro_seo["UF_H1"];
			}
			else
			{
				if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
				{
					$H1_B = "УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"];
				}
				else
				{
					$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
				}
			}
			if(!empty($metro_seo["UF_TITLE"]))
			{
				$APPLICATION->SetPageProperty("title", $metro_seo["UF_TITLE"]);
			}
			else
			{
				if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
				{
					//$APPLICATION->SetTitle("УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"]);
					$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
				}
				else
				{
					//$APPLICATION->SetTitle("УЗИ круглосуточно в " . $location["NAME"]);
					$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
				}
			}
			
			$APPLICATION->SetPageProperty("keywords",strtolower($metro_seo["UF_KEYWORDS"]));
			$APPLICATION->SetPageProperty("description", $metro_seo["UF_DESCRIPTION"]);
			if(!empty($metro_seo["UF_TEXT"]))
			{
				$loc_seo_text = $metro_seo["UF_TEXT"];
			}
			
			if($curDir == "/location/")
			{
				LocalRedirect($location_sef, false, "301 Moved Permanently");
			}
		}
		elseif(!empty($location))
		{
			//LocalRedirect($GetCurPageParamFilNoindex, false, "301 Moved Permanently");
			if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
			{
				//$APPLICATION->SetTitle("УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"]);
				$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
				$H1_B = "УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"];
			}
			else
			{
				//$APPLICATION->SetTitle("УЗИ круглосуточно в " . $location["NAME"]);
				$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
				$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
			}

			$loc_seo_text = "";
			
			if($curDir == $location_sef)
			{
				LocalRedirect($location_get, false, "301 Moved Permanently");
			}
		}
		else
		{
			CHTTP::SetStatus("404 Not Found");
			define("ERROR_404","Y");
		}*/
	} /*elseif (strstr($get_location, "_rayon")) {
		$location_get = "";
		$location_sef = "";

		$get_location = str_replace("_rayon", "", $get_location);
		$rayon_confirm = true;
		$arFilter = array(
			"IBLOCK_ID" => 2,
			"ACTIVE" => "Y",
			"CODE" => $get_location
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME",
			"PROPERTY_OKRUG",
			"PROPERTY_NAME_ALT"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$location = $arFields;

			$location_get = "/location/?location=" . $arFields["CODE"] . "_rayon";
			$location_sef = "/location/rayon/" . $arFields["CODE"] . "/";
		}

		$metro = array();
		$arFilter = array(
			"IBLOCK_ID" => 1,
			"ACTIVE" => "Y",
			"PROPERTY_RAYON" => $location["ID"]
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME",
			"PROPERTY_SOSED_METRO"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$metro[] = $arFields;
			$metros_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["PROPERTY_SOSED_METRO_VALUE"]] = $arFields["PROPERTY_SOSED_METRO_VALUE"];
		}

		$rayon["NAME"] = $location["NAME"];
		$rayon["CODE"] = $location["CODE"];
		$loc = $location["NAME"];
		$res = CIBlockElement::GetByID($location["PROPERTY_OKRUG_VALUE"]);
		if ($ar_res = $res->GetNext()) {
			$okrug["NAME"] = $ar_res["NAME"];
			$okrug["CODE"] = $ar_res["CODE"];
		}

		$rayon_seo = array();
		$block_id = 2;
		$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();
		$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();

		$rsData = $entity_data_class::getList(array(
			'select' => array('*'),
			'order' => array(),
			'limit' => $limit,
			'filter' => array("UF_RAYON" => $location["ID"], "UF_ACTIVE" => true)
		));
		while ($el = $rsData->fetch()) {
			$rayon_seo = $el;
		}

		/*if(!empty($rayon_seo) && !empty($location))
		{
			//$APPLICATION->AddChainItem( , "");
			//$APPLICATION->SetTitle($rayon_seo["UF_H1"]);
			if(!empty($rayon_seo["UF_H1"]))
			{
				$H1_B = $rayon_seo["UF_H1"];
			}
			else
			{
				if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
				{
					$H1_B = "УЗИ круглосуточно в районе " . $location["PROPERTY_NAME_ALT_VALUE"];
				}
				else
				{
					$H1_B = "УЗИ круглосуточно в районе " . $location["NAME"];
				}
			}
			if(!empty($rayon_seo["UF_TITLE"]))
			{
				$APPLICATION->SetPageProperty("title", $rayon_seo["UF_TITLE"]);
			}
			else
			{
				if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
				{
					//$APPLICATION->SetTitle("УЗИ круглосуточно в районе " . $location["PROPERTY_NAME_ALT_VALUE"]);
					$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
				}
				else
				{
					//$APPLICATION->SetTitle("УЗИ круглосуточно в районе " . $location["NAME"]);
					$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
				}
			}
			$APPLICATION->SetPageProperty("keywords",strtolower($rayon_seo["UF_KEYWORDS"]));
			$APPLICATION->SetPageProperty("description", $rayon_seo["UF_DESCRIPTION"]);
			if(!empty($rayon_seo["UF_TEXT"]))
			{
				$loc_seo_text = $rayon_seo["UF_TEXT"];
			}
			
			if($curDir == "/location/")
			{
				LocalRedirect($location_sef, false, "301 Moved Permanently");
			}
		}
		elseif(!empty($location))
		{
			//LocalRedirect($GetCurPageParamFilNoindex, false, "301 Moved Permanently");
			if(!empty($location["PROPERTY_NAME_ALT_VALUE"]))
			{
				//$APPLICATION->SetTitle("УЗИ круглосуточно в районе " . $location["PROPERTY_NAME_ALT_VALUE"]);
				$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
				$H1_B = "УЗИ круглосуточно в районе " . $location["PROPERTY_NAME_ALT_VALUE"];
			}
			else
			{
				//$APPLICATION->SetTitle("УЗИ круглосуточно в районе " . $location["NAME"]);
				$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
				$H1_B = "УЗИ круглосуточно в районе " . $location["NAME"];
			}

			$loc_seo_text = "";
			
			if($curDir == $location_sef)
			{
				LocalRedirect($location_get, false, "301 Moved Permanently");
			}
		}
		else
		{
			CHTTP::SetStatus("404 Not Found");
			define("ERROR_404","Y");
		}**
	} elseif (strstr($get_location, "_okrug")) {
		$location_get = "";
		$location_sef = "";
		$get_location = str_replace("_okrug", "", $get_location);
		$okrug_confirm = true;
		$arFilter = array(
			"IBLOCK_ID" => 3,
			"ACTIVE" => "Y",
			"CODE" => $get_location
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$location = $arFields;

			$location_get = "/location/?location=" . $arFields["CODE"] . "_okrug";
			$location_sef = "/location/okrug/" . $arFields["CODE"] . "/";
		}

		$metro = array();
		$arFilter = array(
			"IBLOCK_ID" => 1,
			"ACTIVE" => "Y",
			"PROPERTY_OKRUG" => $location["ID"]
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME",
			"PROPERTY_SOSED_METRO"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$metro[] = $arFields;
			$metros_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["ID"]] = $arFields["ID"];
			$sosed_metro_id[$arFields["PROPERTY_SOSED_METRO_VALUE"]] = $arFields["PROPERTY_SOSED_METRO_VALUE"];
		}

		if (!empty($location)) {
			$okrug["NAME"] = $location["NAME"];
			$okrug["CODE"] = $location["CODE"];
			$loc = $location["NAME"];
		}

		$okrug_seo = array();
		$block_id = 2;
		$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();
		$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();

		$rsData = $entity_data_class::getList(array(
			'select' => array('*'),
			'order' => array(),
			'limit' => $limit,
			'filter' => array("UF_OKRUG" => $location["ID"], "UF_ACTIVE" => true)
		));
		while ($el = $rsData->fetch()) {
			$okrug_seo = $el;
		}

		/*if(!empty($okrug_seo) && !empty($location))
		{
			//$APPLICATION->AddChainItem( , "");
			//$APPLICATION->SetTitle($okrug_seo["UF_H1"]);
			if(!empty($okrug_seo["UF_H1"]))
			{
				$H1_B = $okrug_seo["UF_H1"];
			}
			else
			{
				$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
			}
			if(!empty($okrug_seo["UF_TITLE"]))
			{
				$APPLICATION->SetPageProperty("title", $okrug_seo["UF_TITLE"]);
			}
			else
			{
				//$APPLICATION->SetTitle("УЗИ круглосуточно в " . $location["NAME"]);
				$APPLICATION->SetTitle("УЗИ в " . $location["NAME"] . " - круглосуточно 24 часа!");
			}
			
			$APPLICATION->SetPageProperty("keywords",strtolower($okrug_seo["UF_KEYWORDS"]));
			$APPLICATION->SetPageProperty("description", $okrug_seo["UF_DESCRIPTION"]);
			if(!empty($okrug_seo["UF_TEXT"]))
			{
				$loc_seo_text = $okrug_seo["UF_TEXT"];
			}
			
			if($curDir == "/location/")
			{
				LocalRedirect($location_sef, false, "301 Moved Permanently");
			}
		}
		elseif(!empty($location))
		{
			//LocalRedirect($GetCurPageParamFilNoindex, false, "301 Moved Permanently");
			//$APPLICATION->SetTitle("УЗИ круглосуточно в " . $location["NAME"]);
			$APPLICATION->SetTitle("УЗИ в " . $location["NAME"] . " - круглосуточно 24 часа!");
			$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
			$loc_seo_text = "";
			
			if($curDir == $location_sef)
			{
				LocalRedirect($location_get, false, "301 Moved Permanently");
			}
		}
		else
		{
			CHTTP::SetStatus("404 Not Found");
			define("ERROR_404","Y");
		}**
	}*/

	if (!empty($sosed_metro_id)) {
		$arFilter = array(
			"IBLOCK_ID" => 8,
			"ACTIVE" => "Y",
			"PROPERTY_METRO" => $sosed_metro_id
		);
		$res = CIBlockElement::GetList(array(), $arFilter, false, false, array(
			"ID",
			"NAME",
			"CODE",
			"PROPERTY_ROUND_CLOCK"
		));
		while ($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$IdClinics[] = $arFields["ID"];
			$clinic[$arFields["ID"]]["ID"] = $arFields["ID"];
			$clinic[$arFields["ID"]]["NAME"] = $arFields["NAME"];
			if (!empty($arFields["PROPERTY_ROUND_CLOCK_VALUE"])) {
				$clinics24[] = $arFields["ID"];
			}

			$clinic[$arFields["ID"]]["PROPERTY_ROUND_CLOCK_VALUE"] = $arFields["PROPERTY_ROUND_CLOCK_VALUE"];
		}
	}

	if (!empty($metro_info)) {
		$pretext = "В районе метро";
	} elseif (!empty($rayon)) {
		$pretext = "В районе";
	} elseif (!empty($okrug)) {
		$pretext = "В";
	}

	$more_clin = false;
	$DISPLAY_BOTTOM_PAGER_TOP = "Y";
	if (is_array($clinic) && count($clinic) >= 1) {
		$more_clin = false;
		$DISPLAY_BOTTOM_PAGER_TOP = "Y";
	} else {
		$more_clin = true;
		$DISPLAY_BOTTOM_PAGER_TOP = "N";
	}

	$clinics24Count_conf = false;
	$clinicsCount_conf = false;
	$clinics24Count_text = false;

	if (is_array($clinics24) && count($clinics24) > 0) {
		$count_clin = clinicToStr(count($clinics24));
		$clinics24Count_conf = "Y";
		$clinics24Count_text = " круглосуточно";
	} elseif (is_array($clinic) && count($clinic) > 0) {
		$count_clin = clinicToStr(count($clinic));
		$clinicsCount_conf = "Y";
	}

	// Сео начало
	if (!empty($metro_seo) && !empty($location)) {
		// Заголовок h1
		if (!empty($metro_seo["UF_H1"])) {
			$H1_B = $metro_seo["UF_H1"];
		} else {
			if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
				$H1_B = "УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"];
			} else {
				$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
			}
		}

		// Title
		if (!empty($metro_seo["UF_TITLE"])) {
			$APPLICATION->SetPageProperty("title", $metro_seo["UF_TITLE"]);
		} else {
			if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
				$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
			} else {
				$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
			}
		}

		// META Description
		if (!empty($metro_seo["UF_DESCRIPTION"])) {
			$APPLICATION->SetPageProperty("description", $metro_seo["UF_DESCRIPTION"]);
		} else {
			$APPLICATION->SetPageProperty("description", $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Список клиник, адреса, цены на УЗИ диагностику. Предварительная запись по телефону.");
		}

		// META Keywords
		if (!empty($metro_seo["UF_KEYWORDS"])) {
			$APPLICATION->SetPageProperty("keywords", strtolower($metro_seo["UF_KEYWORDS"]));
		} else {
			$APPLICATION->SetPageProperty("keywords", strtolower("диагностические центры, узи, круглосуточно, " . $location["NAME"] . ", запись"));
		}

		// Сео Текст 
		if (!empty($metro_seo["UF_TEXT"])) {
			$loc_seo_text = $metro_seo["UF_TEXT"];
		}

		// Редирект
		if ($curDir == "/location/") {
			LocalRedirect($location_sef, false, "301 Moved Permanently");
		}

		if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
			$title_list = $location["PROPERTY_NAME_ALT_VALUE"];
		} else {
			$title_list = "на м. " . $location["NAME"];
		}
	} elseif (!empty($rayon_seo) && !empty($location)) {
		// Заголовок h1
		if (!empty($rayon_seo["UF_H1"])) {
			$H1_B = $rayon_seo["UF_H1"];
		} else {
			if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
				$H1_B = "УЗИ круглосуточно в районе " . $location["PROPERTY_NAME_ALT_VALUE"];
			} else {
				$H1_B = "УЗИ круглосуточно в районе " . $location["NAME"];
			}
		}

		// Title
		if (!empty($rayon_seo["UF_TITLE"])) {
			$APPLICATION->SetPageProperty("title", $rayon_seo["UF_TITLE"]);
		} else {
			if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
				$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
			} else {
				$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
			}
		}

		// META Description
		if (!empty($rayon_seo["UF_DESCRIPTION"])) {
			$APPLICATION->SetPageProperty("description", $rayon_seo["UF_DESCRIPTION"]);
		} else {
			$APPLICATION->SetPageProperty("description", $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Список клиник, адреса, цены на УЗИ диагностику. Предварительная запись по телефону.");
		}

		// META Keywords
		if (!empty($rayon_seo["UF_KEYWORDS"])) {
			$APPLICATION->SetPageProperty("keywords", strtolower($rayon_seo["UF_KEYWORDS"]));
		} else {
			$APPLICATION->SetPageProperty("keywords", strtolower("диагностические центры, узи, круглосуточно, " . $location["NAME"] . ", запись"));
		}

		// Сео Текст 
		if (!empty($rayon_seo["UF_TEXT"])) {
			$loc_seo_text = $rayon_seo["UF_TEXT"];
		}

		// Редирект
		if ($curDir == "/location/") {
			LocalRedirect($location_sef, false, "301 Moved Permanently");
		}

		if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
			$title_list = $location["PROPERTY_NAME_ALT_VALUE"];
		} else {
			$title_list = "в " . $location["NAME"];
		}
	} elseif (!empty($okrug_seo) && !empty($location)) {
		// Заголовок h1
		if (!empty($okrug_seo["UF_H1"])) {
			$H1_B = $okrug_seo["UF_H1"];
		} else {
			$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
		}

		// Title
		if (!empty($okrug_seo["UF_TITLE"])) {
			$APPLICATION->SetPageProperty("title", $okrug_seo["UF_TITLE"]);
		} else {
			$APPLICATION->SetTitle("УЗИ в " . $location["NAME"] . " - круглосуточно 24 часа!");
		}

		// META Description
		if (!empty($okrug_seo["UF_DESCRIPTION"])) {
			$APPLICATION->SetPageProperty("description", $okrug_seo["UF_DESCRIPTION"]);
		} else {
			$APPLICATION->SetPageProperty("description", $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Список клиник, адреса, цены на УЗИ диагностику. Предварительная запись по телефону.");
		}

		// META Keywords
		if (!empty($okrug_seo["UF_KEYWORDS"])) {
			$APPLICATION->SetPageProperty("keywords", strtolower($okrug_seo["UF_KEYWORDS"]));
		} else {
			$APPLICATION->SetPageProperty("keywords", strtolower("диагностические центры, узи, круглосуточно, " . $location["NAME"] . ", запись"));
		}

		// Сео Текст 
		if (!empty($okrug_seo["UF_TEXT"])) {
			$loc_seo_text = $okrug_seo["UF_TEXT"];
		}

		// Редирект
		if ($curDir == "/location/") {
			LocalRedirect($location_sef, false, "301 Moved Permanently");
		}

		if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
			$title_list = $location["PROPERTY_NAME_ALT_VALUE"];
		} else {
			$title_list = "в " . $location["NAME"];
		}
	} elseif (!empty($location)) {
		if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
			// Title
			$APPLICATION->SetTitle("УЗИ " . $location["PROPERTY_NAME_ALT_VALUE"] . " - круглосуточно 24 часа!");
			// Заголовок h1
			$H1_B = "УЗИ круглосуточно " . $location["PROPERTY_NAME_ALT_VALUE"];
			// META Description
			$APPLICATION->SetPageProperty("description", $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Список клиник, адреса, цены на УЗИ диагностику. Предварительная запись по телефону.");
			// META Keywords
			$APPLICATION->SetPageProperty("keywords", strtolower("диагностические центры, узи, круглосуточно, " . $location["NAME"] . ", запись"));
		} else {
			// Title
			$APPLICATION->SetTitle("УЗИ " . $location["NAME"] . " - круглосуточно 24 часа!");
			$H1_B = "УЗИ круглосуточно в " . $location["NAME"];
			// META Description
			$APPLICATION->SetPageProperty("description", $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Список клиник, адреса, цены на УЗИ диагностику. Предварительная запись по телефону.");
			// META Keywords
			$APPLICATION->SetPageProperty("keywords", strtolower("диагностические центры, узи, круглосуточно, " . $location["NAME"] . ", запись"));
		}

		$loc_seo_text = "";

		// Редирект
		if ($curDir == $location_sef) {
			LocalRedirect($location_get, false, "301 Moved Permanently");
		}

		if (!empty($location["PROPERTY_NAME_ALT_VALUE"])) {
			$title_list = $location["PROPERTY_NAME_ALT_VALUE"];
		} else {
			$title_list = "в " . $location["NAME"];
		}
	} else {
		CHTTP::SetStatus("404 Not Found");
		define("ERROR_404", "Y");
	}
	// Сео конец

	if ($curDir == $location_sef) {
		$PAGER_TEMPLATE = "round_new";
	}

	// Текст начало
	$head_block = "<div class=\"page__preview\"><div class=\"inside group\"><div class=\"page__preview-info width-auto\"><div class=\"breadcrumbs\"><a href=\"/\">Главная</a><a href=\"/location/\">Круглосуточные клиники</a><span>" . $loc . "</span></div>";

	$head_block .= "<h1 class=\"page__preview-title\">" . $H1_B . "</h1>";

	if (!empty($loc_seo_text)) {
		$head_block .= "<div class=\"page__preview-desc\">" . $loc_seo_text . "</div>";
	} else {
		//$head_block.= "<div class=\"page__preview-desc\">" . $pretext . " " . $location["NAME"] . " " . $count_clin . ", где можно пройти УЗИ обследование. Записаться на УЗИ можно по телефону клиники указанному на сайте. Точную стоимость и свободное время для приёма уточняйте у администратора клиники. </div>";
		if ($more_clin) {
			$head_block .= "<div class=\"page__preview-desc\">" . $pretext . " " . $location["NAME"] . " не оказалось диагностических центров, где можно пройти круглосуточно УЗИ обследование. Вы можете выбрать один из ближайших диагностических центров, в котором специалисты проводят УЗИ диагностику 24 часа. Звоните, и администратор клиники запишет на удобное время.</div>";
		} else {
			$head_block .= "<div class=\"page__preview-desc\">" . $pretext . " " . $location["NAME"] . " " . $count_clin . ", где" . $clinics24Count_text . " проводится УЗИ обследование. Специалисты медицинских центров ведут прием 24 часа по предварительной записи, поэтому рекомендуем уточнить свободное время приема и точную цену диагностики у администратора клиники по телефону.</div>";
		}
	}

	$head_block .= "<div class=\"page__preview-data\"><ul class=\"group\">";

	if (!empty($metro_info)) {
		//$head_block.= "<li>Станция метро: <a href=\"/location/?location=" . $metro_info["CODE"] . "_metro\">" . $metro_info["NAME"] . "</a></li>";
		$head_block .= "<li>Станция метро: " . $metro_info["NAME"] . "</li>";
	}

	if (!empty($rayon)) {
		//$head_block.= "<li>Район: <a href=\"/location/?location=" . $rayon["CODE"] . "_rayon\">" . $rayon["NAME"] . "</a></li>";
		$head_block .= "<li>Район: " . $rayon["NAME"] . "</li>";
	}

	if (!empty($okrug)) {
		//$head_block.= "<li>Округ: <a href=\"/location/?location=" . $okrug["CODE"] . "_okrug\">" . $okrug["NAME"] . "</a></li>";
		$head_block .= "<li>Округ: " . $okrug["NAME"] . "</li>";
	}

	$head_block .= "</ul></div></div>";

	// $head_block .= "<div class="page__service text-center"><img class="img-responsive center-block img-circle" src="".$SERVICE_AVATAR."" alt="">";

	/*if(!empty($metro_info["NAME"])) {
	$pretext = " в ";
	}*/

	// $head_block .= "<p>минимальная стоимость УЗИ ".$pretext.$loc." <span>".number_format(min($prices), 0, ",", " ")." руб.</span></p></div></div></div>";

	$head_block .= "</div></div>";

	if (defined('ERROR_404') && ERROR_404 == 'Y' && !defined('ADMIN_SECTION')) {
		$head_block = "";
	}
	// Текст конец
	ob_start();
	echo $head_block;
	$out1 = ob_get_contents();
	ob_end_clean();
	$APPLICATION->AddViewContent("head_block", $out1);
?>
	<?
	global $FilterIdClinics_BOT;
	$FilterIdClinics_BOT = array(
		"PROPERTY_ROUND_CLOCK_VALUE" => "Y"
	);
	global $FilterIdClinics;
	$FilterIdClinics = array(
		"ID" => $IdClinics
	);

	// pre_dump($service);
	// Заголовок
	$TITLE_LIST_MAIN = "Диагностические центры " . $title_list;
	?>
	<?
	// Список клиники по текущему и ближайшему метро
	$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"template_clinics_location",
		array(
			"COMPONENT_TEMPLATE" => "template_clinics_location",
			"IBLOCK_TYPE" => "external_reference",
			"IBLOCK_ID" => "8",
			"NEWS_COUNT" => "15",
			"SORT_BY1" => "PROPERTY_ROUND_CLOCK",
			"SORT_ORDER1" => "DESC",
			"SORT_BY2" => "SORT",
			"SORT_ORDER2" => "ASC",
			"FILTER_NAME" => "FilterIdClinics",
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
			"PAGER_TEMPLATE" => $PAGER_TEMPLATE,
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "Клиники",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_BASE_LINK_ENABLE" => "N",
			"SET_STATUS_404" => "N",
			"SHOW_404" => "N",
			"MESSAGE_404" => "",
			"TITLE_LIST_MAIN" => $TITLE_LIST_MAIN
		),
		false
	); ?>
	<? //if($more_clin):
	// Заголовок
	$TITLE_LIST_SEC = "Рекомендуемые УЗИ центры";
	?>
	<?
	// Список круглосуточных клиники
	$APPLICATION->IncludeComponent("bitrix:news.list", "template_clinics_location", array(
		"COMPONENT_TEMPLATE" => "template_clinics_location",
		"IBLOCK_TYPE" => "external_reference",
		"IBLOCK_ID" => "8",
		"NEWS_COUNT" => "15",
		"SORT_BY1" => "PROPERTY_ROUND_CLOCK",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "FilterIdClinics_BOT",
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
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
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
		"PAGER_TEMPLATE" => $PAGER_TEMPLATE,
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Клиники",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"TITLE_LIST_SEC" => $TITLE_LIST_SEC
	), false); ?>
	<? //endif;
	?>

<?
} else {
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
			$seo_metro[$el["UF_METRO"]] = true;
		}
		if (!empty($el["UF_RAYON"])) {
			//$seo_rayon[$el["UF_RAYON"]] = true;
		}
		if (!empty($el["UF_OKRUG"])) {
			//$seo_okrug[$el["UF_OKRUG"]] = true;
		}
	}

	$okrug = array();
	// $res = CIBlockElement::GetList(array(), array(
	// 	"IBLOCK_ID" => 3,
	// 	"ACTIVE" => "Y"
	// ), false, false, array(
	// 	"ID",
	// 	"NAME",
	// 	"CODE"
	// ));
	// while ($ob = $res->GetNextElement()) {
	// 	$arFields = $ob->GetFields();
	// 	$locations[$arFields["ID"]] = $arFields;

	// 	if ($seo_okrug[$arFields["ID"]]) {
	// 		$locations[$arFields["ID"]]["URL"] = "/location/okrug/" . $arFields["CODE"] . "/";
	// 	} else {
	// 		$locations[$arFields["ID"]]["URL"] = "/location/?location=" . $arFields["CODE"] . "_okrug";
	// 	}

	// 	$res1 = CIBlockElement::GetList(array(), array(
	// 		"IBLOCK_ID" => 2,
	// 		"ACTIVE" => "Y",
	// 		"PROPERTY_OKRUG" => $arFields["ID"]
	// 	), false, false, array(
	// 		"ID",
	// 		"NAME",
	// 		"CODE"
	// 	));
	// 	while ($ob1 = $res1->GetNextElement()) {
	// 		$arFields1 = $ob1->GetFields();
	// 		$locations[$arFields["ID"]]["RAYON"][$arFields1["ID"]] = $arFields1;

	// 		if ($seo_rayon[$arFields1["ID"]]) {
	// 			$locations[$arFields["ID"]]["RAYON"][$arFields1["ID"]]["URL"] = "/location/rayon/" . $arFields1["CODE"] . "/";
	// 		} else {
	// 			$locations[$arFields["ID"]]["RAYON"][$arFields1["ID"]]["URL"] = "/location/?location=" . $arFields1["CODE"] . "_rayon";
	// 		}
	// 	}
	// }

	$res2 = CIBlockElement::GetList(array(), array(
		"IBLOCK_ID" => 1,
		"ACTIVE" => "Y"
	), false, false, array(
		"ID",
		"NAME",
		"CODE"
	));
	while ($ob2 = $res2->GetNextElement()) {
		$arFields2 = $ob2->GetFields();
		$metro_tmp[$arFields2["ID"]] = $arFields2;

		if ($seo_metro[$arFields2["ID"]]) {
			$metro_tmp[$arFields2["ID"]]["URL"] = "/location/metro/" . $arFields2["CODE"] . "/";
		} else {
			$metro_tmp[$arFields2["ID"]]["URL"] = "/location/?location=" . $arFields2["CODE"] . "_metro";
		}
	}

	sort($metro_tmp);
	foreach ($metro_tmp as $key => $value) {
		$first_char = substr($value["NAME"], 0, 1);
		$prev_char = substr($metro_tmp[$key - 1]["NAME"], 0, 1);
		$metro[$first_char][$key] = $value;
	} ?>

	<h1><? $APPLICATION->ShowTitle(false) ?></h1>
	<?$APPLICATION->IncludeComponent(
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
		"FILTER_NAME" => "",
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
		"PAGER_TITLE" => "Новости",
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
);?>

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
<?
}
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>