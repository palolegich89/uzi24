<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Page\Asset;
//Asset::getInstance()->addJs($templateFolder . "/fancybox/jquery-3.1.1.min.js");
Asset::getInstance()->addJs($templateFolder . "/fancybox/jquery.fancybox.js"); 
Asset::getInstance()->addCss($templateFolder . "/fancybox/jquery.fancybox.css");
?>