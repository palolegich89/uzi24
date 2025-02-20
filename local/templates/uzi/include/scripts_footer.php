<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("iblock");
$metro_stations = [];
$arFilter = array("IBLOCK_ID" => 1, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "NAME", "CODE"));
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$metro_stations[] = $arFields['NAME'];
	$metro_stations_code[] = $arFields['CODE'];
}

$rayon_name = [];
$arFilter = array("IBLOCK_ID" => 2, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array(), $arFilter, false, false, array("ID", "NAME", "CODE"));
while ($ob = $res->GetNextElement()) {
	$arFields = $ob->GetFields();
	$rayon_name[] = $arFields['NAME'];
	$rayon_code[] = $arFields['CODE'];
}

if (!empty($_GET['location']) && !strstr($_GET['location'], '_okrug')) {

	if (strstr($_GET['location'], '_metro')) {
		$display_value = str_replace("_metro", "", $_GET['location']);
	} elseif (strstr($_GET['location'], '_rayon')) {
		$display_value = str_replace("_rayon", "", $_GET['location']);
	} else {
		$display_value = $_GET['location'];
	}

	$search_key = array_search($display_value, $rayon_code);

	if (!empty($search_key)) {
		$display_value = $rayon_name[$search_key];
	} else {
		$search_key = array_search($display_value, $metro_stations_code);
		$display_value = $metro_stations[$search_key];
	}

}
?>
<script>
    var availableTags = [
		<?foreach($metro_stations as $key => $value):?>
        "метро <?=$value;?>",
		<?endforeach;?>
		<?/*foreach($rayon_name as $key => $value):?>
                    "район <?=$value;?>",
					<?endforeach;*/?>
    ];

    var availableTags_code = [
		<?foreach($metro_stations_code as $key => $value):?>
        "<?=$value;?>_metro",
		<?endforeach;?>
		<?/*foreach($rayon_code as $key => $value):?>
                    "<?=$value;?>_rayon",
					<?endforeach;*/?>
    ];

    $("#tags").autocomplete({source: availableTags});

    $(document).ready(function () {
        $(".page__sidebar-nav ul li ul li.active").each(function (index, value) {
            //$(this).removeClass('active');
            $(this).parent().parent().addClass('active');
        });

        $('#tags').keyup(function () {
            var value = $('#tags').val();
            //value = value.charAt(0).toUpperCase() + value.substr(1).toLowerCase();

            if (availableTags.indexOf(value) != -1) {
                if (!$('#tags').hasClass('complete')) {
                    $('#tags').addClass('complete');
                    var index = availableTags.indexOf(value);
                    $('#tags').attr('data-value', availableTags_code[index]);
                }
            } else {
                $('#tags').removeClass('complete');
            }
        });

        $(document).on('click', '.ui-menu-item a', function (e) {
            var value = $('#tags').val();
            //value = value.charAt(0).toUpperCase() + value.substr(1).toLowerCase();

            if (availableTags.indexOf(value) != -1) {
                if (!$('#tags').hasClass('complete')) {
                    $('#tags').addClass('complete');
                    var index = availableTags.indexOf(value);
                    $('#tags').attr('data-value', availableTags_code[index]);
                }
            } else {
                $('#tags').removeClass('complete');
            }
        });

        $(".group .button-find").click(function () {
            if (!$('#tags').hasClass('complete')) {
                return false;
            } else {
                var value = $('#tags').attr('data-value');
                $('#tags2').val(value);
            }
        });
    });
</script>


<link rel='stylesheet' id='style-fansybox-css'href='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css?ver=master' type='text/css' media='all' />
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js?ver=master' id='script-fansybox-js'></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/form.js"></script>
<!--<script type="text/javascript" src="--><?php //= SITE_TEMPLATE_PATH; ?><!--/js/vendor.js"></script>-->
<script type="text/javascript" src="<?= SITE_TEMPLATE_PATH; ?>/js/app.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input[name="phone"]').inputmask("+7(999)999-99-99");
    });
</script>