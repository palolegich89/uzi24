<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
define("ERROR_404","Y");

$APPLICATION->SetPageProperty("title", "Страница не найдена");
$APPLICATION->SetTitle("Страница не найдена");
// $APPLICATION->AddChainItem('404');

?>
<style>
h1.upper.NotoSerif.f24.ven_h1 {
		/*max-width: 1065px;
		margin: 20px auto !important;*/
    text-align: center;
}
.link {
    font-size: 20px;
    font-weight: bold;
    text-decoration: underline;
}
.big404{
    text-align: center;
    font-size: 200px;
    font-weight: bold;
    line-height: 250px;
}
</style>
<div class="section content">
	<div class="ten columns offset-by-one">
		<div class="row">
			<p style="text-align:center;">Так сложились звезды, что этой страницы либо не существует, либо ее похитили инопланетяне для опытов. Но это не беда! Мы уверены, что вы обязательно найдете что-нибудь полезное для себя на нашем сайте.</p>
			<div class="sad-robot"></div>
			<div class="big404">404</div>
			<?/*<p>Перейти к <a href="<?=SITE_DIR?>" class="link">карте сайта</a>.</p>*/?>
			<p style="display:block;width:100%; text-align:center;"><a href="<?=SITE_DIR?>" class="link" >Вернуться на главную</a></p>
		</div>
	</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>