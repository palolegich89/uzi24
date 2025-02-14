<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php"); 
use Bitrix\Main\Application as Application;
use Bitrix\Main\Config\Option as Option;
$moduleId = "callapi";
\Bitrix\Main\Loader::includeModule($moduleId);
$request = Application::getInstance()->getContext()->getRequest(); 
$phone = cCallApi::phoneNumber($request->getPost("phone"));
$arParams = json_decode($request->getPost("PARAMS"), true);
if(!$phone)
	{
		$arResult["TYPE"] = "FAIL";
		$arResult["MESSAGE"] = "Проверьте правильность введения номера";
		echo json_encode($arResult);
		die();
	}
//авторизация, открыть не удалять
$login = Option::get($moduleId, "login");
$password = Option::get($moduleId, "password");
$arJson = cCallApi::getAuthArray($login,$password);

$arAuthResult = cCallApi::Request("callapi", "v4.0", $arJson);
$accessToken = $arAuthResult["result"]["data"]["access_token"];
if(!$accessToken)
	{
		$arResult["TYPE"] = "FAIL";
		$arResult["MESSAGE"] = "Произошла ошибка, попробуйте позже (callapi -1)";
		echo json_encode($arResult);
		die();
	}

//если есть параметры	
if(cCallApi::phoneNumber($arParams["VIRTUAL_PHONE"]) && (int)$arParams["SCENARIO"])
	{
		$virtualNumber = cCallApi::phoneNumber($arParams["VIRTUAL_PHONE"]);
		$scenarioId = (int)$arParams["SCENARIO"];
		$externalId = "form".(int)$arParams["ID"];
	}
else if((int)$arParams["IBLOCK_ID"] && (int)$arParams["ELEMENT_ID"] )
	{
		//берем параметры из модуля
		$jsonArSelectedTable = Option::get($moduleId, "SELECTED");
		$arSelectedTable = json_decode($jsonArSelectedTable, true);
		$arResult["SELECTED"] = $arSelectedTable;
		foreach($arSelectedTable as $arRow)
			{
				if($arParams["IBLOCK_ID"] == $arRow["IBLOCK"])
					{
						$propertyId = $arRow["PROPERTY"];
						$virtualNumber = cCallApi::getPhone((int)$arParams["IBLOCK_ID"] , (int)$arParams["ELEMENT_ID"], $propertyId);
						$scenarioId = $arRow["SCENARIO"];
						$externalId = (int)$arParams["ELEMENT_ID"];
						if(!$virtualNumber)
							{
								$virtualNumber =  cCallApi::getPhone(Option::get($moduleId, "defaultPhone"));
							}
						if(!$virtualNumber)
							{
								$arResult["TYPE"] = "FAIL";
								$arResult["MESSAGE"] = "Произошла ошибка, попробуйте позже. (callapi -2)";
								echo json_encode($arResult);
								die();
							}
					}
			}
	}	
else{
		$arResult["TYPE"] = "FAIL";
		$arResult["MESSAGE"] = "Произошла ошибка, попробуйте позже. (callapi -3)";
		echo json_encode($arResult);
		die();
	}	

$arStartCallArray = cCallApi::getStartCallArray($accessToken, $virtualNumber, $phone, $scenarioId, $externalId);
// начать звонок, открыть не удалять	
$arStartCallResult = cCallApi::Request("callapi", "v4.0", $arStartCallArray);

//сделать обработку результата запроса
if(empty($arStartCallResult["result"]["data"]["call_session_id"]))
	{
		$arResult["TYPE"] = "FAIL";
		$arResult["MESSAGE"] = "Произошла ошибка, попробуйте позже. (callapi -4)";
		echo json_encode($arResult);
		die();
	}
//$arResult["STARTCALL"] = $arStartCallResult;
//$arResult["STARTCALL"] = $arStartCallArray;
$arResult["TYPE"] = "SUCCESS";
$arResult["MESSAGE"] = "Оператор перезвонит вам при первой возможности";

echo json_encode($arResult);
?>