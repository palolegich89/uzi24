<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$PRICE = 'от '.number_format($arResult["sort_price"][0]["UF_PRICE"], 0, ',', ' ').' руб.';

$chain = !empty($arResult["META_TAGS"]["ELEMENT_CHAIN"])?$arResult["META_TAGS"]["ELEMENT_CHAIN"]:$arResult["NAME"];
$h1 = !empty($arResult["META_TAGS"]["TITLE"])?$arResult["META_TAGS"]["TITLE"]:$arResult["NAME"]; 
?>

<div class="page__preview">
	<div class="inside group">
		<div class="page__preview-info">
			<div class="breadcrumbs"><a href="/">Главная</a><span><?echo $chain;?></span></div>
			<h1 class="page__preview-title"><?echo $h1;?></h1>
			<div class="page__preview-desc">
			
				<?echo $arResult["DISPLAY_PROPERTIES"]["TOP_TEXT"]["~VALUE"]["TEXT"];?>
				<?if(!empty($arResult["DETAIL_TEXT"])):?>
					<span class="spoiler-text"><?echo $arResult["DETAIL_TEXT"];?></span>
					<a class="spoiler" href="#">Читать далее...</a>
				<?endif;?>
			</div>
		</div>
		<div class="page__service text-center">
			<img class="img-responsive center-block img-circle" src="<?echo $arResult["PROPERTIES"]["AVATAR"]["SRC"];?>" alt="<?echo $arResult["NAME"];?>" />
			<p><?echo $arResult["NAME"];?> <span><?=$PRICE?></span></p>
		</div>
	</div>
</div>
