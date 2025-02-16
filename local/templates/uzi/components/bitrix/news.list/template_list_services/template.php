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
?>
<h4 class="page__sidebar-title">Виды УЗИ диагностики</h4>
<nav class="page__sidebar-nav">
    <ul>
		<?
		$url = explode('/', $APPLICATION->GetCurDir());
		?>
		<? foreach ($arResult["ITEMS"] as $key => $value): ?>
            <li <? if ($url[2] == $value['CODE']): ?>class="active"<? endif ?> ><a
                        href="<?= $value['DETAIL_PAGE_URL']; ?>"><?= $value['NAME']; ?></a>
				<? if (!empty($value['CHILDREN'])): ?>
                    <ul>
						<? foreach ($value['CHILDREN'] as $k => $v): ?>
                            <li <? if ($url[2] == $v['CODE']): ?>class="active"<? endif ?>><a
                                        href="<?= $v['DETAIL_PAGE_URL']; ?>"><?= $v['NAME']; ?></a></li>
						<? endforeach; ?>
                    </ul>
				<? endif ?>
            </li>
		<? endforeach ?>
    </ul>
</nav>