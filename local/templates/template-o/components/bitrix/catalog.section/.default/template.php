<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */
global $IBLOCK_ID_REV;
global $SECTION_ID_REV;
global $ELEMENT_ID_REV;
global $SECTION_SECTION_PAGE_URL_REV;

$IBLOCK_ID_REV = $arResult["IBLOCK_ID"];
$SECTION_ID_REV = $arResult["ID"];
$ELEMENT_ID_REV = "";
$SECTION_SECTION_PAGE_URL_REV = (!empty($arParams["METRO"])?$arResult["SECTION_PAGE_URL"]."metro/".$arParams["METRO_INFO"]["CODE"]."/":$arResult["SECTION_PAGE_URL"]);

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$PRICE = 'от '.number_format($arResult["sort_price"][0]["min_price"], 0, ',', ' ').' руб.';
$PRICE_VALUE = $arResult["sort_price"][0]["min_price"];

$chain = !empty($arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"])?$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]:$arResult["NAME"];
$chain_metro = !empty($arParams["METRO_INFO"])?$arParams["METRO_INFO"]["NAME"]:false;
if($chain_metro != false){
	$chain_text = '<a href="'.$arResult["SECTION_PAGE_URL"].'">'.$chain.'</a>';
	$chain_metro_text = "<span>".$chain_metro."</span>";
	$link_text = !empty($arResult["UF_LINK"])?'<p><a href="'.$arResult["SECTION_PAGE_URL"].'">'.$arResult["UF_LINK"].'</a></p>':"";
}else{
	$chain_text = "<span>".$chain."</span>";
	$chain_metro_text = "";
}
//Устанавливаем заголовок страницы
if(!empty($arParams["PAGE_H1"])){
	$h1 = $arParams["PAGE_H1"];
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["UF_METRO_H1"]){
	$h1 = str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["UF_METRO_H1"]);
}else{
	$h1 = !empty($arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"])?$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]:$arResult["NAME"];
}

$breadcrumb .= '<div class="breadcrumbs">';
if($chain_metro != false){
	$breadcrumb .= '
		<span class="bx-breadcrumb-item" id="bx_breadcrumb_0" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemref="bx_breadcrumb_1">
			<a href="/" title="Главная" itemprop="url">
				<span itemprop="title">Главная</span>
			</a>
		</span>
	';
	$breadcrumb .= '
		<span class="bx-breadcrumb-item" id="bx_breadcrumb_1" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child" itemref="bx_breadcrumb_2">
			<a href="'.$arResult["SECTION_PAGE_URL"].'" title="'.$arResult["NAME"].'" itemprop="url">
				<span itemprop="title">'.$arResult["NAME"].'</span>
			</a>
		</span>
	';
	$breadcrumb .= '
		<span class="bx-breadcrumb-item" id="bx_breadcrumb_2" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child">
			<span class="bx-breadcrumb-item">'.$chain_metro.'</span>
		</span>
	';
}else{
	$breadcrumb .= '
		<span class="bx-breadcrumb-item" id="bx_breadcrumb_0" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemref="bx_breadcrumb_1">
			<a href="/" title="Главная" itemprop="url">
				<span itemprop="title">Главная</span>
			</a>
		</span>
	';
	$breadcrumb .= '
		<span class="bx-breadcrumb-item" id="bx_breadcrumb_1" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child">
			<span class="bx-breadcrumb-item">'.$arResult["NAME"].'</span>
		</span>
	';
}
$breadcrumb .= '</div>';
//pre_dump($arResult["clinicList"]);
// Вывод листинга клиник
$clinics_list = $arResult["clinicList_IDS"];
if(
	Bitrix\Main\Loader::includeModule('api.uncachedarea')
	&& Bitrix\Main\Loader::includeModule('iblock')
) {
	CAPIUncachedArea::includeFile(
		"/local/include/list_clinics.php",
		array(
			"clinicList" => $arResult["clinicList"],
			"ID_SERVICE" => $serviceId,
			"clinicList_IDS" => $arResult["clinicList_IDS"],
			"clinicIDS" => $arResult["clinicIDS"],
			"METRO" => $arParams["METRO"],
			"METRO_INFO" => $arParams["METRO_INFO"],
			"OKRUG_NAME" => $arResult["OKRUG_NAME"],
			"SECTION_SECTION_PAGE_URL" => (!empty($arParams["METRO"])?$arResult["SECTION_PAGE_URL"]."metro/".$arParams["METRO_INFO"]["CODE"]."/":$arResult["SECTION_PAGE_URL"]),
		)
	);
}
?>
<?$this->SetViewTarget('head_block');?>
<?
$text_str = "которые оказывают";
if(count($arResult["clinicListMap"]) > 1){
	$text_str = "которые оказывают";
}else{
	$text_str = "которая оказывает";
}
if(!empty($arParams["METRO_INFO"])){
	$local_name = "На м. ".$arParams["METRO_INFO"]["NAME"];
}else{
	$local_name = !empty($arResult["TEXT_INFO"]["OKRUG"])?"В ".$arResult["TEXT_INFO"]["OKRUG"]:"В округе ".$arResult["OKRUG_NAME"];
}
?>
	<div class="page__preview">
		<div class="inside group">
			<div class="page__preview-info"<?//if($arResult["sort_price"][0]["min_price"] < 1):?> style="width:100%;"<?//endif;?>>
				<?echo $breadcrumb;?>
				<h1 class="page__preview-title"><?echo $h1;?></h1>
				<div class="page__preview-desc">
					<?if(!empty($arParams["PAGE_TEXT"])):?>
						<?echo htmlspecialcharsBack($arParams["PAGE_TEXT"]);?>
					<?elseif(!empty($arResult['DESCRIPTION'])):?>
						<?=$arResult['DESCRIPTION']?>
					<?elseif(count($arResult["clinicListMap"]) > 0):?>
						<?/*<p><?echo $local_name;?> найдено клиник &mdash; <?echo count($arResult["clinicListMap"]);?><?//echo ClinToStr(count($clinics_list));?>.<?/*if($PRICE_VALUE > 1):?> Минимальная стоимость услуги <?=$PRICE?> <?endif;/?></p>*/?>
						<p>
						<?echo $local_name;?> найдено <?echo count($arResult["clinicListMap"]);?> клиник, которые предоставляют услуги по направлению "<?echo $arResult["NAME"];?>". 
						<?if(!empty($arResult["TEXT_INFO"]["NAME_SERVICE"])):?>Минимальная стоимость услуги "<?echo $arResult["TEXT_INFO"]["NAME_SERVICE"];?>" - <?echo $arResult["TEXT_INFO"]["PRICE"];?> <?endif;?>
						<?if(!empty($arResult["TEXT_INFO"]["NAME"])):?>Наибольшей популярностью среди наших посетителей пользуется <?echo $arResult["TEXT_INFO"]["NAME"];?>. 
						<?if(!empty($arResult["TEXT_INFO"]["WORKTIME"])):?>Медицинский центр работает <?echo $arResult["TEXT_INFO"]["WORKTIME"];?>.<?endif;?><?endif;?>
						</p>
						<?=$link_text;?>
					<?endif;?>
					<?/*if(!empty($arResult["DETAIL_TEXT"])):?>
					<span class="spoiler-text"><?echo $arResult["DETAIL_TEXT"];?></span>
					<a class="spoiler" href="#">Читать далее...</a>
				<?endif;*/?>
				</div>
			</div>
			<?/*if($arResult["sort_price"][0]["min_price"] > 1):?>
				<div class="page__service text-center">
					<?if(!empty($arResult["PROPERTIES"]["AVATAR"]["SRC"])):?><img class="img-responsive center-block img-circle" src="<?echo $arResult["PROPERTIES"]["AVATAR"]["SRC"];?>" alt="<?echo $arResult["NAME"];?>" /><?endif;?>
					<p><?echo $arResult["NAME"];?> <span><?=$PRICE?></span></p>
				</div>
			<?endif;*/?>
		</div>
	</div>
<?$this->EndViewTarget();?>
<?$this->SetViewTarget('metro_sidebar');?>
	<?if(!empty($arResult["METROS"])):?>
		<p style="font-size: 13px;font-weight: bold;">Выберите метро:
			<?$i=1;foreach($arResult["METROS"] as $metro):?>
				<?if($metro["SELECTED"] == true):?><?echo $metro["NAME"];?><?else:?><a href="<?echo $metro["DETAIL_PAGE_URL"];?>"><?echo $metro["NAME"];?></a><?endif;?><?if($i == count($arResult["METROS"])):?>.<?else:?>, <?endif;?>
				<?$i++;endforeach;?>
		</p>
	<?endif;?>
<?$this->EndViewTarget();?>
<?/*$this->SetViewTarget('aside_sidebar');?>
	<div class="page__sidebar">
		<h4 class="page__sidebar-title"><?echo $arResult["NAME"];?></h4>
		<nav class="page__sidebar-nav">
			<ul>
				<?/*foreach($arResult["SECTIONS"] as $key => $value):?>
			<li <?if($value['SELECTED'] == true):?>class="active"<?endif?> ><a href="/<?=$value['CODE'];?>/"><?=$value['NAME'];?></a>
			<?if(!empty($value['ITEMS'])):?>
				<ul>
				<?foreach($value['ITEMS'] as $k => $v):?>
					<li <?if($v['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$v['DETAIL_PAGE_URL'];?>"><?=$v['NAME'];?></a></li>
				<?endforeach;?>
				</ul>
			<?endif?>
			</li>
		<?endforeach*?>
				<?foreach($arResult["ITEMS"] as $k => $v):?>
					<li <?if($v['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$v['DETAIL_PAGE_URL'];?>"><?=$v['NAME'];?></a></li>
				<?endforeach?>
			</ul>
		</nav>
	</div>
<?$this->EndViewTarget();*/?>

<?$this->SetViewTarget('head_block_top');?>
	<?if(!empty($arResult["clinicListMap"])):?>
	<?
	$LAT = 0;
	$LONG = 0;
	foreach($arResult["clinicListMap"] as $adress){
		$LAT += $adress["PROPERTY_LAT_VALUE"];
		$LONG += $adress["PROPERTY_LONG_VALUE"];
	}
	$fin_lat = $LAT/count($arResult["clinicListMap"]);
	$fin_long = $LONG/count($arResult["clinicListMap"]);
	?>
		<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		<script type="text/javascript">
				
			ymaps.ready(init);
			function init () {
				var myMap = new ymaps.Map('map', {
						center: [<?=$fin_lat?>,<?=$fin_long?>],
						zoom: 9,
						controls: []
					}, {
						searchControlProvider: 'yandex#search'
					}),
					clusterer = new ymaps.Clusterer({
						preset: 'islands#blueIcon',
						groupByCoordinates: false,
						clusterDisableClickZoom: true,
						clusterHideIconOnBalloonOpen: false,
						geoObjectHideIconOnBalloonOpen: false
					}),
					getPointData = function (index) {
						var pointsData = new Array();	
						
						<?$i=0;foreach($arResult["clinicListMap"] as $key => $adress):
						if(!empty($adress["PROPERTY_LAT_VALUE"]) && !empty($adress["PROPERTY_LONG_VALUE"])):
						$work_time = !empty($adress["PROPERTY_ROUND_CLOCK_VALUE"])?"24 часа":$adress["PROPERTY_WORKTIME_VALUE"];?>
						
							pointsData[<?=$i?>] = {
									'iconContent': '<?//echo $adress["NAME"];?>',
									'hintContent':'<?if($adress["PROPERTY_ADDRESS_O_VALUE"]):?><?echo $adress["PROPERTY_ADDRESS_O_VALUE"];?><?endif;?><?if($work_time):?><br /><?echo $work_time;?><?endif;?>',
									'balloonContentHeader':'<?echo $adress["NAME"];?>',
									'balloonContent':'<?if($adress["PROPERTY_ADDRESS_O_VALUE"]):?><?echo $adress["PROPERTY_ADDRESS_O_VALUE"];?><?endif;?><?if($work_time):?><br /><?echo $work_time;?><?endif;?>',
								}
						<?$i++;endif;
						endforeach;?>
					   return pointsData[index];
					},
					getPointOptions = function () {
						return {
							preset: 'islands#blueIcon'
						};
					},
					points = [
						<?$i=0;foreach($arResult["clinicListMap"] as $key => $adress):
						if(!empty($adress["PROPERTY_LAT_VALUE"]) && !empty($adress["PROPERTY_LONG_VALUE"])):?>
							[<?echo $adress["PROPERTY_LAT_VALUE"];?>,<?echo $adress["PROPERTY_LONG_VALUE"];?>],
						<?$i++;endif;
						endforeach;?>
					],
					geoObjects = [];

					for(var i = 0, len = points.length; i < len; i++) {
						geoObjects[i] = new ymaps.Placemark(points[i], getPointData(i), getPointOptions());
					}
					clusterer.options.set({
						gridSize: 80,
						clusterDisableClickZoom: false
					});
					clusterer.add(geoObjects);
					myMap.geoObjects.add(clusterer);
					myMap.setBounds(clusterer.getBounds(), {
						checkZoomRange: true
					});
					myMap.setZoom(myMap.getZoom()-0.4); //Чуть-чуть уменьшить зум для красоты
					myMap.behaviors.disable('scrollZoom');
					myMap.controls.add('routeEditor');
					myMap.controls.add('zoomControl');
			}
		</script>
		<div id="map"style="height: 400px;"></div>
	<?endif;?>
<?$this->EndViewTarget();?>