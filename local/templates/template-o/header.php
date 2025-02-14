<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?><!DOCTYPE html>
<html lang="ru">
<head>
	<?
	if(($APPLICATION->GetCurPage() == "/") && ($APPLICATION->GetCurDir() == "/")) {
		$page = 'main';
		GLOBAL $page;
	}
	if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])>0) {
		$APPLICATION->SetPageProperty('pagens', ' – страница '.intval($_GET['PAGEN_1']));
	}
	elseif(isset($_GET['PAGEN_2']) && intval($_GET['PAGEN_2'])>0)
	{
		$APPLICATION->SetPageProperty('pagens', ' – страница '.intval($_GET['PAGEN_2']));
	}
	elseif(isset($_GET['PAGEN_3']) && intval($_GET['PAGEN_3'])>0)
	{
		$APPLICATION->SetPageProperty('pagens', ' – страница '.intval($_GET['PAGEN_3']));
	}
	elseif(isset($_GET['PAGEN_4']) && intval($_GET['PAGEN_4'])>0)
	{
		$APPLICATION->SetPageProperty('pagens', ' – страница '.intval($_GET['PAGEN_4']));
	}
	elseif(isset($_GET['PAGEN_5']) && intval($_GET['PAGEN_5'])>0)
	{
		$APPLICATION->SetPageProperty('pagens', ' – страница '.intval($_GET['PAGEN_5']));
	}
	?>
	<meta charset="utf-8" />
	<title><?$APPLICATION->ShowTitle()?><?=$APPLICATION->GetProperty("pagens");?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?$APPLICATION->ShowLink("canonical", null, true);?>
	<?$APPLICATION->ShowLink('prev', 'prev');?>
	<?$APPLICATION->ShowLink('next', 'next');?>
	<link rel="icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico?v=2" type="image/x-icon" />

	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700|Roboto:300,400,700&amp;amp;subset=cyrillic-ext" rel="stylesheet" />
	<link type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/ui/jqueryui.custom.css" rel="stylesheet" />
	<?/*<link type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/fontawesome-all.min.css" rel="stylesheet" />*/?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery-1.8.3.js"></script>
	<?/*<script src="<?=SITE_TEMPLATE_PATH?>/js/ui/jqueryui.custom.js"></script>*/?>

	<?$APPLICATION->ShowHead();?>

	<script type="text/javascript">
		// <![CDATA[
		jQuery(document).ready(function(){
			jQuery('.spoiler-text').hide()
			jQuery('.spoiler').click(function(){
				jQuery(this).toggleClass("folded").toggleClass("unfolded").prev().slideToggle();
				jQuery(this).css('display', 'none');
				return false;
			})
		})
		// ]]>
	</script>

<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/metahead.php"
	)
);?>
</head>
<body>
<?$APPLICATION->ShowPanel();?>
<?/*if($page == 'main'):?>
		<div class="main-screen container group">
		  <header class="header inner group">
			<a class="header__logo" href="/"></a>
			<div class="header__phone"><a href="tel:<?=DEFAULT_PHONE?>"><?=DEFAULT_PHONE?></a></div>
		  </header>
		  <div class="main-screen__title text-center">
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
		  </div>
		  <div class="main-screen__phone text-center">
			<p class="main-screen__phone-number"><a href="tel:<?=DEFAULT_PHONE?>"><?=DEFAULT_PHONE?></a></p>
			<p>Единый центр записи</p>
		  </div>
		  <div class="main-screen__scroll text-center"><a href="#" scroll-to="#types">Выберите услугу</a></div>
		</div>
	<?else:*/?>
<div class="header container">
	<div class="inside group">
		<a class="header__logo" href="/"></a>
	   <?/* <div class="header__chooser">
				<div class="header__chooser-select">
				  <input type="text" id="tags" name="metro1" data-value="" value="<?=$display_value;?>" placeholder="Выберите метро или район" />
				</div>
				<?
					$tmp_url = $APPLICATION->GetCurDir();

					if(strstr($tmp_url, '/location/')) {
						$pos = strpos($tmp_url, '/location/');
						$url = substr($tmp_url, 0, $pos+1);

					} elseif(strstr($tmp_url, '/services/')) {
						$url = $APPLICATION->GetCurDir();
					} else {
						$url = '/services/';
					}

				?>
				<form class="group" method="get" action="/location/<?//=$url;?>">
					<input type="hidden" id="tags2" name="location" value="" />
					<div class="header__chooser-button">
						<button class="button-find" type="submit">Найти</button>
					</div>
				</form>
			</div>*/?>
			<div class="header__phone add_clin"><a href="/add-clinic/"><i class="fas fa-plus"></i> Добавить клинику</a><?/*<a href="tel:<?=DEFAULT_PHONE?>"><?=DEFAULT_PHONE?></a>*/?></div>
			<div class="header__phone city-marker"><span><i class="fas fa-map-marker-alt"></i> Москва</span></div>
		</div>
	</div>
</div>
<?$APPLICATION->IncludeComponent("bitrix:menu", "template-top-menu", Array(
	"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "top",	// Тип меню для остальных уровней
	"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "Y",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
	"COMPONENT_TEMPLATE" => ".default"
),
	false
);?>

<?/*endif*/?>
<main>
	<div class="<?if($page == 'main'):?>main-page<?else:?>page<?endif?> container">
		<?if($page != 'main'):?>
			<?$APPLICATION->ShowViewContent('head_block_top');?>
			<?$APPLICATION->ShowViewContent('head_block');?>
		<?endif?>
		<?if(!defined("LIKE_MAIN")):?>
		<div class="<?if($page == 'main'):?>inner<?else:?>inside<?endif?> group">
			<?if($page != 'main'):?>
			<div class="page__content<?if(!defined("SHOW_LEFT")):?> width100 no-float<?endif?>">
				<div class="content">
					<?if(!defined("CATALOG")):?>
						<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "template", array(
							"PATH" => "",
							"SITE_ID" => SITE_ID,
							"START_FROM" => "0",
							"COMPONENT_TEMPLATE" => "template"
						),
							false,
							array(
								"ACTIVE_COMPONENT" => "Y"
							)
						);?>
						<h1><?$APPLICATION->ShowTitle(false)?></h1>
					<?endif?>
			 <?endif?>
		 <?endif?>
					