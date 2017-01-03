var $table;
var selectedRow = 0;
var senderId;
var filter;


function operateFormatter(value, row, index) {
    return [
        '<a id="aView" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#detailModal" title="Visualizza">',
        '<i class="glyphicon glyphicon-eye-open"></i>',
        '</a>&nbsp;&nbsp;&nbsp;',
        '<a id="aEdit"  class="edit" href="javascript:void(0)"  data-toggle="modal" data-target="#editModal" title="Modifica">',
        '<i class="glyphicon glyphicon-edit"></i>',
        '</a>&nbsp;&nbsp;&nbsp;',
        '<a id="aRemove"  class="remove" href="javascript:void(0)" title="Disattiva">',
        '<i class="glyphicon glyphicon-trash"></i>',
        '</a>'
    ].join('');
}

function operateFormatterNoChanges(value, row, index) {
    return [
        '<a id="aView" class="view" href="javascript:void(0)" data-toggle="modal" data-target="#detailModal" title="Visualizza">',
        '<i class="glyphicon glyphicon-eye-open"></i>',
        '</a>'
    ].join('');
}

window.operateEvents = {
    'click .view': function (e, value, row, index) {
        selectedRow = row;
    },
    'click .edit': function (e, value, row, index) {
        selectedRow = row;
    },
    'click .remove': function (e, value, row, index) {
        BootstrapDialog.show({
            title: 'ATTENZIONE',
            type: BootstrapDialog.TYPE_WARNING,
            message: 'Sicuro di voler eliminare questo record?',
            buttons: [{
                label: 'Sì',
                cssClass: 'btn-warning',
                action: function (dialog) {
                    dialog.close();
                    $.ajax({
                        type: "POST",
                        url: "ajax_responder.php",
                        data: {
                            ajax_function: "DisattivaRecord",
                            table: oForm.table,
                            keyfield: oForm.keyfield,
                            keyvalue: row[oForm.keyfield]
                        },
                        success: function (response) {
                            var res = JSON.parse(response);
                            if (res["status"] === "success") {
                                $table.bootstrapTable('refresh');
                                toastr.info('Record eliminato!');
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
    },
    'click .qrcode': function (e, value, row, index) {
        selectedRow = row;
        //GeneraQRCode(selectedRow);
    }
};

jQuery(document).ready(function ($) {

    $table = $("#table-" + oForm.table),
        $table.bootstrapTable({height: 500});

    $('#table-parametri').on('post-body.bs.table', function (e, data) {
        filter = data;
    });

    $('#editModal').modal({
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

            $.when(ReadRecord(payload)).done(function(result) {
                $('#myEditModalLabel').text((event.relatedTarget.id === "aEdit" ? oForm.labelForEdit : oForm.labelForNew));
                var value;
                var html = '';
                senderId = (event.relatedTarget ? event.relatedTarget.id : "");
                html += '<div class="panel-group" id="accordion">';
                $.each(oForm.panels, function (i, oPanel) {
                    html += '<div class="panel panel-default">';
                    html += '<div class="panel-heading">';
                    html += '<h4 class="panel-title">';
                    if (oPanel.collapsable === "true") {
                        html += '<input type=checkbox class="panelcheckbox" id=chk' + oPanel.name + ' name=chk' + oPanel.name + (oPanel.collapsed === "true" ? "" : " checked") + '>';
                        html += '&nbsp;&nbsp;&nbsp;';
                    }
                    html += '1. ' + oPanel.description;
                    html += '</h4>';    //class=panel-title
                    html += '</div>';   //class=panel-heading
                    html += '<div id=clps' + oPanel.name + ' class="panel-collapse collapse ' + (oPanel.collapsed === "true" ? "" : "in") + '">';
                    html += '<div class=panel-body>';
                    html += '<form class="form-horizontal" method="post" name=frm' + oPanel.name + ' id=frm' + oPanel.name + '>';

                    $.each(oPanel.rows, function (i, oRow) {
                        html += '<div class="form-group">';
                        $.each(oRow.cells, function (i, oCell) {
                            html += '<div class="cell">';
                            html += '<label class="control-label col-sm-' + oCell.labelsize + '" for="' + oCell.name + '">' + oCell.label + '</label>';
                            html += '<div class="col-sm-' + oCell.fieldsize + '">';
                            value = (event.relatedTarget.id === "aEdit" ? result[oCell.name] : "");
                            switch (oCell.type) {
                                case "password":
                                    html += '<input type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                    html += '</div>';   //class=col-sm
                                    html += '</div>';   //class=cell
                                    html += '</div>';   //class=form-group
                                    html += '<div class="form-group">';
                                    html += '<div class="cell">';
                                    html += '<label class="control-label col-sm-' + oCell.labelsize + '" for="' + oCell.name + '2">Ripeti password</label>';
                                    html += '<div class="col-sm-' + oCell.fieldsize + '">';
                                    html += '<input type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '2" name="' + oCell.name + '2" value="' + value + '"/>';
                                    var password2Rule = {"password2": {equalTo: "#password"}};
                                    var password2Message = {"password2": {equalTo: "Le due password non corrispondono!"}};
                                    $.extend(oPanel.rules, password2Rule);
                                    $.extend(oPanel.messages, password2Message);
                                    break;
                                case "boolean":
                                    html += '<input type="checkbox" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" ' + (value === "1" ? "checked" : "") + '/>';
                                    break;
                                case "color":
                                    html += '<input type="color" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                    break;
                                case "date":
                                    html += '<input type="text" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                                    break;
                                case "image":
                                    html += '<input type="' + oCell.type + '" src="images/' + value + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '" style="width:48px"/>';
                                    break;
                                case "select":
                                    html += '<select class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '">';
                                    var selectParams = oCell.selectParams;
                                    if (selectParams.source === "table") {
                                        var form_data = {
                                            table: selectParams.table,
                                            keycolumn: selectParams.keycolumn,
                                            displaycolumn: selectParams.displaycolumn,
                                            sortcolumn: selectParams.sortcolumn,
                                            filter: selectParams.filter,
                                            ajax_function: "CreateOptions"
                                        };

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
                                        $.each(selectParams.values, function (k, v) {
                                            html += '<option value="' + k + '">' + v + '</option>';
                                        });
                                    }
                                    html += '</select>';
                                    break;
                                default:
                                    html += '<input type="' + oCell.type + '" class="form-control full-width" id="' + oCell.name + '" name="' + oCell.name + '" value="' + value + '"/>';
                            }

                            html += '</div>';   //class=col-sm
                            html += '</div>';   //class=cell
                        });
                        html += '</div>';   //class=form-group
                    });
                    html += '</form>';      //form
                    html += '</div>';       //class=panel-body
                    html += '</div>';       //class=panel-collapse
                    html += '</div>';       //class=panel-default

                });
                html += '</div>';   //class=panel-group

                that.find('#rowDetails').html(html);
                //$(this).find('#rowDetails').html(html);

                $.each(oForm.panels, function (i, oPanel) {
                    $.each(oPanel.rows, function (i, oRow) {
                        $.each(oRow.cells, function (i, oCell) {
                            value = (event.relatedTarget.id === "aEdit" ? result[oCell.name] : "");
                            if (oCell.editable === "true") {
                                if (oCell.type === "date") {
                                    value = DateFormatWEB(value);
                                    //impostazioni del campo data di nascita
                                    $('#' + oCell.name).datepicker({format: 'dd/mm/yyyy', autoclose: true, language: "it"});
                                    $('#' + oCell.name).datepicker('update', value);
                                }
                                if (oCell.type === "select") {
                                    $('#' + oCell.name).val(value);
                                }
                            }
                        });
                    });
                    $('#frm' + oPanel.name).validate({
                        rules: oPanel.rules,
                        messages: oPanel.messages
                    });

                });

                $('.panelcheckbox').on('change', function () {
                    var name = $(this).prop('id').replace('chk', '');
                    if (!$(this).prop('checked')) {
                        $("#clps" + name).collapse('hide');
                    } else {
                        $("#clps" + name).collapse('show');
                    }
                });

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

            //console.log(payload);
            $.when(ReadRecord(payload)).done(function(result) {
                //console.log(result);
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
                                value = (result[oCell.name] ? result[oCell.name] : "");
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


    $("#btnPrint").on("click", function () {
        console.log(filter);
        var k = $table.bootstrapTable('getVisibleColumns');
        console.log(k);
        PopupCenter('genpdf.php?t=' + oForm.table, oForm.table, '1000', '500');
    });


    $("#btnSalva").on("click", function () {

        var isValid = checkIfValid();

        if (isValid) {

            BootstrapDialog.show({
                title: 'ATTENZIONE',
                type: BootstrapDialog.TYPE_WARNING,
                message: 'Salvare le modifiche?',
                buttons: [{
                    label: 'Sì',
                    cssClass: 'btn-warning',
                    action: function (dialog) {
                        dialog.close();
                        SaveChanges();
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
        return (isValid);
    });


    function SaveChanges() {
        var form_data = {};
        var columns = {};

        form_data.table = oForm.table;
        form_data.key = oForm.keyfield;
        form_data.keyvalue = selectedRow[form_data.key];
        form_data.autoincrement = oForm.autoincrement;

        form_data.attivo = "1";
        form_data.modificatoda = localStorage.idutente;
        if (senderId === "aEdit") {
            form_data.keyvalue = selectedRow[form_data.key];
            form_data.operazione = "M";
        } else {
            form_data.operazione = "I";
        }

        //form_data.ajax_function = "TestAjax";
        form_data.ajax_function = "SaveRecord";


        $.each(oForm.panels, function (i, oPanel) {
            var form = $('#frm' + oPanel.name);
            $.each(oPanel.rows, function (i, oRow) {
                $.each(oRow.cells, function (i, oCell) {
                    if (oCell.name != form_data.key) {
                        switch (oCell.type) {
                            case "password":
                                var md5 = $.md5($("#" + oCell.name).val());
                                columns[oCell.name] = md5;
                                break;
                            case "boolean":
                                var v = $("input[name=" + oCell.name + "]").prop('checked');
                                columns[oCell.name] = (v ? "1" : "0");
                                break;
                            case "radio":
                                columns[oCell.name] = $("input[name=" + oCell.name + "]:checked").val();
                                break;
                            case "date":
                                columns[oCell.name] = DateFormatDB($("#" + oCell.name).val());
                                break;
                            default:
                                columns[oCell.name] = $("#" + oCell.name).val();
                        }
                    } else {
                        if (oCell.autoincrement) {
                            form_data.autoincrement = true;
                        }
                    }
                });
            });
        });
        form_data.columns = columns;
        $.ajax({
            type: "POST",
            url: "ajax_responder.php",
            data: form_data,
            success: function (response) {
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

    function checkIfValid() {
        var isValid = true;
        $.each(oForm.panels, function (i, oPanel) {
            if (oPanel.rules) {
                var form = $('#frm' + oPanel.name);
                form.validate();
                isValid = isValid && form.valid();
            }
        });
        return(isValid);
    }

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
