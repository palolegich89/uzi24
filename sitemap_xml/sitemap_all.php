<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header("content-type: text/xml;");
$sitemap_all[] = SITE_URL.'/sitemap_metro.xml';
$sitemap_all[] = SITE_URL.'/sitemap_rayon.xml';
$sitemap_all[] = SITE_URL.'/sitemap_okrug.xml';
$sitemap_all[] = SITE_URL.'/sitemap_files.xml';

$sitemapItems .= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
$sitemapItems .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

foreach($sitemap_all as $sitemap){
	$sitemapItems .= '	<sitemap>'.PHP_EOL;
		$sitemapItems .= '		<loc>'.$sitemap.'</loc>'.PHP_EOL;
		$sitemapItems .= '		<lastmod>'.date("Y-m-d", strtotime("yesterday")).'</lastmod>'.PHP_EOL;
	$sitemapItems .= '	</sitemap>'.PHP_EOL;
}

$sitemapItems .= '</sitemapindex>';

print $sitemapItems;