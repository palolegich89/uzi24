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
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"template", 
	array(
		"PATH" => "",
		"SITE_ID" => SITE_ID,
		"START_FROM" => "0",
		"COMPONENT_TEMPLATE" => "template"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?>
<h1><?=$arResult["NAME"]?></h1>
<div class="page__preview-desc">
	<?/*if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
	<?endif*/?>
	<?echo $arResult["DETAIL_TEXT"];?>
</div>
<?if(!empty($arResult["SECTIONS"])):?>
<?$this->SetViewTarget('aside_sidebar');?>
<div class="page__sidebar">
	<h4 class="page__sidebar-title">Разделы</h4>
	<nav class="page__sidebar-nav">
		<ul>
		<?foreach($arResult["SECTIONS"] as $key => $value):?>
			<li <?if($value['SELECTED'] == true):?>class="active"<?endif?> ><a href="/info/blog/<?=$value['CODE'];?>/"><?=$value['NAME'];?></a></li>
		<?endforeach?>
		</ul>
	</nav>
</div>
<?$this->EndViewTarget();?>
<?endif;?>