<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Контент");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule('highloadblock');

session_start();

//unset($_SESSION['SEO_INFO']);

$arFilter = array("IBLOCK_ID" => 4, "ACTIVE" => "Y", "ID" => $_SESSION['SEO_INFO']['UF_SERVICE']);
$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1000), array("ID", "NAME", "CODE", "PREVIEW_TEXT", "PROPERTY_AVATAR"));
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$service = $arFields;
}

$img = CFile::ResizeImageGet($service['PROPERTY_AVATAR_VALUE'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
$service['AVATAR'] = $img['src'];

$str1 = substr($service['PREVIEW_TEXT'], 0, 250);

$pos1 = strrpos($str1, '.') + 2;

$preview_text = substr($service['PREVIEW_TEXT'], 0, $pos1);

$detail_text = substr($service['PREVIEW_TEXT'], $pos1);


$head_block = '<div class="page__preview"><div class="inside group"><div class="page__preview-info"><div class="breadcrumbs"><a href="#">Главная</a><span>УЗИ горла</span></div>';

$head_block .= '<h1 class="page__preview-title">' . $service['NAME'] . '</h1>';

$head_block .= '<div class="page__preview-desc">' . $preview_text . '<span class="spoiler-text">' . $detail_text . '</span><a class="spoiler" href="#">Читать далее...</a></div></div>';

$head_block .= '<div class="page__service text-center"><img class="img-responsive center-block img-circle" src="' . $service['AVATAR'] . '" alt="">';

$head_block .= '</div></div></div>';


ob_start();
echo $head_block;
$out1 = ob_get_contents();
ob_end_clean();
$APPLICATION->AddViewContent('head_block', $out1);
?>

<h2 class="page__content-title">Где сделать <?= $service['NAME']; ?> круглосуточно</h2>

<?

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('TABLE_NAME' => 'b_uzi')));
if (!($hldata = $rsData->fetch())) {
	echo 'Инфоблок не найден';
} else {
	$hlentity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
	$hlDataClass = $hldata['NAME'] . 'Table';
	$res = $hlDataClass::getList(
		array(
			'filter' => array(
				'UF_SERVICE' => $_SESSION['SEO_INFO']['UF_SERVICE'],
			)
		)
	);
	while ($arItem = $res->Fetch()) {
		$HLinfo[] = $arItem;
	}
}

$i = 0;
foreach ($HLinfo as $key => $value) {

	$arFilter = array("IBLOCK_ID" => 8, "ACTIVE" => "Y", "ID" => $value['UF_CLINIC'], 'PROPERTY_METRO' => $_SESSION['SEO_INFO']['UF_METRO']);
	$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), array("ID", "NAME", "CODE", "PROPERTY_ADDRESS", "PROPERTY_AVATAR", "PROPERTY_METRO", "PROPERTY_PHONE", "PROPERTY_WORKTIME", "PROPERTY_ROUND_CLOCK"));
	while ($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$clinic[$i]['NAME'] = $arFields['NAME'];
		$clinic[$i]['ADDRESS'] = $arFields['PROPERTY_ADDRESS_VALUE'];

		$res1 = CIBlockElement::GetByID($arFields['PROPERTY_METRO_VALUE']);
		if ($ar_res1 = $res1->GetNext())
			$clinic[$i]['METRO'] = 'м. ' . $ar_res1['NAME'];

		$img = CFile::ResizeImageGet($arFields['PROPERTY_AVATAR_VALUE'], array('width' => 150, 'height' => 150), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$clinic[$i]['AVATAR'] = $img['src'];

		$clinic[$i]['PHONE'] = $arFields['PROPERTY_PHONE_VALUE'];

		$res2 = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "ID" => $value['UF_PRICE']), false, array("nPageSize" => 1), array("ID", "NAME", "CODE", "PROPERTY_PRICE"));
		while ($ob2 = $res2->GetNextElement()) {
			$arFields2 = $ob2->GetFields();
			$clinic[$i]['PRICE'] = number_format($arFields2['PROPERTY_PRICE_VALUE'], 0, ',', ' ') . ' руб.';
		}
	}

	$i++;
}
?>

<div class="clinic__list">

	<? foreach ($clinic as $key => $value): ?>

		<div class="clinic group">
			<div class="clinic__logo">
				<div class="like_table">
					<div class="table_cell"><img class="img-responsive center-block" src="<?= $value['AVATAR']; ?>" alt=""></div>
				</div>
			</div>
			<div class="clinic__info">
				<h3 class="clinic__name"><?= $value['NAME']; ?></h3>
				<p class="clinic__address"><?= $value['ADDRESS']; ?></p>
				<p class="clinic__metro-distance"><?= $value['METRO']; ?></p>
				<p class="clinic__phone"><a href="tel:<?= $value['PHONE']; ?>"><?= $value['PHONE']; ?></a></p>
			</div>
			<div class="clinic__price">
				<div class="clinic__price-data orange">
					<div class="clinic__price-value"><?= $value['PRICE']; ?></div>
					<div class="clinic__price-service"><?= $service['NAME']; ?></div>
				</div>
			</div>
		</div>

	<? endforeach; ?>

</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>