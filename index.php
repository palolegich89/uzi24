<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Список круглосуточных УЗИ центров. Все виды УЗИ исследований с ценами и телефонами клиник.");
$APPLICATION->SetPageProperty("keywords", "узи, круглосуточно, 24 часа, клиники, диагностические центры");
$APPLICATION->SetPageProperty("title", "УЗИ Круглосуточно - список центров в Москве");
$APPLICATION->SetTitle("Только круглосуточные УЗИ клиники и диагностические центры Москвы и МО");
?>  <div class="how-subscribe group">
	<div class="how-subscribe__image"><img class="img-responsive center-block" src="images/img1.png" alt="УЗИ 24 часа"></div>
	<div class="how-subscribe__text">
	  <article class="how-subscribe__text-one">
	<h2 class="how-subscribe__title">Как записаться на УЗИ</h2>
		<h3 class="how-subscribe__text-one__title">Выбирайте вид УЗИ диагностики</h3>
		<p>
		  Выберите необходимый вид УЗИ диагностики из списка расположенного ниже. Если Вы затрудняетесь с выбором, звоните в ближайший медицинский центр, операторы предоставят самую полную консультацию.</p>
	  </article>
	  <article class="how-subscribe__text-one">
		<h3 class="how-subscribe__text-one__title">Выбирайте клинику</h3>
		<p>На странице УЗИ диагностики выберите центр или клинику, которая наиболее подходит по расположению и по стоимости УЗИ.</p>
	  </article>
	  <article class="how-subscribe__text-one">
		<h3 class="how-subscribe__text-one__title">Записывайтесь на приём 24 часа</h3>
		<p>Звоните по указанному телефону клиники и записывайтесь на УЗИ диагностику в любое удобное время. Все представленные клиники осуществляют запись и приём пациентов круглосуточно.</p>
	  </article>
	</div>
  </div>
  <div class="types" id="types">
	<h3 class="types__title">Виды УЗИ диагностики</h3>
	<?
	$services = array();
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog"); 
	$arFilter = Array("IBLOCK_ID"=>4, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1000), Array("ID", "NAME", "CODE", "PROPERTY_PARENT"));
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$services[] = $arFields;
	}
	
	foreach($services as $key => $value) {
			
		if(!empty($value['PROPERTY_PARENT_VALUE'])) {
				
			foreach($services as $k => $v) {
				if($v['ID'] == $value['PROPERTY_PARENT_VALUE']) {
					
					$services[$k]['CHILDREN'][] = $value;
					unset($services[$key]);
				
				}
			}
			
		}
		
	}  
	?>
	<div class="types__list">
	  <ul class="group">	
		<?foreach($services as $key => $value):?>
		 <li class="type">	
			<p class="type__name"><a href="/services/<?=$value['CODE'];?>/"><?=$value['NAME'];?></a></p>
			<?if(!empty($value['CHILDREN'])):?>
				<p class="type__desc">
					<?foreach($value['CHILDREN'] as $k => $v):?>
						<a href="/services/<?=$v['CODE'];?>/"><?=$v['NAME'];?></a> 
						<?if(($k+1) != count($value['CHILDREN'])):?>
						|
						<?endif?>
					<?endforeach;?>
				</p>
			<?endif?>
		 </li>	
		<?endforeach;?>
	  </ul>
	</div>
  </div>
  <div class="faq group">
	<div class="faq__image"><img class="img-responsive center-block" src="images/img1.png" alt=""></div>
	<div class="faq__questions">
	  <div class="faq__question open">
	<h4 class="faq__title">Частые вопросы про УЗИ</h4>
		<div class="faq__question-title"><a href="#">Что такое УЗИ</a></div>
		<div class="faq__question-answer">
		  <p>
			УЗИ — это неинвазивный метод исследования тканей организма и органов с помощью ультразвуковых волн. Метод позволяет визуализировать на экране параметры внутренних органов человека, оценить кровоток и проходимость сосудов, диагностировать беременность с определением срока и прочее. В основе УЗИ лежит свойство тканей организма отражать ультразвуковые волны.
		  </p>
		</div>
	  </div>
	  <div class="faq__question">
		<div class="faq__question-title"><a href="#">Как проводится УЗИ</a></div>
		<div class="faq__question-answer">
<p>По способу проведения есть несколько разновидностей УЗИ: трансвагинальное, трансабдоминальное, трансректальное, внутриматочное.</p>
<p>При выполнении исследования специалист вводит датчик трансвагинально или трансректально, либо водит датчиком по поверхности кожи пациента. Ультразвуковые волны частично отражаются от тканей организма и улавливаются датчиком, после чего на мониторе отображается модель того или иного органа человека.</p>
		</div>
	  </div>
	  <div class="faq__question">
		<div class="faq__question-title"><a href="#">В чём преимущество УЗИ</a></div>
		<div class="faq__question-answer">
<p>Метод УЗИ позволяет получить точные сведения о состоянии внутренних органов человека, достоверно оценить наличие любых отклонений.</p> 
<p>Важное преимущество УЗИ метода — возможность раннего выявления патологий при отсутствии явной симптоматики.</p> 
<p>Метод УЗИ безопасен и может проводиться неоднократно с целью выявления заболевания, контроля динамики развития, оценки состояния плода при беременности.</p> 
		</div>
	  </div>
	  <div class="faq__question">
		<div class="faq__question-title"><a href="#">Где можно сделать УЗИ круглосуточно</a></div>
		<div class="faq__question-answer">
		  <p>
На нашем портале &laquo;УЗИ Круглосуточно&raquo; собраны только проверенные клиники с высоким рейтингом, которые стабильно получают положительные отзывы. Это позволяет пациентам экономить время на поиск хорошего специалиста, тем более, что можно выбрать клинику по удаленности от метро, в определенном районе, по круглосуточному времени работы. В каждой клинике установлено современное УЗ-оборудование для проведения исследований экспертного класса.
		  </p>
		</div>
	  </div>
	</div>
  </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>