<?
class cSiteParams
	{
 		public static function setConstants()
			{
				switch (SITE_ID) 
					{
					case "s1":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s1.php");
						break;
					case "s2":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s2.php");
						break;
					case "s3":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s3.php");
						break;
					case "s4":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s4.php");
						break;
					case "s5":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s5.php");
						break;
					case "s6":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s6.php");
						break;
					case "s7":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s7.php");
						break;
					case "s8":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s8.php");
						break;
					case "s9":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/s9.php");
						break;
					case "a1":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/a1.php");
						break;
					case "a2":
						include_once($_SERVER['DOCUMENT_ROOT']."/local/config/a2.php");
						break;
					}
			}
	}
?>