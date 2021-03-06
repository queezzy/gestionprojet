
$('#nouvelprojet').click(function () {
    $('#myAlert').remove();
    $('#block_table_projets').hide();
    $('#block_form_projet').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    window.location.replace(Routing.generate('gp_projet_admin'));
});
/*('#form_projet').submit(function (e) {
    e.preventDefault();
    $('#myAlert').remove();
    var donnees = $(this).serialize();
    if ($('#projet_id').val() === "") {
        $.ajax({
            type: 'post',
            url: Routing.generate('gp_projet_add'),
            data: donnees
        });
    } 
});*/

function edit_projet(id_projet) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_projet_get', {id: id_projet});
    $('#action-edit'+id_projet).hide();
    $('#action-delete'+id_projet).hide();
    $('#loader-edit-delete'+id_projet).show();
    $('#block_form_projet').load(url, function () {
        $('#action-edit'+id_projet).show();
        $('#action-delete'+id_projet).show();
        $('#loader-edit-delete'+id_projet).hide();
        $('#block_table_projets').hide();
        $('#block_form_projet').show();
        $('#close_form').click(function (e) {
            e.preventDefault();
            window.location.replace(Routing.generate('gp_projet_admin'));
        });
    });
}

function delete_projet(id_projet) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce projet')) {
        execute_delete_projet(id_projet);
    }
}

$("#confirmModalNo").click(function (e) {
    $("#confirmModal").modal("hide");
});

$("#confirmModalYes").click(function (e) {
    var id_projet = parseInt($('#idprojettodelete').val());
    $("#confirmModal").modal("hide");
    execute_delete(id_projet);
});

function execute_delete_projet(id_projet) {
    $.ajax({
        type: 'post',
        url: Routing.generate('gp_projet_delete', {id : id_projet}),
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_projet).hide();
            $('#action-delete'+id_projet).hide();
            $('#loader-edit-delete'+id_projet).show();
        },
        success: function (data, textStatus, jqXHR) {
            $('#action-edit'+id_projet).show();
            $('#action-delete'+id_projet).show();
            $('#loader-edit-delete'+id_projet).hide();
            var child = "";
            var lignetable = "";
                if (data.letype === "sucess") {
                    $('#lignetable' + id_projet).remove(lignetable);
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
            $('#action-edit'+id_projet).show();
            $('#action-delete'+id_projet).show();
            $('#loader-edit-delete'+id_projet).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du projet' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_projet) {
    window.location.replace(Routing.generate('gp_projet_details', {idprojet: id_projet}));
}

