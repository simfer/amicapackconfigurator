<?php
include_once "header.php";
include_once "daelib.php";
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ruoli</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="toolbar">
                <button id="btnNew" type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal"><i
                        class="glyphicon glyphicon-plus"></i>&nbsp;Aggiungi
                </button>
                <button id="btnPrint" type="button" class="btn btn-success"><i class="glyphicon glyphicon-print"></i>&nbsp;Stampa
                </button>
            </div>
            <style type="text/css">
                .modal-dialog {
                    width: 60%;
                }
            </style>

            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myEditModalLabel">Edit</h4>
                        </div>
                        <div id="rowDetails" class="modal-body">
                            <!-- The form is placed inside the body of modal -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                            <button id="btnSalva" type="button" class="btn btn-primary" data-dismiss="modal">Salva
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myDetailLabel">Dettaglio</h4>
                        </div>
                        <div id="rowDetails" class="modal-body">
                            <!-- here it comes the detail body-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="table-ruoli"
                   data-toggle="table-ruoli"
                   data-method="GET"
                   data-toolbar="#toolbar"
                   data-search="true"
                   data-show-refresh="true"
                   data-show-columns="true"
                   data-pagination="true"
                   data-page-list="[10, 25, 50, 100, ALL]"
                   data-url="get_table_data.php?tabella=ruoli"
                   data-click-to-select="true"
            >
                <thead>
                <tr>
                    <th data-field="state" data-radio="true"></th>
                    <th data-field="idruolo" data-align="center" data-visible="false">ID Ruolo</th>
                    <th data-field="descrizione" data-align="left" data-sortable="true">Descrizione</th>
                    <th data-field="attivo" data-align="center" data-visible="false" data-sortable="false">Attivo</th>
                    <th data-field="operate"
                        data-formatter="operateFormatter"
                        data-events="operateEvents">Azione
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



    <?php
    include_once "footer.php";
    ?>
    <script type="text/javascript">
        var oForm = {
            "table":"ruoli",
            "labelForNew":"Nuovo ruolo",
            "labelForEdit":"Modifica ruolo",
            "keyfield":"idruolo",
            "autoincrement":"true",
            "buttons": [
                {"name": "btnChiudi","caption":"Chiudi","class":"btn btn-default","dismiss":"true"},
                {"name": "btnSalva","caption":"Salva","class":"btn btn-primary","dismiss":"true"}],
            "panels":[
                {
                    "name": "ruolo", "description":"Ruolo", "collapsable":"false","collapsed":"false",
                    "rules": {
                        "descrizione": {required: true}
                    },
                    "messages": {
                        "descrizione": {required: "Campo obbligatorio!"}
                    },
                    "rows": [
                        {"cells":[
                            {"name": "descrizione", "label": "Descrizione", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]}
                    ]

                }
            ]
        };

    </script>
    <script src="js/global_functions.js" type="text/javascript"></script>

