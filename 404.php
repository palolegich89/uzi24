<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
define("ERROR_404","Y");

$APPLICATION->SetPageProperty("title", "Страница не найдена");
$APPLICATION->SetTitle("Страница не найдена");
// $APPLICATION->AddChainItem('404');

$services = array();
CModule::IncludeModule("iblock");
$arFilter = array("IBLOCK_ID" => 4, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(
    array(),
    $arFilter,
    false,
    array("nPageSize" => 1000),
    array("ID", "NAME", "CODE", "DETAIL_PAGE_URL", "PROPERTY_PARENT")
);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $services[] = $arFields;
}

foreach ($services as $key => $value) {
    if (!empty($value['PROPERTY_PARENT_VALUE'])) {
        foreach ($services as $k => $v) {
            if ($v['ID'] == $value['PROPERTY_PARENT_VALUE']) {
                $services[$k]['CHILDREN'][] = $value;
                unset($services[$key]);
            }
        }
    }
}
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
			<p style="text-align:center;">Этой страницы не существует. Но это не беда! Мы уверены, что вы обязательно найдете что-нибудь полезное для себя на нашем сайте.</p>
			<div class="sad-robot"></div>
			<div class="big404">404</div>
			<?/*<p>Перейти к <a href="<?=SITE_DIR?>" class="link">карте сайта</a>.</p>*/?>
			<p style="display:block;width:100%; text-align:center;"><a href="<?=SITE_DIR?>" class="link" >Вернуться на главную</a></p>
		</div>
	</div>
</div>
<div class="types" id="types">
    <h3 class="types__title">Виды УЗИ диагностики</h3>
    <div class="types__list">
        <ul class="group">
            <? foreach ($services as $key => $value): ?>
                <li class="type">
                    <p class="type__name"><a href="<?= $value['DETAIL_PAGE_URL']; ?>"><?= $value['NAME']; ?></a></p>
                    <? if (!empty($value['CHILDREN'])): ?>
                        <ul class="type__desc">
                            <? foreach ($value['CHILDREN'] as $k => $v): ?>
                                <li><a href="<?= $v['DETAIL_PAGE_URL']; ?>"><?= $v['NAME']; ?></a></li>

                            <? endforeach; ?>
                        </ul>
                    <? endif ?>
                </li>
            <? endforeach; ?>
        </ul>
    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>