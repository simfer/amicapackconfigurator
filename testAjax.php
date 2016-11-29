<html>
<head>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <body>
    <div class="container">
        <h1>Test Ajax</h1>
        <input type="button" id="btnClick" value="Click me">
    </div>
    </body>

</head>
</html>

<script>

    $(function () {

        $("#btnClick").on('click',function () {
            Test();
        });

        function Test() {
            var formdata = {};
            formdata.idutente = "1";
            formdata.ajax_function = "LeggiUtente";

            $.ajax({
                url: "ajax_responder.php",
                dataType: "json",
                type: "POST",
                data: formdata,
                cache: false,
                success: function (response) {
                    var res = response["result"];
                    console.log(res);
                    console.log(response["sql"]);
                },
                error: function (response) {
                    console.log("error");
                    console.log(response);
                }
            });
        }

    });

</script>

</body>

</html>
