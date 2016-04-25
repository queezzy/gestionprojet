
$('#nouvelphoto').click(function () {
    $('#myAlert').remove();
    $('#block_table_photos').hide();
    $('#block_form_photo').show();
});

function edit_photo(id_photo) {
    $('#myAlert').remove();
    //la route pour faire le get by id
    var url = Routing.generate('gp_photo_get', {id: id_photo});
    $('#action-edit'+id_photo).hide();
    $('#action-delete'+id_photo).hide();
    $('#loader-edit-delete'+id_photo).show();
    $('#block_form_photo').load(url, function () {
        $('#action-edit'+id_photo).show();
        $('#action-delete'+id_photo).show();
        $('#loader-edit-delete'+id_photo).hide();
        $('#block_table_photos').hide();
        $('#block_form_photo').show();
    });
}

function delete_photo(id_photo) {
    $('#myAlert').remove();
    if (confirm('Voulez-vous vraiment supprimer ce photo')) {
        execute_delete_photo(id_photo);
    }
}

function execute_delete_photo(id_photo) {
    $.ajax({
        type: 'post',
        url: Routing.generate('gp_photo_delete', {id : id_photo}),
        dataType: 'json',
        beforeSend: function () {
            $('#action-edit'+id_photo).hide();
            $('#action-delete'+id_photo).hide();
            $('#loader-edit-delete'+id_photo).show();
        },
        success: function (donnees, textStatus, jqXHR) {
            $('#action-edit'+id_photo).show();
            $('#action-delete'+id_photo).show();
            $('#loader-edit-delete'+id_photo).hide();
            var child = "";
            var lignetable = "";
            var data = donnees.data;
                if (data.letype === "sucess") {
                    $('#lignetable' + id_photo).remove(lignetable);
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
            $('#action-edit'+id_photo).show();
            $('#action-delete'+id_photo).show();
            $('#loader-edit-delete'+id_photo).hide();
            var child = '<div id="myAlert" class="alert alert-danger">' +
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'
                    + 'Echec de le suppression du photo' +
                    '</div>';
            $('#message_success').html(child);
        }
    });
}

function show_details(id_photo) {
    window.location.replace(Routing.generate('gp_photo_details', {id: id_photo}));
}