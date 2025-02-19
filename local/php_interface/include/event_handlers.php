<?
AddEventHandler('main', 'OnEpilog', '_Check404Error', 1);
  function _Check404Error(){
    if (defined('ERROR_404') && ERROR_404 == 'Y') {
    global $APPLICATION;
    $APPLICATION->RestartBuffer();
    include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/404.php';
    include $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
  }
}

AddEventHandler('main', 'OnEpilog', 'orPagenMeta');
function orPagenMeta() {
	unset($_GET['']);
	unset($_GET[' ']);
	unset($_GET['ELEMENT_CODE']);
	unset($_GET['ELEMENT_ID']);
	unset($_GET['SECTION_CODE']);
	unset($_GET['SECTION_ID']);

	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $domain = $protocol . $_SERVER['SERVER_NAME'];
    $currentUrl = $_SERVER['REQUEST_URI'];

	if (defined('ERROR_404') && ERROR_404 == 'Y') {
		$GLOBALS['APPLICATION']->SetPageProperty("robots", "noindex, follow");
	} elseif ($page = preg_grep("/PAGEN_(.*)/i", array_keys($_REQUEST))) {
		$page = intval($_REQUEST[reset($page)]);
		// canonical
		$GLOBALS['APPLICATION']->AddHeadString('<link href="' . $domain . $GLOBALS['APPLICATION']->sDirPath . '" rel="canonical" />', true);
		//h1
		//$GLOBALS['APPLICATION']->SetTitle($GLOBALS['APPLICATION']->GetTitle(false) . ' — Страница ' . $page);
		//title
		$title = $GLOBALS['APPLICATION']->GetTitle(false);
		$GLOBALS['APPLICATION']->SetPageProperty('title', $title . ' — Страница ' . $page);
		//description
		$description = $GLOBALS['APPLICATION']->GetProperty('description');
		$GLOBALS['APPLICATION']->SetPageProperty('description', $description . ' — Страница ' . $page);
		$GLOBALS['APPLICATION']->SetPageProperty("robots", "index, follow");
	} elseif ($_GET) {
		$GLOBALS['APPLICATION']->SetPageProperty("robots", "noindex, follow");
		$GLOBALS['APPLICATION']->AddHeadString('<link href="' . $domain . $GLOBALS['APPLICATION']->sDirPath . '" rel="canonical" />', true);
	} else {
        if (strpos($currentUrl, '/filter/') !== false) {
            // Получаем путь до '/filter/'
			//$canonicalPath = $domain . substr($currentUrl, 0, strpos($currentUrl, 'filter/'));
    
            //$GLOBALS['APPLICATION']->SetPageProperty("robots", "noindex, follow");
            //$GLOBALS['APPLICATION']->AddHeadString('<link href="' . $canonicalPath . '" rel="canonical" />', true);
        }

		//$GLOBALS['APPLICATION']->SetPageProperty("robots", "index, follow");
		//$GLOBALS['APPLICATION']->AddHeadString('<link href="https://' . $_SERVER['SERVER_NAME'] . $GLOBALS['APPLICATION']->sDirPath . '" rel="canonical" />', true);
	}
}
