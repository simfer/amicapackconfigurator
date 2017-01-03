<?php
include_once "header.php";
include_once "daelib.php";
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Preventivi</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="toolbar">
                <button id="btnNuovoPreventivo" type="button" class="btn btn-success" onclick="location.href='modificaPreventivo.php';">
                    <i class="glyphicon glyphicon-plus"></i>&nbsp;Nuovo preventivo
                </button>
            </div>
            <style type="text/css">
                .modal-dialog {
                    width: 60%;
                }
            </style>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>

            <table id="table-preventivi"
                   data-toggle="table-preventivi"
                   data-url="get_table_data.php?tabella=preventivi"
                   data-method="GET"
                   data-toolbar="#toolbarPreventivi"
                   data-search="true"
                   data-show-refresh="true"
                   data-show-columns="true"
                   data-pagination="true"
                   data-page-list="[10, 25, 50, 100, ALL]"
                   data-click-to-select="true"
            >
                <thead>
                <tr>
                    <th data-field="state" data-radio="true"></th>
                    <th data-field="idpreventivo" data-align="left" data-sortable="true" data-visible="false">ID Prev</th>
                    <th data-field="codicefiscale" data-align="left" data-sortable="true">C.Fisc.</th>
                    <th data-field="cognome" data-align="left" data-sortable="true">Cognome</th>
                    <th data-field="nome" data-align="left" data-sortable="true">Nome</th>
                    <th data-field="professione" data-align="left" data-sortable="true"  data-visible="false">Professione</th>
                    <th data-field="datanascita" data-align="left" data-sortable="true" data-formatter="DateFormatWEB">D. Nasc.</th>
                    <th data-field="rca" data-align="left" data-sortable="false">RCA</th>
                    <th data-field="augusta" data-align="left" data-sortable="false">Augusta</th>
                    <th data-field="accessori" data-align="left" data-sortable="false">Accessori</th>
                    <th data-field="copertureaggiuntive" data-align="left" data-sortable="false">Copert. Agg.</th>
                    <th data-field="premiototale" data-align="left" data-sortable="false">Premio totale</th>
                    <th data-field="operate"
                        data-formatter="operateFormatterPreventivi"
                        data-events="operateEventsPreventivi">Azione
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
            "table":"preventivi",
            "labelForNew":"Nuovo preventivo",
            "labelForEdit":"Modifica preventivo",
            "keyfield":"idpreventivo",
            "autoincrement":"false",
            "readRecordFunction": {"name":"LeggiPreventivo","parameters":["idpreventivo"]},
            "buttons": [
                {"name": "btnChiudi","caption":"Chiudi","class":"btn btn-default","dismiss":"true"},
                {"name": "btnSalva","caption":"Salva","class":"btn btn-primary","dismiss":"true"}],
            "panels":[
                {
                    "name": "cliente", "description":"Cliente", "collapsable":"true","collapsed":"false",
                    "rules": {
                        "cognome": {required: true}
                    },
                    "messages": {
                        "cognome": {required: "Campo obbligatorio!"}
                    },
                    "rows": [
                        {"cells":[
                            {"name": "codicefiscale", "label": "C.Fisc.", "labelsize":"2","fieldsize":"10", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "cognome", "label": "Cognome", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
                            {"name": "nome", "label": "Nome", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "telefono", "label": "Telefono", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
                            {"name": "cellulare", "label": "Cellulare", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "datanascita", "label": "Data di nascita", "labelsize":"2","fieldsize":"4", "type": "date", "visible": "true", "disabled": "false", "editable": "true"},
                            {"name": "idprofessione", "label": "Professione", "labelsize":"2","fieldsize":"4", "type": "select", "selectParams": {
                                "source": "table",
                                "table":"professioni",
                                "keycolumn":"idprofessione",
                                "displaycolumn":"descrizione",
                                "filter":"attivo=1",
                                "sortcolumn":"descrizione"
                            },"visible": "true", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "email", "label": "Email", "labelsize":"2","fieldsize":"10", "type": "email", "visible": "true", "disabled": "false", "editable": "true"}
                        ]}
                    ]
                },
                {
                    "name": "rca", "description":"RCA", "collapsable":"true","collapsed":"true",
                    "rules": {
                        "cognome": {required: true}
                    },
                    "messages": {
                        "cognome": {required: "Campo obbligatorio!"}
                    },
                    "rows": [
                        {"cells":[
                            {"name": "idprovincia", "label": "Provincia", "labelsize":"2","fieldsize":"4", "type": "select", "selectParams": {
                                "source": "table",
                                "table":"zone",
                                "keycolumn":"idcomune",
                                "displaycolumn":"provincia",
                                "filter":"attivo=1",
                                "sortcolumn":"comune"
                            },"visible": "true", "editable": "true"},
                            {"name": "idcomune", "label": "Comune", "labelsize":"2","fieldsize":"4", "type": "select", "selectParams": {
                                "source": "table",
                                "table":"zone",
                                "keycolumn":"idcomune",
                                "displaycolumn":"comune",
                                "filter":"attivo=1",
                                "sortcolumn":"comune"
                            },"visible": "true", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "idtipoalimentazione", "label": "Tipo Alim.", "labelsize":"2","fieldsize":"4", "type": "select", "selectParams": {
                                "source": "table",
                                "table":"tipialimentazione",
                                "keycolumn":"idtipoalimentazione",
                                "displaycolumn":"descrizione",
                                "filter":"attivo=1",
                                "sortcolumn":"descrizione"
                            },"visible": "true", "editable": "true"},
                            {"name": "idcilindrata", "label": "Cilindrata", "labelsize":"2","fieldsize":"4", "type": "select", "selectParams": {
                                "source": "table",
                                "table":"cilindrate",
                                "keycolumn":"idcilindrata",
                                "displaycolumn":"descrizione",
                                "filter":"attivo=1",
                                "sortcolumn":"descrizione"
                            },"visible": "true", "editable": "true"}
                        ]}
                    ]
                }
            ]
        };

    </script>

    <script src="js/preventivi_functions.js" type="text/javascript"></script>

