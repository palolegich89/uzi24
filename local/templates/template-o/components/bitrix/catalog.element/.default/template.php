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
 * @var string $templateFolder
 */
CHTTP::SetStatus("404 Not Found");
define("ERROR_404","Y");

$this->setFrameMode(true);

$PRICE = 'от '.number_format($arResult["sort_price"][0]["PRICE_VALUE"], 0, ',', ' ').' руб.';
$PRICE_VALUE = $arResult["sort_price"][0]["PRICE_VALUE"];

$chain = !empty($arResult["META_TAGS"]["ELEMENT_CHAIN"])?$arResult["META_TAGS"]["ELEMENT_CHAIN"]:$arResult["NAME"];
$chain_metro = !empty($arParams["METRO_INFO"])?$arParams["METRO_INFO"]["NAME"]:false;

//Устанавливаем заголовок страницы
if(!empty($arParams["PAGE_H1"])){
    $h1 = $arParams["PAGE_H1"];
}elseif(!empty($arParams["METRO_INFO"]) && $arResult["PROPERTIES"]["METRO_H1"]["VALUE"]){
    $h1 = str_replace("#metro#", $arParams["METRO_INFO"]["NAME"], $arResult["PROPERTIES"]["METRO_H1"]["VALUE"]);
}else{
    $h1 = !empty($arResult["META_TAGS"]["TITLE"])?$arResult["META_TAGS"]["TITLE"]:$arResult["NAME"];
}
//Информация об услуге
$res = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
if($ar_res = $res->GetNext()){
    $IBLOCK_SECTION_NAME = $ar_res['NAME'];
    $IBLOCK_SECTION_URL = $ar_res['SECTION_PAGE_URL'];
}
$breadcrumb .= '<div class="breadcrumbs">';
$breadcrumb .= '
    <span class="bx-breadcrumb-item" id="bx_breadcrumb_0" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemref="bx_breadcrumb_1">
        <a href="/" title="Главная" itemprop="url">
            <span itemprop="title">Главная</span>
        </a>
    </span>
