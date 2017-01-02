var $table;
var selectedRow = 0;

var oFields = {
    "fields": [
        {
            "name": "idcliente",
            "label": "ID",
            "type": "hidden",
            "visible": "true",
            "disabled": "false"
        },
        {"name": "codicefiscale", "label": "C. Fisc.", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "cognome", "label": "Cognome", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "nome", "label": "Nome", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "datanascita", "label": "D. Nasc.", "type": "date", "visible": "true", "disabled": "false", "editable": "false"},
        {"name": "email", "label": "Email", "type": "email", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "telefono", "label": "Telefono", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "cellulare", "label": "Cell.", "type": "text", "visible": "true", "disabled": "false", "editable": "true"},
        {"name": "idprofessione", "label": "Professione", "type": "select", "selectParams": {
            "source": "table",
            "thetable":"professioni",
            "keycolumn":"idprofessione",
            "displaycolumn":"descrizione",
            "sortcolumn":"descrizione"
        },"visible": "false", "editable": "false"},
        {"name": "professione", "label": "Professione", "type": "text", "visible": "true", "editable": "false"}
    ]
};


function operateFormatter(value, row, index) {
    // return [
    //     '<a id="aView" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#detailModal" title="Visualizza">',
    //     '<i class="glyphicon glyphicon-eye-open"></i>',
    //     '</a>&nbsp;&nbsp;&nbsp;',
    //     '<a id="aEdit"  class="edit" href="javascript:void(0)"  data-toggle="modal" data-target="#editModal" title="Modifica">',
    //     '<i class="glyphicon glyphicon-edit"></i>',
    //     '</a>&nbsp;&nbsp;&nbsp;',
    //     '<a id="aRemove"  class="remove" href="javascript:void(0)" title="Disattiva">',
    //     '<i class="glyphicon glyphicon-trash"></i>',
    //     '</a>'
    // ].join('');
    return [
        '<a id="aView" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#detailModal" title="Visualizza">',
        '<i class="glyphicon glyphicon-eye-open"></i>',
        '</a>&nbsp;&nbsp;&nbsp;'
    ].join('');
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        //alert('You click like action, row: ' + JSON.stringify(row));
        selectedRow = row;
    },
    'click .edit': function (e, value, row, index) {
        selectedRow = row;
    },
    'click .remove': function (e, value, row, index) {
        BootstrapDialog.show({
            title: 'ATTENZIONE',
            type: BootstrapDialog.TYPE_WARNING,
            message: 'Sicuro di voler eliminare questo cliente?',
            buttons: [{
                label: 'Sì',
                cssClass: 'btn-warning',
                action: function (dialog) {
                    dialog.close();
                    $.ajax({
                        type: "POST",
                        url: "ajax_responder.php",
                        data: {ajax_function: "DisattivaRecord", thetable:'clienti',keyfield:'idcliente',keyvalue: row.idcliente},
                        success: function (response) {
                            var res = JSON.parse(response);
                            console.log(res['result']);
                            if (res["status"] === "success") {
                                $table.bootstrapTable('refresh');
                                toastr.info('Cliente eliminato!');
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

jQuery(document).ready(function($) {

    function getHeight() {
        return jQuery(window).height();
    }

    console.log($(window).height());
    console.log($("div").outerHeight(true));

    $table = $('#table-clienti'),
        $table.bootstrapTable({height:500});

    /*    $table.bootstrapTable({
     height: getHeight()
     });
     $(window).resize(function () {
     $table.bootstrapTable('resetView', {
     height: getHeight()
     });
     });
     */

    $('#editModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false
    }).on('show.bs.modal', function (event) {
        if (event.relatedTarget) {
            var value;
            var html = '<form id="editForm" method="post" class="form-horizontal">';

            //console.log((event.relatedTarget ? event.relatedTarget.id : ""));
            $.each(oFields.fields, function (i, object) {
                //senderId = (event.relatedTarget ? event.relatedTarget.id : "");
                value = (event.relatedTarget.id === "aEdit" ? selectedRow[object.name] : "");
                if (object.editable === "true") {
                    html += '<div class="form-group">';
                    if (object.type != "hidden") {
                        html += '<label class="col-xs-3 control-label">' + object.label + '</label>';
                    }
                    html += '<div class="col-xs-5">';
                    switch(object.type) {
                        case "date":
                            html += '<input type="text" class="form-control" id="' + object.name + '" name="' + object.name + '" value="' + value + '"/>';
                            break;
                        case "select":
                            html += '<select class="form-control" id="' + object.name + '" name="' + object.name + '">';
                            var selectParams = object.selectParams;
                            if (selectParams.source === "table") {
                                var form_data = {
                                    thetable: selectParams.thetable,
                                    keycolumn: selectParams.keycolumn,
                                    displaycolumn: selectParams.displaycolumn,
                                    sortcolumn: selectParams.sortcolumn,
                                    ajax_function: "CreateOptions"
                                };
                                //console.log(form_data);
                                $.ajax({
                                    type: "POST",
                                    url: "ajax_responder.php",
                                    data: form_data,
                                    async: false,
                                    success: function (response) {
                                        var res = JSON.parse(response);
                                        if (res["status"] === "success") {
                                            html += res["result"];
                                        } else {
                                            toastr.error("ERRORE: " + res['result']);
                                        }
                                    },
                                    error: function (response) {
                                        toastr.error("ERRORE: " + response);
                                    }
                                });

                            } else {
                                html += '<option value=""></option>';
                                $.each(selectParams.values, function(k,v){
                                    html += '<option value="' + k + '">' + v + '</option>';
                                });
                            }
                            break;
                        default:
                            html += '<input type="' + object.type + '" class="form-control" id="' + object.name + '" name="' + object.name + '" value="' + value + '"/>';
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';
                }
            });


            html += '</form>';

            $(this).find('#rowDetails').html(html);

            $.each(oFields.fields, function (i, object) {
                value = (event.relatedTarget.id === "aEdit" ? selectedRow[object.name] : "");
                if (object.editable === "true") {
                    if (object.type === "date") {
                        value = DateFormatWEB(value);
                        //impostazioni del campo data di nascita
                        $('#'+object.name).datepicker({format: 'dd/mm/yyyy', autoclose: true, language: "it"}); //.on('changeDate', function(e) {console.log("Date set");});
                        $('#'+object.name).datepicker('update', value);
                    }
                    if (object.type === "select") {
                        $('#'+object.name).val(value);
                    }
                }
            });

            $("#editForm").validate({
                rules: {
                    'codicefiscale': {
                        required: true
                    },
                    'cognome': {
                        required: true
                    }
                },
                messages: {
                    'codicefiscale': {
                        required: "Campo obbligatorio!"
                    },
                    'cognome': {
                        required: "Campo obbligatorio!"
                    }
                }
             });
        }
    });

    $("#editModal").on('hidden.bs.modal', function () {
        //Removing the error elements from the from-group
        $('.form-group').removeClass('has-error has-feedback');
        $('.form-group').removeClass('has-success has-feedback');
        $('.form-group').find('label.error').remove();
        $('.form-group').find('i.fa').remove();
    });

    $('#detailModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false
    }).on('show.bs.modal', function () {
        var html = '<table class="table table-user-information">';

        html += '<tbody>';

        $.each(oFields.fields, function (i, object) {
            if (object.visible === "true") {
                var value = (selectedRow[object.name] ? selectedRow[object.name] : "");
                html += '<tr>';
                html += '<td>' + object.label + '</td>';

                switch(object.type) {
                    case "date":
                        value = DateFormatWEB(value);
                        html += '<td>' + value + '</td>';
                        break;
                    default:
                        html += '<td>' + value + '</td>';
                }
                html += '</tr>';
            }
        });

        html += '</tbody>';
        html += '</table>';

        $(this).find('#rowDetails').html(html);

    });

    $("#btnSalva").on("click", function () {

        var form = $("#editForm" );
        form.validate();
        if(!form.valid()) {
            return false;
        } else {

        var form_data = {};
        var columns = {};

        form_data["table"] = "clienti";
        form_data["key"] = "idcliente";
        form_data["keyvalue"] = $("#" + form_data["key"]).val();

        $.each(oFields.fields, function (i, object) {
            if (object.name != form_data["key"]) {
                switch(object.type) {
                    case "radio":
                        columns[object.name] = $("input[name="+object.name+"]:checked").val();
                        break;
                    case "date":
                        columns[object.name] = DateFormatDB($("#" + object.name).val());
                        break;
                    default:
                        columns[object.name] = $("#" + object.name).val();
                }
            }
        });
        form_data["columns"] = columns;

        form_data["modificatoda"] = "1";
        form_data["operazione"] = (form_data["keyvalue"] ? "U" : "I");
        form_data["ajax_function"] = "SalvaRecord";

        console.log(form_data);

        //invio dati


        $.ajax({
            type: "POST",
            url: "ajax_responder.php",
            data: form_data,
            success: function (response) {
                console.log(response);
                var res = JSON.parse(response);
                if (res["status"] === "success") {
                    $table.bootstrapTable('refresh');
                    toastr.info('Record salvato con successo!');
                } else {
                    toastr.error("ERRORE: " + res['result']);

                }
            },
            error: function (response) {
                toastr.error("ERRORE: " + response);
            }
        });
        }
    });


});
