<?php
include_once "header.php";
include_once "daelib.php";

$idutente = $_SESSION ["idutente"];

?>

<style type="text/css">
    .row {
        margin-top: 30px;
        margin-bottom: 30px;
        margin-left: 15px;
        margin-right: 15px;
    }

    .span-checkbox {
        float: right
    }

    .full-width {
        width: 90%
    }

    input[type='number'] {
        -moz-appearance: textfield;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    #cover {
        background: url("images/495.gif") no-repeat scroll center center #FFF;
        position: absolute;
        height: 100%;
        width: 100%;
    }

    .modal-body {
        font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
        line-height: 0.5;
        font-size: small;
    }

    input[type="checkbox"]:focus {
        outline: 0;
    }

    input[type="checkbox"] {
        appearance: none;
        background-color: #fafafa;
        border: 1px solid #d3d3d3;
        border-radius: 26px;
        cursor: pointer;
        height: 28px;
        position: relative;
        transition: border .25s .15s, box-shadow .25s .3s, padding .25s;
        width: 44px;
        vertical-align: top;
        -webkit-appearance: none;
    }

    input[type="checkbox"]:after {
        background-color: white;
        border: 1px solid #d3d3d3;
        border-radius: 24px;
        box-shadow: inset 0 -3px 3px rgba(0, 0, 0, 0.025), 0 1px 4px rgba(0, 0, 0, 0.15), 0 4px 4px rgba(0, 0, 0, 0.1);
        content: '';
        display: block;
        height: 24px;
        left: 0;
        position: absolute;
        right: 16px;
        top: 0;
        transition: border .25s .15s, left .25s .1s, right .15s .175s;
    }

    input[type="checkbox"]:checked {
        border-color: #53d76a;
        box-shadow: inset 0 0 0 13px #53d76a;
        padding-left: 18px;
        transition: border .25s, box-shadow .25s, padding .25s .15s;
    }

    input[type="checkbox"]:checked:after {
        border-color: #53d76a;
        left: 16px;
        right: 0;
        transition: border .25s, left .15s .25s, right .25s .175s;
    }
