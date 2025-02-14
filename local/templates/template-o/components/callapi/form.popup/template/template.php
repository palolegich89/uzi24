<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<input type="button" value="<?=$arParams["BUTTON_TEXT"]?>" class="callapi-popup callapi-popup-show-<?=$arParams["ID"]?>">
<div class="callapi-popup-content-<?=$arParams["ID"]?>" style="display:none">
	<div class="form">	
         <p>Оставьте номер, мы вам перезвоним!</p>
        <hr>
        <form class="callapi-form-<?=$arParams["ID"]?>">
            <input type="text" name="phone" placeholder="Телефон">
            <button class="submit">Отправить</button>
	        <div class="report"></div>
            
			<input type="hidden" name="PARAMS" value='<?=json_encode($arParams)?>'>
        </form>
  	</div>
</div>
<script>
$( document ).ready(function() {
	var popupConfig = {
		"ajax" : "<?=$templateFolder?>/form.php",
		"button" : ".callapi-popup-show-<?=$arParams["ID"]?>",
		"form": ".callapi-popup-content-<?=$arParams["ID"]?>",
		"action": ".callapi-form-<?=$arParams["ID"]?>",
		};
	var popup = new Popup(popupConfig);
});
</script>