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
                .table-user-information > tbody > tr {
                    border-top: 1px solid rgb(221, 221, 221);
                }

                .table-user-information > tbody > tr:first-child {
                    border-top: 0;
                }

                .table-user-information > tbody > tr > td {
                    border-top: 0;
                }
                #dettaglioPreventivo input[type='text'] {width:80%;}

            </style>

            <div class="modal fade" id="dettaglioPreventivo" tabindex="-1" role="dialog" aria-labelledby="dettaglioPreventivo"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="dettaglioPreventivoLabel">Dettaglio preventivo n. <label id="lbl_idpreventivo"></label></h4>
                        </div>
                        <div id="rowDetails" class="modal-body">
                            <div class="panel panel-info">
                                <div class="panel-heading">Cliente n. <label id="lbl_idcliente"></label></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_codicefiscale">C.Fisc.</label>
                                                <input type="text" name="det_codicefiscale" id="det_codicefiscale">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_cognome">Cognome</label>
                                                <input type="text" name="det_cognome" id="det_cognome">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_nome">Nome</label>
                                                <input type="text" name="det_nome" id="det_nome">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_datanascita">Data di nascita</label>
                                                <input type="text" name="det_datanascita" id="det_datanascita">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_email">E-mail</label>
                                                <input type="text" name="det_email" id="det_email">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_telefono">Telefono</label>
                                                <input type="text" name="det_telefono" id="det_telefono">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_cellulare">Cellulare</label>
                                                <input type="text" name="det_cellulare" id="det_cellulare">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3">
                                            <div class="form-group">
                                                <label for="det_professione">Professione</label>
                                                <input type="text" name="det_professione" id="det_professione">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">Polizza RCA</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_provincia">Provincia</label>
                                                <input type="text" name="det_provincia" id="det_provincia">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_comune">Comune</label>
                                                <input type="text" name="det_comune" id="det_comune">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_tipoalimentazione">Tipo alim.</label>
                                                <input type="text" name="det_tipoalimentazione" id="det_tipoalimentazione">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_cilindrata">Cilindrata</label>
                                                <input type="text" name="det_cilindrata" id="det_cilindrata">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_classepotenza">Classe potenza</label>
                                                <input type="text" name="det_classepotenza" id="det_classepotenza">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_classemerito">Classe merito</label>
                                                <input type="text" name="det_classemerito" id="det_classemerito">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_marcaveicolo">Marca veicolo</label>
                                                <input type="text" name="det_marcaveicolo" id="det_marcaveicolo">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_tipoveicolo">Tipo veicolo</label>
                                                <input type="text" name="det_tipoveicolo" id="det_tipoveicolo">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_gruppoetaveicolo">Età veicolo</label>
                                                <input type="text" name="det_gruppoetaveicolo" id="det_gruppoetaveicolo">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_numannisenzasinistri">Anni senza sin.</label>
                                                <input type="text" name="det_numannisenzasinistri" id="det_numannisenzasinistri">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_numsinistridenunciati">Sin. ult. 2 anni</label>
                                                <input type="text" name="det_numsinistridenunciati" id="det_numsinistridenunciati">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="det_massimale">Massimale</label>
                                                <input type="text" name="det_massimale" id="det_massimale">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- here it comes the detail body-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
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
    <script src="js/preventivi_functions.js" type="text/javascript"></script>

