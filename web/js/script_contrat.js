
//Envoi de la requete de recuperation des equipe
function loadContrat() {
    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=contratws");

    //En cas de succe de la requete
    request.done(function( contrats ) {
        //on vide le tableau contenant les equipes
        $("#table-contrat").empty();
        //et on le rempli en recuperant les données recu
        for(let contrat of contrats) {
            $("#table-contrat").append(
                "<tr>" +
                "   <td>" + contrat.dateDebut + "</td>" +
                "   <td>" +  contrat.dateFin + "</td>" +
                "   <td>" + contrat.dateSignature + "</td>" +
                "   <td>" + contrat.cout + "</td>" +
                "   <td>" + contrat.Nprojet + "</td>" +
                "   <td><a class=\"purple\" href=\"index.php?page=entrepriseprofil&id=" + contrat.idEntreprise + "\"><i class=\"glyphicon glyphicon-home\"></i>"+ contrat.Nentreprise +"</a></td>"+
                "   <td><a href=\"index.php?page=contratmodif&id=" + contrat.id + "\"><i class=\"glyphicon glyphicon-pencil purple\"></i></a></td> "+
                "   <td><a href=\"index.php?page=contratsuppr&id=" + contrat.id + "\"><i class=\"glyphicon glyphicon-trash purple\"></i></a></td> "+
                "</tr>"
            )
        }
    });
}


$(document).ready(function() {

    $("#modal-ajout-message").hide();
    $("#modal-modif-message").hide();

    loadContrat();
});
