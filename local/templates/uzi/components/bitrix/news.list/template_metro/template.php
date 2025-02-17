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

$type = $arParams['TYPE'] ? $arParams['TYPE'] : '/location/metro/';

$coulmnCount = 4;
$itemsCount = count($arResult["ITEMS"]);
$itemsPerColumn = ceil($itemsCount / $coulmnCount);
$currentLetter = null;

$prefix = '';
?>
<div class="appointments">
    <div class="wrap b-shadow clear">

        <!--alphabet-->
        <div class="alphabet clear four-columns  target1 js-alphabet <?= !empty($arParams['EXPANDED']) ? 'expanded' : '' ?>">
            <div class="ab-column">
				<? foreach ($arResult["ITEMS"] as $index => $arItem):

				$name = $arParams['SPEC_NAME'] ? $arItem["PROPERTIES"]["BRANCH_NAME"]["VALUE"] : $arItem['NAME'];

				if ($index != 0 && $index % $itemsPerColumn == 0) {
					echo '</ul>';
					echo '</div>';
					echo '</div>';
					echo '<div class="ab-column">';
					$currentLetter = null;
				}

				if ($currentLetter != mb_substr($name, 0, 1)) {
                    if ($currentLetter !== null) {
                        echo '</ul>';
                        echo '</div>';
                    }
                    $currentLetter = mb_substr($name, 0, 1);
				?>
                <div class="ab-list">
                    <span class="letter"><?= $currentLetter ?></span>
                    <ul>
						<?
						}
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
                        <li class="no-underline" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= $name ?></a>
                        </li>
						<? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
