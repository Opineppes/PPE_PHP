//Envoi de la requete de recuperation des equipe
function loadEntreprise() {
    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=entreprisews");

    //En cas de succe de la requete
    request.done(function( entreprises ) {
        //on vide le tableau contenant les equipes
        $("#table-entreprise").empty();
        //et on le rempli en recuperant les données recu
        for(let entreprise of entreprises) {
            $("#table-entreprise").append(
                "<tr>" +
                "   <td>" + entreprise.libelle + "</td>" +
                "   <td>" + entreprise.adresse + "</td>" +
                "   <td>" + entreprise.cp + "</td>" +
                "   <td>" + entreprise.ville + "</td>" +
                "   <td>" + entreprise.nomContact + "</td>" +
                "   <td><a class=\"purple\" href=\"index.php?page=entrepriseprofil&id=" + entreprise.id + "\"><i class=\"glyphicon glyphicon-home\"></i> Profil </a></td>"+
                "   <td><a href=\"index.php?page=entreprisemodif&id=" + entreprise.id + "\"><i class=\"glyphicon glyphicon-pencil purple\"></i></a></td> "+
                "   <td><a href=\"index.php?page=entreprisesuppr&id=" + entreprise.id + "\"><i class=\"glyphicon glyphicon-trash purple\"></i></a></td> "+
                "</tr>"
            )
        }
    });
}


$(document).ready(function() {

    $("#modal-ajout-message").hide();
    $("#modal-modif-message").hide();

    loadEntreprise();
});
