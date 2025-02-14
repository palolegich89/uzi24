<?
class cIBlockElementExtended extends CIBlockElement
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
//		echo "<pre>"; print_r($arOrder) ;echo "</pre>";
//		echo "OrderBy = ".$el->sOrderBy."<br>";
//		echo "sGroupBy = ".$el->sGroupBy."<br>";
//			echo "branch 0<br>";
		if(!empty($arNavStartParams) && is_array($arNavStartParams))
		{
//			echo "branch 1<br>";
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
//				echo "branch 1 - 0<br>";
			}
			elseif(
				$nElementID > 0
				&& $el->sGroupBy == ""
				&& $el->sOrderBy != ""
				&& strpos($el->sSelect, "BE.ID") !== false
				&& !$el->bCatalogSort
			)
			{
//				echo "branch 1 - 1<br>";
				$nPageSize = (isset($arNavStartParams["nPageSize"]) ? (int)$arNavStartParams["nPageSize"] : 0);

				if($nPageSize > 0)
				{
//					echo "branch 1 - 1 - 0<br>";
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
//					echo "branch 1 - 1 - 1<br>";					
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
//			echo "branch 1 - 2 - 0<br>";
				if ($el->sGroupBy == "")
				{
//					echo "branch 1 - 2 - 1<br>";
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
//					echo "branch 1 - 2 - 2<br>";																			
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
//			echo "branch 2 - 0 - 0<br>";																						
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
} 
?>