<?php
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;

/**
 * Агент для обновления HL-блока SEO метро.
 *
 * Функция обновляет HL-блок, подсчитывая для каждого метро количество клиник,
 * привязанных к нему (свойство METRO в инфоблоке клиник). Если для метро
 * найдено менее 3 клиник, то для соответствующей HL-записи устанавливается UF_ACTIVE = false.
 *
 * @return string Строка вызова агента для повторного запуска.
 */
function updateMetroSeoHLAgent()
{
    // Подключаем необходимые модули
    if (!Loader::includeModule("iblock") || !Loader::includeModule("highloadblock")) {
        return "";
    }
    
    // Задайте ID инфоблоков и HL-блока (замените на актуальные значения)
    $metroIblockID   = 1; // Инфоблок метро
    $clinicsIblockID = 8; // Инфоблок клиник
    $hlblockID       = 2; // HL-блок для SEO метро
    
    // Получаем данные HL-блока по его ID
    $hlblock = HighloadBlockTable::getById($hlblockID)->fetch();
    if (!$hlblock) {
        return "";
    }
    
    // Компилируем сущность HL-блока и получаем DataClass для работы с данными
    $entity = HighloadBlockTable::compileEntity($hlblock);
    $hlDataClass = $entity->getDataClass();
    
    // Собираем количество клиник для каждого метро за один проход
    $metroClinicsCount = [];
    
    // Получаем все активные клиники, у которых задана привязка к метро
    $clinicsRes = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID"       => $clinicsIblockID,
            "ACTIVE"          => "Y",
            // Фильтр: только элементы с непустым значением свойства METRO
            "!PROPERTY_METRO" => false,
        ],
        false,
        false,
        ["ID", "PROPERTY_METRO"]
    );
    while ($clinic = $clinicsRes->Fetch()) {
        // Получаем значения свойства METRO
        $metroValues = isset($clinic["PROPERTY_METRO_VALUE"]) ? $clinic["PROPERTY_METRO_VALUE"] : null;
        if ($metroValues === null) {
            continue;
        }
        // Если значение не является массивом, приводим к массиву
        if (!is_array($metroValues)) {
            $metroValues = [$metroValues];
        }
        // Для каждого привязанного метро увеличиваем счётчик
        foreach ($metroValues as $metroId) {
            $metroId = intval($metroId);
            if ($metroId <= 0) {
                continue;
            }
            if (!isset($metroClinicsCount[$metroId])) {
                $metroClinicsCount[$metroId] = 0;
            }
            $metroClinicsCount[$metroId]++;
        }
    }
    
    // Получаем все активные элементы метро
    $metroRes = CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => $metroIblockID,
            "ACTIVE"    => "Y"
        ],
        false,
        false,
        ["ID", "NAME"]
    );
    while ($metro = $metroRes->Fetch()) {
        $metroId = intval($metro["ID"]);
        // Получаем количество клиник, привязанных к данному метро (если нет – 0)
        $clinicCount = isset($metroClinicsCount[$metroId]) ? $metroClinicsCount[$metroId] : 0;
        // Если количество клиник меньше 3, флаг активности устанавливаем в false
        $active = ($clinicCount >= 3);
        
        // Проверяем, существует ли уже запись в HL-блоке для данного метро (по полю UF_METRO)
        $hlResult = $hlDataClass::getList([
            "filter" => ["UF_METRO" => $metroId],
            "limit"  => 1,
        ]);
        if ($hlData = $hlResult->fetch()) {
            // Запись найдена – обновляем данные
            $hlDataClass::update($hlData["ID"], [
                "UF_CLINICS_COUNT" => $clinicCount,
                "UF_ACTIVE"        => $active,
            ]);
        } else {
            // Записи нет – создаем новую
            $hlDataClass::add([
                "UF_METRO"      => $metroId,
                "UF_CLINICS_COUNT" => $clinicCount,
                "UF_ACTIVE"        => $active,
            ]);
        }
    }
    
    // Возвращаем строку вызова агента для повторного запуска
    return "updateMetroSeoHLAgent();";
}
?>
