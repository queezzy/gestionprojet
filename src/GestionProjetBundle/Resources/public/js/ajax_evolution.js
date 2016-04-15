

function edit_evolution_intervenant(id_intervenant) {
    var url = Routing.generate('gp_evolution_intervenant_get', {id: id_intervenant});
    $('#loader-evolution-intervenant'+id_intervenant).show();
    $('#lien-evolution-intervenant'+id_intervenant).hide();
    $('#form_evolution_intervenant').load(url, function () {
        $('#loader-evolution-intervenant'+id_intervenant).hide();
        $('#lien-evolution-intervenant'+id_intervenant).show();
        $("#form_evolution_intervenant").modal("show");
        $('#send_intervenant').click(function (e) {
            e.preventDefault();
            $("#form_intervenant").submit();
            //window.location.replace(Routing.generate('gp_evolution'));
        });
    });
}
function edit_evolution_projet(id_projet) {
    //$("#form_evolution_projet").modal("show");
    var url = Routing.generate('gp_evolution_projet_get', {id: id_projet});
    $('#loader-evolution-projet').show();
    $('#lien-evolution-projet').hide();
    $('#form_evolution_projet').load(url, function () {
        $('#loader-evolution-projet').hide();
        $('#lien-evolution-projet').show();
        $("#form_evolution_projet").modal("show");
        $('#send_projet').click(function (e) {
            e.preventDefault();
            $("#form_projet").submit();
            //window.location.replace(Routing.generate('gp_evolution'));
        });
    });
}

