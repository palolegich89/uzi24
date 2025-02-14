<?
function gethlel($block_id, $name_value, $list_filter, $limit = 999, $order = "ID", $order_line = "ASC")
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
                'filter' => array($name_value => $list_filter)
            ));
            while ($el = $rsData->fetch()) {
                $els[$el["ID"]] = $el;
            }
            return $els;
        } else {
            return false;
        }
    }
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
            while ($el = $rsData->fetch()) {
                $els[$el["ID"]] = $el;
            }
            return $els;
        } else {
            return false;
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
            return     $entity_data_class;
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
/*
class cIBlockElementExtended extends CIBlockElement2
{
    public static function GetList($arOrder=false, $arFilter=array(), $arGroupBy=false, $arNavStartParams=false, $arSelectFields=array(), $listIds = false)
    {
        global $DB;

        $el = new cIBlockElementExtended();
        $el->prepareSql($arSelectFields, $arFilter, $arGroupBy, $arOrder);

        if($el->bOnlyCount)
        {
            $res = $DB->Query("
                SELECT ".$el->sSelect."
                FROM ".$el->sFrom."
                WHERE 1=1 ".$el->sWhere."
                ".$el->sGroupBy."
            ");
            $res = $res->Fetch();
            return $res["CNT"];
        }

//        echo "OrderBy = ".$el->sOrderBy."<br>";
//        echo "sGroupBy = ".$el->sGroupBy."<br>";
//            echo "branch 0<br>";
        if(!empty($arNavStartParams) && is_array($arNavStartParams))
        {
//            echo "branch 1<br>";
            $nTopCount = (isset($arNavStartParams["nTopCount"]) ? (int)$arNavStartParams["nTopCount"] : 0);
            $nElementID = (isset($arNavStartParams["nElementID"]) ? (int)$arNavStartParams["nElementID"] : 0);

            if($nTopCount > 0)
            {
                $strSql = "
                    SELECT ".$el->sSelect."
                    FROM ".$el->sFrom."
                    WHERE 1=1 ".$el->sWhere."
                    ".$el->sGroupBy."
                    ".$el->sOrderBy;
                    $count = 1;
                    if($listIds  && !$el->sOrderBy)
                        {
                            $strSql;
                            $counter = count($listIds);
                            $strSql .= " ORDER BY FIELD(BE.ID, ";
                            foreach($listIds as $id)
                                {
                                    $strSql .= "".$id."";
                                    if($count<$counter)$strSql .= ",";
                                    $count++;
                                }
                            $strSql .= ") ";
                        }
                    $strSql .= "
                    LIMIT ".$nTopCount;

                $res = $DB->Query($strSql);
//                echo "branch 1 - 0<br>";
            }
            elseif(
                $nElementID > 0
                && $el->sGroupBy == ""
                && $el->sOrderBy != ""
                && strpos($el->sSelect, "BE.ID") !== false
                && !$el->bCatalogSort
            )
            {
//                echo "branch 1 - 1<br>";
                $nPageSize = (isset($arNavStartParams["nPageSize"]) ? (int)$arNavStartParams["nPageSize"] : 0);

                if($nPageSize > 0)
                {
//                    echo "branch 1 - 1 - 0<br>";
                    $DB->Query("SET @rank=0");
                    $DB->Query("
                        SELECT @rank:=el1.rank
                        FROM (
                            SELECT @rank:=@rank+1 AS rank, el0.*
                            FROM (
                                SELECT ".$el->sSelect."
                                FROM ".$el->sFrom."
                                WHERE 1=1 ".$el->sWhere."
                                ".$el->sGroupBy."
                                ".$el->sOrderBy."
                                LIMIT 18446744073709551615
                            ) el0
                        ) el1
                        WHERE el1.ID = ".$nElementID."
                    ");
                    $DB->Query("SET @rank2=0");

                    $res = $DB->Query("
                        SELECT *
                        FROM (
                            SELECT @rank2:=@rank2+1 AS RANK, el0.*
                            FROM (
                                SELECT ".$el->sSelect."
                                FROM ".$el->sFrom."
                                WHERE 1=1 ".$el->sWhere."
                                ".$el->sGroupBy."
                                ".$el->sOrderBy."
                                LIMIT 18446744073709551615
                            ) el0
                        ) el1
                        WHERE el1.RANK between @rank-$nPageSize and @rank+$nPageSize
                    ");
                }
                else
                {
//                    echo "branch 1 - 1 - 1<br>";                    
                    $DB->Query("SET @rank=0");
                    $res = $DB->Query("
                        SELECT el1.*
                        FROM (
                            SELECT @rank:=@rank+1 AS RANK, el0.*
                            FROM (
                                SELECT ".$el->sSelect."
                                FROM ".$el->sFrom."
                                WHERE 1=1 ".$el->sWhere."
                                ".$el->sGroupBy."
                                ".$el->sOrderBy."
                                LIMIT 18446744073709551615
                            ) el0
                        ) el1
                        WHERE el1.ID = ".$nElementID."
                    ");
                }
            }
            else
            {
//            echo "branch 1 - 2 - 0<br>";
                if ($el->sGroupBy == "")
                {
//                    echo "branch 1 - 2 - 1<br>";
                    $strSql = 
                    $res_cnt = $DB->Query("
                        SELECT COUNT(".($el->bDistinct? "DISTINCT BE.ID": "'x'").") as C
                        FROM ".$el->sFrom."
                        WHERE 1=1 ".$el->sWhere."
                        ".$el->sGroupBy."
                    ");
                    $res_cnt = $res_cnt->Fetch();
                    $cnt = $res_cnt["C"];
                }
                else
                {
//                    echo "branch 1 - 2 - 2<br>";                                                                            
                    $res_cnt = $DB->Query("
                        SELECT 'x'
                        FROM ".$el->sFrom."
                        WHERE 1=1 ".$el->sWhere."
                        ".$el->sGroupBy."
                    ");
                    $cnt = $res_cnt->SelectedRowsCount();
                }

                $strSql = "
                    SELECT ".$el->sSelect."
                    FROM ".$el->sFrom."
                    WHERE 1=1 ".$el->sWhere."
                    ".$el->sGroupBy."
                    ".$el->sOrderBy."
                ";
                $res = new CDBResult();
                
                if($listIds && !$el->sOrderBy)
                {
                    $count=1;
                    $counter = count($listIds);
                    $strSql .= " ORDER BY FIELD(BE.ID, ";
                    foreach($listIds as $id)
                        {
                            $strSql .= "".$id."";
                            if($count<$counter)$strSql .= ",";
                            $count++;
                        }
                    $strSql .= ") ";
                }
                //echo "strSql = ".$strSql."<br>";
                
                
                $res->NavQuery($strSql, $cnt, $arNavStartParams);
            }
        }
        else//if(is_array($arNavStartParams))
        {
//            echo "branch 2 - 0 - 0<br>";                                                                                        
            $strSql = "
                SELECT ".$el->sSelect."
                FROM ".$el->sFrom."
                WHERE 1=1 ".$el->sWhere."
                ".$el->sGroupBy."
                ".$el->sOrderBy."
            ";
            $res = $DB->Query($strSql, false, "FILE: ".__FILE__."<br> LINE: ".__LINE__);
        }

        $res = new CIBlockResult($res);
        $res->SetIBlockTag($el->arFilterIBlocks);
        $res->arIBlockMultProps = $el->arIBlockMultProps;
        $res->arIBlockConvProps = $el->arIBlockConvProps;
        $res->arIBlockAllProps  = $el->arIBlockAllProps;
        $res->arIBlockNumProps = $el->arIBlockNumProps;
        $res->arIBlockLongProps = $el->arIBlockLongProps;

        return $res;
    }
} */