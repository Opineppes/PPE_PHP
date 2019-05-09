<?php

//Affichage de la page avec les formulaire de modification et d'ajout
function actionEquipe($twig, $db, $infos_page = array())
{
    //recuperation des liste permettant le remplissage des formulaire
    $class_developpeur = new Developpeur($db);
    $liste_developpeur = $class_developpeur->select();

    //affichage de la page
    echo $twig->render('equipe/equipe.html.twig', array("infos_page"=>$infos_page, "liste_developpeur"=>$liste_developpeur));
}

//Web service pour la suppression d'une equipe
function actionEquipeSupprWS($twig, $db)
{
    $infos_page = array();

    if(isset($_GET['id']))
    {
        $class_element = new Equipe($db);

        //on execute une requete sql permettant la suppression d'un element
        $exec = $class_element->delete($_GET['id']);
        if (!$exec)
        {
            //si la requete sql a echoue on envoi un message d'erreur
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table equipe';
        }
        else
        {
            //si elle a reussi on envoi un message de validation
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Equipe supprimée avec succès';
        }
    }

    //retourne les information utilise pour le traitement cote client
    echo json_encode($infos_page);
}

//web service pour l'ajout d'une equipe
function actionEquipeAjoutWS($twig, $db)
{
    $infos_page = array();

    $class_element = new Equipe($db);

    //on recupere les information de l'element a ajouter
    $inputLibelle = $_POST['inputLibelle'];
    $inputIdResponsable = $_POST['inputIdResponsable'];
    
    //on execute une requete permettant d'ajouter un element
    $exec = $class_element->insert($inputLibelle, $inputIdResponsable);
    if (!$exec[0]) //ne pas tnir compte de ce block pour les autre controlleur (specifique au controleur equipe), copier coller votre ancien block ici
    {
        if($exec[1] == 23000)
        {
            //Si la requete echoue avec un code d'erreur 23000 on envoi le message d'erreur suivant 
            $infos_page['message_invalid_ajout'] = "Ce nom d'equipe est deja utiliser";
        }
        else
        {
            //si le code erreur est autre que 23000 on envoi un problement d'insertion
            $infos_page['message_invalid_ajout'] = "Problème d'insertion dans la table equipe";
        }
    }
    else
    {
        //si la requete sql s'effectue corectement, on envoi un message de succé
        $infos_page['popup_type'] = "success";
        $infos_page['popup_message'] = "Ajout de l'equipe reussi";

        //et on ajoute une participation du responsable à l'equipe
        $class_participation = new Participation($db);
        $class_participation->insert($inputIdResponsable, $exec[1]);
    }

    //retourne les information utilise pour le traitement cote client
    echo json_encode($infos_page);
}

//web service pour la modification d'une equipe
function actionEquipeModifWS($twig, $db)
{
    $infos_page = array();

    if(isset($_GET['id']))
    {
        $class_element = new Equipe($db);

        //execution de la requete sql permettant de recuperer des information d'une equipe
        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            //si la requete ne renvoi pas de resultat null, on envoi les information de l'element
            $infos_page['element_infos'] = $element;
        }
        else
        {
            //si la requete renvoi un resultat null on envoi un message d'erreur
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Equipe invalide";
        }
    }
    else
    {
        $class_element = new Equipe($db);

        //recuperation des informations devant etre mise a jour
        $id = $_POST['id'];
        $libelle = $_POST['inputLibelle'];
        $inputIdResponsable = $_POST['inputIdResponsable'];
        
        //execution de la requete permettant la mise a jour d'un element
        $exec = $class_element->update($id, $libelle, $inputIdResponsable);
        if(!$exec)
        {
            //si la requete echoue on envoi un message d'erreur
            $infos_page['message_invalid_modif'] = "Problème d'insertion dans la table equipe";
        }
        else
        {
            //si la requete reussi on envoi un message d'erreur
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = "Modification de l'equipe réussie";
        }
    }
    
    //retourne les information utilise pour le traitement cote client
    echo json_encode($infos_page);
}

// WebService pour la recuperation de la liste des elements
function actionEquipeWS($twig, $db)
{
   $equipe = new Equipe($db);
   echo json_encode($equipe->select());
}