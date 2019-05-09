//les fonctions constructRequest et showPopup sont declarer dans le fichier script.js

//Envoi de la requete de recuperation des equipe
function loadEquipes() {
    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=equipews");

    //En cas de succe de la requete
    request.done(function( equipes ) {
        //on vide le tableau contenant les equipes
        $("#table-equipe").empty();
        //et on le rempli en recuperant les données recu
        for(let equipe of equipes) {
            $("#table-equipe").append(
                "<tr>" +
                "   <td>" + equipe.libelle + "</td>" +
                "   <td>" + equipe.nom + " " + equipe.prenom + "</td>" +
                "   <td><a class=\"modif-button\" idequipe=\"" + equipe.id + "\" href=\"#\"><i class=\"glyphicon glyphicon-pencil purple\"></i></a></td>" +
                "   <td><a class=\"suppr-button\" idequipe=\"" + equipe.id + "\" href=\"#\"><i class=\"glyphicon glyphicon-trash purple\"></i></a></td>" +
                "</tr>"
            )
        }

        //on attribut pour chaque bouton supprimer et modifier les actions qu'ils devront effectuer lors d'un clique
        $(".suppr-button").click(onClickBtnSuppr);
        $(".modif-button").click(onClickBtnModif);
    });
}

//Envoi de la commande de suppression lors de l'appuie sur le bouton
function onClickBtnSuppr(e) {
    e.preventDefault();

    //On recupere l'identifiant de l'equipe stocker en attribut
    let idEquipe = $(this).attr("idequipe");

    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=equipesupprws&id=" + idEquipe);

    //En cas de succe de la requete
    request.done(function( infos ) {
        //on affiche le message envoyer par le controleur (succé ou echec) tout en rechargeant les equipes
        showPopup(infos.popup_message, infos.popup_type);
        loadEquipes();
    });
}

//Envoi de la requete de recuperation d'infos de l'equipe
function onClickBtnModif(e) {
    e.preventDefault();

    //On recupere l'identifiant de l'equipe stocker en attribut
    let idEquipe = $(this).attr("idequipe");

    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=equipemodifws&id=" + idEquipe);

    //En cas de succe de la requete
    request.done(function( infos ) {
        //si les informations sur l'equipe sont definis
        if(infos.element_infos !== undefined) {
            //on modifie la valeur de tout les champ
            $("#modif-id").val(infos.element_infos.id);
            $("#modif-libelle").val(infos.element_infos.libelle);
            $("#modif-responsable").val(infos.element_infos.idResponsable);

            //et on affiche le modal modif
            $("#modal-modif").modal("show");
        } else {
            //sinon on affiche un popup avec le message recu
            showPopup(infos.popup_message, infos.popup_type);
        }
    });
}

//envoi de la commande de modification lors de la validation du formulaire d'envoi
function onSubmitModif(e) {
    e.preventDefault();

    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=equipemodifws", "POST", $(this).serialize() );

    //En cas de succe de la requete
    request.done(function( infos ) {
        //on verifie si il n'y pas eu d'erreur lors du traitement par le controleur
        if(infos.message_invalid_modif !== undefined) {
            //si il y en a eu une, on affiche le message d'erreur dans une alerte au dessus des entree du formulaire
            let modifMessage = $("#modal-modif-message");
            modifMessage.html(infos.message_invalid_modif);
            modifMessage.show(250);
        } else {
            //sinon on cache le formulaire de modification et on affiche un message de succé tout en rechargeant les equipe
            $("#modal-modif").modal("hide");
            showPopup(infos.popup_message, infos.popup_type);
            loadEquipes();
        }
    });
}

//Envoi de la commande d'ajout d'equipe lors de la validation du formulaire
function onSubmitAjout(e) {
    e.preventDefault();

    //On execute la requete sur le serveur distant
    let request = constructRequest("index.php?page=equipeajoutws", "POST", $(this).serialize() );

    //En cas de succe de la requete
    request.done(function( infos ) {
        //on verifie si il n'y pas eu d'erreur lors du traitement par le controleur
        if(infos.message_invalid_ajout !== undefined) {
            //si il y en a eu une, on affiche le message d'erreur dans une alerte au dessus des entree du formulaire
            let ajoutMessage = $("#modal-ajout-message");
            ajoutMessage.html(infos.message_invalid_ajout);
            ajoutMessage.show(250);
        } else {
            //sinon on cache le formulaire d'ajout et on affiche un message de succé tout en rechargeant les equipe
            $("#modal-ajout").modal("hide");
            showPopup(infos.popup_message, infos.popup_type);
            loadEquipes();
        }
    });
}

//attribution des evenement, disparition des message de formulaire, et chargement des equipes.
$(document).ready(function() {
    $("#modal-ajout-form").submit(onSubmitAjout);
    $("#modal-modif-form").submit(onSubmitModif);

    $("#modal-ajout-message").hide();
    $("#modal-modif-message").hide();

    loadEquipes();
});