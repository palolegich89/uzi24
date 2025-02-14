
	<?if($page != 'main' && $APPLICATION->GetCurDir() != '/location/' && empty($_GET['location'])):?>
			</div>
		</div>
		  <aside class="page__sidebar">
			<?/*
			<div class="page__service text-center"><img class="img-responsive center-block img-circle" src="/images/img2.png" alt="">
			  <p>минимальная стоимость УЗИ в Коньково <span>1 200 руб.</span>
			  </p>
			</div>
			*/?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"template_list_services", 
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "N",
					"CHECK_DATES" => "Y",
					"COMPONENT_TEMPLATE" => "template_list_services",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "N",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "N",
					"DISPLAY_PREVIEW_TEXT" => "N",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "4",
					"IBLOCK_TYPE" => "services",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "999",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "PARENT",
						1 => "",
					),
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"STRICT_SECTION_CHECK" => "N"
				),
				false
			);?>
		  </aside>
		</div>
	  </div>
	<?elseif(strstr($APPLICATION->GetCurDir(), '/location/') && !empty($_GET['location'])):?>
		</div>
			</div>
		  <aside class="page__sidebar">
			<?/*
			<div class="page__service text-center"><img class="img-responsive center-block img-circle" src="/images/img2.png" alt="">
			  <p>минимальная стоимость УЗИ в Коньково <span>1 200 руб.</span>
			  </p>
			</div>
			*/?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"template_list_services", 
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "N",
					"CHECK_DATES" => "Y",
					"COMPONENT_TEMPLATE" => "template_list_services",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "N",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "N",
					"DISPLAY_PREVIEW_TEXT" => "N",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "4",
					"IBLOCK_TYPE" => "services",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "N",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "999",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "PARENT",
						1 => "",
					),
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"STRICT_SECTION_CHECK" => "N"
				),
				false
			);?>
		  </aside>
				</div>
	<?endif?>
	</main>
	<footer class="footer container">
	  <div class="inner group">
		<div class="footer__desc">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => "/include/footer_text.php"
				)
			);?>
		</div>
			<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", Array(
				"ROOT_MENU_TYPE" => "bottom",	// Тип меню для первого уровня
					"MENU_CACHE_TYPE" => "N",	// Тип кеширования
					"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
					"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
					"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
					"MAX_LEVEL" => "1",	// Уровень вложенности меню
					"CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
					"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
					"DELAY" => "Y",	// Откладывать выполнение шаблона меню
					"ALLOW_MULTI_SELECT" => "Y",	// Разрешить несколько активных пунктов одновременно
				),
				false
			);?>
			 
	  </div>
	</footer>
<?
	$metro_stations = array();
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog"); 
	$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "NAME", "CODE"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$metro_stations[] = $arFields['NAME'];
		$metro_stations_code[] = $arFields['CODE'];
	}

	$rayon_name = array();
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog"); 
	$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "NAME", "CODE"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$rayon_name[] = $arFields['NAME'];
		$rayon_code[] = $arFields['CODE'];
	}

	if(!empty($_GET['location']) && !strstr($_GET['location'], '_okrug')) {
		
		if(strstr($_GET['location'], '_metro')) {
			$display_value = str_replace("_metro", "", $_GET['location']);
		} elseif(strstr($_GET['location'], '_rayon')) {
			$display_value = str_replace("_rayon", "", $_GET['location']);
		} else {
			$display_value = $_GET['location'];
		}
		
		$search_key = array_search($display_value, $rayon_code);
		
		if(!empty($search_key)) {
			$display_value = $rayon_name[$search_key];
		} else {
			$search_key = array_search($display_value, $metro_stations_code);
			$display_value = $metro_stations[$search_key];
		}

	}
?>
	<script>
	var availableTags = [
		<?foreach($metro_stations as $key => $value):?>
			"метро <?=$value;?>",
		<?endforeach;?>
		<?foreach($rayon_name as $key => $value):?>
			"район <?=$value;?>",
		<?endforeach;?>
	];
		
	var availableTags_code = [
		<?foreach($metro_stations_code as $key => $value):?>
			"<?=$value;?>_metro",
		<?endforeach;?>
		<?foreach($rayon_code as $key => $value):?>
			"<?=$value;?>_rayon",
		<?endforeach;?>
	];		

	$( "#tags" ).autocomplete({source: availableTags});

	$(document).ready(function() {
			$(".page__sidebar-nav ul li ul li.active").each(function(index, value){
			  
			  //$(this).removeClass('active');
			  $(this).parent().parent().addClass('active');

			});

			$('#tags').keyup(function(){
			  
			  var value = $('#tags').val();
			  
			  //value = value.charAt(0).toUpperCase() + value.substr(1).toLowerCase();
			  
			  if (availableTags.indexOf( value ) != -1) {
				if(!$('#tags').hasClass('complete')) {
					$('#tags').addClass('complete');
					var index = availableTags.indexOf(value);
					$('#tags').attr('data-value', availableTags_code[index]);
				}
			  } else {
				$('#tags').removeClass('complete');
			  }

			});
			
			$(document).on('click', '.ui-menu-item a', function(e) {
			  
			  var value = $('#tags').val();
			  
			  //value = value.charAt(0).toUpperCase() + value.substr(1).toLowerCase();
			  
			  if (availableTags.indexOf( value ) != -1) {
				if(!$('#tags').hasClass('complete')) {
					$('#tags').addClass('complete');
					var index = availableTags.indexOf(value);
					$('#tags').attr('data-value', availableTags_code[index]);
				}
			  } else {
				$('#tags').removeClass('complete');
			  }

			});

			$( ".group .button-find" ).click(function() {
				if(!$('#tags').hasClass('complete')) {
					return false;
				} else {
					var value = $('#tags').attr('data-value');
					$('#tags2').val(value);
					
				}
			});	
		});
	</script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/vendor.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/app.js"></script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47758114 = new Ya.Metrika({
                    id:47758114,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/47758114" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
  </body>
</html>