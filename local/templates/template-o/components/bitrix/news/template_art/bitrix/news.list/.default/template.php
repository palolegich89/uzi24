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
$curPage = $APPLICATION->GetCurPage();
$curDir = $APPLICATION->GetCurDir(true);
?>
<?if($arParams["BLOCK_HEADER"]){?>
	<div class="block-title"><?=$arParams["BLOCK_HEADER"]?></div>
<? } elseif($curDir == "/info/") {?>
	<div class="block-title">Новые статьи</div>
<? }?>
<div class="article">
<?foreach($arResult["ITEMS"] as $arItem){?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	$obParser = new CTextParser;
	$arItem["PREVIEW_TEXT"] = $obParser->html_cut($arItem["PREVIEW_TEXT"], 200);
	?>
	<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="art-item">
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><div class="img" style="background:url(<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>) no-repeat center; background-size:cover;"></div></a>
		<? if($arParams["SHOW_TITLE_CATEGORY"] == "Y"){?>
        <div class="title-category">
       		<? if($arParams["SHOW_TITLE_CATEGORY_LINK"] == "Y"){?>
	        <a href="<?=$arItem["CATEGORY_SECTION_URL"]?>"><?=$arItem["CATEGORY_NAME"]?></a>
            <? } else {?>
			<?=$arItem["CATEGORY_NAME"]?>
            <? }?>
        </div>
		<? }?>
		<div class="art-text">
			<div class="title"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></div>
			<?=$arItem["PREVIEW_TEXT"]?>

		</div>
	</div>
<? }?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<!--pagination-->
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
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