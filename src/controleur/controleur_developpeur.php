<?php

function actionDeveloppeur($twig, $db, $infos_page = array()) // ( à modifier en fonction de la page )
{
    $class_element = new Developpeur($db);//                                                                         ( à modifier en fonction de la page )
    $liste = $class_element->select();  // Recuperation de la liste d'elements

    $class_utilisateur = new UTilisateur($db);
    $liste_utilisateur = $class_utilisateur->selectWithoutDeveloppeur();

    $class_remuneration = new Remuneration($db);
    $liste_remuneration = $class_remuneration->select();

    echo $twig->render('developpeur/developpeur.html.twig', array('infos_page'=>$infos_page, 'liste'=>$liste, 'liste_utilisateur'=>$liste_utilisateur, 'liste_remuneration'=>$liste_remuneration)); //    ( à modifier en fonction de la page )
}

function actionDeveloppeurSuppr($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();
    if(isset($_GET['id']))
    {
        $class_element = new Developpeur($db); //                                                            ( à modifier en fonction de la page )

        $exec = $class_element->delete($_GET['id']); // Suppression de l'element avec son identifiant       ( à modifier en fonction de la page )
        if (!$exec) // Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = 'Problème de suppression dans la table developpeur'; //           ( à modifier en fonction de la page )
        }
        else // Affichage d'un message de succe si le contraire
        {
            $infos_page['popup_type'] = "success";
            $infos_page['popup_message'] = 'Developpeur supprimée avec succès'; //                           ( à modifier en fonction de la page )
        }
    }

    actionDeveloppeur($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionDeveloppeurAjout($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if (isset($_POST['btAjouter']))
    {
        $class_element = new Developpeur($db); //                                                               ( à modifier en fonction de la page )
        $class_utilisateur = new Utilisateur($db);

        // Recuperation des element passer en $_POST                                                        ( à modifier en fonction de la page )
        $idUtilisateur = $_POST['inputEmailUtilisateur'];
        $tel = $_POST['inputTelephone'];
        $idRem = $_POST['inputIdRemuneration'];
        
        if($class_utilisateur->selectDevelopperId($idUtilisateur) == null) {
            $exec = $class_element->insert($tel, $idRem, $idUtilisateur); // Insertion d'un element avec ses valeurs              ( à modifier en fonction de la page )
            if (!$exec)// Affichage d'un message d'erreur si la suppresion n'a pas fonctionner
            {
                $infos_page['message_invalid_ajout'] = 'Problème d\'insertion dans la table developpeur '; //    ( à modifier en fonction de la page )
            }
            else // Affichage d'un message de succe si le contraire
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Ajout du developpeur reussi"; //                              ( à modifier en fonction de la page )
            }
        }
        else 
        {
            $infos_page['message_invalid_ajout'] = "Cet utilisateur possede deja un profil developpeur";
        }

    }

    actionDeveloppeur($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}

function actionDeveloppeurModif($twig, $db) // ( à modifier en fonction de la page )
{
    $infos_page = array();

    if(isset($_GET['id'])) // Si id est passer en parametre alors
    {
        $class_element = new Developpeur($db); //                                                ( à modifier en fonction de la page )

        $element = $class_element->selectById($_GET['id']);  
        if ($element != null){
            $infos_page['element_infos'] = $element; // on envoi les infos sur l'element si il existe
        }
        else // Sinon on affiche un message d'erreur
        {
            $infos_page['popup_type'] = "danger";
            $infos_page['popup_message'] = "Developpeur invalide"; //                            ( à modifier en fonction de la page )
        }
    }
    else // si id n'est pas passé en parameter $_GET
    {
        if(isset($_POST['btModifier'])) // On verifie si btModifier est passe en parametre $_POST alors
        {
            $class_element = new Developpeur($db); //                                            ( à modifier en fonction de la page )

            //on recupere les element du formulaire                                             ( à modifier en fonction de la page )
            $id = $_POST['id'];
            $tel = $_POST['inputTelephone'];
            $idRem = $_POST['inputIdRemuneration'];
          
            $exec = $class_element->update($tel, $idRem, $id); // et on met a jour l'element        ( à modifier en fonction de la page )
            if(!$exec)
            {
                $infos_page['popup_type'] = "danger";
                $infos_page['popup_message'] = 'Echec de la modification du developpeur'; //  ( à modifier en fonction de la page )
            }
            else
            {
                $infos_page['popup_type'] = "success";
                $infos_page['popup_message'] = "Modification du developpeur réussie"; //      ( à modifier en fonction de la page )
            }
        }
    }
    
    actionDeveloppeur($twig, $db, $infos_page); // Affichage de la page avec la liste des elements
}