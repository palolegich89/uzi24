<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контент");
?>


<h1>Заголовок первого уровня</h1>
<p>
  Первый абзац текста которые состоит из нескольких слов, а слова состоят из букв. Поэтому и получаетсявот такой вот забавный текст. Данный текст написан для пример, чтобы показать как он будет выглядеть на сайте. <a href="#">Ссылка в тексте</a>
</p>
<p>
  Второй абзац текст которые состоит из нескольких слов, а слова состоят из букв. Поэтому и получаетсявот такой вот забавный текст. Данный текст написан для пример, чтобы показать как он будет выглядеть на сайте
  и какой отступ задан между абзацами.
</p>
<h2>Заголовок второго уровня</h2>
<p>
  Первый абзац текста которые состоит из нескольких слов, а слова состоят из букв. Поэтому и получаетсявот такой вот забавный текст. Данный текст написан для пример, чтобы показать как он будет выглядеть на сайте. <a href="#">Ссылка в тексте</a>
</p>
<h3>Заголовок третьего уровня</h3>
<p>
  Первый абзац текста которые состоит из нескольких слов, а слова состоят из букв. Поэтому и получаетсявот такой вот забавный текст. Данный текст написан для пример, чтобы показать как он будет выглядеть на сайте.
  Если необходимо выделить текст болдом, то это выглядит <b>вот так</b>.
</p>
<p>Далее идёт маркированный список:</p>
<ul>
  <li>Элемент 1.</li>
  <li>Элемент 2.</li>
  <li>Элемент 3.</li>
</ul>
<p>Далее идёт мнумерованный список:</p>
<ol>
  <li>Элемент 1.</li>
  <li>Элемент 2.</li>
  <li>Элемент 3.</li>
</ol>
<form class="form">
  <h4>Элементы форм для некоторых страниц</h4>
  <input type="text" name="name" placeholder="Ваше имя">
  <input type="tel" name="phone" placeholder="Контактный телефон">
  <textarea name="mess" placeholder="Введите Ваше сообщение"></textarea>
  <button class="button-find" type="submit">Отправить</button>
</form>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>