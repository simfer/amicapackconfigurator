<?php
include_once "header.php";
include_once "daelib.php";
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
    .modal-body {
        font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
        line-height: 0.5;
        font-size: small;
    }
    input[type="checkbox"]:focus{
        outline:0;
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
        content:'';
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
            <h1 class="page-header">Sicurezza</h1>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tabUtentiGruppi" role="tab" data-toggle="tab">
                        Utenti - Gruppi
                    </a>
                </li>
                <li>
                    <a href="#tabGruppiRuoli" role="tab" data-toggle="tab">
                        Gruppi - Ruoli
                    </a>
                </li>
                <li>
                    <a href="#tabRuoliAutorizzazioni" role="tab" data-toggle="tab">
                        Ruoli - Autorizzazioni
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tabUtentiGruppi">
                    <table id="tblUtentiGruppi" data-toggle="table" data-height="450">
                        <?
                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idgruppo, descrizione FROM gruppi ORDER BY idgruppo");
                            $stmt->execute();

                            while ($rowUG = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $col_arrayUG[$rowUG['idgruppo']] = $rowUG['descrizione'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idutente, username FROM utenti ORDER BY idutente");
                            $stmt->execute();

                            while ($rowUG = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $row_arrayUG[$rowUG['idutente']] = $rowUG['username'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idutente, idgruppo FROM utenti_gruppi");
                            $stmt->execute();

                            while ($rowUG = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $cell_arrayUG[$rowUG['idutente'] . "_" . $rowUG['idgruppo']] = 1;
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        $html = "<thead><tr><th>&nbsp;</th>";
                        foreach ($col_arrayUG as $key => $value) {
                            $html .= "<th>" . $value . "</th>";
                        }
                        $html .= "</tr></thead>";
                        echo $html;
                        echo "<tbody>";
                        foreach ($row_arrayUG as $key2 => $value2) {
                            $html = "<tr><td>" . $value2 . "</td>";
                            foreach ($col_arrayUG as $key => $value) {
                                $html .= '<td><input class="chkUG" id="chk_' . $key2 . '_' . $key . '" type="checkbox" ' .
                                    (array_key_exists($key2 . "_" . $key, $cell_arrayUG) ? "checked" : "") . '/></td>';
                            }
                            $html .= "</tr>";
                            echo $html;
                        }
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabGruppiRuoli">
                    <table id="tblGruppiRuoli" data-toggle="table" data-height="450">
                        <?
                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idruolo, descrizione FROM ruoli ORDER BY idruolo");
                            $stmt->execute();

                            while ($rowGR = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $col_arrayGR[$rowGR['idruolo']] = $rowGR['descrizione'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idgruppo, descrizione FROM gruppi ORDER BY idgruppo");
                            $stmt->execute();

                            while ($rowGR = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $row_arrayGR[$rowGR['idgruppo']] = $rowGR['descrizione'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idgruppo, idruolo FROM gruppi_ruoli");
                            $stmt->execute();

                            while ($rowGR = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $cell_arrayGR[$rowGR['idgruppo'] . "_" . $rowGR['idruolo']] = 1;
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        $html = "<thead><tr><th>&nbsp;</th>";
                        foreach ($col_arrayGR as $key => $value) {
                            $html .= "<th>" . $value . "</th>";
                        }
                        $html .= "</tr></thead>";
                        echo $html;
                        echo "<tbody>";
                        foreach ($row_arrayGR as $key2 => $value2) {
                            $html = "<tr><td>" . $value2 . "</td>";
                            foreach ($col_arrayGR as $key => $value) {
                                $html .= '<td><input class="chkGR" id="chk_' . $key2 . '_' . $key . '" type="checkbox" ' .
                                    (array_key_exists($key2 . "_" . $key, $cell_arrayGR) ? "checked" : "") . '/></td>';
                            }
                            $html .= "</tr>";
                            echo $html;
                        }
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
                <div class="tab-pane fade" id="tabRuoliAutorizzazioni">
                    <table id="tblRuoliAutorizzazioni" data-toggle="table" data-height="450">
                        <?
                        $col_arrayRA = [];
                        $row_arrayRA = [];
                        $cell_arrayRA = [];

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idautorizzazione, descrizione FROM autorizzazioni ORDER BY idautorizzazione");
                            $stmt->execute();

                            while ($rowRA = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $col_arrayRA[$rowRA['idautorizzazione']] = $rowRA['descrizione'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idruolo, descrizione FROM ruoli ORDER BY idruolo");
                            $stmt->execute();

                            while ($rowRA = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $row_arrayRA[$rowRA['idruolo']] = $rowRA['descrizione'];
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        try {
                            $conn = new PDO (APC_DB_DSN, APC_DB_USER, APC_DB_PASSWORD);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $stmt = $conn->prepare("SELECT idruolo, idautorizzazione FROM ruoli_autorizzazioni");
                            $stmt->execute();

                            while ($rowRA = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $cell_arrayRA[$rowRA['idruolo'] . "_" . $rowRA['idautorizzazione']] = 1;
                            }

                        } catch (PDOException $e) {
                            echo "ERROR: " . $e->getMessage();
                        }

                        $html = "<thead><tr><th>&nbsp;</th>";
                        foreach ($col_arrayRA as $key => $value) {
                            $html .= "<th>" . $value . "</th>";
                        }
                        $html .= "</tr></thead>";
                        echo $html;
                        echo "<tbody>";
                        foreach ($row_arrayRA as $key2 => $value2) {
                            $html = "<tr><td>" . $value2 . "</td>";
                            foreach ($col_arrayRA as $key => $value) {
                                $html .= '<td><input class="chkRA" id="chk_' . $key2 . '_' . $key . '" type="checkbox" ' .
                                    (array_key_exists($key2 . "_" . $key, $cell_arrayRA) ? "checked" : "") . '/></td>';
                            }
                            $html .= "</tr>";
                            echo $html;
                        }
                        echo "</tbody>";
                        ?>
                    </table>
                </div>
            </div>

            <div id="footerBar" style="float: right">
                <button id="btnSalva" type="button" class="btn btn-lg btn-success">
                    <i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Salva
                </button>
            </div>
        </div>
    </div>



    <?php
    include_once "footer.php";
    ?>

    <script type="text/javascript">

        jQuery().ready(function() {

            $.whenAll = function (deferreds) {
                function isPromise(fn) {
                    return fn && typeof fn.then === 'function' &&
                        String($.Deferred().then) === String(fn.then);
                }
                var d = $.Deferred(),
                    keys = Object.keys(deferreds),
                    args = keys.map(function (k) {
                        return $.Deferred(function (d) {
                            var fn = deferreds[k];

                            (isPromise(fn) ? fn : $.Deferred(fn))
                                .done(d.resolve)
                                .fail(function (err) { d.reject(err, k); })
                            ;
                        });
                    });

                $.when.apply(this, args)
                    .done(function () {
                        var resObj = {},
                            resArgs = Array.prototype.slice.call(arguments);
                        resArgs.forEach(function (v, i) { resObj[keys[i]] = v; });
                        d.resolve(resObj);
                    })
                    .fail(d.reject);

                return d;
            };

            function getHeight() {
                return jQuery(window).height();
            }

            //$("#tblRuoliAutorizzazioni").prop("data-height",300);

            function SalvaUtentiGruppi() {
                var deferred = $.Deferred();
                var searchIDs = $("input.chkUG:checked").map(function () {
                    return this.id;
                }).toArray();
                //set the form data
                var form_data = {
                    searchIDs: searchIDs,
                    ajax_function: "SalvaUtentiGruppi"
                };

                var resp;
                //create and submit the ajax request
                $.ajax({
                    type: "POST",
                    url: "ajax_responder.php",
                    data: form_data,
                    success: function (response) {
                        resp = response;
                        deferred.resolve(resp);
                    },
                    error: function (response) {
                        resp = response;
                        deferred.reject(resp);
                    }
                });
                return(deferred);
            }

            function SalvaGruppiRuoli() {
                var deferred = $.Deferred();
                var searchIDs = $("input.chkGR:checked").map(function () {
                    return this.id;
                }).toArray();

                //set the form data
                var form_data = {
                    searchIDs: searchIDs,
                    ajax_function: "SalvaGruppiRuoli"
                };

                var resp;
                //create and submit the ajax request
                $.ajax({
                    type: "POST",
                    url: "ajax_responder.php",
                    data: form_data,
                    success: function (response) {
                        resp = response;
                        deferred.resolve(resp);
                    },
                    error: function (response) {
                        resp = response;
                        deferred.reject(resp);
                    }
                });
                return(deferred);
            }

            function SalvaRuoliAutorizzazioni() {
                var deferred = $.Deferred();
                var searchIDs = $("input.chkRA:checked").map(function () {
                    return this.id;
                }).toArray();

                //set the form data
                var form_data = {
                    searchIDs: searchIDs,
                    ajax_function: "SalvaRuoliAutorizzazioni"
                };

                var resp;
                //create and submit the ajax request
                $.ajax({
                    type: "POST",
                    url: "ajax_responder.php",
                    data: form_data,
                    success: function (response) {
                        resp = response;
                        deferred.resolve(resp);
                    },
                    error: function (response) {
                        resp = response;
                        deferred.reject(resp);
                    }
                });
                return(deferred);
            }

            $("#btnSalva").click(function (event) {
                $(this).blur();

                //var response1 = SalvaUtentiGruppi();
                //var response2 = SalvaGruppiRuoli();
                //var response3 = SalvaRuoliAutorizzazioni();

                var reqObj = {
                    x: SalvaUtentiGruppi(),
                    y: SalvaGruppiRuoli(),
                    z: SalvaRuoliAutorizzazioni()
                };

                $.whenAll(reqObj)
                    .done(function (res) {
                    toastr.info('Informazioni salvate correttamente!');
                        console.log('Success');
                        console.log(res);
                    })
                    .fail(function (firstFail, name) {
                        console.log('Fail for: ' + name);
                        console.log(firstFail);
                    });

//                var res1 = JSON.parse(response1);
//                var res2 = JSON.parse(response2);
//                var res3 = JSON.parse(response3);
//
//                if ((res1["status"] === "success") && (res2["status"] === "success") && (res3["status"] === "success")) {
//                    toastr.info('Informazioni salvate correttamente!');
//                } else {
//                    if (res1["status"] != "succcess") {
//                        toastr.error("ERRORE: " + res1['result']);
//                    }
//                    if (res2["status"] != "succcess") {
//                        toastr.error("ERRORE: " + res2['result']);
//                    }
//                    if (res3["status"] != "succcess") {
//                        toastr.error("ERRORE: " + res3['result']);
//                    }
//                };
//                return false;
            });
        });

    </script>

    <script src="daeSpinner.js" type="text/javascript"></script>

