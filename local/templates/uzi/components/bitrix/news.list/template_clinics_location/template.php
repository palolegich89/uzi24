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
//echo "<pre>";print_r($arParams["INFO_CLINICS"]);echo "</pre>";
?>
<? if (!empty($arResult["ITEMS"])): ?>
    <? if (!empty($arParams["TITLE_LIST_MAIN"])): ?><h2
            class="page__content-title"><?= $arParams["TITLE_LIST_MAIN"]; ?></h2><? endif; ?>
    <? if (!empty($arParams["TITLE_LIST_SEC"])): ?><h2
            class="page__content-title"><?= $arParams["TITLE_LIST_SEC"]; ?></h2><? endif; ?>
    <div class="clinic__list" id="clin_block">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            $this->AddEditAction(
                $arItem["ID"],
                $arItem["EDIT_LINK"],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
            );
            $this->AddDeleteAction(
                $arItem["ID"],
                $arItem["DELETE_LINK"],
                CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
                array("CONFIRM" => GetMessage("CT_BNL_ELEMENT_DELETE_CONFIRM"))
            );

            $work_time = !empty($arItem["DISPLAY_PROPERTIES"]["ROUND_CLOCK"]["VALUE"]) ? "24 часа" : $arItem["DISPLAY_PROPERTIES"]["WORKTIME"]["VALUE"];

            if (date("H:i") >= "08:00" && date("H:i") <= "21:00" && empty($arItem["PROPERTIES"]["NO_CHANGE_PHONE"]["VALUE"])) {
                $phone = PHONE_DOKDOK;
                $phoneUrl = PHONE_DOKDOK_URL;
            } else {
                $phone = $arItem["DISPLAY_PROPERTIES"]["PHONE"]["VALUE"];
                $phoneUrl = $arItem["DISPLAY_PROPERTIES"]["PHONE"]["VALUE"];
            }
            $file_logo = CFile::ResizeImageGet(
                $arItem["DISPLAY_PROPERTIES"]["AVATAR"]["FILE_VALUE"],
                array('width' => 175, 'height' => 165),
                BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                true
            );
            foreach($arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"] as $key => $metro){
                if(empty($metro)){
                    unset($arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"][$key]);
                }
            }
            ?>
            <div class="clinic group" id="<?= $this->GetEditAreaId($arItem["ID"]); ?>">
                <div class="clinic__logo">
                    <div class="like_table">
                        <div class="table_cell">
                            <img
                                class="img-responsive center-block"
                                src="<?= $file_logo['src'] ?>"
                                alt="<?= $arItem["NAME"]; ?>"
                                width="<?= $file_logo['width']; ?>"
                                height="<?= $file_logo['height']; ?>" />
                            <? if ($arItem["PROPERTIES"]["RATING"]["VALUE"]): ?>
                                <div style="text-align: center;margin-top: 15px;font-size: large;font-weight: bold;">
                                    <img src="/local/templates/uzi/images/stars.png"  width="45" height="45"> <?= $arItem["PROPERTIES"]["RATING"]["VALUE"] ?>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                </div>
                <div class="clinic__info">
                    <h3 class="clinic__name"><?= $arItem["NAME"]; ?></h3>
                    <p class="clinic__address"><?= $arItem["DISPLAY_PROPERTIES"]["ADDRESS"]["VALUE"]; ?></p>
                    <p class="clinic__metro-distance">
                        <? if (is_array($arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"])) {
                            echo implode(", ", $arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"]);
                        } else {
                            echo $arItem["DISPLAY_PROPERTIES"]["METRO"]["ITEMS"];
                        }; ?><br /><br />
                        <?= $arItem["DISPLAY_PROPERTIES"]["DESCRIPTION_UZI"]["VALUE"]["TEXT"]; ?>
                    </p>
                    <p class="clinic__phone">
                        <a href="tel:<?= $phoneUrl; ?>"><?= $phone; ?></a>
                        <? if (!empty($work_time)): ?><span> &mdash; <?= $work_time; ?></span><? endif; ?>
                    </p>

                    <button type="button" class="btn-record schedule__item info_data js-record" data-fancybox="" data-src="#record-popup" data-clinic="<?= $arItem["EXTERNAL_ID"] ?>">Записаться онлайн</button>
                    <? if (!empty($arItem["SERVICES"])): ?>
                        <ul class="price_list">
                            <? foreach ($arItem["SERVICES"] as $SERVICES):
                                $PRICE = number_format($SERVICES["UF_PRICE"], 0, ',', ' ') . ' руб.';
                            ?>
                                <li><span class="left"><?= $SERVICES["NAME"] ?></span><span class="right"><?= $PRICE ?></span></li>
                            <? endforeach; ?>
                        </ul>
                    <? endif; ?>
                </div>
                <? if (!empty($arResult["CLIN_PRICE"][$arItem["ID"]]["UF_PRICE"])):
                    $PRICE = number_format($arResult["CLIN_PRICE"][$arItem["ID"]]["UF_PRICE"], 0, ',', ' ') . ' руб.';
                ?>
                    <div class="clinic__price">
                        <div class="clinic__price-data orange">
                            <div class="clinic__price-value"><?= $PRICE; ?></div>
                            <div class="clinic__price-service"><?= $arResult["SERVICE"]['NAME']; ?></div>
                        </div>
                    </div>
                <? endif; ?>
            </div>
            <? //pre_dump($arItem["DISPLAY_PROPERTIES"]);
            ?>
        <? endforeach; ?>
        <br />
        <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
            <br /><?= $arResult["NAV_STRING"] ?>
        <? endif; ?>
    </div>
<? endif; ?>