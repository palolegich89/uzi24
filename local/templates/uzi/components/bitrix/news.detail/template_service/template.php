<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

$PRICE = 'от ' . number_format($arResult["sort_price"][0]["UF_PRICE"], 0, ',', ' ') . ' руб.';

$chain = !empty($arResult["META_TAGS"]["ELEMENT_CHAIN"]) ? $arResult["META_TAGS"]["ELEMENT_CHAIN"] : $arResult["NAME"];
$h1 = !empty($arResult["META_TAGS"]["TITLE"]) ? $arResult["META_TAGS"]["TITLE"] : $arResult["NAME"];
?>
<div class="page__preview">
	<div class="inside group">
		<div class="page__preview-info" <? if (empty($arResult["DETAIL_TEXT"])): ?>style="min-height: unset;" <? endif; ?>>
			<div class="breadcrumbs"><a href="/">Главная</a><span><? echo $chain; ?></span></div>
			<h1 class="page__preview-title"><? echo $h1; ?></h1>
			<div class="page__preview-desc">

				<? echo $arResult["DISPLAY_PROPERTIES"]["TOP_TEXT"]["~VALUE"]["TEXT"]; ?>
				<? if (!empty($arResult["DETAIL_TEXT"])): ?>
					<span class="spoiler-text"><? echo $arResult["DETAIL_TEXT"]; ?></span>
					<a class="spoiler" href="javascript:void(0);" aria-label="Читать текст полностью">Читать далее...</a>
				<? endif; ?>
			</div>
		</div>
		<? if ($PRICE > 0): ?>
			<div class="page__service text-center">
				<? if ($arResult["PROPERTIES"]["AVATAR"]["SRC"]): ?>
					<img class="img-responsive center-block img-circle" src="<?= $arResult["PROPERTIES"]["AVATAR"]["SRC"]; ?>" alt="<? echo $arResult["NAME"]; ?>" />
				<? endif; ?>
				<p><? echo $arResult["NAME"]; ?> <span><?= $PRICE ?></span></p>
			</div>
		<? endif; ?>
	</div>
</div>
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		const spoilerLink = document.querySelector('.spoiler');
		const spoilerText = document.querySelector('.spoiler-text');

		spoilerLink.addEventListener('click', function(e) {
			e.preventDefault();
			// Задаем высоту, равную полной высоте содержимого, для плавного раскрытия
			spoilerText.style.maxHeight = spoilerText.scrollHeight + 'px';
			this.style.display = 'none';
		});
	});
</script>