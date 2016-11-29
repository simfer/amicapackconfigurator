<?php
include_once "header.php";
include_once "daelib.php";

$idutente = $_SESSION ["idutente"];

?>
<style type="text/css">
    .row{
        margin-top: 30px;
        margin-bottom: 30px;
        margin-left: 15px;
        margin-right: 15px;
    }
    .span-checkbox { float:right }

    .full-width { width:90% }

    input[type='number'] {
        -moz-appearance:textfield;
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
            <form class="form-horizontal" method="post" name="myForm" id="myForm">
                <input type="hidden" value="<?=$idutente?>" id="idutente" name="idutente">
                <div class="form-group">
                    <div class="cell">
                        <label class="control-label col-sm-2" for="cognome">Cognome *</label>
                        <div class="col-sm-4">
                            <input type="text" name="cognome" id="cognome" class="form-control full-width" tabindex="1">
                        </div>
                    </div>
                    <div class="cell">
                        <label class="control-label col-sm-2" for="nome">Nome *</label>
                        <div class="col-sm-4">
                            <input type="text" name="nome" id="nome" class="form-control full-width" tabindex="2">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="cell">
                        <label class="control-label col-sm-2" for="username">Nome utente</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control full-width" id="username" name="username"
                                   placeholder="[6-20] caratteri" tabindex="3"/>
                        </div>
                    </div>
                    <div class="cell">
                        <label class="control-label col-sm-2" for="telefono">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control full-width" id="email" name="email" tabindex="4"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="cell">
                        <label class="control-label col-sm-2" for="password">Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control full-width" id="password" name="password"
                                   placeholder="[6-20] caratteri" tabindex="5"/>
                        </div>
                    </div>
                    <div class="cell">
                        <label class="control-label col-sm-2" for="password2">Ripeti Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control full-width" id="password2" name="password2"
                                   placeholder="[6-20] caratteri" tabindex="6"/>
                        </div>
                    </div>
                </div>
            </form>
            <div id="footerBar" style="float: right">
                <button id="btnReset" type="button" class="btn btn-lg btn-warning">
                    <i class="glyphicon glyphicon-trash"></i>&nbsp;Azzera campi
                </button>
                <button id="btnSalva" type="button" class="btn btn-lg btn-success" tabindex="9">
                    <i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Salva
                </button>
            </div>
        </div>
    </div>

<?php
include_once "footer.php";
?>

<script>

    $(function () {
        //Validazione form
        jQuery.validator.setDefaults({
            highlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                    $(element).closest('.form-group').find('i.fa').remove();
                    $(element).closest('.form-group').append('<i class="fa fa-exclamation fa-lg form-control-feedback"></i>');
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                if (element.type === "radio") {
                    this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                } else {
                    $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                    $(element).closest('.form-group').find('i.fa').remove();
                    $(element).closest('.form-group').append('<i class="fa fa-check fa-lg form-control-feedback"></i>');
                }
            }
        });

        if($("#idutente").val() != "") {
            $.when(LeggiUtente()).done(function(result) {
                var utente = result;
                $("#username").val(utente.username);
                $("#cognome").val(utente.cognome);
                $("#nome").val(utente.nome);
                $("#email").val(utente.email);
            });
        }

        $("#myForm").validate({
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
                    minlength: 6,
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

        $("#btnSubmit").click(function () {
            var form = $("#myForm");
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
                            var utente = {
                                idutente: $("#idutente").val(),
                                cognome: $("#cognome").val(),
                                nome: $("#nome").val(),
                                username: $("#username").val(),
                                password: $("#password").val(),
                                password2: $("#password2").val(),
                                email: $("#email").val(),
                                ajax_function: "SalvaUtente"
                            };

                            //create and submit the ajax request
                            //invio dati
                            $.ajax({
                                type: "POST",
                                url: "ajax_responder.php",
                                data: utente,
                                success: function (response) {
                                    var res = JSON.parse(response);
                                    if (res["status"] === "success") {
                                        toastr.info('Profilo utente salvato con successo!');
                                        location.href = "home.php";
                                    } else {
                                        toastr.error("ERRORE: " + res['result']);
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
                async:false,
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

</body>

</html>
