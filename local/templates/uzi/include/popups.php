<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>
<div class="overlay"></div>

<div class="js-record record-form popup form" id="record-popup">
    <div>
        <div class="h2">Запись на процедуру</div>

        <form method="post" class="js-form" id="recordForm">
            <input type="hidden" name="record_type" value="clinic">
            <input type="hidden" name="clinic" value="">
            <input type="hidden" name="doctor" value="">
            <input type="hidden" name="slot" value="">
            <input type="hidden" name="date" value="">

            <input required="" class="input-text" type="text" name="name"
                           placeholder="Ваше имя">
            <input required="" class="input-text input-phone" name="phone" type="tel"
                           placeholder="__ (___) ___-__-__">

<!--            <input type="text" name="comment" class="input-text" placeholder="Введите комментарий">-->
            <div class="pp-hint">
                После отправки данных с Вами свяжется оператор клиники для подтверждения записи.
            </div>

            <div class="input-col clear sms-validate" style="display:none">
                <input required class="input-text" name="validationCode" type="text"
                           placeholder="Код из смс-сообщения">
            </div>
            <div class="pp-hint sms-validate-error style-error" style="display:none">
                Введен неверный код активации, попробуйте еще раз.
            </div>

            <div class="pp-hint pp-error style-error"></div>

            <button disabled class="button btn-disabled js-submit-btn-record button-add" data-request="/ajax/records_docdoc.php">
                Записаться
            </button>

<!--            <div class="center">-->
<!--                <p>Для записи в клинику Вы также можете позвонить по телефону</p>-->
<!--                <span id="phonePopup">-->
<!--                    <a class="phone-link" href="tel:+74951518866">+7 (495) 151-88-66</a>-->
<!--                </span>-->
<!--            </div>-->
            <div class="center">
                Нажимая «Записаться», я принимаю
                <a href="/user-agreement.pdf" class="user-agreement" target="_blank">условия пользовательского
                    соглашения</a>
                и даю свое согласие на обработку персональных данных.
            </div>
        </form>
    </div>
</div>