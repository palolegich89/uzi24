<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", 'Добавить клинику на сайт "УЗИ круглосуточно". Изучайте цены и выбирайте лучший вариант. Актуальные адреса и номера телефонов для записи на УЗИ. Доступна онлайн-запись.');
$APPLICATION->SetPageProperty("title", "Добавить клинику на сайт УЗИ Круглосуточно");
$APPLICATION->SetTitle("Добавить клинику");
?><h1>Добавить клинику</h1>
<p>Если Вы являетесь владельцем или управляющим клиники, режим которой 24 часа, и хотели бы видеть её в нашем каталоге, то заполните форму ниже. После рассмотрения заявки нашими администраторами, мы разместим её в нашем каталоге.</p>

<?

if(!empty($_POST)) {

	if(!empty($_POST['name']) && !empty($_POST['email'])) {

			$to = "seotorium@yandex.ru";

			/* тема/subject */
			$subject = "Заявка на добавление клиники";

			/* сообщение */
			$message = '<p><b>Имя:</b> '.$_POST['name'].'</p>'; 
			$message .= '<p><b>E-mail:</b> '.$_POST['email'].'</p>';
			$message .= '<p><b>Телефон:</b> '.$_POST['phone'].'</p>';
			$message .= '<p><b>Компания:</b> '.$_POST['company'].'</p>';
			$message .= '<p><b>URL сайта:</b> '.$_POST['url'].'</p>';
			$message .= '<p><b>Комментарий:</b> '.$_POST['mess'].'</p>';
			
			/* Для отправки HTML-почты вы можете установить шапку Content-type. */
			$headers= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=UTF-8\r\n";
			
			/* дополнительные шапки */
			$headers .= "From: Info <info@uzi24.ru>";

			/* и теперь отправим из */
			mail($to, $subject, $message, $headers);

			$end = 'Y';

		
	} else {

		if(empty($_POST[1])) {
			echo '<p style="font-size: 16px; color: red;  margin-bottom: 10px" >Заполните поле "Ваше имя"</p>';
		}
		
		if(empty($_POST[7])) {
			echo '<p style="font-size: 16px; color: red;  margin-bottom: 10px" >Заполните поле "E-mail"</p>';
		}	
		
		$end = 'N';

	}

}
?>

<?if($end == 'Y'):?>

	<div class="message-uniform">
			<p>Ваша заявка отправлена, ожидайте звонка менеджера.</p>
	</div>

<?else:?>

	<form class="form" method="post" action="/add-clinic/">

	  <input type="text" name="name" placeholder="Ваше имя">
	  
	  <input type="text" name="email" placeholder="Ваш e-mail">
	  
	  <input type="tel" name="phone" placeholder="Контактный телефон">
	  
	  <input type="text" name="company" placeholder="Компания">
	  
	  <input type="text" name="url" placeholder="URL сайта">
	  
	  <textarea name="mess" placeholder="Введите Ваш комментарий"></textarea>
	  
	  <button class="button-add" type="submit">Отправить</button>
	  
	</form>

<?endif?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>