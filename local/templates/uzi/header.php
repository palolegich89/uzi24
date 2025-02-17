<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<?
	if (($APPLICATION->GetCurPage() == "/") && ($APPLICATION->GetCurDir() == "/")) {
		$page = 'main';
		global $page;
	}
	?>
    <meta charset="utf-8">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="/favicon.ico?v=2" type="image/x-icon"/>

    <meta name="yandex-verification" content="cd2fcc257f7cdeea"/>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700|Roboto:300,400,700&amp;amp;subset=cyrillic-ext"
          rel="stylesheet"/>
    <link type="text/css" href="<?= SITE_TEMPLATE_PATH ?>/js/ui/jqueryui.custom.css" rel="stylesheet"/>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/js/ui/jqueryui.custom.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
	<? $APPLICATION->ShowHead(); ?>
</head>
<body>
<? $APPLICATION->ShowPanel(); ?>
<? if ($page == 'main'): ?>
    <div class="main-screen container group">
        <header class="header inner group">
            <a class="header__logo" href="/"></a>
			<? /*<div class="header__phone"><a href="tel:+74951060089">+7 (495) 106-00-89</a></div>*/ ?>
        </header>
        <div class="main-screen__title text-center">
            <h1><? $APPLICATION->ShowTitle(false) ?></h1>
        </div>
        <div class="main-screen__phone text-center">
			<? /*<p class="main-screen__phone-number"><a href="tel:84951060089">8 (495) 106-00-89</a></p>*/ ?>
            <p>Единый центр записи на УЗИ</p>
        </div>
        <div class="main-screen__chooser">
            <div class="main-screen__chooser-select">
                <input type="text" id="tags" name="metro1" data-value="" value="<?= $display_value; ?>"
                       placeholder="Выберите метро или район"/>
            </div>
            <form class="group" method="get" action="/location/">
                <input type="hidden" id="tags2" name="location" value=""/>
                <div class="main-screen__chooser-button">
                    <button class="button-find" type="submit">Найти</button>
                </div>
            </form>
        </div>
        <div class="main-screen__scroll text-center"><a href="#" scroll-to="#types">Выберите вид диагностики</a></div>
    </div>
<? else: ?>
    <div class="header container">
        <div class="inside group"><a class="header__logo" href="/"></a>
            <div class="header__chooser">
                <div class="header__chooser-select">
                    <input type="text" id="tags" name="metro1" data-value="" value="<?= $display_value; ?>"
                           placeholder="Выберите метро или район"/>
                </div>
				<?
				$tmp_url = $APPLICATION->GetCurDir();

				if (strstr($tmp_url, '/location/')) {
					$pos = strpos($tmp_url, '/location/');
					$url = substr($tmp_url, 0, $pos + 1);

				} elseif (strstr($tmp_url, '/services/')) {
					$url = $APPLICATION->GetCurDir();
				} else {
					$url = '/services/';
				}

				?>
                <form class="group" method="get" action="/location/<? //=$url;?>">
                    <input type="hidden" id="tags2" name="location" value=""/>
                    <div class="header__chooser-button">
                        <button class="button-find" type="submit">Найти</button>
                    </div>
                </form>
            </div>
			<? /*<div class="header__phone"><a href="+74951060089">+7 (495) 106-00-89</a></div>*/ ?>
        </div>
    </div>
<? endif ?>
<? if ($page == 'main'): ?>
    <main>
        <div class="main-page container">
            <div class="inner group">

<? elseif ($APPLICATION->GetCurDir() == '/location/' && empty($_GET['location'])): ?>
    <main>
        <div class="page container">
            <div class="inside group">
                <div class="metro-stations">
<? else: ?>
    <main>
        <div class="page container">
            <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "template", array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0"
            ),
                false,
                array(
                    "ACTIVE_COMPONENT" => "N"
                )
            ); ?>
            <? $APPLICATION->ShowViewContent('head_block'); ?>
            <div class="inside group">
                <div class="page__content">
                    <div class="content">
<? endif ?>
                                                