</style>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Il mio profilo</h1>
            <h5 style="color: #ff7c0a;text-indent: 50px;">I campi contrassegnati con * sono obbligatori</h5>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Dati utente
                        </h4>
                    </div>
                    <div id="clpsDatiCliente" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmUtente" id="frmUtente">
                                <input type="hidden" value="<?= $idutente ?>" id="idutente" name="idutente">
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="cognome">Cognome *</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="cognome" id="cognome"
                                                   class="form-control full-width" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="nome">Nome *</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="nome" id="nome" class="form-control full-width"
                                                   tabindex="2">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="username">Nome utente</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="username"
                                                   name="username"
                                                   placeholder="[6-20] caratteri" tabindex="3"/>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="telefono">Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control full-width" id="email" name="email"
                                                   tabindex="4"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="password">Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control full-width" id="password"
                                                   name="password"
                                                   placeholder="[6-20] caratteri" tabindex="5"/>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="password2">Ripeti Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control full-width" id="password2"
                                                   name="password2"
                                                   placeholder="[6-20] caratteri" tabindex="6"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footerBar" style="float: right">
                <button id="btnSalva" type="button" class="btn btn-lg btn-success" tabindex="9" aria-pressed="false">
                    <i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Salva
                </button>
            </div>
        </div>
    </div>


    <?php
    include_once "footer.php";
    ?>

    <script type="text/javascript">

        jQuery().ready(function () {

            if ($("#idutente").val() != "") {
                $.when(LeggiUtente()).done(function (result) {
                    var utente = result;
                    $("#username").val(utente.username);
                    $("#cognome").val(utente.cognome);
                    $("#nome").val(utente.nome);
                    $("#email").val(utente.email);
                });
            }

            $("#frmUtente").validate({
                rules: {
                    'cognome': {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    'nome': {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    'username': {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    },
                    'password': {
                        minlength: 6,
                        maxlength: 20
                    },
                    'password2': {
                        equalTo: "#password"
                    },
                    'email': {
                        required: true,
                        email: true,
                        minlength: 5,
                        maxlength: 100
                    }
                },
                messages: {
                    'cognome': {
                        required: "Il 'cognome' è obbligatorio",
                        minlength: "Cognome troppo corto!'",
                        maxlength: "Cognome utente troppo lungo!"
                    },
                    'nome': {
                        required: "Il 'nome' è obbligatorio",
                        minlength: "Nome troppo corto!'",
                        maxlength: "Nome troppo lungo!"
                    },
                    'username': {
                        required: "Il 'nome utente' è obbligatorio",
                        minlength: "Nome utente troppo corto!'",
                        maxlength: "Nome utente troppo lungo!"
                    },
                    'password': {
                        minlength: "Password troppo corta!'",
                        maxlength: "Password troppo lunga!"
                    },
                    'password2': {
                        equalTo: "Le password non corrispondono!'"
                    },
                    'email': {
                        required: "Il campo 'email' è obbligatorio",
                        email: "L'indirizzo email deve avere il formato 'name@domain.com'",
                        minlength: "Email troppo corta!'",
                        maxlength: "Email troppo lunga!"
                    }
                }
            });


            $("#btnSalva").click(function () {
                $(this).blur();
                console.log("hhdhdhdhd");
                var form = $("#frmUtente");
                form.validate();
                if (!form.valid()) {
                    return false;
                } else {
                    BootstrapDialog.show({
                        title: 'ATTENZIONE',
                        type: BootstrapDialog.TYPE_WARNING,
                        message: 'Sei sicuro?',
                        buttons: [{
                            label: 'Sì',
                            cssClass: 'btn-warning',
                            action: function (dialog) {
                                dialog.close();
                                //set the form data

                                var form_data = {
                                    ajax_function: "SaveRecord",
                                    table:"utenti",
                                    key:"idutente",
                                    keyvalue: $("#idutente").val(),
                                    autoincrement:"true",
                                    modificatoda:"1",
                                    operazione:"I",
                                    attivo:"1"
                                };

                                var columns = {
                                    cognome: $("#cognome").val(),
                                    nome: $("#nome").val(),
                                    username: $("#username").val(),
                                    password: $.md5($("#password").val()),
                                    email: $("#email").val()
                                };

                                form_data.columns = columns;

                                //create and submit the ajax request
                                //invio dati

                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: "ajax_responder.php",
                                    data: form_data,
                                    success: function (response) {
                                        //var res = JSON.parse(response);
                                        if (response["status"] === "success") {
                                            //toastr.info('Profilo utente salvato con successo!');
                                            localStorage.messagetype = "success";
                                            localStorage.message = "Profilo utente salvato con successo!";
                                            location.href = "home.php";
                                        } else {
                                            toastr.error("ERRORE: " + response['result']);
                                        }
                                    },
                                    error: function (response) {
                                        toastr.error("ERRORE: " + response);
                                    }
                                });
                            }
                        }, {
                            label: 'No',
                            cssClass: 'btn-warning',
                            action: function (dialog) {
                                dialog.close();
                            }
                        }]
                    });
                }
            });

            function LeggiUtente() {
                var deferred = $.Deferred();
                var utente = {};

                utente.idutente = $("#idutente").val();
                utente.ajax_function = "LeggiUtente";

                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    data: utente,
                    cache: false,
                    success: function (response) {
                        var res = response["result"];
                        deferred.resolve(res);
                    },
                    error: function (response) {
                        console.log("error");
                        console.log(response);
                        deferred.resolve(response);
                    }
                });
                return deferred.promise();
            }

        });

    </script>

    <script src="daeSpinner.js" type="text/javascript"></script>

