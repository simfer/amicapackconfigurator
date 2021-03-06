<?php
include_once "header.php";
include_once "daelib.php";
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Utenti</h1>
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
                .modal-dialog  {width:60%;}
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

            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal" aria-hidden="true">
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
            <table id="table-utenti"
                   data-toggle="table-utenti"
                   data-url="get_table_data.php?tabella=utenti"
                   data-method="GET"
                   data-toolbar="#toolbar"
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
                    <th data-field="idutente" data-align="center" data-sortable="true">ID Utente</th>
                    <th data-field="username" data-align="left" data-sortable="true">Username</th>
                    <th data-field="cognome" data-align="left" data-sortable="true">Cognome</th>
                    <th data-field="nome" data-align="left" data-sortable="true">Nome</th>
                    <th data-field="email" data-align="left" data-visible="true" data-sortable="true">Email</th>
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
            "table":"utenti",
            "labelForNew":"Nuovo utente",
            "labelForEdit":"Modifica utente",
            "keyfield":"idutente",
            "autoincrement":"true",
            "buttons": [
                {"name": "btnChiudi","caption":"Chiudi","class":"btn btn-default","dismiss":"true"},
                {"name": "btnSalva","caption":"Salva","class":"btn btn-primary","dismiss":"true"}],
            "panels":[
                {
                    "name": "utente", "description":"Utente", "collapsable":"false","collapsed":"false",
                    "rules": {
                        "username": {required: true},
                        "password": {required: true, minlength: 6}
                    },
                    "messages": {
                        "username": {required: "Campo obbligatorio!"},
                        "password": {required: "Campo obbligatorio!", minlength: "La password deve essere lunga almeno 6 caratteri!"}
                    },
                    "rows": [
                        {"cells":[
                            {"name": "username", "label": "Username", "labelsize":"2","fieldsize":"10", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "password", "label": "Password", "labelsize":"2","fieldsize":"10", "type": "password", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "cognome", "label": "Cognome", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
                            {"name": "nome", "label": "Nome", "labelsize":"2","fieldsize":"4", "type": "text", "visible": "true", "disabled": "false", "editable": "true"}
                        ]},
                        {"cells":[
                            {"name": "email", "label": "Email", "labelsize":"2","fieldsize":"10", "type": "email", "visible": "true", "disabled": "false", "editable": "true"}
                        ]}
                    ]

                }
            ]
        };

    </script>

    <script src="js/global_functions.js" type="text/javascript"></script>

