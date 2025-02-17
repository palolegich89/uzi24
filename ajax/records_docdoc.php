<?php
declare(strict_types=1);

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

use Bitrix\Main\Application;

$request = Application::getInstance()->getContext()->getRequest();
$post_list = $request->getPostList();

$docdoc_login = DOCDOC_LOGIN;
$docdoc_pass = DOCDOC_PASS;

$url = 'https://' . $docdoc_login . ':' . $docdoc_pass . '@api.docdoc.ru/public/rest/1.0.12/request';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if (!empty($post_list['record_type'])) {
    $post = [
        'name' => $post_list['name'],
        'phone' => $post_list['phone'],
        'clinic' => $post_list['clinic'],
    ];

    if (!empty($post_list['comment'])) {
        $post['comment'] = $post_list['comment'];
    }

    if ($post_list['record_type'] === 'doctor') {
        $post['doctor'] = $post_list['doctor'];
    }

    $preOrder = false;
    $order = false;
    $arOrderPost = [];

    // Поля предзаявки
    if (empty($post_list['validationCode'])) {
        $preOrder = true;
        $arOrderPost = [
            'validate' => 1,
            'name' => $post_list['name'],
            'phone' => $post_list['phone'],
            'clinic' => $post_list['clinic'],
            'city' => 1,
            'stations' => [],
            'dateAdmission' => $post_list['admission'],
        ];
        $post = $arOrderPost;
    }

    // Поля заявки
    if (!empty($post_list['validationCode'])) {
        $order = true;
        $preOrder = false;
        $arOrderPost = [
            'name' => $post_list['name'],
            'phone' => $post_list['phone'],
            'clinic' => $post_list['clinic'],
            'city' => 1,
            'stations' => [],
            'validationCode' => $post_list['validationCode'],
            'requestId' => $post_list['requestId'],
        ];
        $post = $arOrderPost;
    }

    $json = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    $retValue = curl_exec($ch);
    if ($retValue === false) {
        echo json_encode(['status' => 'fail', 'message' => 'Ошибка при выполнении запроса к API']);
        die();
    }

    $response = json_decode($retValue, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['status' => 'fail', 'message' => 'Ошибка при декодировании ответа API']);
        die();
    }

    if ($preOrder) {
        if ($response['Response']['status'] === 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'Создана предзаявка',
                'info' => $response,
                'action' => 'preOrder',
                'requestId' => $response['Response']['id'],
                'error_message' => $response['Response']['message']
            ]);
        } else {
            echo json_encode([
                'status' => 'fail',
                'message' => '(Предзаявка) Что-то пошло не так, попробуйте еще раз.',
                'info' => $response,
                'error_message' => $response['Response']['message']
            ]);
        }
        die();
    } elseif ($order) {
        if ($response['Response']['status'] === 'success') {
            $dateAdmissionTimeStamp = strtotime($arOrderPost['dateAdmission']);
            $printDateAdmission = date("d.m.Y H:i", $dateAdmissionTimeStamp);

            CModule::IncludeModule("iblock");

            $arSelect = ["NAME"];
            $arFilter = ["IBLOCK_ID" => 107, "PROPERTY_CLINIC_ID" => (int)$arOrderPost['clinic']];
            $res = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);
            $arClinic = [];
            if ($ob = $res->GetNextElement()) {
                $arClinic = $ob->GetFields();
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Спасибо за запись!<br>Ваша заявка на запись №' . (int)$arOrderPost['requestId'] . ' отправлена в клинику «' . $arClinic["NAME"] . '». Желаемое время приема ' . $printDateAdmission . '. Заявка будет обработана в течение 10 минут. Дождитесь смс с подтверждением записи.',
                'info' => $response,
                'post' => $post,
                'action' => 'orderDone',
                'error_message' => $response['Response']['message']
            ]);
        } elseif ($response['Response']['status'] === 'error' && $response['Response']['message'] === "Неправильный код валидации") {
            echo json_encode(['status' => 'success', 'message' => 'Неправильный код валидации', 'info' => $response, 'action' => 'smsNotValid', 'error_message' => $response['Response']['message']]);
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Что-то пошло не так, попробуйте еще раз.', 'info' => $response, 'error_message' => $response['Response']['message']]);
        }
        die();
    } else {
        if ($response['Response']['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => 'Ваша заявка принята', 'error_message' => $response['Response']['message']]);
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'Что-то пошло не так, попробуйте еще раз.', 'error_message' => $response['Response']['message']]);
        }
        die();
    }
}
