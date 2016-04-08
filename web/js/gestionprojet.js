//  Code js de l'application


// fonction de prévisualisation des images après upload
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview-image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Application de la prévisualisation aux formulaire de création d'un utilisateur
$(".inputfile").change(function(){
    readURL(this);
});

//fonction hello
function hello(){
    alert("hello");
}