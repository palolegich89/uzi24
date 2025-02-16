<?

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\Loader;

/**
 * Получение элементов из хайлоадблока с возможностью рандомной выборки.
 *
 * @param int    $blockId    ID хайлоадблока.
 * @param string $nameValue  Имя поля для фильтрации.
 * @param mixed  $listFilter Значение для фильтрации.
 * @param int    $limit      Лимит выборки (по умолчанию 999).
 * @param string $order      Поле для сортировки (если не рандомная выборка).
 * @param string $orderLine  Направление сортировки (ASC или DESC).
 * @param bool   $random     Если true, выборка будет выполнена в случайном порядке.
 *
 * @return array Массив элементов, индексированный по ID.
 */
function getHlel(
	int    $blockId,
	string $nameValue,
	       $listFilter,
	int    $limit = 999,
	string $order = 'ID',
	string $orderLine = 'ASC',
	bool   $random = false
): array
{
	// Подключаем модуль highloadblock
	if (!Loader::includeModule('highloadblock')) {
		return [];
	}

	// Проверяем корректность ID блока
	if ($blockId < 1) {
		return [];
	}

	$elements = [];

	// Получаем информацию о хайлоадблоке
	$hlblock = HighloadBlockTable::getById($blockId)->fetch();
	if (!$hlblock) {
		return [];
	}

	// Компилируем сущность
	$entity = HighloadBlockTable::compileEntity($hlblock);
	$entityDataClass = $entity->getDataClass();

	// Формируем параметры запроса
	$params = [
		'select' => ['*'],
		'limit' => $limit,
		'filter' => [$nameValue => $listFilter],
	];

	if ($random) {
		// Добавляем вычисляемое поле для случайной сортировки
		$params['runtime'] = [
			new ExpressionField('RAND', 'RAND()'),
		];
		$params['order'] = ['RAND' => 'ASC'];
	} else {
		$params['order'] = [$order => $orderLine];
	}

	// Выполняем запрос
	$rsData = $entityDataClass::getList($params);

	while ($element = $rsData->fetch()) {
		$elements[(int)$element['ID']] = $element;
	}

	return $elements;
}


function gethlelarray($block_id, $filter, $limit = 999, $order = "ID", $order_line = "ASC")
{
	if (CModule::IncludeModule("highloadblock")) {
		if (!empty($block_id) || $block_id >= 1) {
			$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($block_id)->fetch();
			$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();

			$rsData = $entity_data_class::getList(array(
				'select' => array('*'),
				'order' => array($order => $order_line),
				'limit' => $limit,
				'filter' => $filter
			));
			while ($element = $rsData->fetch()) {
				$elements[$element["ID"]] = $element;
			}
			return $elements;
		} else {
			return [];
		}
	}
}

class cExtendedHL
{
	function getEntityDataClass($HLBID)
	{
		if (CModule::IncludeModule("highloadblock")) {
			$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($HLBID)->fetch();
			$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
			$entity_data_class = $entity->getDataClass();
			return $entity_data_class;
		}
	}
}

function getarrayhl($filter_value, $filter = array())
{
	if (CModule::IncludeModule("highloadblock")) {
		$result = array();

		$rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('TABLE_NAME' => $filter_value)));
		if (!($arData = $rsData->fetch())) {
			echo 'Инфоблок не найден';
		}
		$Entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arData);
		$DataClass = $Entity->getDataClass();
		$parametrs = array(
			'select' => array("*"),
			'filter' => $filter,
		);
		$rsOffices = $DataClass::GetList($parametrs);
		while ($arOffice = $rsOffices->Fetch()) {
			$result[$arOffice["ID"]] = $arOffice;
		}

		return $result;
	}
}

function pre_dump($array)
{
	$USER = new CUser();
	if ($USER->IsAdmin()) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
}

//print_r(array_sort($people, 'age', SORT_DESC)); // Sort by oldest first
//print_r(array_sort($people, 'surname', SORT_ASC)); // Sort by surname
function array_sort($array, $on, $count, $order = SORT_ASC)
{
	$new_array = array();
	$sortable_array = array();
	$key = 0;

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v) && $key < $count) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} elseif ($key < $count) {
				$sortable_array[$k] = $v;
			}
			$key++;
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
				break;
			case SORT_DESC:
				arsort($sortable_array);
				break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}

	return $new_array;
}

function record_sort($records, $field, $reverse = false)
{
	$hash = array();

	foreach ($records as $record) {
		$hash[$record[$field]] = $record;
	}

	($reverse) ? krsort($hash) : ksort($hash);

	$records = array();

	foreach ($hash as $record) {
		$records[] = $record;
	}

	return $records;
}

