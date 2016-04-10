
$('#nouvellot').click(function () {
    $('#myAlert').remove();
    $('#block_table_lots').hide();
    $('#block_form_lot').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    window.location.replace(Routing.generate('gp_lot'));
});
/*('#form_lot').submit(function (e) {
    e.preventDefault();
    $('#myAlert').remove();
    var donnees = $(this).serialize();
    if ($('#lot_id').val() === "") {
        $.ajax({
            type: 'post',
            url: Routing.generate('gp_lot_add'),
            data: donnees
        });
    } 
});*/

function edit_lot(id_lot, gp_route) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_lot_get', {id: id_lot});
    $('#action-edit'+id_lot).hide();
    $('#action-delete'+id_lot).hide();
    $('#loader-edit-delete'+id_lot).show();
    $('#block_form_lot').load(url, function () {
        $('#action-edit'+id_lot).show();
        $('#action-delete'+id_lot).show();
        $('#loader-edit-delete'+id_lot).hide();
        $('#block_table_lots').hide();
        $('#block_form_lot').show();
        /*$('#form_lot').submit(function (e){
            var id_lot = parseInt($('#lot_id').val());
            e.preventDefault();
            $('#myAlert').remove();
            var donnees = $(this).serialize();
            $.ajax({
                type: 'post',
                data: donnees,
                //la route pour faire le update by id
                url: Routing.generate(gp_route, {id: id_lot}),
                dataType: 'json',
                beforeSend: function () {
                    $('#actions').hide();
                    $('#loader').show();
                },
                success: function (data, textStatus, jqXHR) {
                    var child = "";
                        if (data.letype === "error") {
                            $('#actions').show();
                            $('#loader').hide();
                            child += '<div id="myAlert" class="alert alert-danger">' +
                                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                                    + data.message +
                                    '</div>';
                            $('#message_lot').html(child);
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#actions').show();
                    $('#loader').hide();
                    var child = '<div id="myAlert" class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + 'EXCEPTION' +
                            '</div>';
                    $('#message_lot').append(child);
                }
            });
        });*/
        $('#close_form').click(function (e) {
            e.preventDefault();
            window.location.replace(Routing.generate('gp_lot'));
        });
    });
}

function delete_lot(id_lot) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce lot')) {
        execute_delete_lot(id_lot);
    }
}

$("#confirmModalNo").click(function (e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function (e) {
    var id_lot = parseInt($('#idlottodelete').val());
    $("#confirmModal").modal("hide");
    execute_delete(id_lot);
});

function execute_delete_lot(id_lot) {
    $.ajax({
        type: 'post',
        url: Routing.generate('gp_lot_delete', {id : id_lot}),
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_lot).hide();
            $('#action-delete'+id_lot).hide();
            $('#loader-edit-delete'+id_lot).show();
        },
        success: function (data, textStatus, jqXHR) {
            $('#action-edit'+id_lot).show();
            $('#action-delete'+id_lot).show();
            $('#loader-edit-delete'+id_lot).hide();
            var child = "";
            var lignetable = "";
                if (data[0].letype === "success") {
                    $('#lignetable' + id_lot).remove(lignetable);
                    child += '<div id="myAlert" class="alert alert-success">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + data.message +
                            '</div>';
                } else if (data.letype === "error") {
                    child += '<div id="myAlert" class="alert alert-danger">' +
                            '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                            + data.message +
                            '</div>';
                }
                $('#message_success').html(child);
                setTimeout(function () {
                    $('#myAlert').alert("close");
                }, 4000);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#action-edit'+id_lot).show();
            $('#action-delete'+id_lot).show();
            $('#loader-edit-delete'+id_lot).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du lot' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_lot) {
    $('#block_form_lot').hide();
    $('#block_table_lots').show();
    $('#table_lots').hide();
    $('#loader-details').show();
    window.location.replace(Routing.generate('gp_lot_details', {idlot: id_lot}));
}