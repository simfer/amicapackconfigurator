<?
    require_once "header.php";

?>

<div class="container">
<h1>Sicurezza</h1>


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
    <table id="tblUtentiGruppi" data-toggle="table" data-height="600">
        <?
            try {
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
    <table id="tblGruppiRuoli" data-toggle="table" data-height="600">
        <?
            try {
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
    <table id="tblRuoliAutorizzazioni" data-toggle="table" data-height="600">
        <?
            $col_arrayRA = [];
            $row_arrayRA = [];
            $cell_arrayRA = [];

            try {
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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
                $conn = new PDO (DB_DSN, DB_USER, DB_PASSWORD);
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

<div id="footerx">
    <div class="form-inline" role="form">
        <button id="btnSalva" type="button" class="btn btn-success"><i class="glyphicon glyphicon-save"></i>&nbsp;Salva
        </button>
    </div>
</div>
</div>

<?
    include "footer.php"
?>

<script>

    $(function () {
        function SalvaUtentiGruppi() {
            //var searchIDs = $("input:checkbox:checked").map(function(){
            var searchIDs = $("input.chkUG:checked").map(function () {
                return this.id;
            }).toArray();
            //console.log(searchIDs);
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
                async: false,
                success: function (response) {
                    resp = response;
                },
                error: function (response) {
                    resp = response;
                }
            });
            return resp;
        }

        function SalvaGruppiRuoli() {
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
                async: false,
                success: function (response) {
                    resp = response;
                },
                error: function (response) {
                    resp = response;
                }
            });
            return resp;
        }

        function SalvaRuoliAutorizzazioni() {
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
                async: false,
                success: function (response) {
                    resp = response;
                },
                error: function (response) {
                    resp = response;
                }
            });
            return resp;
        }

        $("#btnSalva").click(function (event) {
            event.preventDefault();

            var response1 = SalvaUtentiGruppi();
            var response2 = SalvaGruppiRuoli();
            var response3 = SalvaRuoliAutorizzazioni();

            var res1 = JSON.parse(response1);
            var res2 = JSON.parse(response2);
            var res3 = JSON.parse(response3);

            if ((res1["status"] === "success") && (res2["status"] === "success") && (res3["status"] === "success")) {
                toastr.info('Informazioni salvate correttamente!');
            } else {
                if (res1["status"] != "succcess") {
                    toastr.error("ERRORE: " + res1['result']);
                }
                if (res2["status"] != "succcess") {
                    toastr.error("ERRORE: " + res2['result']);
                }
                if (res3["status"] != "succcess") {
                    toastr.error("ERRORE: " + res3['result']);
                }
            };
            return false;
        });
    });

</script>

</body>

</html>