// Склонение
function clinic24ToStr($count)
{
	$str = '';
	$num = $count > 100 ? substr($count, -2) : $count;
	if ($num >= 5 && $num <= 14) {
		$pre_count = "найдено";
		$str = "круглосуточных клиник";
	} else {
		$pre_count = "найдено";
		$num = substr($count, -1);
		if ($num == 0 || ($num >= 5 && $num <= 9)) $str = 'круглосуточных клиник';
		if ($num == 1) $pre_count = "найдена";
		$str = 'круглосуточная клиника';
		if ($num >= 2 && $num <= 4) $str = 'круглосуточных клиники';
	}
	return $pre_count . ' ' . $count . ' ' . $str;
}

function clinicToStr($count)
{
	$str = '';
	$num = $count > 100 ? substr($count, -2) : $count;
	if ($num >= 5 && $num <= 14) {
		$pre_count = "найдено";
		$str = "диагностических центров";
	} else {
		$pre_count = "найдено";
		$num = substr($count, -1);
		if ($num == 0 || ($num >= 5 && $num <= 9)) $str = 'диагностических центров';
		if ($num == 1) $pre_count = "найден";
		$str = 'диагностический центр';
		if ($num >= 2 && $num <= 4) $str = 'диагностических центра';
	}
	return $pre_count . ' ' . $count . ' ' . $str;
}

// Поиск ID элемента или секции по символьному коду
function getIdByCode($code, $iblock_id, $type)
{
	if (CModule::IncludeModule("iblock")) {
		if ($type == 'IBLOCK_ELEMENT') {
			$arFilter = array("IBLOCK_ID" => $iblock_id, "CODE" => $code);
			$res = CIBlockElement::GetList(array(), $arFilter, false, array("nPageSize" => 1), array('ID'));
			$element = $res->Fetch();
			if ($res->SelectedRowsCount() != 1) return false;
			else return $element['ID'];
		} else if ($type == 'IBLOCK_SECTION') {
			$res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $iblock_id, 'CODE' => $code));
			$section = $res->Fetch();
			if ($res->SelectedRowsCount() != 1) return false;
			else return $section['ID'];
		} else {
			echo '<p style="font-weight:bold;color:#ff0000">Укажите тип</p>';
			return;
		}
	}
}

// Склонение количества клиник
function ClinToStr($count, $set_skl2 = false)
{
	$str = '';
	$num = $count > 100 ? substr($count, -2) : $count;
	if ($num >= 5 && $num <= 14) {
		$str = "клиник";
	} else {
		$num = substr($count, -1);
		if ($num == 0 || ($num >= 5 && $num <= 9)) $str = 'клиник';
		if ($num == 1) ($set_skl2) ? $str = 'клиника' : $str = 'клинику';
		if ($num >= 2 && $num <= 4) $str = 'клиники';
	}
	return $count . ' ' . $str;
}

// рисуем полные и пустые звезды
function echoStars($default = 3, $max = 5)
{
	for ($i = 1; $i <= $max; $i++) {

		$class = '';

		if (($i >= $default) && ($i - $default > 0.6)) {
			$class = 'empty';
		}

		echo '<li class="' . $class . '"></li>';
	}
}

/**
 * Преобразует JSON-строку с расписанием в удобочитаемое описание.
 *
 * Если в расписании присутствует запись с Day="0" (пн–пт), она выводится как есть.
 * Остальные записи (например, для сб и вс) группируются по интервалу времени и выводятся с диапазоном дней,
 * если они идут подряд.
 *
 * Пример для JSON:
 * [{"Day":"0","StartTime":"08:00","EndTime":"22:00","DayTitle":"пн-пт"},
 *  {"Day":"6","StartTime":"08:00","EndTime":"22:00","DayTitle":"сб"},
 *  {"Day":"7","StartTime":"08:00","EndTime":"22:00","DayTitle":"вс"}]
 *
 * Ожидаемый результат:
 * "пн-пт с 08:00 до 22:00, Сб-Вск с 08:00 до 22:00"
 *
 * @param string $json JSON-строка с расписанием.
 *
 * @return string Отформатированное расписание.
 */
