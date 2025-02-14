					<?if(!defined("LIKE_MAIN")):?>
					<?if($page != 'main'):?>
				</div>
			</div>
		<?endif?>
			<?$APPLICATION->ShowViewContent('aside_sidebar');?>
		</div>
	<?endif?>
	  <div class="protivop">ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. ПРОКОНСУЛЬТИРУЙТЕСЬ СО СПЕЦИАЛИСТОМ</div>
	</div>
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
		<div class="footer__desc1">Сайт носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями ч. 2 ст. 437 Гражданского кодекса РФ. Чтобы получить подробную информации о стоимости услуг, обращайтесь, пожалуйста, к администраторам клиник.</div>
	</div>
</footer>

<?/*<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/vendor.js"></script>*/?>
<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/app.js"></script>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/metrika.php"
	)
);?>

<div class="cookie-alert hide">
	<div>Наш ресурс использует cookie. Продолжая пользоваться сайтом, Вы соглашаетесь с использованием файлов cookie.</div>
	<button type="button" class="close">
		<span aria-hidden="true">×</span>
	</button>
</div>
<script>
   $(document).ready(function() {
	 function getCookie(name) {
	     var value = "; " + document.cookie;
	     var parts = value.split("; " + name + "=");
	     if (parts.length == 2) return parts.pop().split(";").shift();
	 }

	 if (getCookie('use_cookie') == undefined) {
	     $('.cookie-alert').removeClass('hide');
	 }

   });

   $('.cookie-alert .close').on('click', function () {
	 $('.cookie-alert').addClass('hide');
	 document.cookie = "use_cookie=1; path=/; max-age=86400000";
   });
</script>

<style type="text/css"> dofollow { display: none; }</style><dofollow>tamil sex movie <a href="https://mojoporn.net" rel="dofollow" title="mojoporn.net">mojoporn.net</a> indian real rape mms
rajesthanisex <a href="https://analpornstars.info" target="_blank">analpornstars.info</a> srilanka sex vidio
rathimoorcha <a href="https://www.borwap.pro/" target="_self" title="borwap.pro tube porn video best">borwap.pro</a> xnxx audio
darna november 7 2022 full episode <a href="https://www.teleseryeheaven.com/" target="_self" title="teleseryeheaven.com daig kayo ng lola ko 2022">teleseryeheaven.com</a> almost paradise episodes
sexy video borivali <a href="https://xkeezmovies.mobi" rel="dofollow" target="_self" title="xkeezmovies.mobi">xkeezmovies.mobi</a> free model sex video
</dofollow>
<style type="text/css"> dofollow { display: none; }</style><dofollow>kolkata ka randi <a href="https://dungtube.info" rel="dofollow" title="dungtube.info gay porn hd online">dungtube.info</a> sushma raj hot
chennai sex video <a href="https://tubzolina.com" target="_blank" title="tubzolina.com">tubzolina.com</a> hotmalayalamsex
bf photo sexy photo <a href="https://anybunny.mobi" rel="dofollow" target="_self" title="anybunny.mobi">anybunny.mobi</a> kanda sex video
www indai xxx com <a href="https://tubezaur.mobi" rel="dofollow" target="_self">tubezaur.mobi</a> www.oldman sex.com
recent indian porn videos <a href="https://www.porningo.com/" target="_self">porningo.com</a> gand mara video
</dofollow>
<style type="text/css"> dofollow { display: none; }</style><dofollow>سكس جسم نار <a href="https://teenpornwatch.net/" title="teenpornwatch.net كارتر كرويز">teenpornwatch.net</a> سكس فض بكارة
لبنانية تتناك <a href="https://arabianporns.com/" rel="dofollow" title="arabianporns.com">arabianporns.com</a> فيديونيك
سكس فى المحل <a href="https://www.okunitani.com/" title="okunitani.com">okunitani.com</a> سكس رعشه
telugu sex videos local <a href="https://top-porn-tube.com">top-porn-tube.com</a> hottest sex vedios
افلام جنس تركي <a href="https://www.hardpornx.net/" target="_blank" title="hardpornx.net">hardpornx.net</a> تتناك امام زوجها
</dofollow>

</body>
</html><?
if(defined("SHOW_LEFT_MENU") && SHOW_LEFT_MENU == true && ERROR_404 != "Y"){
	/***********
	 * Разделы *
	 ***********/
	CModule::IncludeModule('iblock');
	$arFilter = Array("IBLOCK_ID"=>IntVal(IB_CONTENT), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "DEPTH_LEVEL"=>1);
	$rs_section = CIBlockSection::GetList(Array("LEFT_MARGIN" => "ASC"), $arFilter, true, Array("UF_*"));
	while($ar_section = $rs_section->Fetch())
	{
		$arResult["SECTIONS"][$ar_section["ID"]] = $ar_section;
		if($SECTION_ID == $ar_section["ID"]){
			$arResult["SECTIONS"][$ar_section["ID"]]["SELECTED"] = true;
		}
	}
	?>
	<?ob_start();?>
	<div class="page__sidebar">
		<h4 class="page__sidebar-title">Услуги</h4>
		<nav class="page__sidebar-nav">
			<ul>
				<?foreach($arResult["SECTIONS"] as $key => $value):?>
					<li <?if($value['SELECTED'] == true):?>class="active"<?endif?> ><a href="/<?=$value['CODE'];?>/"><?=$value['NAME'];?></a>
						<?if(!empty($value['ITEMS'])):?>
							<ul>
								<?foreach($value['ITEMS'] as $k => $v):?>
									<li <?if($v['SELECTED'] == true):?>class="active"<?endif?>><a href="<?=$v['DETAIL_PAGE_URL'];?>"><?=$v['NAME'];?></a></li>
								<?endforeach;?>
							</ul>
						<?endif?>
					</li>
				<?endforeach?>
			</ul>
		</nav>
	</div>
	<?$aside_sidebar = ob_get_contents();
	ob_end_clean();
	$APPLICATION->AddViewContent('aside_sidebar', $aside_sidebar);
}?>