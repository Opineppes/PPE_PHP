//construit une requete ajax
function constructRequest(url, method = "GET", data = {}) {
    //Creation de la requete en fonction des arguments recu
    let request = $.ajax( {
        url: url,
        method: method,
        dataType: "json",
        data: data,
        beforeSend: function( xhr ) {
            xhr.overrideMimeType( "application/json; charset=utf-8" );
        }
    });

    //Ajout du message d'erreur en cas d'eche de la requete
    request.fail(function( jqXHR, textStatus ) {
        showPopup(textStatus, "danger");
        console.log(jqXHR);
    });

    //retour de la requete pour ajouter la fonction done() (ou autre);
    return request;
}

//Affichage d'un message popup
function showPopup(message, type) {
    let popupMessage = $("#modal-popup-message");

    popupMessage.html(message);
    popupMessage.attr("class", "modal-body alert-" + type);
    
    $("#modal-popup").modal("show");
}