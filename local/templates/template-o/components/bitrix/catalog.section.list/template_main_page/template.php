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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<div class="types" id="types">
	<h3 class="types__title">Направления</h3>
	<div class="types__list">
	  <ul class="group">
		<?foreach($arResult["SECTIONS_NEW"] as $key => $value):?>
		 <li class="type">	
			<p class="type__name"><a href="<?=$value['SECTION_PAGE_URL'];?>"><?=$value['NAME'];?></a></p>
				<?/*if(!empty($value['CILDREN'])):?>
				<p class="type__desc">
					<?$k=1;foreach($value['CILDREN'] as $v):?>
						<a href="<?=$v['SECTION_PAGE_URL'];?>"><?=$v['NAME'];?></a> 
						<?if(($k) != count($value['CILDREN'])):?>
						|
						<?endif?>
					<?$k++;endforeach;?>
				</p>
				<?endif*/?>
		 </li>
		<?endforeach;?>
	  </ul>
	</div>
</div>