<?php
    include "daelib.php";
?>

<html>
<head>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>

</head>

<body>

<!--Clienti: --><?//=GetNumberOfRecords("clienti","attivo=1")?>
<br>
Regione: <?=CreateSelect("regioni","zoneaugusta","","regione","regione","regione") ?>
<br>
Provincia: <?=CreateSelect("province","zoneaugusta","regione","provincia","provincia","provincia") ?>

<button class="btn-success" id="btnGo">aaaa</button>
<script type="text/javascript">
    jQuery().ready(function() {

        var province = $("#province > option").clone();

        var augusta = {};
        augusta.regione = $("#regioni").val();
        augusta.provincia = $("#province").val();



        $('#regioni').on('change', function () {
            console.log("first");
            var regione = $(this).val();
            augusta.regione = regione;

            var res = "";

            var html = "";

            province.each(function() {
                if ($(this).attr('parentid') == regione) {
                    html = html + '<option id="' + $(this).val() + '">' + $(this).val() + '</option>';
                }
            });
            $("#province").html(html);
            $("#province").trigger("change");
        });

        $('#province').on('change', function () {
            augusta.provincia = $(this).val();
        });

        $("#btnGo").on("click",function () {
            console.log(augusta);
        });

        $("#regioni").trigger("change");

    });


</script>
</body>

</html>
