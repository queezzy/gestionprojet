
$('#nouvelcourier').click(function () {
    $('#myAlert').remove();
    $('#block_table_couriers').hide();
    $('#block_form_courier').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    window.location.replace(Routing.generate('gp_courier'));
});


function edit_courier(id_courier) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_courier_get', {id: id_courier});
    $('#action-edit'+id_courier).hide();
    $('#action-delete'+id_courier).hide();
    $('#loader-edit-delete'+id_courier).show();
    $('#block_form_courier').load(url, function () {
        $('#action-edit'+id_courier).show();
        $('#action-delete'+id_courier).show();
        $('#loader-edit-delete'+id_courier).hide();
        $('#block_table_couriers').hide();
        $('#block_form_courier').show();
        $('#close_form').click(function (e) {
            e.preventDefault();
            window.location.replace(Routing.generate('gp_courier'));
        });
    });
}

function delete_courier(id_courier) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce courier')) {
        execute_delete_courier(id_courier);
    }
}

$("#confirmModalNo").click(function (e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function (e) {
    var id_courier = parseInt($('#idcouriertodelete').val());
    $("#confirmModal").modal("hide");
    execute_delete(id_courier);
});

function execute_delete_courier(id_courier) {
    $.ajax({
        type: 'post',
        url: Routing.generate('gp_courier_delete', {id : id_courier}),
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_courier).hide();
            $('#action-delete'+id_courier).hide();
            $('#loader-edit-delete'+id_courier).show();
        },
        success: function (donnees, textStatus, jqXHR) {
            $('#action-edit'+id_courier).show();
            $('#action-delete'+id_courier).show();
            $('#loader-edit-delete'+id_courier).hide();
            var child = "";
            var lignetable = "";
            var data = donnees.data;
                if (data.letype === "sucess") {
                    $('#lignetable' + id_courier).remove(lignetable);
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
            $('#action-edit'+id_courier).show();
            $('#action-delete'+id_courier).show();
            $('#loader-edit-delete'+id_courier).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du courier' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_courier) {
    $('#block_form_courier').hide();
    $('#block_table_couriers').show();
    $('#table_couriers').hide();
    $('#loader-details').show();
    window.location.replace(Routing.generate('gp_courier_details', {idcourier: id_courier}));
}