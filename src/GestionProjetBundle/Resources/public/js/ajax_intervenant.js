
$('#nouvelintervenant').click(function () {
    $('#myAlert').remove();
    $('#block_table_intervenants').hide();
    $('#block_form_intervenant').show();
});
$('#close_form').click(function (e) {
    e.preventDefault();
    window.location.replace(Routing.generate('gp_intervenant'));
});
/*('#form_intervenant').submit(function (e) {
    e.preventDefault();
    $('#myAlert').remove();
    var donnees = $(this).serialize();
    if ($('#intervenant_id').val() === "") {
        $.ajax({
            type: 'post',
            url: Routing.generate('gp_intervenant_add'),
            data: donnees
        });
    } 
});*/

function edit_intervenant(id_intervenant) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_intervenant_get', {id: id_intervenant});
    $('#action-edit'+id_intervenant).hide();
    $('#action-delete'+id_intervenant).hide();
    $('#loader-edit-delete'+id_intervenant).show();
    $('#block_form_intervenant').load(url, function () {
        $('#action-edit'+id_intervenant).show();
        $('#action-delete'+id_intervenant).show();
        $('#loader-edit-delete'+id_intervenant).hide();
        $('#block_table_intervenants').hide();
        $('#block_form_intervenant').show();
        $('#close_form').click(function (e) {
            e.preventDefault();
            window.location.replace(Routing.generate('gp_intervenant'));
        });
    });
}

function delete_intervenant(id_intervenant) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce intervenant')) {
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
        url: Routing.generate('gp_intervenant_delete', {id : id_intervenant}),
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
                if (data.letype === "sucess") {
                    $('#lignetable' + id_intervenant).remove(lignetable);
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
            $('#action-edit'+id_intervenant).show();
            $('#action-delete'+id_intervenant).show();
            $('#loader-edit-delete'+id_intervenant).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du intervenant' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_intervenant) {
    window.location.replace(Routing.generate('gp_intervenant_details', {id: id_intervenant}));
}