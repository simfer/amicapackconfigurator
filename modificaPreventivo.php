<?php
include_once "header.php";
include_once "daelib.php";

// Controllo se è stato passato il parametro 'idpreventivo' alla pagina
if (isset($_GET['idpreventivo']) && !empty($_GET['idpreventivo'])) {
    // se il parametro è presente allora si tratta di una modifica di un preventivo esistente
    $idpreventivo = $_GET['idpreventivo'];
    $title = "Modifica preventivo";
} else {
    // se il parametro non è presente, si tratta di un nuovo preventivo
    $title = "Nuovo preventivo";
}

// Controllo se è stato passato il parametro 'datitest' alla pagina
if (isset($_GET['datitest']) && !empty($_GET['datitest'])) {
    // se il parametro è presente allora un campo nascosto denominato 'datitest' assumerà il valore 'true'
    $datitest = $_GET['datitest'];
}

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
            <h1 class="page-header"><?=$title?></h1>
            <h5 style="color: #ff7c0a;text-indent: 50px;">I campi contrassegnati con * sono obbligatori</h5>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <input type="hidden" value="<?=$idpreventivo?>" id="idpreventivo" name="idpreventivo">
            <input type="hidden" value="<?=$datitest?>" id="datitest" name="datitest">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <label><input type="checkbox" id=chkDatiCliente name=chkDatiCliente></label>&nbsp;&nbsp;&nbsp;1. Dati cliente
                        </h4>
                    </div>
                    <div id="clpsDatiCliente" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmCliente" id="frmCliente">
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="codicefiscale">Codice fiscale *</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control full-width" id="codicefiscale" name="codicefiscale" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="cognome">Cognome *</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="cognome" name="cognome" />
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="nome">Nome *</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="nome" name="nome" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="email">Email *</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control full-width" id="email" name="email"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="telefono">Telefono</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control full-width" id="telefono" name="telefono" />
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="cellulare">Cellulare</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control full-width" id="cellulare" name="cellulare"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="professione">Professione *</label>
                                        <div class="col-sm-3">
                                            <?=CreateSelect("professione","professioni","","idprofessione","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2">Data di nascita *</label>
                                        <div class="control-label col-sm-1">
                                            <select class="form-control full-width" id="giorno" name="giorno">
                                                <?=CreateDays() ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <div class="control-label col-sm-1">
                                            <select class="form-control full-width" id="mese" name="mese">
                                                <?=CreateMonths() ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <div class="control-label col-sm-2">
                                            <select class="form-control full-width" id="anno" name="anno">
                                                <?=CreateYears() ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <div class="control-label col-sm-1">
                                            <input class="form-control full-width" id="etaintestatario" name="etaintestatario" disabled>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" id="clpsDatiRCAMain">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <label><input type="checkbox" id=chkDatiRCA name=chkDatiRCA></label>&nbsp;&nbsp;&nbsp;2. Polizza RCA
                        </h4>
                    </div>
                    <div id="clpsDatiRCA" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmRCA" id="frmRCA">
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="provincia">Provincia *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("provincia","zone","","provincia","provincia","provincia","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="comune">Comune *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("comune","zone","provincia","idcomune","comune","comune","form-control full-width") ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="tipoalimentazione">Tipo alimentazione *</label>
                                        <div class="col-sm-2">
                                            <?=CreateSelect("tipoalimentazione","tipialimentazione","","idtipoalimentazione","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="cilindrata">Cilindrata *</label>
                                        <div class="col-sm-2">
                                            <?=CreateSelect("cilindrata","cilindrate","","idcilindrata","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="classepotenza">Classe potenza *</label>
                                        <div class="col-sm-2">
                                            <?=CreateSelect("classepotenza","classipotenza","idcilindrata,idtipoalimentazione","idclassepotenza","descrizione","idclassepotenza","form-control full-width") ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="marcaveicolo">Marca veicolo *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("marcaveicolo","marcheveicolo","","idmarcaveicolo","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="tipoveicolo">Tipo veicolo *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("tipoveicolo","tipiveicolo","","idtipoveicolo","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="gruppoetaveicolo">Età veicolo *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("gruppoetaveicolo","gruppietaveicolo","","idgruppoetaveicolo","descrizione","idgruppoetaveicolo","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="classemerito">Classe di merito * </label>
                                        <div class="control-label col-sm-2">
                                            <select class="form-control full-width" id="classemerito" name="classemerito">
                                                <?=CreateClassiMerito() ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="numannisenzasinistri">Anni senza sinistri *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("numannisenzasinistri","numannisenzasinistri","","idnumannisenzasinistri","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="numsinistridenunciati">Sinistri ult. 2 anni *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("numsinistridenunciati","numsinistridenunciati","","idnumsinistridenunciati","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="massimale">Massimale *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("massimale","massimali","","idmassimale","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="tipofrazionamento">Frazionamento *</label>
                                        <div class="col-sm-4">
                                            <?=CreateSelect("tipofrazionamento","tipifrazionamento","","idtipofrazionamento","descrizione","descrizione","form-control full-width") ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="blackbox">Black-box *</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="blackbox" id="blackbox" class="form-control full-width" checked disabled
                                                   data-toggle="tooltip" data-placement="auto left" data-delay='{"show":"2000", "hide":"500"}'
                                                   title="La formula Black-box è sempre abilitata!">
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="blackbox">Polizza inf. cond. *</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="polinfcond" id="polinfcond" class="form-control full-width" checked disabled
                                                   data-toggle="tooltip" data-placement="auto left" data-delay='{"show":"2000", "hide":"500"}'
                                                   title="La formula Polizza Infortunio Conducente è sempre abilitata!">
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="guidaesperta">Guida esperta</label>
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="guidaesperta" id="guidaesperta" class="form-control full-width"
                                                   data-toggle="tooltip" data-placement="auto left" data-delay='{"show":"2000", "hide":"500"}'
                                                   title="La polizza con formula guida esperta prevede una limitazione
                                                   dell'assicurazione RCA con riduzione del costo della garanzia se assicuro
                                                   che il veicolo viene guidato da persone «esperte». Per avere
                                                   copertura assicurativa in caso di sinistro, l'auto deve essere guidata
                                                   da persone con età minima 25 anni e con patente da almeno 2 anni.">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-6">
                                            <button style="width: 100%" id="btnMostraDettaglio" data-toggle="modal" data-target="#dettaglioRCA"
                                                    type="button" class="btn btn-primary can-be-enabled">Mostra dettaglio calcoli</button>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="totalepremioanteimposte">Tot. premio ante imp.</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="totalepremioanteimposte" name="totalepremioanteimposte" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-8" for="totaleimposte">Totale imposte</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="totaleimposte" name="totaleimposte" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-8" for="totalepremio">Totale premio</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="totalepremio" name="totalepremio" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-8" for="commissioniagenzia">Commissioni agenzia</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="commissioniagenzia" name="commissioniagenzia" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-8" for="totalerca">Totale RCA</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control full-width" id="totalerca" name="totalerca" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" id="clpsDatiAugustaMain">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <label><input type="checkbox" id=chkDatiAugusta name=chkDatiAugusta></label>&nbsp;&nbsp;&nbsp;3. Polizza AUGUSTA
                        </h4>
                    </div>
                    <div id="clpsDatiAugusta" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmAugusta" id="frmAugusta">

                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-4" for="valoredaassicurare">Valore da assicurare *</label>
                                        <div class="col-sm-2">
                                            <input type="number" class="form-control full-width" name="valoredaassicurare" id="valoredaassicurare">
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2">Categoria *</label>
                                        <div class="col-sm-4">
                                            <label class="radio-inline"><input type="radio" name="categoria" data-toggle="radio" id="firnuovo" value="N" checked>Nuovo</label>
                                            <label class="radio-inline"><input type="radio" name="categoria" data-toggle="radio" id="firusato" value="U">Usato</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="regioneAugusta">Reg. *</label>
                                        <div class="col-sm-2">
                                            <?=CreateSelect("regioneAugusta","zoneaugusta","","regione","regione","regione","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="provinciaAugusta">Prov. *</label>
                                        <div class="col-sm-1">
                                            <?=CreateSelect("provinciaAugusta","zoneaugusta","regione","provincia","provincia","provincia","form-control full-width") ?>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="duratacopertura">Dur. copert. (mesi) *</label>
                                        <div class="col-sm-6">
                                            <div class="btn-group" id="duratacopertura">
                                                <button id="btn12" type="button" class="btn btn-info locked_inactive">12</button>
                                                <button id="btn18" type="button" class="btn btn-default unlocked_inactive">18</button>
                                                <button id="btn24" type="button" class="btn btn-default unlocked_inactive">24</button>
                                                <button id="btn30" type="button" class="btn btn-default unlocked_inactive">30</button>
                                                <button id="btn36" type="button" class="btn btn-default unlocked_inactive">36</button>
                                                <button id="btn42" type="button" class="btn btn-default unlocked_inactive">42</button>
                                                <button id="btn48" type="button" class="btn btn-default unlocked_inactive">48</button>
                                                <button id="btn54" type="button" class="btn btn-default unlocked_inactive">54</button>
                                                <button id="btn60" type="button" class="btn btn-default unlocked_inactive">60</button>
                                                <button id="btn72" type="button" class="btn btn-default unlocked_inactive">72</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="tipocopertura" id="tcfir" checked disabled>
                                            <i></i>FIR *
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="coeffF">Coeff. FIR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="coeffF" id="coeffF" disabled>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="importoF">Importo FIR</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="importoF" id="importoF" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="tipocopertura" id="tccollisione">
                                            <i></i>Collisione
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="coeffC">Coeff. Coll.</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="coeffC" id="coeffC" disabled>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="importoC">Importo Coll.</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="importoC" id="importoC" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-2">
                                            <input type="checkbox" name="tipocopertura" id="tckasko">
                                            <i></i>KASKO
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="coeffK">Coeff. KASKO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="coeffK" id="coeffK" disabled>
                                        </div>
                                    </div>
                                    <div class="cell">
                                        <label class="control-label col-sm-2" for="importoK">Importo KASKO</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="importoK" id="importoK" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="cell">
                                        <label class="control-label col-sm-9" for="importoK">TOTALE</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control full-width" name="totaleaugusta" id="totaleaugusta" disabled>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" id="clpsDatiAccessoriMain">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <label><input type="checkbox" id=chkDatiAccessori name=chkDatiAccessori></label>&nbsp;&nbsp;&nbsp;4. Accessori
                        </h4>
                    </div>
                    <div id="clpsDatiAccessori" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmAccessori" id="frmAccessori">
                                <?=CreateTableAccessori()?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" id="clpsDatiCopertureAggiuntiveMain">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <label><input type="checkbox" id=chkDatiCopertureAggiuntive name=chkDatiCopertureAggiuntive></label>&nbsp;&nbsp;&nbsp;5. Coperture aggiuntive
                        </h4>
                    </div>
                    <div id="clpsDatiCopertureAggiuntive" class="panel-collapse collapse">
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" name="frmCopertureAggiuntive" id="frmCopertureAggiuntive">
                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="tipocoperturaagg" data-toggle="checkbox" id="ptl">
                                            &nbsp;<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
                                                     data-placement="auto left" data-delay='{"show":"1000", "hide":"500"}'
                                                     title="Grazie alla Polizza stipulata con D.A.S. SpA, Società di Assicurazione specializzata nel ramo Tutela Legale,
                                                     viene offerta una copertura nell'ambito della Circolazione Stradale a favore dei Clienti di Amica & C SRL.
                                                     Per ulteriori informazioni fai click qui."></i>&nbsp;Polizza Tutela Legale
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="ptlpremio">Premio *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="ptlpremio" name="ptlpremio" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="ptldurata">Durata *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="ptldurata" name="ptldurata" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="ptlcosto">Costo *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="ptlcosto" name="ptlcosto" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="ptlmargine">Marg. *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="ptlmargine" name="ptlmargine" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="cell">
                                        <div class="col-sm-4">
                                            <input type="checkbox" name="tipocoperturaagg" data-toggle="checkbox" id="eg">
                                            &nbsp;<i class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
                                                     data-placement="auto left" data-delay='{"show":"1000", "hide":"500"}'
                                                     title="Estensione garanzia!"></i>&nbsp;Estensione Garanzia
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="egpremio">Premio *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="egpremio" name="egpremio" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="egdurata">Durata *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="egdurata" name="egdurata" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="egcosto">Costo *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="egcosto" name="egcosto" class="form-control input-sm" disabled value="40" readonly/>
                                        </div>
                                    </div>

                                    <div class="cell">
                                        <label class="control-label col-sm-1" for="egmargine">Marg. *</label>
                                        <div class="col-sm-1">
                                            <input type="number" id="egmargine" name="egmargine" class="form-control input-sm" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footerBar" style="float: right">
                <button id="btnAnnulla" type="button" class="btn btn-lg btn-warning">
                    <i class="glyphicon glyphicon-arrow-left"></i>&nbsp;Annulla
                </button>
                <button id="btnSalva" type="button" class="btn btn-lg btn-success">
                    <i class="glyphicon glyphicon-floppy-save"></i>&nbsp;Salva
                </button>
            </div>
            <div class="modal fade" id="dettaglioRCA" tabindex="-1" role="dialog" aria-labelledby="dettaglioRCA"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="dettaglioRCALabel">Dettaglio RCA</h4>
                        </div>
                        <div id="dettaglioRCABody" class="modal-body">
                            <!-- here it comes the detail body-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
    include_once "footer.php";
    ?>
    <script type="text/javascript">

        jQuery().ready(function() {

            //*************************************************************
            // Funzioni di servizio
            //*************************************************************

            // Arrotonda il valore v a 2 decimali dopo la virgola
            function RoundTo2Decs(v) {
                return Math.round(v * 100) / 100;
            }

            // Aggiunge degli zeri a sinistra di un numero 'num' riempendolo fino alla lunghezza 'size'
            function pad(num, size) {
                var s = num+"";
                while (s.length < size) s = "0" + s;
                return s;
            }

            //*************************************************************
            // Inizializzazione tooltip e popover
            //*************************************************************
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();


            //*************************************************************
            // Validazione form
            //*************************************************************
            // Validazione form cliente
            $('#frmCliente').validate({
                rules: {
                    codicefiscale: {
                        minlength: 16,
                        maxlength: 16,
                        required: true
                    },
                    email: {
                        email:true,
                        required: true
                    },
                    nome: {
                        required: true
                    },
                    cognome: {
                        required: true
                    },
                    professione: {
                        required: true
                    },
                    giorno: {
                        required: true
                    },
                    mese: {
                        required: true
                    },
                    anno: {
                        required: true
                    }
                },
                messages: {
                    codicefiscale: {
                        minlength: "Il codice fiscale deve essere lungo 16 caratteri",
                        maxlength: "Il codice fiscale deve essere lungo 16 caratteri",
                        required: "Campo richiesto"
                    },
                    email: {
                        email:"Formato email non valido",
                        required: "Campo richiesto"
                    },
                    nome: {
                        required: "Campo richiesto"
                    },
                    cognome: {
                        required: "Campo richiesto"
                    },
                    professione: {
                        required: "Campo richiesto"
                    },
                    giorno: {
                        required: "Campo richiesto"
                    },
                    mese: {
                        required: "Campo richiesto"
                    },
                    anno: {
                        required: "Campo richiesto"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.cell').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.cell').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Validazione form RCA
            $('#frmRCA').validate({
                rules: {
                    provincia: {
                        required: true
                    },
                    comune: {
                        required: true
                    },
                    classepotenza: {
                        required: true
                    },
                    classemerito: {
                        required: true
                    },
                    cilindrata: {
                        required: true
                    },
                    marcaveicolo: {
                        required: true
                    },
                    tipoveicolo: {
                        required: true
                    },
                    gruppoetaveicolo: {
                        required: true
                    },
                    tipoalimentazione: {
                        required: true
                    },
                    numannisenzasinistri: {
                        required: true
                    },
                    numsinistridenunciati: {
                        required: true
                    },
                    tipofrazionamento: {
                        required: true
                    }
                },
                messages: {
                    provincia: {
                        required: "Campo richiesto!"
                    },
                    comune: {
                        required: "Campo richiesto!"
                    },
                    classepotenza: {
                        required: "Campo richiesto!"
                    },
                    classemerito: {
                        required: "Campo richiesto!"
                    },
                    cilindrata: {
                        required: "Campo richiesto!"
                    },
                    marcaveicolo: {
                        required: "Campo richiesto!"
                    },
                    tipoveicolo: {
                        required: "Campo richiesto!"
                    },
                    gruppoetaveicolo: {
                        required: "Campo richiesto!"
                    },
                    tipoalimentazione: {
                        required: "Campo richiesto!"
                    },
                    numannisenzasinistri: {
                        required: "Campo richiesto!"
                    },
                    numsinistridenunciati: {
                        required: "Campo richiesto!"
                    },
                    tipofrazionamento: {
                        required: "Campo richiesto!"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.cell').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.cell').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Validazione form Augusta
            $('#frmAugusta').validate({
                rules: {
                    valoredaassicurare: {
                        required: true
                    },
                    regioneAugusta: {
                        required: true
                    },
                    provinciaAugusta: {
                        required: true
                    }
                },
                messages: {
                    valoredaassicurare: {
                        required: "Campo richiesto!"
                    },
                    regioneAugusta: {
                        required: "Campo richiesto!"
                    },
                    provinciaAugusta: {
                        required: "Campo richiesto!"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.cell').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.cell').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            // Validazione form Coperture aggiuntive
            $('#frmCopertureAggiuntive').validate({
                rules: {
                    ptlpremio: {
                        required: true
                    },
                    ptldurata: {
                        required: true
                    },
                    ptlcosto: {
                        required: true
                    },
                    ptlmargine: {
                        required: true
                    },
                    egpremio: {
                        required: true
                    },
                    egdurata: {
                        required: true
                    },
                    egcosto: {
                        required: true
                    },
                    egmargine: {
                        required: true
                    }
                },
                messages: {
                    ptlpremio: {
                        required: "Campo richiesto!"
                    },
                    ptldurata: {
                        required: "Campo richiesto!"
                    },
                    ptlcosto: {
                        required: "Campo richiesto!"
                    },
                    ptlmargine: {
                        required: "Campo richiesto!"
                    },
                    egpremio: {
                        required: "Campo richiesto!"
                    },
                    egdurata: {
                        required: "Campo richiesto!"
                    },
                    egcosto: {
                        required: "Campo richiesto!"
                    },
                    egmargine: {
                        required: "Campo richiesto!"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.cell').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.cell').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });


            //*************************************************************
            // Gestione accordion
            //*************************************************************

            $("#chkDatiRCA").on('change',function(){
                if(!$("#chkDatiRCA").prop('checked')) {
                    $("#clpsDatiRCA").collapse('hide');

                } else {
                    $("#clpsDatiRCA").collapse('show');
                }
            });

            $("#chkDatiAugusta").on('change',function(){
                if(!$("#chkDatiAugusta").prop('checked')) {
                    $("#clpsDatiAugusta").collapse('hide');

                } else {
                    $("#clpsDatiAugusta").collapse('show');
                }
            });

            $("#chkDatiAccessori").on('change',function(){
                if(!$("#chkDatiAccessori").prop('checked')) {
                    $("#clpsDatiAccessori").collapse('hide');

                } else {
                    $("#clpsDatiAccessori").collapse('show');
                }
            });

            $("#chkDatiCopertureAggiuntive").on('change',function(){
                if(!$("#chkDatiCopertureAggiuntive").prop('checked')) {
                    $("#clpsDatiCopertureAggiuntive").collapse('hide');

                } else {
                    $("#clpsDatiCopertureAggiuntive").collapse('show');
                }
            });


            //*************************************************************
            // Gestione form Cliente
            //*************************************************************

            var cliente = {};
            cliente.idprofessione = "";
            cliente.etaintestatario = 0;

            $("#frmCliente input").on('change',function () {
                var v = $(this).val();
                $(this).val(v.toUpperCase());

                var controlId = $(this).prop('id');
                var codicefiscale = $(this).val();

/*
                if (controlId == 'codicefiscale') {
                    console.log(controlId + "xxx");

                    $.ajax({
                        url: "ajax_responder.php",
                        dataType: "json",
                        type: "post",
                        data: {codicefiscale:codicefiscale,ajax_function:"ControllaEsistenzaCodiceFiscale"},
                        async:false,
                        cache: false,
                        success: function (response) {
                            console.log(response);
                            //var result = response['result']['valorepremiobase'];
                        },
                        error: function (response) {
                            //var result = response['result'];
                            //var status = response['status'];
                            //var sql = response['sql'];
                            //toastr.error("ERRORE: " + result);
                            console.log(response);
                        }
                    });

                }
*/
            });

            // Cambio professione
            $('#professione').on('change', function () {
                cliente.idprofessione = $(this).find(':selected').prop('id');
                cliente.professione = $(this).find(':selected').prop('text');
                ControllaFormRCA(); //Controllo se la form RCA è completa per calcolarne il totale
            });

            //Cambio giorno di nascita
            $("#giorno").on("change", function () {
                cliente.etaintestatario = calcolaEta();
                ControllaFormRCA(); //Controllo se la form RCA è completa per calcolarne il totale
            });

            //Cambio mese di nascita
            $("#mese").on("change", function () {
                cliente.etaintestatario = calcolaEta();
                ControllaFormRCA(); //Controllo se la form RCA è completa per calcolarne il totale
            });

            //Cambio anno di nascita
            $("#anno").on("change", function () {
                cliente.etaintestatario = calcolaEta();
                ControllaFormRCA(); //Controllo se la form RCA è completa per calcolarne il totale
            });

            // Calcola l'età corrente di un soggetto in base alla sua data di nascita
            function calcolaEta() {

                birthMonth = $("#mese").val();
                birthDay = $("#giorno").val();
                birthYear = $("#anno").val();


                if (!birthDay | !birthMonth | !birthYear) return 0;

                todayDate = new Date();
                todayYear = todayDate.getFullYear();
                todayMonth = todayDate.getMonth();
                todayDay = todayDate.getDate();
                age = todayYear - birthYear;

                if (todayMonth < birthMonth - 1)
                {
                    age--;
                }

                if (birthMonth - 1 == todayMonth && todayDay < birthDay)
                {
                    age--;
                }
                $("#etaintestatario").val(age);
                return age;
            }



            //*************************************************************
            // Gestione form RCA
            //*************************************************************

            // Creo un JSON per contenere tutti i dati da passare alla funzione salva. La variabile viene anche inizializzata
            var rca = {};

            // Imposto i valori fissi
            rca.idmassimale = 1;
            $("#massimale").val(rca.idmassimale);
            rca.blackbox = true;
            rca.polinfcond = true;
            $("#blackbox").prop('checked',rca.blackbox);
            $("#polinfcond").prop('checked',rca.polinfcond);
            // Faccio un clone dell'elenco dei comuni e delle classi di potenza. Quando vengono filtrati serve conservare l'elenco originale
            var comuni = $("#comune > option").clone();
            var classipotenza = $("#classepotenza > option").clone();

            // Se il valore della provincia cambia devo filtrare opportunamente i suoi comuni
            $('#provincia').on('change', function () {
                rca.provincia = $(this).find(':selected').prop('id');

                var html = "";

                // Rigenero l'elenco dei comuni in base alla provincia scelta
                comuni.each(function() {
                    if ($(this).attr('provincia') == rca.provincia) {
                        html = html + '<option id="' + $(this).attr('id') + '" value="' + $(this).val() + '">' + $(this).text() + '</option>';
                    }
                });

                $("#comune").html(html);

                // Simulo un evento change sui comuni per aggiornarne il valore
                $("#comune").trigger("change");
            });

            // Se il valore del comune cambia aggiorno il JSON
            $('#comune').on('change', function () {
                rca.idcomune = $(this).val();
            });

            // Simulo un evento change sulle province
            $("#provincia").trigger("change");


            // Se il tipo alimentazione cambia devo filtrare opportunamente le classi potenza
            $('#tipoalimentazione').on('change', function () {
                rca.tipoalimentazione = $(this).find(':selected').prop('id');
                FiltraClassePotenza(); // La classe potenza va filtrata in base al tipo alimentazione e alla cilindrata
            });


            // Se la cilindrata cambia devo filtrare opportunamente le classi potenza
            $('#cilindrata').on('change', function () {
                var cilindrata = $(this).find(':selected').prop('id');

                // se il valore di cilindrata è > 24 lo fisso a 24 perché tutti gli altri valori vengono accomunati
                rca.idcilindrata = (eval(cilindrata) > 24 ? 24 : eval(cilindrata));

                FiltraClassePotenza(); // La classe potenza va filtrata in base al tipo alimentazione e alla cilindrata
            });

            // Filtra la classe di potenza in base al tipo alimentazione e alla cilindrata
            function FiltraClassePotenza() {
                var html = "";

                // Rigenero l'elenco delle classi potenza in base al tipo di alimentazione
                classipotenza.each(function() {
                    //if ($(this).attr('idtipoalimentazione') == rca.tipoalimentazione) {
                    if ($(this).attr('idtipoalimentazione') == rca.tipoalimentazione && $(this).attr('idcilindrata') == rca.idcilindrata) {
                        html = html + '<option id="' + $(this).attr('id') + '" value="' + $(this).val() + '">' + $(this).text() + '</option>';
                    }
                });

                $("#classepotenza").html(html);

                // Simulo un evento change sui comuni per aggiornarne il valore
                $("#classepotenza").trigger("change");
            }

            // Se il valore della classe potenza cambia aggiorno il JSON
            $('#classepotenza').on('change', function () {
                rca.idclassepotenza = $(this).val();
            });

            // Simulo un evento change sul tipo alimentazione
            $("#tipoalimentazione").trigger("change");

            // Funzione per il calcolo del valore del premio base imponibile. Viene passata come parametro una variabile json
            // contenente idcomune,idclassepotenza e classemerito.
            // Viene restituita una promessa contenente il valore del premio
            // Se nessun valore viene trovato o in caso di errore viene semplicemente restituito 0
            // Siccome lo 0 non è ammesso bisognerà controllare che in caso si presenti questo valore, venga stampato un
            // messaggio che informi che il premio base imponibile non è disponibile
            function LeggiValorePremioBase() {
                var deferred = $.Deferred();

                rca.ajax_function = "LeggiValorePremioBase";
                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    data: rca,
                    cache: false,
                    success: function (response) {
                        var result = response['result']['valorepremiobase'];
                        deferred.resolve(eval(result));
                    },
                    error: function (response) {
                        var result = response['result'];
                        var status = response['status'];
                        var sql = response['sql'];
                        toastr.error("ERRORE: " + result);
                        console.log(response);
                        deferred.resolve(0);
                    }
                });
                return deferred.promise();
            }

            // Legge i valori dei parametri per il calcolo del totale RCA
            function LeggiValoriParametri() {
                var deferred = $.Deferred();
                v = {};
                rca.ajax_function = "LeggiValoriParametri";

                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    data: rca,
                    cache: false,
                    success: function (response) {
                        var result = response['result'];
                        $.each(result,function(i,obj) {
                            v[obj.id] = eval(obj.valore);
                        });
                        deferred.resolve(v);
                    },
                    error: function (response) {
                        console.log(response);
                        var result = response['result'];
                        var status = response['status'];
                        var sql = response['sql'];
                        toastr.error("ERRORE: " + result);
                        deferred.resolve(v);
                    }
                });
                return deferred.promise();
            }

            // Esegue il calcolo di tutte le somme parziali per calcolo del premio finale
            // Se il valore finale NON è un valore numerico viene mostrata la scritta "DATI MANCANTI"
            function CalcolaSommeParziali() {
                rca.S01 = rca.valorepremiobase * (100 + rca.valoriparametri.massimale) / 100;
                rca.S02 = rca.S01 * (100 + rca.valoriparametri.etaintestatario) / 100;
                rca.S03 = rca.S02 * (100 + rca.valoriparametri.professione) / 100;
                rca.S04 = rca.S03 * (100 + rca.valoriparametri.marcaveicolo) / 100;
                rca.S05 = rca.S04 * (100 + rca.valoriparametri.tipoveicolo) / 100;
                rca.S06 = rca.S05 * (100 + rca.valoriparametri.gruppoetaveicolo) / 100;
                rca.S07 = rca.S06 * (100 + rca.valoriparametri.numsinistridenunciati) / 100;
                rca.S08 = rca.S07 * (100 + rca.valoriparametri.numannisenzasinistri) / 100;

                rca.S09 = rca.S08 * (100 + ((rca.blackbox) ? rca.valoriparametri.blackbox : 0)) / 100;
                rca.S10 = rca.S09 * (100 + ((rca.guidaesperta) ? rca.valoriparametri.guidaesperta : 0)) / 100;
                console.log(rca.S10);
                rca.S11 = rca.S10 * (100 + rca.valoriparametri.scontoconvenzione) / 100;
                console.log(rca.S11);

                rca.S18 = RoundTo2Decs(rca.S11 + ((rca.polinfcond) ? rca.valoriparametri.polinfcond : 0));

                rca.ssn = rca.S18 * rca.valoriparametri.ssn / 100;
                rca.imposte = rca.S18 * rca.valoriparametri.imposte / 100;

                rca.totaleimposte = RoundTo2Decs(rca.ssn + rca.imposte);

                rca.S19 = rca.S18 + rca.totaleimposte + rca.valoriparametri.ard;

                rca.commissioniagenzia = RoundTo2Decs(rca.S19 * rca.valoriparametri.commissioniagenzia / 100);
                rca.S20 = rca.S19 + rca.commissioniagenzia;
                console.log(rca);
                if (rca.S20) {
                    rca.totalerca = RoundTo2Decs(rca.S20);
                    $("#totalepremioanteimposte").val(rca.S18);
                    $("#totaleimposte").val(rca.totaleimposte);
                    $("#totalepremio").val(rca.S19);
                    $("#commissioniagenzia").val(rca.commissioniagenzia);
                    $("#totalerca").val(rca.totalerca);
                } else {
                    rca.totalerca = 0;
                    $("#totalepremioanteimposte").val(0);
                    $("#totaleimposte").val(0);
                    $("#totalepremio").val(0);
                    $("#commissioniagenzia").val(0);
                    $("#totalerca").val("DATI PRESENTI SOLO PER PROV. CE!");
                }
            }

            // Genera il dettaglio per le somme parziali
            function GeneraDettaglio() {
                // leggo le descrizioni dei valori selezionati nelle varie combo
                var zona = $("#comune").find(':selected').prop('text');
                var cilindrata = $("#cilindrata").find(':selected').prop('text');
                var tipoalimentazione = $("#tipoalimentazione").find(':selected').prop('text');

                var massimale = $("#massimale").find(':selected').prop('text');
                var marcaveicolo = $("#marcaveicolo").find(':selected').prop('text');
                var tipoveicolo = $("#tipoveicolo").find(':selected').prop('text');
                var gruppoetaveicolo = $("#gruppoetaveicolo").find(':selected').prop('text');
                var numsinistridenunciati = $("#numsinistridenunciati").find(':selected').prop('text');
                var numannisenzasinistri = $("#numannisenzasinistri").find(':selected').prop('text');

                // preparo l'HTML da mostrare nella form modale
                var html = '<form class="form-horizontal">' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-9">Premio base di rif. (Zona ' + zona +
                    '; Cilindrata ' + cilindrata + '; Alim. ' + tipoalimentazione + '; CU ' + rca.classemerito + ')</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + rca.valorepremiobase + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Massimale ' + massimale + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.massimale + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + rca.valorepremiobase + ' x ' + (100 + rca.valoriparametri.massimale)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S01) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Età intestatario ' + cliente.etaintestatario + ' anni </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.etaintestatario + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S01) + ' x ' + (100 + rca.valoriparametri.etaintestatario)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S02) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Professione: ' + cliente.professione + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.professione + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S02) + ' x ' + (100 + rca.valoriparametri.professione)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S03) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Marca veicolo: ' + marcaveicolo + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.marcaveicolo + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S03) + ' x ' + (100 + rca.valoriparametri.marcaveicolo)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S04) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Tipo veicolo: ' + tipoveicolo + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.tipoveicolo + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S04) + ' x ' + (100 + rca.valoriparametri.tipoveicolo)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S05) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Età veicolo: ' + gruppoetaveicolo + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.gruppoetaveicolo + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S05) + ' x ' + (100 + rca.valoriparametri.gruppoetaveicolo)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S06) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Sinistri ultimi 2 anni: ' + numsinistridenunciati + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.numsinistridenunciati + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S06) + ' x ' + (100 + rca.valoriparametri.numsinistridenunciati)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S07) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Anni senza sinistri: ' + numannisenzasinistri + ' </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.numannisenzasinistri + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S07) + ' x ' + (100 + rca.valoriparametri.numannisenzasinistri)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S08) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Black box: Sì </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.blackbox + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S08) + ' x ' + (100 + rca.valoriparametri.blackbox)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S09) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Guida esperta: Sì </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.guidaesperta + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S09) + ' x ' + (100 + rca.valoriparametri.guidaesperta)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S10) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Totale imponibile (con convenzione) </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.scontoconvenzione + '%</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S10) + ' x ' + (100 + rca.valoriparametri.scontoconvenzione)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S11) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-9 right">Premio imponibile (P.I.) </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S11) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3">Polizza inf. cond.: Sì </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.polinfcond + '€</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + rca.valoriparametri.polinfcond + '€</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S18) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3"> + S.S.N (' + rca.valoriparametri.ssn + '% del P.I.) </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S18) + ' x ' + (100 + rca.valoriparametri.ssn)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-6">€ ' + Math.round(rca.ssn) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3"> + Imposte (' + rca.valoriparametri.imposte + '% del P.I.) </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + Math.round(rca.S18) + ' x ' + (100 + rca.valoriparametri.imposte)/100 + '</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-6">€ ' + Math.round(rca.imposte) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-3"> + Assistenza stradale: Sì </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">' + rca.valoriparametri.ard + '€</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">= ' + rca.valoriparametri.ard + '€</label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S19) + '</label></div>' +
                    '</div>' +

                    '<div class="form-group">' +
                    '<div class="cell"><label class="control-label col-sm-9 right">PREMIO TOTALE </label></div>' +
                    '<div class="cell"><label class="control-label col-sm-3">€ ' + Math.round(rca.S20) + '</label></div>' +
                    '</div>' +

                    '</form>';
                return html;
            }

            // Mostra dettaglio RCA
            $('#dettaglioRCA').on('shown.bs.modal', function() {
                $("#dettaglioRCABody").html(GeneraDettaglio());
            })

            // Se qualcosa è stato modificato nella form, al posto del totale viene mostrata la scritta "RICALCOLA!"
            $("#frmRCA").on('change',function (e) {
                ControllaFormRCA();
            });

            // Controlla se la form RCA ha tutti i valori a posto. In tal caso va a fare il calcolo del totale previa
            // lettura della base imponibile e dei parametri di calcolo
            function ControllaFormRCA() {
                rca.idcliente = cliente.idcliente;
                rca.idprofessione = cliente.idprofessione;
                rca.idetaintestatario = cliente.etaintestatario;
                rca.idmarcaveicolo = $("#marcaveicolo").val();
                rca.idtipoveicolo = $("#tipoveicolo").val();
                rca.idgruppoetaveicolo = $("#gruppoetaveicolo").val();
                rca.idclassepotenza = $("#classepotenza").val();
                rca.idtipoalimentazione = $("#tipoalimentazione").val();
                rca.classemerito = $("#classemerito").val();
                rca.idnumannisenzasinistri = $("#numannisenzasinistri").val();
                rca.idnumsinistridenunciati = $("#numsinistridenunciati").val();
                rca.idtipofrazionamento = $("#tipofrazionamento").val();
                rca.guidaesperta = $("#guidaesperta").prop('checked');
                if(rca.idprofessione && rca.idetaintestatario && rca.provincia && rca.idcomune && rca.idclassepotenza &&
                    rca.classemerito && rca.idcilindrata && rca.idmarcaveicolo && rca.idtipoveicolo &&
                    rca.idgruppoetaveicolo && rca.idtipoalimentazione && rca.idnumannisenzasinistri && rca.idnumsinistridenunciati &&
                    rca.idmassimale && rca.idtipofrazionamento ) {
                    $.when(LeggiValorePremioBase()).done(function(value) {
                        // Imposto il valore premio base
                        rca.valorepremiobase = value;
                        $.when(LeggiValoriParametri()).done(function(value) {
                            // Imposto il valore degli altri parametri
                            rca.valoriparametri = value;
                            //Ricalcolo le somme parziali
                            CalcolaSommeParziali();
                        });
                    });
                }
            }



            //*************************************************************
            // Gestione form Augusta
            //*************************************************************

            // Faccio un clone dell'elenco delle province. Quando vengono filtrate serve conservare l'elenco originale
            var provinciaAugusta = $("#provinciaAugusta > option").clone();

            // Creo un JSON per contenere tutti i dati da passare alla funzione salva. La variabile viene anche inizializzata
            var augusta = {};
            augusta.valoredaassicurare = 0;
            augusta.categoria =  $("input:radio[name=categoria]").val();
            augusta.duratacopertura = 12;

            // Se il valore da assicurare cambia aggiorno il JSON
            $("#valoredaassicurare").on("change",function () {
                augusta.valoredaassicurare = $(this).val();
                $("input:checkbox[name=tipocopertura]").trigger("change");
            });

            // Se il valore della regione cambia devo filtrare opportunamente le sue province
            $('#regioneAugusta').on('change', function () {
                var regioneAugusta = $(this).val();
                augusta.regione = regioneAugusta;

                var html = "";

                // Rigenero l'elenco delle province in base alla regione scelta
                provinciaAugusta.each(function() {
                    if ($(this).attr('regione') == regioneAugusta) {
                        html = html + '<option id="' + $(this).attr('id') + '" value="' + $(this).val() + '">' + $(this).text() + '</option>';
                    }
                });
                $("#provinciaAugusta").html(html);

                // Simulo un evento change sulle province per aggiornarne il valore
                $("#provinciaAugusta").trigger("change");
            });

            // Se il valore della provincia cambia aggiorno il JSON
            $('#provinciaAugusta').on('change', function () {
                augusta.provincia = $(this).val();
                $("input:checkbox[name=tipocopertura]").trigger("change");
            });

            // Se il valore della categoria cambia aggiorno il JSON (categoria può essere N per Nuovo e U per Usato)
            $("input:radio[name=categoria]").change(function(){
                augusta.categoria = $(this).val();
                $("input:checkbox[name=tipocopertura]").trigger("change");
            });

            // Quando viene scelta una differente durata copertura il bottone corrispondente viene visualizzato in blu.
            // Manca la durata 66 mesi. Se la durata copertura cambia viene anche aggiornato il JSON
            $('#duratacopertura button').click(function(sender){
                var btn = sender.target.id;
                var v = sender.target.innerHTML;

                for (i = 0; i < 10; i++) {
                    k = (i + 2) * 6;
                    $('#btn'+k).removeClass("btn-info");
                    $('#btn'+k).removeClass("locked_inactive");
                    $('#btn'+k).addClass("btn-default");
                    $('#btn'+k).addClass("unlocked_inactive");
                }


                $('#btn'+v).removeClass("btn-default");
                $('#btn'+v).removeClass("unlocked_inactive");
                $('#btn'+v).addClass("btn-info");
                $('#btn'+v).addClass("locked_inactive");

                augusta.duratacopertura = v;
                $("input:checkbox[name=tipocopertura]").trigger("change");
            });

            // Calcolo l'importo di ciascuna garanzia. Accetta come parametro di input uno dei seguenti valori
            // 'F 'per FIR, 'C' per Collisione, 'K' per KASKO. Viene anche aggiornato il JSON
            function CalcolaImportoGaranzia(tipo) {
                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    async:false,
                    data: {
                        provincia : augusta.provincia,
                        categoria : augusta.categoria,
                        tipologia : tipo,
                        durata : augusta.duratacopertura,
                        ajax_function: "LeggiCoefficienteAugusta"},
                    cache: false,
                    success: function (response) {
                        var res = response['result']['coefficiente'];
                        switch(tipo) {
                            case "F":
                                augusta.coeffF = eval(res);
                                augusta.importoF = augusta.coeffF * augusta.valoredaassicurare / 1000;
                                break;
                            case "C":
                                augusta.coeffC = eval(res);
                                augusta.importoC = augusta.coeffC * augusta.valoredaassicurare / 1000;
                                break;
                            case "K":
                                augusta.coeffK = eval(res);
                                augusta.importoK = augusta.coeffK * augusta.valoredaassicurare / 1000;
                                break;
                            default:
                        }


                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }

            // Se la seleziono/deseleziono una garanzia, ne ricalcolo il valore. Aggiorno anche il JSON
            $("input:checkbox[name=tipocopertura]").change(function(){
                if (CampiAugustaCompleti()) {
                    if ($("#tcfir").is(":checked")) {
                        k = CalcolaImportoGaranzia("F");
                        $('#coeffF').val(augusta.coeffF);
                        $('#importoF').val(augusta.importoF);
                    } else {
                        augusta.coeffF = 0;
                        augusta.importoF = 0;
                        $('#coeffF').val("");
                        $('#importoF').val("");
                    }

                    if ($("#tccollisione").is(":checked")) {
                        k = CalcolaImportoGaranzia("C");
                        $('#coeffC').val(augusta.coeffC);
                        $('#importoC').val(augusta.importoC);
                    } else {
                        augusta.coeffC = 0;
                        augusta.importoC = 0;
                        $('#coeffC').val("");
                        $('#importoC').val("");
                    }

                    if ($("#tckasko").is(":checked")) {
                        k = CalcolaImportoGaranzia("K");
                        $('#coeffK').val(augusta.coeffK);
                        $('#importoK').val(augusta.importoK);
                    } else {
                        augusta.coeffK = 0;
                        augusta.importoK = 0;
                        $('#coeffK').val("");
                        $('#importoK').val("");
                    }
                    augusta.totaleaugusta = augusta.importoF + augusta.importoC + augusta.importoK;
                    $("#totaleaugusta").val(augusta.totaleaugusta);
                } else {
                    AzzeraCampiAugusta();
                }
            });

            $("#regioneAugusta").trigger("change");

            // Ritorna true se tutti i campi di input sono popolati correttamente, false altrimenti
            function CampiAugustaCompleti() {
                var flag = (augusta.valoredaassicurare !=0 ) && (augusta.categoria != 0) && (augusta.duratacopertura != 0) && (augusta.regione != "") && (augusta.provincia != "");
                return flag;
            }

            // Azzera i campi di input della form Augusta
            function AzzeraCampiAugusta() {
                $('#coeffF').val("");
                $('#importoF').val("");
                $('#coeffC').val("");
                $('#importoC').val("");
                $('#coeffK').val("");
                $('#importoK').val("");
                $("#totaleaugusta").val("");
                augusta.coeffF = augusta.importoF = 0;
                augusta.coeffC = augusta.importoC = 0;
                augusta.coeffK = augusta.importoK = 0;
                $("#tccollisione").attr("checked",false);
                $("#tckasko").attr("checked",false);
            }



            //*************************************************************
            // Gestione form Accessori
            //*************************************************************

            var accessori = {};
            accessori.totaleaccessori = 0;
            accessori.listaaccessori = {};

            // quando un accessorio viene selezionato abilito l'input per il valore del listino scontato e sposto il focus su di esso
            $("input:checkbox[name=chkAccessorio]").change(function() {
                var index = $(this).attr('data-index');
                if($(this).prop('checked')) {
                    $("#listinoscontato"+index).prop('disabled',false);
                    $("#listinoscontato"+index).focus();
                } else {
                    // se l'accessorio viene deselezionato, cancello il valore del listino scontato e del margine e disabilito il campo di input
                    $("#listinoscontato"+index).val("");
                    $("#margine"+index).val("");
                    $("#listinoscontato"+index).prop('disabled',true);
                }
                RicalcolaTotale(); // ricalcolo il totale accessori
            });

            // quando viene inserito un valore nel campo listino scontato
            $('[name="listinoscontato"]').on('change',function () {
                var index = $(this).prop("id").replace('listinoscontato','');
                var listinoscontato = $(this).val();
                var costo = eval($(this).parents("tr").children().eq(4).html());
                var montaggio = eval($(this).parents("tr").children().eq(5).html());
                var minval = RoundTo2Decs((costo + montaggio) * 1.22);
                var margine = RoundTo2Decs((listinoscontato / 1.22) - costo - montaggio);

                // controllo se il valore di listino scontato inserito è maggiore del valore minimo.
                // se sì allora tutto OK
                if (listinoscontato >= minval) {
                    $("#margine" + index).val(margine);
                    $($(this)).closest('td').removeClass('has-error');
                    $("#"+$(this).id+"help").remove();
                } else {
                    // se no, allora mostro un errore proprio sotto la casella di input del listino scontato
                    var $span = $('<small/>').addClass('help-block validMessage');
                    $(this).closest('td').addClass('has-error');
                    $span.attr('id', $(this).id+"help")
                        .attr('data-field', $(this).id)
                        .insertAfter($(this))
                        .show();
                    $span.html("Valore troppo basso!");

                    $("#margine" + index).val(""); //c'è un errore, allora il margine viene cancellato
                }
                RicalcolaTotale(); // ricalcolo il totale accessori
            });


            // Ricalcola il totale per le opzioni selezionate nella form accessori
            function RicalcolaTotale() {
                var totaleLS = 0;
                var totaleM = 0;
                var v;

                $('[name="listinoscontato"]').each(function () {
                    //v = $(this).prop("valueAsNumber");
                    v = eval($(this).val());
                    totaleLS = totaleLS + (!isNaN(v) ? v : 0);
                });


                $('[name="margine"]').each(function () {
                    //v = $(this).prop("valueAsNumber");
                    v = eval($(this).val());
                    totaleM = totaleM + (!isNaN(v) ? v : 0);
                });

                $("#totalelistinoscontato").val(RoundTo2Decs(totaleLS));
                $("#totalemargine").val(RoundTo2Decs(totaleM));
            }


            // Controlla se la form Accessori è valida
            function FormAccessoriValida() {
                var result = {};
                result.isValid = true;
                result.message = "OK";

                //se la form Accessori è stata selezionata controllo che ci sia almeno uno degli accessori selezionati
                if($("#chkDatiAccessori").prop('checked')) {
                    var numelementiSel = 0;
                    $('input[name="listinoscontato"]').each(function (i) {
                        if (!$(this).prop("disabled")) {
                            numelementiSel += 1;
                            if ($(this).val() == "") {
                                result.isValid = false;
                                result.message = "Nella sezione Accessori, il campo Listino Scontato della riga " + (i+1) + " non presenta alcun valore!";
                            }
                        }
                    });
                    if (numelementiSel == 0) {
                        result.isValid = false;
                        result.message = "Nessun elemento selezionato nella sezione Accessori!"
                    }
                }
                return result;
            }



            //*************************************************************
            // Gestione form coperture aggiuntive
            //*************************************************************

            var copertureaggiuntive = {};
            copertureaggiuntive.listacopertureaggiuntive = {};

            $("#ptl").on("change",function () {
                $("#ptlpremio").prop('disabled', !$("#ptl").prop("checked"));
                $("#ptldurata").prop('disabled', !$("#ptl").prop("checked"));
                $("#ptlcosto").prop('disabled', !$("#ptl").prop("checked"));
                $("#ptlmargine").prop('disabled', !$("#ptl").prop("checked"));
            });

            $("#eg").on("change",function () {
                $("#egpremio").prop('disabled', !$("#eg").prop("checked"));
                $("#egdurata").prop('disabled', !$("#eg").prop("checked"));
                $("#egcosto").prop('disabled', !$("#eg").prop("checked"));
                $("#egmargine").prop('disabled', !$("#eg").prop("checked"));
            });

            // Controllo se la form delle coperture aggiuntive è valida
            function FormCopertureAggiuntiveValida() {
                var result = {};
                result.isValid = true;
                result.message = "OK";

                if($("#chkDatiCopertureAggiuntive").prop('checked')) {
                    if($("#ptl").prop("checked")) {
                        if($("#ptlpremio").val()==""){
                            result.isValid = false;
                            result.message = "Nella sezione Coperture Aggiuntive , il campo Premio della Polizza Tutela Legale non presenta alcun valore!";
                        }
                        if($("#ptlcosto").val()==""){
                            result.isValid = false;
                            result.message = "Nella sezione Coperture Aggiuntive , il campo Costo della Polizza Tutela Legale non presenta alcun valore!";
                        }
                        if($("#ptldurata").val()==""){
                            result.isValid = false;
                            result.message = "Nella sezione Coperture Aggiuntive , il campo Durata della Polizza Tutela Legale non presenta alcun valore!";
                        }
                    } else {
                        if($("#eg").prop("checked")) {
                            if($("#egpremio").val()==""){
                                result.isValid = false;
                                result.message = "Nella sezione Coperture Aggiuntive , il campo Premio della Polizza Estensione Garanzia non presenta alcun valore!";
                            }
                            if($("#egcosto").val()==""){
                                result.isValid = false;
                                result.message = "Nella sezione Coperture Aggiuntive , il campo Costo della Polizza Estensione Garanzia non presenta alcun valore!";
                            }
                            if($("#egdurata").val()==""){
                                result.isValid = false;
                                result.message = "Nella sezione Coperture Aggiuntive , il campo Durata della Polizza Estensione Garanzia non presenta alcun valore!";
                            }
                        } else {
                            result.isValid = false;
                            result.message = "Nessuna copertura aggiuntiva selezionata!";
                        }
                    }
                }
                return result;
            }




            // IMPOSTAZIONI GLOBALI

            // Controlla se c'è almeno una copertura assicurativa selezionata nel modulo. Se non ce n'è nessuna,
            // ritorna un errore e l'intero modulo viene invalidato
            function ControllaModulo() {
                var result = {};
                result.isValid = true;
                result.message = "OK";
                var contaAccordion = 0;

                if($("#chkDatiRCA").prop('checked')) {
                    contaAccordion +=1;
                }
                if($("#chkDatiAugusta").prop('checked')) {
                    contaAccordion +=1;
                }
                if($("#chkDatiAccessori").prop('checked')) {
                    contaAccordion +=1;
                }
                if($("#chkDatiCopertureAggiuntive").prop('checked')) {
                    contaAccordion +=1;
                }

                if (contaAccordion == 0) {
                    result.isValid = false;
                    result.message = "ERRORE: E' necessario selezionare almeno una copertura!"
                }
                return result;
            }

            // Salvo il preventivo
            $("#btnSalva").on('click',function () {
                var idpreventivo = $("#idpreventivo").val();
                var idcliente = cliente.idcliente;

                // controllo se l'intero modulo è valido
                var controllaModulo = ControllaModulo();

                //se l'intero modulo è valido, controllo se ci sono errori in ogni singola form
                if(controllaModulo.isValid) {

                    var s = [];

                    var frmCliente = $("#frmCliente");
                    frmCliente.validate();
                    var frmClienteValida = frmCliente.valid();
                    if(!frmClienteValida) {
                        s.push("Cliente");
                    }

                    var frmRCA = $("#frmRCA");
                    frmRCA.validate();
                    var frmRCAValida = frmRCA.valid();
                    if((!frmRCAValida) || (rca.totalerca == 0)) {
                        s.push("RCA");
                    }

                    var frmAugusta = $("#frmAugusta");
                    frmAugusta.validate();
                    var frmAugustaValida = frmAugusta.valid();
                    if(!frmAugustaValida) {
                        s.push("AUGUSTA");
                    }

                    var frmAccessoriValida = FormAccessoriValida().isValid;

                    if(!frmAccessoriValida) {
                        s.push("Accessori");
                    }

                    var frmCopertureAggiuntive = $("#frmCopertureAggiuntive");
                    frmCopertureAggiuntive.validate();
                    var frmCopertureAggiuntiveValida = frmCopertureAggiuntive.valid() & FormCopertureAggiuntiveValida().isValid;
                    if(!frmCopertureAggiuntiveValida) {
                        s.push("Coperture Aggiuntive");
                    }

                    // questa variabile sarà 'true' se tutte le singole form sono valide
                    var okSalva =  frmClienteValida & frmRCAValida & frmAugustaValida & frmAccessoriValida & frmCopertureAggiuntiveValida;

                    // se tutte le form sono valide
                    if(okSalva) {
                        BootstrapDialog.show({
                            title: 'ATTENZIONE',
                            type: BootstrapDialog.TYPE_WARNING,
                            message: 'Salvare il preventivo corrente?',
                            buttons: [{
                                label: 'Sì',
                                cssClass: 'btn-warning',
                                action: function (dialog) {
                                    dialog.close();
                                    SalvaPreventivo(idpreventivo,idcliente);
                                    location.href = "preventivi.php";
                                }
                            }, {
                                label: 'No',
                                cssClass: 'btn-warning',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                        });
                    } else {
                        toastr.error("Ci sono errori nelle sezioni [" + s + "] !");
                    }

                } else {
                    toastr.error(controllaModulo.message);
                }
            });


            // Funzioni di servizio

            // PreparaCliente
            function PreparaCliente(id_cliente) {
                cliente.idcliente = id_cliente;
                cliente.codicefiscale = $("#codicefiscale").val();
                cliente.cognome = $("#cognome").val();
                cliente.nome = $("#nome").val();
                cliente.email = $("#email").val();
                cliente.telefono = $("#telefono").val();
                cliente.cellulare = $("#cellulare").val();
                var datanascita = $("#giorno").val() + "/" + $("#mese").val() + "/" + $("#anno").val();
                cliente.datanascita = DateFormatDB(datanascita);
                return cliente;
            }

            // PreparaPolizzaRCA
            function PreparaPolizzaRCA(id_preventivo,id_cliente) {
                rca.idpreventivo = id_preventivo;
                rca.idcliente = id_cliente;
                rca.blackbox = (rca.blackbox ? 1:0);
                rca.guidaesperta = (rca.guidaesperta ? 1:0);
                rca.polinfcond = (rca.polinfcond ? 1:0);

                return rca;
            }

            // PreparaPolizzaAugusta
            function PreparaPolizzaAugusta(id_preventivo) {
                augusta.idpreventivo = id_preventivo;
                return augusta;
            }

            // PreparaAccessori
            function PreparaAccessori(id_preventivo) {
                accessori.idpreventivo = id_preventivo;
                accessori.totaleaccessori = 0;

                $('[name="listinoscontato"]').each(function (i) {
                    var index = i + 1;
                    if (!$(this).prop("disabled")) {
                        accessori.listaaccessori["acc"+index] = {};
                        accessori.listaaccessori["acc"+index].id = index;
                        accessori.listaaccessori["acc"+index].listinoscontato = eval($("#listinoscontato" + index).val());
                        //var margine = Math.round(eval($("#margine" + index).val())*100)/100;
                        var margine = RoundTo2Decs(eval($("#margine" + index).val()));
                        accessori.listaaccessori["acc"+index].margine = margine;
                        accessori.totaleaccessori += accessori.listaaccessori["acc"+index].listinoscontato;
                    }
                });

                return accessori;
            }

            // PreparaCopertureAggiuntive
            function PreparaCopertureAggiuntive(id_preventivo) {
                copertureaggiuntive.idpreventivo = id_preventivo;
                copertureaggiuntive.totalecopertureaggiuntive = 0;

                if($("#ptl").prop("checked")) {
                    copertureaggiuntive.listacopertureaggiuntive["ca1"] = {};
                    copertureaggiuntive.listacopertureaggiuntive["ca1"].id = 1;
                    copertureaggiuntive.listacopertureaggiuntive["ca1"].premio = eval($("#ptlpremio").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca1"].durata = eval($("#ptldurata").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca1"].costo = eval($("#ptlcosto").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca1"].margine = eval($("#ptlmargine").val());
                    copertureaggiuntive.totalecopertureaggiuntive = copertureaggiuntive.totalecopertureaggiuntive + copertureaggiuntive.listacopertureaggiuntive["ca1"].premio;
                }

                if($("#eg").prop("checked")) {
                    copertureaggiuntive.listacopertureaggiuntive["ca2"] = {};
                    copertureaggiuntive.listacopertureaggiuntive["ca2"].id = 2;
                    copertureaggiuntive.listacopertureaggiuntive["ca2"].premio = eval($("#egpremio").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca2"].durata = eval($("#egdurata").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca2"].costo = eval($("#egcosto").val());
                    copertureaggiuntive.listacopertureaggiuntive["ca2"].margine = eval($("#egmargine").val());
                    copertureaggiuntive.totalecopertureaggiuntive = copertureaggiuntive.totalecopertureaggiuntive + copertureaggiuntive.listacopertureaggiuntive["ca2"].premio;
                }
                return copertureaggiuntive;
            }

            // SalvaPreventivo
            function SalvaPreventivo(id_preventivo,id_cliente) {
                var idpreventivo;
                var idcliente;
                var form_data = {};

                // genero un timestamp per il preventivo e per il cliente
                var t = (Date.now() / 1000 | 0);

                if (id_preventivo) {
                    idpreventivo = id_preventivo;
                } else {
                    idpreventivo = "PR" + t;
                }

                if(id_cliente) {
                    idcliente = id_cliente;
                } else {
                    idcliente = "CL" + t;
                }


                //Il cliente viene salvato sempre
                form_data.cliente = PreparaCliente(idcliente);

                //Se RCA è selezionata viene salvata
                if($("#chkDatiRCA").prop('checked')) {
                    form_data.rca = PreparaPolizzaRCA(idpreventivo,idcliente);
                } else {
                    rca.totalerca = 0;
                    form_data.rca = {};
                }

                //Se Augusta è selezionata viene salvata
                if($("#chkDatiAugusta").prop('checked')) {
                    form_data.augusta = PreparaPolizzaAugusta(idpreventivo);
                } else {
                    augusta.totaleaugusta = 0;
                    form_data.augusta = {};
                }

                //Se la form Accessori è selezionata viene salvata
                if($("#chkDatiAccessori").prop('checked')) {
                    form_data.accessori = PreparaAccessori(idpreventivo);
                } else {
                    accessori.totaleaccessori = 0;
                    form_data.accessori = {};
                }

                //Se la form Coperture Aggiuntive è selezionata viene salvata
                if($("#chkDatiCopertureAggiuntive").prop('checked')) {
                    form_data.copertureaggiuntive = PreparaCopertureAggiuntive(idpreventivo);
                } else {
                    copertureaggiuntive.totalecopertureaggiuntive = 0;
                    form_data.copertureaggiuntive = {};
                }


                var preventivo = {};
                preventivo.idpreventivo = idpreventivo;
                preventivo.idcliente = idcliente;
                preventivo.premiototale = rca.totalerca + augusta.totaleaugusta +
                    accessori.totaleaccessori + copertureaggiuntive.totalecopertureaggiuntive;
                preventivo.operazione = ($("#idpreventivo").val() != "" ? "M" : "I");
                form_data.preventivo = preventivo;
                form_data.ajax_function = "SalvaPreventivo";

                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    async:false,
                    data: form_data,
                    cache: false,
                    success: function (response) {
                        localStorage.messagetype = "success";
                        localStorage.message = "Preventivo inserito correttamente!";
                    },
                    error: function (response) {
                        localStorage.messagetype = "error";
                        localStorage.message = response["result"];
                    }
                });
            }

            // Imposta dei dati di test all'apertura della form di edit
            function CancellaCampiRCA() {

                // DATI POLIZZA
                $("#provincia").val("");$("#provincia").trigger("change");

                $("#classepotenza").val("");$("#classepotenza").trigger("change");
                $("#classemerito").val("");$("#classemerito").trigger("change");
                $("#tipoalimentazione").val("");$("#tipoalimentazione").trigger("change");
                $("#marcaveicolo").val("");$("#marcaveicolo").trigger("change");
                $("#tipoveicolo").val("");$("#tipoveicolo").trigger("change");
                $("#gruppoetaveicolo").val("");$("#gruppoetaveicolo").trigger("change");
                $("#numannisenzasinistri").val("");$("#numannisenzasinistri").trigger("change");
                $("#numsinistridenunciati").val("");$("#numsinistridenunciati").trigger("change");
                $("#tipofrazionamento").val("");$("#tipofrazionamento").trigger("change");
                $("#guidaesperta").attr("checked",false);$("#guidaesperta").trigger("change");

            }


            $("#chkDatiCliente").prop('checked',true);
            $("#chkDatiCliente").prop('disabled',true);
            $("#clpsDatiCliente").collapse('show');

            $("#btnAnnulla").on('click',function () {
                BootstrapDialog.show({
                    title: 'ATTENZIONE',
                    type: BootstrapDialog.TYPE_WARNING,
                    message: 'Annullare le modifiche?',
                    buttons: [{
                        label: 'Sì',
                        cssClass: 'btn-warning',
                        action: function (dialog) {
                            dialog.close();
                            location.href = "preventivi.php";
                        }
                    }, {
                        label: 'No',
                        cssClass: 'btn-warning',
                        action: function (dialog) {
                            dialog.close();
                        }
                    }]
                });
            })


            function LeggiPreventivo() {
                var deferred = $.Deferred();
                var preventivo = {};

                preventivo.idpreventivo = $("#idpreventivo").val();
                preventivo.ajax_function = "LeggiPreventivo";

                $.ajax({
                    url: "ajax_responder.php",
                    dataType: "json",
                    type: "post",
                    async:false,
                    data: preventivo,
                    cache: false,
                    success: function (response) {
                        var res = response["result"];
                        deferred.resolve(res);
                    },
                    error: function (response) {
                        console.log(response);
                        deferred.resolve(response);
                    }
                });
                return deferred.promise();
            }

            // Imposta dei dati di test per il cliente all'apertura della form di edit
            function ImpostaDatiTestCliente() {
                //DATI CLIENTE
                $("#codicefiscale").val("LFFGPR71A01B963Y");
                $("#cognome").val("Loffredo");
                $("#nome").val("Giampiero");
                $("#email").val("misterx@acme.com");
                $("#telefono").val("72783888");
                $("#cellulare").val("66378838");
                $("#giorno").val("01");
                $("#mese").val("01");
                $("#anno").val("1971");$("#anno").trigger("change");
                $("#professione").val("17");$("#professione").trigger("change");
            }

            // Imposta dei dati di test per la polizza RCA all'apertura della form di edit
            function ImpostaDatiTestRCA() {
                // DATI RCA
                $("#chkDatiRCA").prop('checked',true);$("#chkDatiRCA").trigger("change");
                $("#provincia").val("CASERTA");$("#provincia").trigger("change");
                $("#comune").val("114");$("#comune").trigger("change");
                $("#tipoalimentazione").val("1");$("#tipoalimentazione").trigger("change");
                $("#cilindrata").val("14");$("#cilindrata").trigger("change");
                $("#classepotenza").val("13");$("#classepotenza").trigger("change");
                $("#classemerito").val("01");$("#classemerito").trigger("change");
                $("#marcaveicolo").val("6");$("#marcaveicolo").trigger("change");
                $("#tipoveicolo").val("1");$("#tipoveicolo").trigger("change");
                $("#gruppoetaveicolo").val("1");$("#gruppoetaveicolo").trigger("change");
                $("#numannisenzasinistri").val("1");$("#numannisenzasinistri").trigger("change");
                $("#numsinistridenunciati").val("1");$("#numsinistridenunciati").trigger("change");
                $("#tipofrazionamento").val("2");$("#tipofrazionamento").trigger("change");
                $("#guidaesperta").attr("checked",true);
                ControllaFormRCA();
            }

            // Imposta dei dati di test per Augusta all'apertura della form di edit
            function ImpostaDatiTestAugusta() {
                // DATI AUGUSTA
                $("#chkDatiAugusta").prop('checked',true);$("#chkDatiAugusta").trigger("change");
                $("#valoredaassicurare").val("10000");$("#valoredaassicurare").trigger("change");
                $("#regioneAugusta").val("CAMPANIA");$("#regioneAugusta").trigger("change");
                $("#provinciaAugusta").val("CE");$("#provinciaAugusta").trigger("change");

                $("#tccollisione").prop('checked',true);$("#tccollisione").trigger("change");
                $("#tckasko").prop('checked',true);$("#tckasko").trigger("change");

            }

            // Imposta dei dati di test per la form Accessori
            function ImpostaDatiTestAccessori() {

                // DATI ACCESSORI
                $("#chkDatiAccessori").prop('checked',true).trigger("change");

                var accessorio1 = {
                    attivo:"1",
                    dataoperazione:"2016-08-03 14:07:30",
                    idaccessorio:"2",
                    idpreventivo:"PR1470226050",
                    listinoscontato:600.00,
                    margine:276.8,
                    modificatoda:"1",
                    operazione:"I"
                };

                var index = accessorio1.idaccessorio;
                $("#chkAccessorio"+index).prop('checked',true);
                $("#listinoscontato"+index).prop('disabled',false);
                $("#listinoscontato"+index).val(accessorio1.listinoscontato);
                var margine = accessorio1.margine;

                $("#margine"+index).val(margine);

                accessori.listaaccessori["acc"+index] = {};
                accessori.listaaccessori["acc"+index].id = index;
                accessori.listaaccessori["acc"+index].listinoscontato = accessorio1.listinoscontato;
                accessori.listaaccessori["acc"+index].margine = accessorio1.margine;
                accessori.totaleaccessori += accessorio1.listinoscontato;

                var accessorio2 = {
                    attivo:"1",
                    dataoperazione:"2016-08-03 14:07:30",
                    idaccessorio:"5",
                    idpreventivo:"PR1470226050",
                    listinoscontato:200.00,
                    margine:133.93,
                    modificatoda:"1",
                    operazione:"I"
                };

                var index = accessorio2.idaccessorio;
                $("#chkAccessorio"+index).prop('checked',true);
                $("#listinoscontato"+index).prop('disabled',false);
                $("#listinoscontato"+index).val(accessorio2.listinoscontato);
                var margine = accessorio2.margine;

                $("#margine"+index).val(margine);

                accessori.listaaccessori["acc"+index] = {};
                accessori.listaaccessori["acc"+index].id = index;
                accessori.listaaccessori["acc"+index].listinoscontato = accessorio2.listinoscontato;
                accessori.listaaccessori["acc"+index].margine = accessorio2.margine;
                accessori.totaleaccessori += accessorio2.listinoscontato;

                RicalcolaTotale();

            }

            // Imposta dei dati di test per la form Coperture Aggiuntive
            function ImpostaDatiTestCopertureAggiuntive() {
                $("#chkDatiCopertureAggiuntive").prop('checked',true).trigger("change");
                $("#eg").prop('checked',true).trigger('change');
                $("#egpremio").val(100);
                $("#egdurata").val(36);
                //$("#egcosto").val(40);
                $("#egmargine").val(60);
            }

            // Imposta i dati di test per l'intero modulo
            function ImpostaDatiTest() {
                ImpostaDatiTestCliente();
                ImpostaDatiTestRCA();
                //ImpostaDatiTestAugusta();
                //ImpostaDatiTestAccessori();
                //ImpostaDatiTestCopertureAggiuntive();
            }

            $(window).load(function(){
                // Se è stato passato il parametro per la generazione dei dati di test, imposto i dati di test per
                // l'intero modulo
                var datitest = $("#datitest").val();
                if (datitest) ImpostaDatiTest();

                //Se mi trovo in modalità "EDIT", leggo il preventivo specificato
                if($("#idpreventivo").val() != "") {
                    $.when(LeggiPreventivo()).done(function(result) {

                        var xpreventivo = result["preventivo"];
                        var xcliente = result["cliente"];
                        var xrca = result["rca"];
                        var xaugusta = result["augusta"];
                        var xaccessori = result["accessori"];
                        var xcopertureaggiuntive = result["copertureaggiuntive"];

                        // IMPOSTA CLIENTE
                        cliente.idcliente = xcliente.idcliente;
                        cliente.codicefiscale = xcliente.codicefiscale;
                        cliente.cognome = xcliente.cognome;
                        cliente.nome = xcliente.nome;
                        cliente.email = xcliente.email;
                        cliente.telefono = xcliente.telefono;
                        cliente.cellulare = xcliente.cellulare;
                        cliente.datanascita = DateFormatWEB(xcliente.datanascita);

                        var d = xcliente.datanascita;
                        var str = d.split("-");

                        cliente.giorno = str[2];
                        cliente.mese = str[1];
                        cliente.anno = str[0];

                        cliente.idprofessione = xcliente.idprofessione;

                        $("#codicefiscale").val(cliente.codicefiscale);
                        $("#cognome").val(cliente.cognome);
                        $("#nome").val(cliente.nome);
                        $("#email").val(cliente.email);
                        $("#telefono").val(cliente.telefono);
                        $("#cellulare").val(cliente.cellulare);
                        $("#giorno").val(cliente.giorno);
                        $("#mese").val(cliente.mese);
                        $("#anno").val(cliente.anno);$("#anno").trigger("change");
                        $("#professione").val(cliente.idprofessione);$("#professione").trigger("change");


                        //IMPOSTA RCA
                        if (xrca) {
                            //console.log(xrca);
                            $("#chkDatiRCA").prop('checked',true).trigger("change");
                            rca.idpreventivo = xrca.idpreventivo;
                            rca.idcliente = xrca.idcliente;
                            rca.idcomune = xrca.idcomune;
                            rca.provincia = xrca.provincia;
                            rca.comune = xrca.comune;
                            rca.idprofessione = xrca.idprofessione;
                            rca.idetaintestatario = xrca.idetaintestatario;
                            rca.idmarcaveicolo = xrca.idmarcaveicolo;
                            rca.idtipoveicolo = xrca.idtipoveicolo;
                            rca.idgruppoetaveicolo = xrca.idgruppoetaveicolo;
                            rca.idclassepotenza = xrca.idclassepotenza;
                            rca.idtipoalimentazione = xrca.idtipoalimentazione;
                            rca.idcilindrata = xrca.idcilindrata;
                            rca.classemerito = pad(xrca.classemerito,2);
                            rca.idnumannisenzasinistri = xrca.idnumannisenzasinistri;
                            rca.idnumsinistridenunciati = xrca.idnumsinistridenunciati;
                            rca.idtipofrazionamento = xrca.idtipofrazionamento;
                            rca.idmassimale = xrca.idmassimale;
                            rca.blackbox = 1;
                            rca.guidaesperta = xrca.guidaesperta;
                            rca.polinfcond = 1;

                            $("#provincia").val(xrca.provincia).trigger("change");
                            $("#comune").val(xrca.idcomune).trigger("change");
                            $("#classemerito").val(pad(xrca.classemerito,2));
                            $("#tipoalimentazione").val(xrca.idtipoalimentazione).trigger("change");
                            $("#cilindrata").val(xrca.idcilindrata).trigger("change");
                            $("#classepotenza").val(xrca.idclassepotenza);
                            $("#marcaveicolo").val(xrca.idmarcaveicolo);
                            $("#tipoveicolo").val(xrca.idtipoveicolo);
                            $("#gruppoetaveicolo").val(xrca.idgruppoetaveicolo);
                            $("#numannisenzasinistri").val(xrca.idnumannisenzasinistri);
                            $("#numsinistridenunciati").val(xrca.idnumsinistridenunciati);
                            $("#tipofrazionamento").val(xrca.idtipofrazionamento);
                            $("#massimale").val(xrca.idmassimale);
                            $("#guidaesperta").attr("checked",(xrca.guidaesperta==1?true:false));
                            ControllaFormRCA();
                        }

                        //IMPOSTA AUGUSTA
                        if (xaugusta) {
                            $("#chkDatiAugusta").prop('checked',true).trigger("change");
                            augusta.idpreventivo = xaugusta.idpreventivo;

                            augusta.valoredaassicurare = eval(xaugusta.valoredaassicurare);
                            $("#valoredaassicurare").val(augusta.valoredaassicurare);

                            augusta.categoria = xaugusta.categoria;
                            $('input[name=categoria][value="' + augusta.categoria + '"]').prop('checked', true);

                            augusta.duratacopertura = xaugusta.duratacopertura;
                            $("#btn" + augusta.duratacopertura).trigger('click');

                            augusta.regione = xaugusta.regione;
                            $("#regioneAugusta").val(xaugusta.regione).trigger("change");

                            augusta.provincia = xaugusta.provincia;
                            $("#provinciaAugusta").val(xaugusta.provincia).trigger("change");

                            augusta.coeffF = eval(xaugusta.coeffF);
                            augusta.coeffC = eval(xaugusta.coeffC);
                            augusta.coeffK = eval(xaugusta.coeffK);

                            if(augusta.coeffC != 0) {
                                $("#tccollisione").prop('checked',true);
                            }
                            if(augusta.coeffK != 0) {
                                $("#tckasko").prop('checked',true);
                            }

                            $("input:checkbox[name=tipocopertura]").trigger('change');
                        }

                        //IMPOSTA ACCESSORI
                        if (xaccessori) {
                            $("#chkDatiAccessori").prop('checked',true);//.trigger("change");
                            $("#clpsDatiAccessori").collapse('show');

                            accessori.idpreventivo = xaccessori.idpreventivo;

                            var l = xaccessori.length;
                            for(i=0;i<l;i++) {
                                var accessorio = xaccessori[i];
                                var index = accessorio.idaccessorio;
                                //$("input[data-index='" + (eval(index)-1) + "']").prop('checked',true).trigger('check.bs.table',accessorio);
                                $("#listinoscontato" + index).parents('tr').find('input:checkbox:first').prop('checked',true);//.trigger('change');

                                $("#listinoscontato" + index).prop("disabled",false);


                                accessori.listaaccessori["acc"+index] = {};
                                accessori.listaaccessori["acc"+index].id = index;
                                accessori.listaaccessori["acc"+index].listinoscontato = eval(accessorio.listinoscontato);
                                $("#listinoscontato"+index).val(accessori.listaaccessori["acc"+index].listinoscontato).trigger('change');

                                ////var margine = Math.round(eval($("#margine" + index).val())*100)/100;
                                accessori.listaaccessori["acc"+index].margine = accessorio.margine;
                                accessori.totaleaccessori += accessori.listaaccessori["acc"+index].listinoscontato;
                            }
                            $("#totalelistinoscontato").val(accessori.totaleaccessori);
                        }

                        //IMPOSTA COPERTURE AGGIUNTIVE
                        if (xcopertureaggiuntive) {
                            $("#chkDatiCopertureAggiuntive").prop('checked',true).trigger("change");
                            copertureaggiuntive.idpreventivo = xcopertureaggiuntive.idpreventivo;
                            copertureaggiuntive.totalecopertureaggiuntive = xcopertureaggiuntive.totalecopertureaggiuntive;
                            var l = xcopertureaggiuntive.length;
                            for(i=0;i<l;i++) {
                                var coperturaaggiuntiva = xcopertureaggiuntive[i];
                                var index = coperturaaggiuntiva.idcopertura;
                                switch (index) {
                                    case "1":
                                        $("#ptl").trigger("click");
                                        $("#ptlpremio").val(xcopertureaggiuntive[i].premio);
                                        $("#ptldurata").val(xcopertureaggiuntive[i].durata);
                                        $("#ptlcosto").val(xcopertureaggiuntive[i].costo);
                                        $("#ptlmargine").val(xcopertureaggiuntive[i].margine);
                                        break;
                                    case "2":
                                        $("#eg").trigger('click');
                                        $("#egpremio").val(xcopertureaggiuntive[i].premio);
                                        $("#egdurata").val(xcopertureaggiuntive[i].durata);
                                        $("#egcosto").val(xcopertureaggiuntive[i].costo);
                                        $("#egmargine").val(xcopertureaggiuntive[i].margine);
                                        break;
                                }
                            }
                        }
                    });
                }

                // Nascondo lo spinner
                $('#cover').fadeOut(1000);

            });
        });

    </script>
    <script src="daeSpinner.js" type="text/javascript"></script>

