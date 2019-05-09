
//Envoi de la requete de recuperation des equipe
function loadProjet() {
    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=projetws");

    //En cas de succe de la requete
    request.done(function( projets ) {
        //on vide le tableau contenant les equipes
        $("#table-equipe").empty();
        //et on le rempli en recuperant les données recu
        for(let projet of projets) {
            $("#table-projet").append(
                "<tr>" +
                "   <td>" + projet.code + "</td>" +
                "   <td>" + projet.libelleProjet + "</td>" +
                "   <td>" + projet.libelleEquipe + "</td>" +
                "   <td><a href=\"index.php?page=projetmodif&code=" + projet.code + "\"><i class=\"glyphicon glyphicon-pencil purple\"></i></a></td> "+
                "   <td><a href=\"index.php?page=projetsuppr&code=" + projet.code + "\"><i class=\"glyphicon glyphicon-trash purple\"></i></a></td> "+
                "</tr>"
            )
        }
    });
}


$(document).ready(function() {
    //$("#modal-modif-form").submit(onSubmitModif);

    $("#modal-ajout-message").hide();
    $("#modal-modif-message").hide();

    loadProjet();
});
