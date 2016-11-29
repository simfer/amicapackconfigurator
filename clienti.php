<?php
include_once "header.php";
include_once "daelib.php";
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Clienti</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="toolbar">
                <button id="btnPrint" type="button" class="btn btn-success"><i class="glyphicon glyphicon-print"></i>&nbsp;Stampa
                </button>
            </div>
            <style type="text/css">
                .table-user-information > tbody > tr {
                    border-top: 1px solid rgb(221, 221, 221);
                }

                .table-user-information > tbody > tr:first-child {
                    border-top: 0;
                }

                .table-user-information > tbody > tr > td {
                    border-top: 0;
                }
                #editModal .modal-dialog  {width:60%;}
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
            <table id="table-clienti"
                   data-toggle="table-clienti"
                   data-url="get_table_data.php?tabella=clienti"
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
                    <th data-field="idcliente" data-align="center" data-sortable="true">ID Cliente</th>
                    <th data-field="cognome" data-align="left" data-sortable="true">Cognome</th>
                    <th data-field="nome" data-align="left" data-sortable="true">Nome</th>
                    <th data-field="professione" data-align="left" data-visible="true" data-sortable="true">Professione</th>
                    <th data-field="email" data-align="left" data-visible="true" data-sortable="true">Email</th>
                    <th data-field="telefono" data-align="left" data-visible="false" data-sortable="true">Telefono</th>
                    <th data-field="cellulare" data-align="left" data-visible="false" data-sortable="true">Cellulare</th>
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
    <script src="js/clienti_functions.js" type="text/javascript"></script>

