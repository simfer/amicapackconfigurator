var $table;
var selectedRow = 0;

// Codice HTML per l'ultima colonna della tabella. Verranno visualizzati i bottoni per Visualizzazione, Modifica e Cancellazione
function operateFormatterPreventivi(value, row, index) {
    var idpreventivo = row.idpreventivo;

    return [
        '<a id="aViewPreventivi" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#detailModal" title="Visualizza">',
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

    $('#detailModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false
    }).on('show.bs.modal', function (event) {
        if (event.relatedTarget) {
            var that = $(this);

            var payload = {};

            if (oForm.readRecordFunction) {
                payload[oForm.keyfield] = selectedRow[oForm.keyfield];
                payload.ajax_function = oForm.readRecordFunction.name;
            } else {
                payload.table = oForm.table;
                payload.keyfield = oForm.keyfield;
                payload.keyvalue = selectedRow[oForm.keyfield];
                payload.ajax_function = "LeggiRecord";
            }

            console.log(payload);

            $.when(ReadRecord(payload)).done(function(result) {
                console.log(result);
                var value;
                var html = '';
                html += '<div class="panel-group" id="accordion">';
                $.each(oForm.panels, function (i, oPanel) {
                    html += '<div class="panel panel-info">';
                    html += '<div class="panel-heading">' + oPanel.description + '</div>';
                    html += '<div class=panel-body>';
                    html += '<form class="form-horizontal" name=frm' + oPanel.name + ' id=frm' + oPanel.name + '>';

                    $.each(oPanel.rows, function (i, oRow) {
                        html += '<div class="form-group">';
                        $.each(oRow.cells, function (i, oCell) {
                            if (oCell.visible === "true") {
                                html += '<div class="cell">';
                                html += '<label class="control-label col-sm-' + oCell.labelsize + '" for="' + oCell.name + '">' + oCell.label + '</label>';
                                html += '<div class="col-sm-' + oCell.fieldsize + '">';
                                value = (result[oPanel.name][oCell.name] ? result[oPanel.name][oCell.name] : "");
                                switch (oCell.type) {
                                    case "password":
                                        html += '<input disabled type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                        break;
                                    case "boolean":
                                        html += '<input disabled type="checkbox" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" ' + (value === "1" ? "checked" : "") + '/>';
                                        break;
                                    case "color":
                                        html += '<input disabled type="color" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                        break;
                                    case "date":
                                        html += '<input disabled type="text" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                        break;
                                    case "image":
                                        html += '<input disabled type="' + oCell.type + '" src="images/' + value + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '" style="width:48px"/>';
                                        break;
                                    case "select":
                                        console.log(oCell.selectParams.displaycolumn);
                                        value = (result[oPanel.name][oCell.selectParams.displaycolumn] ? result[oPanel.name][oCell.selectParams.displaycolumn] : "");
                                        html += '<input disabled type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                        break;
                                    default:
                                        html += '<input disabled type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                }
                                html += '</div>';  //class=col-sm
                                html += '</div>';  //class=cell
                            }
                        });
                        html += '</div>';  //class=form-group
                    });
                    html += '</form>';
                    html += '</div>';  //class=panel-body
                    html += '</div>';  //class=panel-info

                });
                html += '</div>';  //class=panel-group

                that.find('#rowDetails').html(html);
            });
        }
    });

    function ReadRecord(payload) {
        var deferred = $.Deferred();
        $.ajax({
            url: "ajax_responder.php",
            dataType: "json",
            type: "post",
            data: payload,
            cache: false,
            success: function (response) {
                var res = response["result"];
                deferred.resolve(res);
            },
            error: function (response) {
                deferred.reject(response);
            }
        });
        return(deferred);
    }

});