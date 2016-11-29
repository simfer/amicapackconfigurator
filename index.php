<?php
    session_unset();
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AXAPALM - Accesso area riservata</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap Dialog CSS -->
    <link href="bower_components/bootstrap3-dialog/dist/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css"/>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Accedi all'area riservata</h3>
                    </div>
                    <div id="lg-form" class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input id="username" class="form-control" placeholder="Nome Utente" name="username" type="text" autofocus value="">
                                </div>
                                <div class="form-group">
                                    <input id="password" class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input id="remember_me" name="remember_me" type="checkbox" value="Remember Me">Ricordami
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input id="btnLogin" type="button" class="btn btn-lg btn-success btn-block" value="Entra" autofocus>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>

    <!-- Bootstrap JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Bootstrap Table Javascript -->
    <script src="bower_components/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="bower_components/bootstrap-table/dist/locale/bootstrap-table-it-IT.min.js"></script>

    <!-- Bootstrap Dialog Javascript -->
    <script src="bower_components/bootstrap3-dialog/dist/js/bootstrap-dialog.min.js"></script>

    <script type="text/javascript">

        $(function(){
            if (localStorage.chkbx && localStorage.chkbx != '') {
                $('#remember_me').attr('checked', 'checked');
                $('#username').val(localStorage.username);
                $('#password').val(localStorage.password);
            } else {
                $('#remember_me').removeAttr('checked');
                $('#username').val('');
                $('#password').val('');
            }

            $('#remember_me').click(function() {

                if ($('#remember_me').is(':checked')) {
                    // save username and password
                    localStorage.username = $('#username').val();
                    localStorage.password = $('#password').val();
                    localStorage.chkbx = $('#remember_me').val();
                } else {
                    localStorage.username = '';
                    localStorage.password = '';
                    localStorage.chkbx = '';
                }
            });

            $("#btnLogin").click(function(){
                var form_data = {
                    ajax_function: "Login",
                    username: $("#username").val(),
                    password: $("#password").val()
                };

                $.ajax({
                    url:"ajax_responder.php",
                    type: "POST",
                    dataType: "json",
                    data: form_data,
                    cache: false,
                    async: false,
                    success : function(response) {
                        console.log(response);
                        if (response["status"] === "success") {
                            var username = response["result"]["username"];
                            var password = response["result"]["password"];

                            $("#lg-form").slideUp('slow', function(){
                                window.location.href = 'home.php';
                            });
                        } else {
                            BootstrapDialog.show({
                                title: 'ERRORE',
                                type: BootstrapDialog.TYPE_DANGER,
                                message: response["result"],
                                buttons: [{
                                    label: 'Ok',
                                    cssClass: 'btn-danger',
                                    action: function (dialog) {
                                        dialog.close();
                                    }
                                }]
                            });
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        BootstrapDialog.show({
                            title: 'ERRORE',
                            type: BootstrapDialog.TYPE_DANGER,
                            message: response["result"],
                            buttons: [{
                                label: 'Ok',
                                cssClass: 'btn-danger',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                        });
                    }
                });
                return false;
            });
        });
    </script>


</body>

</html>
