<?
$protokol = ($APPLICATION->IsHTTPS() ? 'https://' : 'http://');
$APPLICATION->SetPageProperty('canonical', $protokol . SITE_SERVER_NAME . $arResult['SECTION_SECTION_PAGE_URL']);
if (
    isset($arResult['NAV_RESULT_NAV_NUM'], $arResult['NAV_RESULT_NAV_PAGE_NOMER'], $arResult['SECTION_SECTION_PAGE_URL'])
    && (
        array_key_exists('PAGEN_' . $arResult['NAV_RESULT_NAV_NUM'], $_GET)
        || $arResult['NAV_RESULT_NAV_PAGE_NOMER'] > 1
    )
) {
    $APPLICATION->SetPageProperty('canonical', $protokol . SITE_SERVER_NAME . $arResult['SECTION_SECTION_PAGE_URL']);
}
 
if (
    isset(
        $arResult['NAV_RESULT_NAV_NUM'],
        $arResult['NAV_RESULT_NAV_PAGE_NOMER'],
        $arResult['NAV_RESULT_NAV_PAGE_COUNT'],
        $arResult['SECTION_SECTION_PAGE_URL']
    )
) {
 
    $paramName = sprintf('PAGEN_%s', $arResult['NAV_RESULT_NAV_NUM']);
 
    if ($arResult['NAV_RESULT_NAV_PAGE_COUNT'] > $arResult['NAV_RESULT_NAV_PAGE_NOMER']) {
        // next
        $urlNextRel = htmlspecialcharsbx(
            CHTTP::urlAddParams(
                CHTTP::urlDeleteParams(
                    $arResult['SECTION_SECTION_PAGE_URL'],
                    $paramName,
                    [
                        'delete_system_params' => true
                    ]
                ),
                [
                    $paramName => $arResult['NAV_RESULT_NAV_PAGE_NOMER'] + 1,
                ],
                [
                    'skip_empty' => true,
                ]
            )
        );
    }
 
    if ($arResult['NAV_RESULT_NAV_PAGE_NOMER'] > 1) {
        // prev
        $urlPrevRel = htmlspecialcharsbx(
            CHTTP::urlAddParams(
                CHTTP::urlDeleteParams(
                    $arResult['SECTION_SECTION_PAGE_URL'],
                    $paramName,
                    [
                        'delete_system_params' => true
                    ]
                ),
                [
                    $paramName => (
                        ($arResult['NAV_RESULT_NAV_PAGE_NOMER'] - 1) == 1
                            ? ''
                            : $arResult['NAV_RESULT_NAV_PAGE_NOMER'] - 1
                    ),
                ],
                [
                    'skip_empty' => true,
                ]
            )
        );
 
    }
 
    if (isset($urlNextRel)) {
        $APPLICATION->SetPageProperty('next', $protokol . SITE_SERVER_NAME . $urlNextRel);
    }
 
    if (isset($urlPrevRel)) {
        $APPLICATION->SetPageProperty('prev', $protokol . SITE_SERVER_NAME . $urlPrevRel);
    }
 
}