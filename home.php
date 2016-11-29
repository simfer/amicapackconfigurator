<?php
    include_once "header.php";
    include_once "daelib.php";
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Home</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-child fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=GetNumberOfRecords("clienti","attivo=1")?></div>
                            <div>Clienti</div>
                        </div>
                    </div>
                </div>
                <a href="clienti.php">
                    <div class="panel-footer">
                        <span class="pull-left">Dettagli</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=GetNumberOfRecords("preventivi","attivo=1")?></div>
                            <div>Preventivi</div>
                        </div>
                    </div>
                </div>
                <a href="preventivi.php">
                    <div class="panel-footer">
                        <span class="pull-left">Dettagli</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=GetNumberOfRecords("polizzeaxa","attivo=1")?></div>
                            <div>Polizze AXA</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Dettagli</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-asterisk fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?=GetNumberOfRecords("polizzeaugusta","attivo=1")?></div>
                            <div>Polizze AUGUSTA</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Dettagli</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Notizie
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart">
                        <h3>AGGIORNAMENTO del 20 novembre 2016</h3>
                        <ul>
                            <li>
                                1. Nel menù a tendina “Marca” mancano alcuni marchi di autovettura
                                <br>
                                <strong style="color: red">Purtroppo i marchi elencati sono quelli riportati sul fascicolo "protezione al volante" di Axa.
                                E' necessario contattare Loffredo per farsi dare i parametri relativi all'inserimento di ulteriori altri marchi.
                                </strong>
                            </li>
                            <li>
                                2. Nel menù “anzianità veicolo” i valori non sono riportati in ordine cronologico
                                <br>
                                <strong style="color: red">Sistemato</strong>
                            </li>
                            <li>
                                3. I massimali vanno trasformati in un unico importo in valore (esempio: 8/8/8 diventa 8 milioni)
                                <strong style="color: red">Sistemato</strong>
                            </li>
                            <li>
                                4. Di lato al flag “guida esperta” va aggiunto quello relativo a “Polizza infortunio conducente” da selezionare già in via obbligatoria.
                                Questa copertura è obbligatoria ed ha un valore da aggiungere al premio pari ad euro 100,00 con un margine di 10 euro.
                                <strong style="color: red">Funzionalità aggiunta!</strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Area notifiche
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-comment fa-fw"></i> Nuova pratica da autorizzare
                                    <span class="pull-right text-muted small"><em>2 giorni fa</em>
                                    </span>
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-twitter fa-fw"></i> Pratica n. 23767 non approvata
                                    <span class="pull-right text-muted small"><em>4 giorni fa</em>
                                    </span>
                        </a>
                    </div>
                    <!-- /.list-group -->
                    <a href="#" class="btn btn-default btn-block">Vedi tutte le notifiche</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<script type="text/javascript">
    jQuery().ready(function() {


    });
</script>

<?
    include_once "footer.php";
?>