function formatSchedule(string $json): string
{
	$data = json_decode($json, true);
	if (!is_array($data) || empty($data)) {
		return '';
	}

	// Разделяем записи: специальные (с Day = "0") и обычные (с конкретным днем)
	$special = []; // для записей с Day = "0" (например, "пн-пт")
	$normal = []; // для остальных (например, сб, вс)

	foreach ($data as $entry) {
		if ($entry['Day'] === "0") {
			$special[] = $entry;
		} else {
			$normal[] = $entry;
		}
	}

	$outputs = [];

	// Вывод для специальной группы: используем значение DayTitle как задано (например, "пн-пт")
	foreach ($special as $entry) {
		$outputs[] = "{$entry['DayTitle']} с {$entry['StartTime']} до {$entry['EndTime']}";
	}

	// Группируем обычные записи по интервалу времени
	$normalGroups = [];
	foreach ($normal as $entry) {
		$intervalKey = $entry['StartTime'] . '-' . $entry['EndTime'];
		if (!isset($normalGroups[$intervalKey])) {
			$normalGroups[$intervalKey] = [];
		}
		$normalGroups[$intervalKey][] = $entry;
	}

	// Стандартное отображение для обычных дней
	$dayMapping = [
		1 => 'Пн',
		2 => 'Вт',
		3 => 'Ср',
		4 => 'Чт',
		5 => 'Пт',
		6 => 'Сб',
		7 => 'Вск'
	];

	foreach ($normalGroups as $interval => $entries) {
		// Сортируем записи по числовому значению дня
		usort($entries, function ($a, $b) {
			return ((int)$a['Day']) - ((int)$b['Day']);
		});
		// Извлекаем номера дней
		$days = array_map(function ($entry) {
			return (int)$entry['Day'];
		}, $entries);

		// Если более одной записи — выводим диапазон (например, "Сб-Вск")
		if (count($days) > 1) {
			$firstDay = $days[0];
			$lastDay = $days[count($days) - 1];
			$dayStr = $dayMapping[$firstDay] . '-' . $dayMapping[$lastDay];
		} else {
			$dayStr = $dayMapping[$days[0]];
		}

		// Все записи в группе имеют одинаковый интервал, поэтому берем время из первой записи
		$startTime = $entries[0]['StartTime'];
		$endTime = $entries[0]['EndTime'];
		$outputs[] = "{$dayStr} с {$startTime} до {$endTime}";
	}

	return implode(', ', $outputs);
}

/**
 * Возвращает описание рабочего времени на текущий день с указанием статуса.
 * Если сегодня рабочий день, для него берётся запись с Day="0" (пн–пт),
 * а для выходных — ищется соответствующая запись (Day="6" или "7").
 *
 * Примеры результатов:
 *   "Работает с 08:00 до 22:00 (сейчас открыто)"
 *   "Работает с 08:00 до 22:00 (сейчас закрыто)"
 *   "Сегодня закрыто" – если для текущего дня расписание отсутствует.
 *
 * @param string $json JSON-строка с расписанием.
 *
 * @return string Описание для текущего дня.
 */
function getTodaySchedule(string $json): string
{
	$schedule = json_decode($json, true);
	if (!is_array($schedule)) {
		return "Сегодня закрыто";
	}

	// Получаем текущий день недели (1 = Пн, …, 7 = Вс)
	$currentDayNum = (int)date('N');
	// Если сегодня Пн–Пт, то ищем запись с Day="0"
	if ($currentDayNum >= 1 && $currentDayNum <= 5) {
		$searchDay = "0";
	} else {
		// Сб (6) или Вс (7)
		$searchDay = (string)$currentDayNum;
	}

	$entry = null;
	foreach ($schedule as $item) {
		if ($item['Day'] === $searchDay) {
			$entry = $item;
			break;
		}
	}

	if (!$entry) {
		return "Сегодня закрыто";
	}

	$startTime = $entry['StartTime'];
	$endTime = $entry['EndTime'];

	// Сравнение времени через strtotime
	$currentTime = strtotime(date('H:i'));
	$startTimestamp = strtotime($startTime);
	$endTimestamp = strtotime($endTime);

	$status = ($currentTime >= $startTimestamp && $currentTime < $endTimestamp)
		? "(сейчас открыто)" : "(сейчас закрыто)";

	return "Работает с {$startTime} до {$endTime} {$status}";
}

/**
 * Проверяет, работает ли объект круглосуточно.
 *
 * Функция принимает JSON-строку с расписанием, где каждая запись содержит поля:
 * - StartTime
 * - EndTime
 * - и другие (например, Day, DayTitle)
 *
 * Если все записи в расписании имеют StartTime = "00:00" и EndTime = "24:00",
 * функция возвращает true. Иначе — false.
 *
 * @param string $json JSON-строка с расписанием.
 *
 * @return string true, если все записи указывают на круглосуточный режим, иначе false.
 */
function isRoundTheClock(string $json): string
{
	$data = json_decode($json, true);
	if (!is_array($data) || empty($data)) {
		return false;
	}

	foreach ($data as $entry) {
		if ($entry['StartTime'] !== '00:00' || !in_array($entry['EndTime'], ['24:00', '23:00', '23:59'])) {
			return "";
		}
	}

	return "Y";
}
