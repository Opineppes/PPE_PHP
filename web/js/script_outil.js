//Envoi de la requete de recuperation des equipes
function loadOutils() {
    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=outilws");

    //En cas de succès de la requete
    request.done(function( outils ) {
        //on vide le tableau contenant les equipes
        $("#table-outil").empty();
        //et on le rempli en recuperant les données reçues
        for(let outil of outils) {
            $("#table-outil").append(
                "<tr>" +
                "   <td>" + outil.libelle + "</td>" +
                "   <td>" + equipe.version + "</td>" +
                "   <td><a class=\"modif-button\" idoutil=\"" + outil.id + "\" href=\"#\"><i class=\"glyphicon glyphicon-pencil purple\"></i></a></td>" +
                "   <td><a class=\"suppr-button\" idoutil=\"" + outil.id + "\" href=\"#\"><i class=\"glyphicon glyphicon-trash purple\"></i></a></td>" +
                "</tr>"
            )
        }
    });
}