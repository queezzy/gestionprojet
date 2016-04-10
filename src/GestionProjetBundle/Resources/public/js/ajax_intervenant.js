
$('#nouvelintervenant').click(function () {
    /*$('#myAlert').remove();
    $("#idintervenant").val("");
    $("#name").val("");
    $("#reference").val("");
    $("#manufacturer").val("");
    $("#provider").val("");
    $("#dateservice").val("");*/
    $('#block_table_intervenants').hide();
    $('#block_form_intervenant').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    $('#myAlert').remove();
    $('#block_table_intervenants').show();
    $('#block_form_intervenant').hide();
});
$('#form_intervenant').submit(function (e) {
    e.preventDefault();
    $('#myAlert').remove();
    var donnees = $(this).serialize();
    var submit = true;
    // evaluate the form using generic validaing
    if (!validator.checkAll($(this))) {
        submit = false;
    }
    if (!submit) {
        return false;
    }
    if ($('#idintervenant').val() === "") {
        $.ajax({
            type: 'post',
            url: Routing.generate('dt_intervenant_add'),
            data: donnees,
            dataType: 'json',
            beforeSend: function () {
                $('#actions').hide();
                $('#loader').show();
            },
            success: function (donnees, textStatus, jqXHR) {
                var child = "";
                var lignetable = "";
                var data = donnees.data;
                if (data.length > 0) {
                    if (data[0].letype === "success") {
                        $('#actions').show();
                        $('#loader').hide();
                        child += '<div id="myAlert" class="alert alert-success">' +
                                '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                + data[0].message +
                                '</div>';

                        lignetable = '<tr id="lignetable' + data[1].id + '" class="odd pointer" style="cursor: pointer;">' +
                                '<td class="a-center ">' +
                                '<input type="checkbox" class="tableflat">' +
                                '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].nom + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].lot + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].localisation + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].email + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].telephone + '</td>' +
                                '<td class="last">' +
                                '<a id="action-edit' + data[1].id + '" onclick="edit_intervenant(' + data[1].id + ')" style="cursor: pointer;" >' +
                                '<i class="glyphicon glyphicon-edit"></i>' +
                                '</a>  ' +
                                '<a id="action-delete' + data[1].id + '" onclick="delete_intervenant(' + data[1].id + ')" style="cursor: pointer;" >' +
                                '<i class="glyphicon glyphicon-trash"></i>' +
                                '</a>' +
                                '<a id="loader-ajax-edit-delete' + data[1].id + '" style="cursor: pointer; display:none;" >' +
                                '<img src="bundles/dtintervenant/images/ajax-loader-edit-delete.gif">' +
                                '</a>' +
                                '</td>' +
                                '</tr>';
                        if (data[1].count === 1) {
                           $('#tbodyintervenants').html(lignetable); 
                        }else{
                            $('#tbodyintervenants').append(lignetable);
                        }
                        //updatetable();
                        $('#block_form_intervenant').hide();
                        $('#block_table_intervenants').show();
                        $('#message_success').html(child);
                        setTimeout(function () {
                            $('#myAlert').alert("close");
                        }, 4000);
                    } else if (data[0].letype === "error") {
                        $('#actions').show();
                        $('#loader').hide();
                        child += '<div id="myAlert" class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                + data[0].message +
                                '</div>';
                        $('#message_intervenant').html(child);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#actions').show();
                $('#loader').hide();
                var child = '<div id="myAlert" class="alert alert-danger">' +
                        '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                        + 'EXCEPTION' +
                        '</div>';
                $('#message_intervenant').append(child);
            }
        });
    } else {
        $.ajax({
            type: 'post',
            url: Routing.generate('dt_intervenant_update'),
            data: donnees,
            dataType: 'json',
            beforeSend: function () {
                $('#actions').hide();
                $('#loader').show();
            },
            success: function (donnees, textStatus, jqXHR) {
                var child = "";
                var lignetable = "";
                var data = donnees.data;
                if (data.length > 0) {
                    if (data[0].letype === "success") {
                        $('#actions').show();
                        $('#loader').hide();
                        child += '<div id="myAlert" class="alert alert-success">' +
                                '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                + data[0].message +
                                '</div>';
                        lignetable = '<td class="a-center ">' +
                                '<input type="checkbox" class="tableflat">' +
                                '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].nomintervenant + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].reference + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].fabricant + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].fournisseur + '</td>' +
                                '<td onclick="show_details(' + data[1].id + ')" class=" ">' + data[1].dateservice + '</td>' +
                                '<td class="last">' +
                                '<a id="action-edit' + data[1].id + '" onclick="edit_intervenant(' + data[1].id + ')" style="cursor: pointer;" >' +
                                '<i class="glyphicon glyphicon-edit"></i>' +
                                '</a>  ' +
                                '<a id="action-delete' + data[1].id + '" onclick="delete_intervenant(' + data[1].id + ')" style="cursor: pointer;" >' +
                                '<i class="glyphicon glyphicon-trash"></i>' +
                                '</a>' +
                                '<a id="loader-ajax-edit-delete' + data[1].id + '" style="cursor: pointer; display:none;" >' +
                                '<img src="bundles/dtintervenant/images/ajax-loader-edit-delete.gif">' +
                                '</a>' +
                                '</td>';
                        $('#lignetable' + data[1].id).html(lignetable);
                        updatetable();
                        $('#block_form_intervenant').hide();
                        $('#block_table_intervenants').show();
                        $('#message_success').html(child);
                        setTimeout(function () {
                            $('#myAlert').alert("close");
                        }, 4000);
                    } else if (data[0].letype === "error") {
                        $('#actions').show();
                        $('#loader').hide();
                        child += '<div id="myAlert" class="alert alert-danger">' +
                                '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                + data[0].message +
                                '</div>';
                        $('#message_intervenant').html(child);
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#actions').show();
                $('#loader').hide();
                var child = '<div id="myAlert" class="alert alert-danger">' +
                        '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                        + 'EXCEPTION' +
                        '</div>';
                $('#message_intervenant').append(child);
            }
        });
    }



});

function edit_intervenant(id_intervenant) {
    $('#myAlert').remove();
    $.ajax({
        type: 'post',
        url: Routing.generate('dt_intervenant_get'),
        data: {"idintervenant": id_intervenant},
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_intervenant).hide();
            $('#action-delete'+id_intervenant).hide();
            $('#loader-edit-delete'+id_intervenant).show();
        },
        success: function (donnees, textStatus, jqXHR) {
            $('#action-edit'+id_intervenant).show();
            $('#action-delete'+id_intervenant).show();
            $('#loader-edit-delete'+id_intervenant).hide();
            var child = "";
            var resultat = donnees.data;
            if (resultat.length > 0) {
                $("#idintervenant").val(resultat[0].id);
                $("#name").val(resultat[0].nomintervenant);
                $("#reference").val(resultat[0].reference);
                $("#manufacturer").val(resultat[0].fabricant);
                $("#provider").val(resultat[0].fournisseur);
                $("#dateservice").val(resultat[0].dateservice);
                $("#block_table_intervenants").hide();
                $('#block_form_intervenant').show();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#action-edit'+id_intervenant).show();
            $('#action-delete'+id_intervenant).show();
            $('#loader-edit-delete'+id_intervenant).hide();
            alert("search-infos bad");
        }
    });
}

function delete_intervenant(id_intervenant) {
    $('#myAlert').remove();
    /*$('#idintervenanttodelete').val(id_intervenant);
    ("#confirmModal").modal("show");*/
    $('#myAlert').remove();
    if (confirm('Cette action supprimera aussi les défaillance qui lui sont associées\n\
Voulez-vous vraiment supprimer cet équipement?')) {
        execute_delete_intervenant(id_intervenant);
    }
}

$("#confirmModalNo").click(function (e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function (e) {
    var id_intervenant = parseInt($('#idintervenanttodelete').val());
    $("#confirmModal").modal("hide");
    execute_delete(id_intervenant);
});

function execute_delete_intervenant(id_intervenant) {
    $.ajax({
        type: 'post',
        url: Routing.generate('dt_intervenant_delete'),
        data: {"idintervenant": id_intervenant},
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_intervenant).hide();
            $('#action-delete'+id_intervenant).hide();
            $('#loader-edit-delete'+id_intervenant).show();
        },
        success: function (donnees, textStatus, jqXHR) {
            $('#action-edit'+id_intervenant).show();
            $('#action-delete'+id_intervenant).show();
            $('#loader-edit-delete'+id_intervenant).hide();
            var child = "";
            var lignetable = "";
            var data = donnees.data;
            if (data.length > 0) {
                if (data[0].letype === "success") {
                    $('#lignetable' + id_intervenant).remove(lignetable);
                    updatetable();
                    child += '<div id="myAlert" class="alert alert-success">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + data[0].message +
                            '</div>';
                } else if (data[0].letype === "error") {
                    child += '<div id="myAlert" class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + data[0].message +
                            '</div>';
                }
                $('#message_success').html(child);
                setTimeout(function () {
                    $('#myAlert').alert("close");
                }, 4000);
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#action-edit'+id_intervenant).show();
            $('#action-delete'+id_intervenant).show();
            $('#loader-edit-delete'+id_intervenant).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'EXCEPTION' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_intervenant) {
    $('#block_form_intervenant').hide();
    $('#block_table_intervenants').show();
    $('#table_intervenants').hide();
    $('#loader-details').show();
    var url = Routing.generate('dt_details_get', {idintervenant: id_intervenant});
    $('#app_content').load(url, function () {
        $('#loader_details').hide();
        initComponents();
        functionAjaxDefaillances();
    });
}

/*$('#menu_intervenants').click(function (){
 $('#block_form_intervenant').hide();
 $('#block_table_intervenants').show();
 $('#tab_intervenants').hide();
 $('#loader_details').html("<img src='/defautech/web/bundles/dtintervenant/images/ajax-loader-details.gif'>");
 $('#loader_details').show();
 var url = Routing.generate('dt_intervenant_get', {idintervenant: id_intervenant});
 $('#app_content').load(url, function (){
 
 });
 });*/
$(function () {
    initComponents();
});

function initComponents() {
    $('#dateservice').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_1"
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });

    $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    var asInitVals = new Array();
    var oTable = $('#example').dataTable({
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "aoColumnDefs": [
            {
                'bSortable': false,
                'aTargets': [0]
            } //disables sorting for column one
        ],
        'iDisplayLength': 12,
        "sPaginationType": "full_numbers"
    });
    $("tfoot input").keyup(function () {
        /* Filter on the column based on the index of this element's parent <th> */
        oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
    });
    $("tfoot input").each(function (i) {
        asInitVals[i] = this.value;
    });
    $("tfoot input").focus(function () {
        if (this.className === "search_init") {
            this.className = "";
            this.value = "";
        }
    });
    $("tfoot input").blur(function (i) {
        if (this.value === "") {
            this.className = "search_init";
            this.value = asInitVals[$("tfoot input").index(this)];
        }
    });
}

function updatetable(){
    $('input.tableflat').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
}



function functionAjaxDefaillances() {
    $('#nouvelledetail').click(function () {
        $("#iddetail").val("");
        $("#modedetail").val("");
        $("#cause").val("");
        $("#effet").val("");
        $("#actionscorrectives").val("");
        $('#block_table_details').hide();
        $('#block_form_detail').show();
    });
    $('#close_form').click(function (e) {
        e.preventDefault();
        $('#myAlert').remove();
        $('#block_table_details').show();
        $('#block_form_detail').hide();
    });
    $('#form_detail').submit(function (e) {
        e.preventDefault();
        $('#myAlert').remove();
        var donnees = $(this).serialize();
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }
        if (!submit) {
            return false;
        }
        if ($('#iddetail').val() === "") {
            $.ajax({
                type: 'post',
                url: Routing.generate('dt_detail_add'),
                data: donnees,
                dataType: 'json',
                beforeSend: function () {
                    $('#actions').hide();
                    $('#loader').show();
                },
                success: function (donnees, textStatus, jqXHR) {
                    var child = "";
                    var lignetable = "";
                    var data = donnees.data;
                    if (data.length > 0) {
                        if (data[0].letype === "success") {
                            $('#actions').show();
                            $('#loader').hide();
                            child += '<div id="myAlert" class="alert alert-success">' +
                                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                    + data[0].message +
                                    '</div>';

                            lignetable = '<tr id="lignetable' + data[1].id + '" class="odd pointer">' +
                                    '<td class="a-center ">' +
                                    '<input type="checkbox" class="tableflat">' +
                                    '</td>' +
                                    '<td class=" ">' + data[1].modedetail + '</td>' +
                                    '<td class=" ">' + data[1].cause + '</td>' +
                                    '<td class=" ">' + data[1].effet + '</td>' +
                                    '<td class=" ">' + data[1].actionscorrectives + '</td>' +
                                    '<td class="last">' +
                                    '<a id="action-edit' + data[1].id + '" onclick="edit_detail(' + data[1].id + ')" style="cursor: pointer;">' +
                                    '<i class="glyphicon glyphicon-edit"></i>' +
                                    '</a>  ' +
                                    '<a id="action-delete' + data[1].id + '" onclick="delete_detail(' + data[1].id + ')" style="cursor: pointer;">' +
                                    '<i class="glyphicon glyphicon-trash"></i>' +
                                    '</a>' +
                                    '<a id="loader-ajax-edit-delete' + data[1].id + '" style="cursor: pointer; display:none;" >' +
                                    '<img src="bundles/dtintervenant/images/ajax-loader-edit-delete.gif">' +
                                    '</a>' +
                                    '</td>' +
                                    '</tr>';
                            if (data[1].count === 1) {
                                $('#tbodydetails').html(lignetable);
                            }else{
                                $('#tbodydetails').append(lignetable);
                            }
                            updatetable();
                            $('#block_form_detail').hide();
                            $('#block_table_details').show();
                            $('#message_success').html(child);
                            setTimeout(function () {
                                $('#myAlert').alert("close");
                            }, 4000);
                        } else if (data[0].letype === "error") {
                            $('#actions').show();
                            $('#loader').hide();
                            child += '<div id="myAlert" class="alert alert-danger">' +
                                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                    + data[0].message +
                                    '</div>';
                            $('#message_detail').html(child);
                        }
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#actions').show();
                    $('#loader').hide();
                    var child = '<div id="myAlert" class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + 'EXCEPTION' +
                            '</div>';
                    $('#message_detail').append(child);
                }
            });
        } else {
            $.ajax({
                type: 'post',
                url: Routing.generate('dt_detail_update'),
                data: donnees,
                dataType: 'json',
                beforeSend: function () {
                    $('#actions').hide();
                    $('#loader').show();
                },
                success: function (donnees, textStatus, jqXHR) {
                    var child = "";
                    var lignetable = "";
                    var data = donnees.data;
                    if (data.length > 0) {
                        if (data[0].letype === "success") {
                            $('#actions').show();
                            $('#loader').hide();
                            child += '<div id="myAlert" class="alert alert-success">' +
                                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                    + data[0].message +
                                    '</div>';
                            lignetable = '<td class="a-center ">' +
                                    '<input type="checkbox" class="tableflat">' +
                                    '</td>' +
                                    '<td class=" ">' + data[1].modedetail + '</td>' +
                                    '<td class=" ">' + data[1].cause + '</td>' +
                                    '<td class=" ">' + data[1].effet + '</td>' +
                                    '<td class=" ">' + data[1].actionscorrectives + '</td>' +
                                    '<td class="last">' +
                                    '<a id="action-edit' + data[1].id + '" onclick="edit_detail(' + data[1].id + ')" style="cursor: pointer;">' +
                                    '<i class="glyphicon glyphicon-edit"></i>' +
                                    '</a>  ' +
                                    '<a id="action-delete' + data[1].id + '" onclick="delete_detail(' + data[1].id + ')" style="cursor: pointer;">' +
                                    '<i class="glyphicon glyphicon-trash"></i>' +
                                    '</a>' +
                                    '<a id="loader-ajax-edit-delete' + data[1].id + '" style="cursor: pointer; display:none;" >' +
                                    '<img src="bundles/dtintervenant/images/ajax-loader-edit-delete.gif">' +
                                    '</a>' +
                                    '</td>';
                            $('#lignetable' + data[1].id).html(lignetable);
                            updatetable();
                            $('#block_form_detail').hide();
                            $('#block_table_details').show();
                            $('#message_success').html(child);
                            setTimeout(function () {
                                $('#myAlert').alert("close");
                            }, 4000);
                        } else if (data[0].letype === "error") {
                            $('#actions').show();
                            $('#loader').hide();
                            child += '<div id="myAlert" class="alert alert-danger">' +
                                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                    + data[0].message +
                                    '</div>';
                            $('#message_detail').html(child);
                        }
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#actions').show();
                    $('#loader').hide();
                    var child = '<div id="myAlert" class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + 'EXCEPTION' +
                            '</div>';
                    $('#message_detail').append(child);
                }
            });
        }
    });
}