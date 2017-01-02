var $table;
var selectedRow = 0;

// Codice HTML per l'ultima colonna della tabella. Verranno visualizzati i bottoni per Visualizzazione, Modifica e Cancellazione
function operateFormatterPreventivi(value, row, index) {
    var idpreventivo = row.idpreventivo;

    return [
        '<a id="aViewPreventivi" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#dettaglioPreventivo" title="Visualizza">',
        '<i class="glyphicon glyphicon-eye-open"></i>',
        '</a>&nbsp;&nbsp;&nbsp;',
        '<a id="aEditPreventivi"  class="edit" href="modificaPreventivo.php?idpreventivo=' + idpreventivo + '" title=Modifica>',
        '<i class="glyphicon glyphicon-edit"></i>',
        '</a>&nbsp;&nbsp;&nbsp;',
        '<a id="aRemovePreventivi"  class="remove" href="javascript:void(0)" title="Disattiva">',
        '<i class="glyphicon glyphicon-trash"></i>',
        '</a>&nbsp;&nbsp;&nbsp;',
        '<a id="aPrintPreventivo"  class="print" href="javascript:void(0)" title="Stampa">',
        '<i class="glyphicon glyphicon-print"></i>',
        '</a>'
    ].join('');

}

// Associazione funzioni Visualizzazione, Modifica e Cancellazione ai bottoni dell'ultima colonna
window.operateEventsPreventivi = {
    'click .view': function (e, value, row, index) {
        selectedRow = row;
    },
    'click .edit': function (e, value, row, index) {
        selectedRow = row;
    },
    'click .print': function (e, value, row, index) {
        selectedRow = row;
        PopupCenter('stampaPreventivo.php?idpreventivo=' + selectedRow["idpreventivo"], 'Preventivi', '900', '500');
    },
    'click .remove': function (e, value, row, index) {
        BootstrapDialog.show({
            title: 'ATTENZIONE',
            type: BootstrapDialog.TYPE_WARNING,
            message: 'Sicuro di voler eliminare questo preventivo?',
            buttons: [{
                label: 'Sì',
                cssClass: 'btn-warning',
                action: function (dialog) {
                    dialog.close();
                    $.ajax({
                        type: "POST",
                        url: "ajax_responder.php",
                        data: {ajax_function: "DisattivaRecord", thetable:'preventivi',keyfield:'idpreventivo',keyvalue: row.idpreventivo},
                        success: function (response) {
                            var res = JSON.parse(response);
                            console.log(res['result']);
                            if (res["status"] === "success") {
                                $table.bootstrapTable('refresh');
                                toastr.info('Preventivo eliminato!');
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
};

jQuery().ready(function() {

    // Legge l'altezza della finestra corrente
    function getHeight() {
        return jQuery(window).height();
    }

    // La tabella preventivi sarà di tipo "bootstrap-table"
    $table = $('#table-preventivi');

    // L'altezza della tabella è fissata a 500px
    $table.bootstrapTable({height:500});

    // Visualizzazione dettaglio preventivo con una finestra modal
    $('#dettaglioPreventivo').modal({
        keyboard: true,
        backdrop: "static",
        show: false
    }).on('show.bs.modal', function () {
        console.log("leggipreventivo");
        $.ajax({
            url: "ajax_responder.php",
            dataType: "json",
            type: "post",
            data: {
                idpreventivo: selectedRow["idpreventivo"],
                ajax_function: "LeggiPreventivo"},
            cache: false,
            success: function (response) {
                var res = response['result'];
                console.log(res);
                if (res != "NOT_FOUND") { // se il record viene trovato instanzio le celle della tabella con i suoi valori
                    $("#lbl_idpreventivo").text(res['preventivo']['idpreventivo']);
                    $("#lbl_idcliente").text(res['cliente']['idcliente']);
                    $("#det_codicefiscale").val(res['cliente']['codicefiscale']);
                    $("#det_cognome").val(res['cliente']['cognome']);
                    $("#det_nome").val(res['cliente']['nome']);
                    $("#det_datanascita").val(res['cliente']['datanascita']);
                    $("#det_email").val(res['cliente']['email']);
                    $("#det_telefono").val(res['cliente']['telefono']);
                    $("#det_cellulare").val(res['cliente']['cellulare']);
                    $("#det_professione").val(res['cliente']['idprofessione']);

                    $("#det_provincia").val(res['rca']['provincia']);
                    $("#det_comune").val(res['rca']['comune']);
                    $("#det_cilindrata").val(res['rca']['idcilindrata']);
                    $("#det_tipoalimentazione").val(res['rca']['idtipoalimentazione']);
                    $("#det_classepotenza").val(res['rca']['idclassepotenza']);
                    $("#det_classemerito").val(res['rca']['classemerito']);

                    $("#det_marcaveicolo").val(res['rca']['idmarcaveicolo']);
                    $("#det_tipoveicolo").val(res['rca']['idtipoveicolo']);
                    $("#det_gruppoetaveicolo").val(res['rca']['idgruppoetaveicolo']);
                    $("#det_numannisenzasinistri").val(res['rca']['idnumannisenzasinistri']);
                    $("#det_numsinistridenunciati").val(res['rca']['idnumsinistridenunciati']);
                    $("#det_massimale").val(res['rca']['idmassimale']);

                } else {
                    toastr.error("ERRORE: Record non trovato!");
                }
            }, // in caso di errore mostro il messaggio di errore
            error: function (response) {
                toastr.error("ERRORE: " + response);
            }
        });
    });
});