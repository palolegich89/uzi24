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
//echo "<pre>";print_r($arParams["INFO_CLINICS"]);echo "</pre>";
?>
<?/*<h2 class="page__content-title">Где сделать <?=$arResult["SERVICE"]['NAME'];?> круглосуточно</h2>*/?>
<div class="clinic__list" id="clin_block">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem["ID"], $arItem["EDIT_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem["ID"], $arItem["DELETE_LINK"], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM")));

	$work_time = !empty($arItem["DISPLAY_PROPERTIES"]["ROUND_CLOCK"]["VALUE"])?"24 часа":$arItem["DISPLAY_PROPERTIES"]["WORKTIME"]["VALUE"];

		/*if(date("H:i") >= "08:00" && date("H:i") <= "21:00" && empty($arItem["PROPERTIES"]["NO_CHANGE_PHONE"]["VALUE"])){
			$phone = PHONE_DOKDOK;
			$phoneUrl = PHONE_DOKDOK_URL;
		}else{
			$phone = $arItem["DISPLAY_PROPERTIES"]["PHONE"]["VALUE"];
			$phoneUrl = $arItem["DISPLAY_PROPERTIES"]["PHONE"]["VALUE"];
		}*/
		if(empty($arItem["PROPERTIES"]["NO_CHANGE_PHONE"]["VALUE"])){
			$phone = DEFAULT_PHONE;
			$phoneUrl = DEFAULT_PHONE;
			$scen = "122601";
		}else{
			$phone = MCS_PHONE;
			$phoneUrl = MCS_PHONE;
			$scen = "53379";
		}
		?>
		<div class="clinic group" id="<?=$arItem["ID"];?>">
			<div class="clinic__logo">
				<div class="like_table">
					<div class="table_cell">
						<img class="img-responsive center-block" src="<?=$arItem["DISPLAY_PROPERTIES"]["AVATAR"]["FILE_VALUE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>" />
						<? if (!empty($arItem['PROPERTIES']['RATING']['VALUE'])): ?>
						<div style="text-align: center;clear: both;">
							<ul class="rate">
								<?=echoStars($arItem['PROPERTIES']['RATING']['VALUE'])?>
							</ul>
							<span>Рейтинг: <?=$arItem['PROPERTIES']['RATING']['VALUE']?></span>
						</div>
						<? endif; ?>
					</div>
				</div>
			</div>
			<div class="clinic__info">
				<div class="clinic__name"><?=$arItem["NAME"];?></div>
				<p class="clinic__address">м. <?=$arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][0];?>, <?=$arItem["DISPLAY_PROPERTIES"]["ADDRESS_O"]["VALUE"];?></p>
				<?/*<?if(!empty($arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"])):?>
				<p class="clinic__metro-distance">
					<?=implode(", ", $arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"]);?>
					<?//=$arItem["DISPLAY_PROPERTIES"]["DESCRIPTION_OKRUG"]["VALUE"]["TEXT"];?>
				</p>
				<?endif;?>*/?>
				<p class="clinic__phone"><a href="tel:<?=$phoneUrl;?>"><?=$phone;?></a><?if(!empty($work_time)):?><span> &mdash; <?=$work_time;?></span><?endif;?></p>
				
				<?$APPLICATION->IncludeComponent(
					"callapi:form.popup",
					"template",
					Array(
						"BUTTON_TEXT" => "Записаться онлайн",
						"COMPONENT_TEMPLATE" => "template",
						"ELEMENT_ID" => "",
						"IBLOCK_ID" => "0",
						"ID" => $arItem["ID"],
						"SCENARIO" => $scen,
						"VIRTUAL_PHONE" => $phone
					)
				);?>
				<?if(!empty($arParams["clinicList"])):?>
					<ul class="price_list">
						<?foreach($arParams["clinicList"][$arItem["ID"]]["SERVICE_NAME"] as $key => $item_price):
							$PRICE_item = number_format($arParams["clinicList"][$arItem["ID"]]["PRICE_VALUE"][$key], 0, ',', ' ').' руб.';
							?>
							<?if(!empty($arParams["clinicList"][$arItem["ID"]]["PRICE_VALUE"][$key])):?>
							<li><span class="left"><?=$item_price?></span><span class="right"><?=$PRICE_item?></span></li>
						<?endif;?>
						<?endforeach;?>
					</ul>
				<?endif;?>
			</div>
			<?/*if(!empty($arParams["clinicList"][$arItem["ID"]]["PRICE_VALUE"]) || !empty($arParams["clinicList"][$arItem["ID"]]["min_price"])):
				if(!empty($arParams["clinicList"][$arItem["ID"]]["min_price"])):
					$PRICE = number_format($arParams["clinicList"][$arItem["ID"]]["min_price"], 0, ',', ' ').' руб.';
				elseif(!empty($arParams["clinicList"][$arItem["ID"]]["PRICE_VALUE"])):
					$PRICE = number_format($arParams["clinicList"][$arItem["ID"]]["PRICE_VALUE"], 0, ',', ' ').' руб.';
				endif;
				*/?><?/*
				<div class="clinic__price">
					<div class="clinic__price-data orange">
						<?$APPLICATION->IncludeComponent(
							"callapi:form.popup",
							"template",
							Array(
								"BUTTON_TEXT" => "Записаться онлайн",
								"COMPONENT_TEMPLATE" => "template",
								"ELEMENT_ID" => "",
								"IBLOCK_ID" => "0",
								"ID" => $arItem["ID"],
								"SCENARIO" => $scen,
								"VIRTUAL_PHONE" => $phone
							)
						);?>
						*/?><?/*if(!empty($PRICE)):?>
							<div class="clinic__price-value"><?=$PRICE;?></div>
							<?if(!empty($arParams["clinicList"][$arItem["ID"]]["min_price"])):?>
								<div class="clinic__price-service"><?=$arParams["clinicList"][$arItem["ID"]]["min_price_name"];?></div>
							<?else:?>
								<div class="clinic__price-service"><?=$arParams["clinicList"][$arItem["ID"]]["SERVICE_NAME"];?></div>
							<?endif;?>
						<?endif;*/?><?/*
					</div>
				</div>*/?>
			<?/*else:?>
				<div class="clinic__price">
					<div class="clinic__price-data orange">
						<div class="clinic__price-value">Звоните!</div>
					</div>
				</div>
			<?endif;*/?>
		</div>
		<?//pre_dump($arItem["DISPLAY_PROPERTIES"]);?>
	<?endforeach;?>
	<br />
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>