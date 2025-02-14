<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("highloadblock");
header("content-type: text/xml;");

$block_id = 2;
$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();   
$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();

$rsData = $entity_data_class::getList(array(
   'select' => array('*'),
   'order' => array(),
   'limit' => $limit,
   'filter' => array("UF_ACTIVE" => true, "!UF_OKRUG" => false) 
));
while($el = $rsData->fetch())
{
	if(!empty($el["UF_OKRUG"])){$items[$el["UF_OKRUG"]] = $el["UF_OKRUG"];}
}

$arSelect = Array("ID", "DATE_ACTIVE_FROM", "CODE");
$arFilter = Array("IBLOCK_ID"=>3, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "ID"=>$items);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$sitemap_products .= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
$sitemap_products .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();

	$sitemap_products .= '	<url>'.PHP_EOL;

		$sitemap_products .= '		<loc>'.SITE_URL.'/location/okrug/'.$arFields["CODE"].'/</loc>'.PHP_EOL;

		$sitemap_products .= '		<lastmod>'.date("Y-m-d", strtotime("yesterday")).'</lastmod>'.PHP_EOL;

		$sitemap_products .= '		<changefreq>daily</changefreq>'.PHP_EOL;

		$sitemap_products .= '		<priority>0.8</priority>'.PHP_EOL;

	$sitemap_products .= '	</url>'.PHP_EOL;
}
$sitemap_products .= '</urlset>'.PHP_EOL;

print $sitemap_products;