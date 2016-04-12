
$('#nouveltache').click(function () {
    $('#myAlert').remove();
    $('#block_table_taches').hide();
    $('#block_form_tache').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    window.location.replace(Routing.generate('gp_tache'));
});

function edit_tache(id_tache, gp_route) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_tache_get', {id: id_tache});
    $('#action-edit'+id_tache).hide();
    $('#action-delete'+id_tache).hide();
    $('#loader-edit-delete'+id_tache).show();
    $('#block_form_tache').load(url, function () {
        $('#action-edit'+id_tache).show();
        $('#action-delete'+id_tache).show();
        $('#loader-edit-delete'+id_tache).hide();
        $('#block_table_taches').hide();
        $('#block_form_tache').show();
        $('#close_form').click(function (e) {
            e.preventDefault();
            window.location.replace(Routing.generate('gp_tache'));
        });
    });
}

function delete_tache(id_tache) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce tache')) {
        execute_delete_tache(id_tache);
    }
}

$("#confirmModalNo").click(function (e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function (e) {
    var id_tache = parseInt($('#idtachetodelete').val());
    $("#confirmModal").modal("hide");
    execute_delete(id_tache);
});

function execute_delete_tache(id_tache) {
    $.ajax({
        type: 'post',
        url: Routing.generate('gp_tache_delete', {id : id_tache}),
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_tache).hide();
            $('#action-delete'+id_tache).hide();
            $('#loader-edit-delete'+id_tache).show();
        },
        success: function (data, textStatus, jqXHR) {
            $('#action-edit'+id_tache).show();
            $('#action-delete'+id_tache).show();
            $('#loader-edit-delete'+id_tache).hide();
            var child = "";
            var lignetable = "";
                if (data.letype === "sucess") {
                    $('#lignetable' + id_tache).remove(lignetable);
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
            $('#action-edit'+id_tache).show();
            $('#action-delete'+id_tache).show();
            $('#loader-edit-delete'+id_tache).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du tache' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_tache) {
    $('#block_form_tache').hide();
    $('#block_table_taches').show();
    $('#table_taches').hide();
    $('#loader-details').show();
    window.location.replace(Routing.generate('gp_tache_details', {idtache: id_tache}));
}