';
if($chain_metro != false){
    $breadcrumb .= '
        <span class="bx-breadcrumb-item" id="bx_breadcrumb_1" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child" itemref="bx_breadcrumb_2">
            <a href="'.$IBLOCK_SECTION_URL.'" title="'.$IBLOCK_SECTION_NAME.'" itemprop="url">
                <span itemprop="title">'.$IBLOCK_SECTION_NAME.'</span>
            </a>
        </span>
    ';
    $breadcrumb .= '
        <span class="bx-breadcrumb-item" id="bx_breadcrumb_2" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child">
            <a href="'.$arResult["DETAIL_PAGE_URL"].'" title="'.$arResult["NAME"].'" itemprop="url">
                <span itemprop="title">'.$arResult["NAME"].'</span>
            </a>
        </span>
    ';
    $breadcrumb .= '<span class="bx-breadcrumb-item">'.$chain_metro.'</span>';
}else{
    $breadcrumb .= '
        <span class="bx-breadcrumb-item" id="bx_breadcrumb_1" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="child">
            <a href="'.$IBLOCK_SECTION_URL.'" title="'.$IBLOCK_SECTION_NAME.'" itemprop="url">
                <span itemprop="title">'.$IBLOCK_SECTION_NAME.'</span>
            </a>
        </span>
    ';
    $breadcrumb .= '<span class="bx-breadcrumb-item">'.$arResult["NAME"].'</span>';
}
$breadcrumb .= '</div>';
// Выводим листинг клиник
$clinics_list = $arResult["clinicList_IDS"];
if(Bitrix\Main\Loader::includeModule('api.uncachedarea') && Bitrix\Main\Loader::includeModule('iblock') && count($arResult["clinicList"]) > 0) {
    CAPIUncachedArea::includeFile(
        "/local/include/list_clinics.php",
        array(
            "clinicList" => $arResult["clinicList"],
            "ID_SERVICE" => $serviceId,
            "clinicList_IDS" => $arResult["clinicList_IDS"],
            "METRO" => $arParams["METRO"],
            "METRO_INFO" => $arParams["METRO_INFO"],
            "OKRUG_NAME" => $arResult["OKRUG_NAME"],
            "COUNT_CLIN" => count($arResult["clinicList"])
        )
    );
}else{
    if(!empty($arParams["METRO_INFO"]["NAME"])){
        $h2_klin = "Клиники на м. ".$arParams["METRO_INFO"]["NAME"];
    }else{
        $h2_klin = "Клиники в ".$arResult["OKRUG_NAME"];
    }
    echo '<h2 class="page__content-title">'.$h2_klin.'</h2>';
}
?>
<?$this->SetViewTarget('head_block');?>
<?
if(ERROR_404 != "Y"){
$text_str = "которые оказывают";
if(count($clinics_list) > 1){
    $text_str = "которые оказывают";
}else{
    $text_str = "которая оказывает";
}
if(!empty($arParams["METRO_INFO"])){
    $local_name = "на м. ".$arParams["METRO_INFO"]["NAME"];
}else{
    $local_name = "в ".$arResult["OKRUG_NAME"];
}
?>
    <div class="page__preview">
        <div class="inside group">
            <div class="page__preview-info"<?if($arResult["sort_price"][0]["PRICE_VALUE"] < 1):?> style="width:100%;"<?endif;?>>
                <?echo $breadcrumb;?>
                <h1 class="page__preview-title"><?echo $h1;?></h1>
                <div class="page__preview-desc">
                    <?if(!empty($arParams["PAGE_TEXT"])):?>
                        <?echo htmlspecialcharsBack($arParams["PAGE_TEXT"]);?>
                    <?elseif(!empty($arResult["DISPLAY_PROPERTIES"]["TOP_TEXT"]["~VALUE"]["TEXT"])):?>
                        <?echo $arResult["DISPLAY_PROPERTIES"]["TOP_TEXT"]["~VALUE"]["TEXT"];?>
                        <?if(!empty($arResult["DETAIL_TEXT"])):?>
                            <span class="spoiler-text"><?echo $arResult["DETAIL_TEXT"];?></span>
                            <a class="spoiler" href="#">Читать далее...</a>
                        <?endif;?>
                    <?else:?>
                        Мы нашли для вас <?echo ClinToStr(count($arResult["clinicList"]));?> <?echo $local_name;?>, <?echo $text_str;?> услугу "<?echo $arResult["NAME"];?>".<?if($PRICE_VALUE > 1):?> Минимальная стоимость услуги <?=$PRICE?> <?endif;?>
                    <?endif;?>
                    <?if(!empty($arResult["METROS"])):?>
                        <p>Выберите метро:
                            <?$i=1;foreach($arResult["METROS"] as $metro):?>
                                <?if($metro["SELECTED"] == true):?><?echo $metro["NAME"];?><?else:?><a href="<?echo $metro["DETAIL_PAGE_URL"];?>"><?echo $metro["NAME"];?></a><?endif;?><?if($i == count($arResult["METROS"])):?>.<?else:?>, <?endif;?>
                                <?$i++;endforeach;?>
                        </p>
                    <?endif;?>
                </div>
            </div>
            <?if($arResult["sort_price"][0]["PRICE_VALUE"] > 1):?>
                <div class="page__service text-center">
                    <?if(!empty($arResult["PROPERTIES"]["AVATAR"]["SRC"])):?><img class="img-responsive center-block img-circle" src="<?echo $arResult["PROPERTIES"]["AVATAR"]["SRC"];?>" alt="<?echo $arResult["NAME"];?>" /><?endif;?>
                    <p><?echo $arResult["NAME"];?> <span><?=$PRICE?></span></p>
                </div>
            <?endif;?>
        </div>
    </div>
<?
}
$this->EndViewTarget();?>